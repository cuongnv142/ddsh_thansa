<?php

namespace app\components;

use Yii;
use yii\helpers\Url;
use yii\jui\Widget;
use yii\web\Cookie;

class languageSwitcher extends Widget {

    public function init() {
        if (php_sapi_name() === 'cli') {
            return true;
        }
        parent::init();
        $languages = Yii::$app->params['languages'];
        $cookies = Yii::$app->request->cookies;
        $languageNew = Yii::$app->request->get('language');
        if ($languageNew) {
            if (isset($languages[$languageNew])) {
                Yii::$app->language = $languageNew;
                $cookies = Yii::$app->response->cookies;
                $cookies->add(new Cookie([
                    'name' => 'language',
                    'value' => $languageNew,
                    'httpOnly' => false,
                    'expire' => time() + 86400 * 365,
                ]));
            }
        } elseif ($cookies->has('language')) {
            if (isset($languages[$cookies->getValue('language')])) {
                Yii::$app->language = $cookies->getValue('language');
            }
        }
    }

    public function getUrlRelated($language) {
        $params = [];
        if ($language != 'vi') {
            $params['language'] = $language;
        }
        $url = Url::home(true);
        $controller = Yii::$app->controller->id;
        $action = Yii::$app->controller->action->id;
        return $url;
    }

    public function run() {
        $languages = Yii::$app->params['languages'];
        $current = Yii::$app->language;
        $arrImgLang = [];
        $arrImgLang['vi'] = '/template/images/VN.png';
        $arrImgLang['en'] = '/template/images/GB.png';
        $html = '<div class="language">';
        foreach ($languages as $code => $language) {
            $class = '';
            $url = $this->getUrlRelated($code);
            if ($code == $current) {
                $class = 'active';
            }
            $html .= '<div class="language-item"><a class="' . $class . '" href="javascript:void(0)" data-url="' . $url . '" onclick="change_language(\'' . $code . '\',this)"><img class="' . $code . ' ' . $class . '" src="' . $arrImgLang[$code] . '"  alt=" ' . $language . '"/>                              
                            </a></div>';
        }
        $html .= '</div>';
        echo $html;
    }

}
