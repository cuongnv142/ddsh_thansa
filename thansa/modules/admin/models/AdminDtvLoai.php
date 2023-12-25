<?php

namespace app\modules\admin\models;

use app\components\FileUpload;
use app\models\DtvLoai;
use app\modules\admin\behaviors\LogActionBehavior;
use Yii;
use yii\data\ActiveDataProvider;
use yii\helpers\Html;

/**
 * AdminDtvLoai represents the model behind the search form of `app\models\DtvLoai`.
 */
class AdminDtvLoai extends DtvLoai {

    public function behaviors() {
        return [
            LogActionBehavior::className()
        ];
    }

    public function search($params) {
        $query = DtvLoai::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => Yii::$app->params['defaultPageSizeAdmin'],
            ],
            'sort' => [
                'defaultOrder' => [
                    'id' => SORT_DESC
                ]
            ]
        ]);

        $this->load($params);

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'loai' => $this->loai,
            'id_dtv_ho' => $this->id_dtv_ho,
            'muc_do_bao_ton_iucn' => $this->muc_do_bao_ton_iucn,
            'muc_do_bao_ton_ndcp' => $this->muc_do_bao_ton_ndcp,
            'muc_do_bao_ton_sdvn' => $this->muc_do_bao_ton_sdvn,
            'muc_do_bao_ton_nd64cp' => $this->muc_do_bao_ton_nd64cp,
            'status' => $this->status,
            'created_at' => $this->created_at,
            'created_by' => $this->created_by,
            'updated_at' => $this->updated_at,
            'updated_by' => $this->updated_by,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
                ->andFilterWhere(['like', 'name_latinh', $this->name_latinh])
                ->andFilterWhere(['like', 'ten_khac', $this->ten_khac])
                ->andFilterWhere(['like', 'dac_diem', $this->dac_diem])
                ->andFilterWhere(['like', 'phan_bo', $this->phan_bo])
                ->andFilterWhere(['like', 'file_dinh_kem', $this->file_dinh_kem])
                ->andFilterWhere(['like', 'nguon_tai_lieu', $this->nguon_tai_lieu]);

        return $dataProvider;
    }

    public static function getHtmlfiledinhkem($file_dinh_kem) {
        $html = '';
        if ($file_dinh_kem) {
            $json = json_decode($file_dinh_kem);
            foreach ($json as $value) {
                $html .= '<a href="' . FileUpload::originalfile($value) . '" title="" data-rel="img_tc" style="margin-right: 4px;" class="cboxElement">' . Html::img(FileUpload::thumbfile(50, 0, $value), ['style' => 'width: 80px;height:80px']) . '</a>';
            }
        }

        return $html;
    }

}
