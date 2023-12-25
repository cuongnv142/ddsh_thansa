<?php

namespace app\modules\admin\models;

use app\models\Tag;
use app\modules\admin\behaviors\LogActionBehavior;
use Yii;
use yii\data\ActiveDataProvider;

class AdminTag extends Tag {
    public function behaviors()
    {
        return [
            LogActionBehavior::className()
        ];
    }
    public function search($params) {
        $query = Tag::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => Yii::$app->params['defaultPageSizeAdmin'],
            ],
        ]);

        $this->load($params);

        $query->andFilterWhere([
            'id' => $this->id,
            'status' => $this->status,
        ]);

        $query->andFilterWhere(['like', 'name', trim($this->name)])
                ->andFilterWhere(['like', 'page_title', $this->page_title])
                ->andFilterWhere(['like', 'page_description', $this->page_description]);

        return $dataProvider;
    }

}
