<?php

namespace app\modules\admin\helpers;

use app\models\User;
use Yii;
use yii\db\Query;

class AdminHelper {

    public static $arrStatus = array(
        0 => 'Ẩn',
        1 => 'Hiện',
    );
    public static $arrDefault = array(
        0 => 'Không',
        1 => 'Có',
    );
    public static $arrIsHot = array(
        0 => 'Không',
        1 => 'Có',
    );
    public static $arrIsHome = array(
        0 => 'Không',
        1 => 'Có',
    );
    public static $arrTypePlace = array(
        0 => 'Nhà hàng',
        1 => 'Địa điểm mua sắm',
        2 => 'TT thể thao, giải trí',
        3 => 'Cơ quan hành chính',
        4 => 'Trường học',
        5 => 'Cơ sở y tế',
        6 => 'Bến xe, trạm xe',
        7 => 'Công trình công cộng',
        8 => 'Khách sạn',
        9 => 'Tiện ích khác',
        10 => 'Dự án',
    );

    public static function loadSuccessMessage() {
        $reVal = '';
        if (Yii::$app->session->hasFlash('success')) {
            $reVal .= '<div class="alert alert-block alert-success">';
            $reVal .= '<button type="button" class="close" data-dismiss="alert"><i class="icon-remove"></i></button>';
            $reVal .= '<i class="icon-ok green"></i><strong class="green"> ' . Yii::$app->session->getFlash("success") . '</strong>';
            $reVal .= '</div>';
        }
        if (\Yii::$app->session->hasFlash('error')) {
            $reVal .= '<div class="alert alert-block alert-danger">';
            $reVal .= '<button type="button" class="close" data-dismiss="alert"><i class="icon-remove"></i></button>';
            $reVal .= '<i class="icon-remove"></i><strong> Lỗi!</strong>';
            $reVal .= '<p>' . Yii::$app->session->getFlash("error") . '</p>';
            $reVal .= '</div>';
        }
        echo $reVal;
    }

    public static function convertCommaToDot($number) {
        return str_replace(',', '.', $number);
    }

    public static function convertDotToComma($number) {
        return str_replace('.', ',', $number);
    }

    public static function getPrice($value) {
        if ($value) {
            $value = str_replace('.', '', $value);
        }
        return (float) $value;
    }

    public static function getYoutubeImage($url, $type = 'maxresdefault') {
        //$type= default(120x90),mqdefault(320x180),hqdefault(480x360),sddefault(640x480),maxresdefault(1920x1080),0(480x360),1(120x90),2(120x90),3(120x90)
        $queryString = parse_url($url, PHP_URL_QUERY);
        parse_str($queryString, $params);
        $v = $params['v'];
        $reval = '';
        //DISPLAY THE IMAGE
        if (strlen($v) > 0) {
            $reval = 'http://i3.ytimg.com/vi/' . $v . '/' . $type . '.jpg';
        }
        return $reval;
    }

    public static function removeCacheFace($url) {
        $url_face = 'https://graph.facebook.com/?id=' . urlencode($url) . '&scrape=true';
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url_face);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows; U; Windows NT 5.1; rv:1.7.3) Gecko/20041001 Firefox/0.10.1");
        $data = curl_exec($ch);
        curl_close($ch);
//       $data= file_get_contents($url_face,null,null);
        return $data;
    }

    public static function getArrRoles() {
        $query = New Query();
        $query->select('name,description')
                ->from('auth_item')
                ->where(['type' => 1])
                ->orderBy("description");
        if (!User::is_adminsupper()) {
            $query->andFilterWhere(['<>', 'name', 'admin']);
        }
        $data = $query->all();
        return $data;
    }

    public static function getRoleName($name) {
        $query = New Query();
        $query->select('description')
                ->from('auth_item')
                ->where(['name' => $name]);
        $data = $query->scalar();
        return $data;
    }

    public static function showHideLangList() {
        if (count(Yii::$app->params['languages']) < 2) {
            $check = false;
        } else {
            $check = true;
        }
        return [
            'attribute' => 'language',
            'format' => 'raw',
            'filter' => Yii::$app->params['languages'],
            'visible' => $check,
            'content' => function ($data) {
                return isset(Yii::$app->params['languages'][$data->language]) ? Yii::$app->params['languages'][$data->language] : '';
            }
        ];
    }

    public static function showHideLangForm($model, $form, $option = ['class' => 'col-xs-3 col-sm-3']) {
        if (count(Yii::$app->params['languages']) < 2) {
            $html = $form->field($model, 'language')->hiddenInput(['value' => 'vi'])->label(false);
        } else {
            $html = $form->field($model, 'language')->dropDownList(Yii::$app->params['languages'], $option);
        }
        return $html;
    }

}
