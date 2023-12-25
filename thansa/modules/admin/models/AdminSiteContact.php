<?php

namespace app\modules\admin\models;

use app\models\SiteContact;
use app\modules\admin\behaviors\LogActionBehavior;
use app\modules\admin\behaviors\SetterImageBehavior;
use Yii;
use yii\data\ActiveDataProvider;

class AdminSiteContact extends SiteContact {

    public function behaviors() {
        return [
            LogActionBehavior::className(),
            SetterImageBehavior::className()
        ];
    }

    public function search($params) {
        $query = SiteContact::find();

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

        $query->andFilterWhere([
            'id' => $this->id,
            'language' => $this->language,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
                ->andFilterWhere(['like', 'email', $this->email])
                ->andFilterWhere(['like', 'phone', $this->phone])
                ->andFilterWhere(['like', 'hotline', $this->hotline])
                ->andFilterWhere(['like', 'fax', $this->fax])
                ->andFilterWhere(['like', 'address', $this->address])
                ->andFilterWhere(['like', 'link_face', $this->link_face])
                ->andFilterWhere(['like', 'link_youtube', $this->link_youtube])
                ->andFilterWhere(['like', 'multitext', $this->multitext]);

        return $dataProvider;
    }

}
