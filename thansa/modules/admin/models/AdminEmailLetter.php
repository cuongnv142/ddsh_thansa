<?php

namespace app\modules\admin\models;

use app\models\EmailLetter;
use app\modules\admin\behaviors\LogActionBehavior;
use Yii;
use yii\data\ActiveDataProvider;


class AdminEmailLetter extends EmailLetter {
    public function behaviors()
    {
        return [
            LogActionBehavior::className()
        ];
    }
    public function search($params) {
        $query = EmailLetter::find();
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
            'status' => $this->status,
//            'created_at' => $this->created_at,
        ]);
        if ($this->created_at) {
            $arrDate = explode('-', $this->created_at);
            $date_from = '';
            $date_to = '';
            if (count($arrDate) > 1) {
                $date_from = trim($arrDate[0]);
                $date_to = trim($arrDate[1]);
            } else {
                $date_from = trim($arrDate[0]);
            }
            if ($date_from) {
                $arrD = explode('/', $date_from);
                if (count($arrD) == 3) {
                    $date_from = date('Y-m-d', strtotime(implode('-', array($arrD[2], $arrD[1], $arrD[0]))));
                    $query->andFilterWhere(
                            ['>=', 'DATE(created_at)', $date_from]
                    );
                }
            }
            if ($date_to) {
                $arrD = explode('/', $date_to);
                if (count($arrD) == 3) {
                    $date_to = date('Y-m-d', strtotime(implode('-', array($arrD[2], $arrD[1], $arrD[0]))));
                    $query->andFilterWhere(
                            ['<=', 'DATE(created_at)', $date_to]
                    );
                }
            }
        }
        $query->andFilterWhere(['like', 'email', $this->email])
                ->andFilterWhere(['like', 'language', $this->language]);

        return $dataProvider;
    }

}
