<?php

namespace app\modules\admin\models;

use app\models\Banner;
use yii\data\ActiveDataProvider;
use app\modules\admin\behaviors\LogActionBehavior;
use app\modules\admin\behaviors\SetterImageBehavior;

class AdminBanner extends Banner {

    public function behaviors() {
        return [
            LogActionBehavior::className(),
            SetterImageBehavior::className()
        ];
    }

    public function search($params) {
        $query = Banner::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => \Yii::$app->params['defaultPageSizeAdmin'],
            ],
            'sort' => [
                // Set the default sort by name ASC and created_at DESC.
                'defaultOrder' => [
                    'id' => SORT_DESC
                ]
            ]
        ]);

        $this->load($params);

        $query->andFilterWhere([
            'id' => $this->id,
            'banner_cat_id' => $this->banner_cat_id,
            'width' => $this->width,
            'height' => $this->height,
            'type' => $this->type,
            'sort_order' => $this->sort_order,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'status' => $this->status,
            'language' => $this->language,
            'id_related' => $this->id_related,
        ]);

        $query->andFilterWhere(['like', 'name', trim($this->name)])
                ->andFilterWhere(['like', 'src', $this->src])
                ->andFilterWhere(['like', 'src_mobile', $this->src_mobile])
                ->andFilterWhere(['like', 'link', $this->link])
                ->andFilterWhere(['like', 'multitext', $this->multitext])
                ->andFilterWhere(['like', 'description', $this->description]);

        return $dataProvider;
    }

}
