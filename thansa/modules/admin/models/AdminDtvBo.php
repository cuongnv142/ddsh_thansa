<?php

namespace app\modules\admin\models;

use app\models\DtvBo;
use app\modules\admin\behaviors\LogActionBehavior;
use Yii;
use yii\data\ActiveDataProvider;

/**
 * AdminDtvBo represents the model behind the search form of `app\models\DtvBo`.
 */
class AdminDtvBo extends DtvBo {

    public function behaviors() {
        return [
            LogActionBehavior::className()
        ];
    }

    public function search($params) {
        $query = DtvBo::find();

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
            'id_dtv_lop' => $this->id_dtv_lop,
            'status' => $this->status,
            'created_at' => $this->created_at,
            'created_by' => $this->created_by,
            'updated_at' => $this->updated_at,
            'updated_by' => $this->updated_by,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
                ->andFilterWhere(['like', 'name_latinh', $this->name_latinh]);

        return $dataProvider;
    }
    
     public static function getParentName($parent_id) {
        if ($parent_id) {
            $model = static::findOne($parent_id);
            return $model ? $model->name : '';
        }
        return '';
    }
    public static function getParentNameTX($parent_id) {
        if ($parent_id) {
            $model = static::findOne($parent_id);
            return $model;
        }
        return '';
    }


}
