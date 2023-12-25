<?php

namespace app\modules\admin\models;

use app\models\Subscribe;
use app\modules\admin\behaviors\LogActionBehavior;
use Yii;
use yii\data\ActiveDataProvider;

class AdminSubscribe extends Subscribe {

    public function behaviors() {
        return [
            LogActionBehavior::className(),
        ];
    }

    public function search($params, $pageSize = true) {
        $query = Subscribe::find();
        if ($pageSize) {
            $pagination = [
                'pageSize' => Yii::$app->params['defaultPageSizeAdmin'],
            ];
        } else {
            $pagination = false;
        }
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => $pagination,
            'sort' => [
                'defaultOrder' => [
                    'id' => SORT_DESC
                ]
            ]
        ]);

        $this->load($params);

        $query->andFilterWhere([
            'subscribe.id' => $this->id,
//            'created_at' => $this->created_at,
            'subscribe.updated_at' => $this->updated_at,
            'subscribe.status' => $this->status,
            'subscribe.type' => ($this->type) ? (int) $this->type : 0,
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
                            ['>=', 'DATE(subscribe.created_at)', $date_from]
                    );
                }
            }
            if ($date_to) {
                $arrD = explode('/', $date_to);
                if (count($arrD) == 3) {
                    $date_to = date('Y-m-d', strtotime(implode('-', array($arrD[2], $arrD[1], $arrD[0]))));
                    $query->andFilterWhere(
                            ['<=', 'DATE(subscribe.created_at)', $date_to]
                    );
                }
            }
        }
        $query->andFilterWhere(['like', 'subscribe.name', $this->name])
                ->andFilterWhere(['like', 'subscribe.phone', $this->phone])
                ->andFilterWhere(['like', 'subscribe.email', $this->email])
                ->andFilterWhere(['like', 'subscribe.note', $this->note])
                ->andFilterWhere(['like', 'subscribe.ip', $this->ip]);

        return $dataProvider;
    }

}
