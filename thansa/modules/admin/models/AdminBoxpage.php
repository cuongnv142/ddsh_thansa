<?php

namespace app\modules\admin\models;

use app\models\Boxpage;
use app\modules\admin\behaviors\LogActionBehavior;
use app\modules\admin\behaviors\SetterImageBehavior;
use Yii;
use yii\data\ActiveDataProvider;

class AdminBoxpage extends Boxpage {

    public function behaviors() {
        return [
            LogActionBehavior::className(),
            SetterImageBehavior::className()
        ];
    }

    public function search($params) {
        $query = Boxpage::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => Yii::$app->params['defaultPageSizeAdmin'],
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
            'boxpage_cat_id' => $this->boxpage_cat_id,
            'sort_order' => $this->sort_order,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'status' => $this->status,
            'language' => $this->language,
            'id_related' => $this->id_related,
        ]);

        $query->andFilterWhere(['like', 'name', trim($this->name)])
                ->andFilterWhere(['like', 'src', $this->src])
                ->andFilterWhere(['like', 'link', $this->link])
                ->andFilterWhere(['like', 'multitext', $this->multitext])
                ->andFilterWhere(['like', 'description', $this->description]);

        return $dataProvider;
    }

}
