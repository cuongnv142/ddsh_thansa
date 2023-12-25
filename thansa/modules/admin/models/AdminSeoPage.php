<?php

namespace app\modules\admin\models;

use app\models\SeoPage;
use app\modules\admin\behaviors\LogActionBehavior;
use app\modules\admin\behaviors\SetterImageBehavior;
use Yii;
use yii\data\ActiveDataProvider;

/**
 * AdminSeoPage represents the model behind the search form about `app\models\SeoPage`.
 */
class AdminSeoPage extends SeoPage {
    public function behaviors()
    {
        return [
            LogActionBehavior::className(),
             SetterImageBehavior::className()
        ];
    }
    public function search($params) {
        $query = SeoPage::find();

        // add conditions that should always apply here

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
            'route_id' => $this->route_id,
            'language' => $this->language,
        ]);

        $query->andFilterWhere(['like', 'route_name', $this->route_name])
                ->andFilterWhere(['like', 'page_title', $this->page_title])
                ->andFilterWhere(['like', 'page_keywords', $this->page_keywords])
                ->andFilterWhere(['like', 'page_description', $this->page_description])
                ->andFilterWhere(['like', 'face_title', $this->face_title])
                ->andFilterWhere(['like', 'face_image', $this->face_image])
                ->andFilterWhere(['like', 'face_description', $this->face_description])
                ->andFilterWhere(['like', 'multitext', $this->multitext]);

        return $dataProvider;
    }

}
