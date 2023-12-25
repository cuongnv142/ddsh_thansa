<?php

namespace app\modules\admin\models;

use app\models\News;
use app\modules\admin\behaviors\LogActionBehavior;
use app\modules\admin\behaviors\SetterImageBehavior;
use Yii;
use yii\data\ActiveDataProvider;

class AdminNews extends News {

    public function behaviors() {
        return [
            LogActionBehavior::className(),
            SetterImageBehavior::className()
        ];
    }

    public function search($params) {
        $query = News::find();

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
        if ($this->updated_at) {
            $arrDate = explode('-', $this->updated_at);
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
                            ['>=', 'DATE(updated_at)', $date_from]
                    );
                }
            }
            if ($date_to) {
                $arrD = explode('/', $date_to);
                if (count($arrD) == 3) {
                    $date_to = date('Y-m-d', strtotime(implode('-', array($arrD[2], $arrD[1], $arrD[0]))));
                    $query->andFilterWhere(
                            ['<=', 'DATE(updated_at)', $date_to]
                    );
                }
            }
        }
        $arrDate_Post = explode('-', $this->post_at);
        $datepost_from = '';
        $datepost_to = '';
        if (count($arrDate_Post) > 1) {
            $datepost_from = trim($arrDate_Post[0]);
            $datepost_to = trim($arrDate_Post[1]);
        } else {
            $datepost_from = trim($arrDate_Post[0]);
        }
        if ($datepost_from) {
            $arrD = explode('/', $datepost_from);
            if (count($arrD) == 3) {
                $datepost_from = date('Y-m-d', strtotime(implode('-', array($arrD[2], $arrD[1], $arrD[0]))));
                $query->andFilterWhere(
                        ['>=', 'DATE(post_at)', $datepost_from]
                );
            }
        }
        if ($datepost_to) {
            $arrD = explode('/', $datepost_to);
            if (count($arrD) == 3) {
                $datepost_to = date('Y-m-d', strtotime(implode('-', array($arrD[2], $arrD[1], $arrD[0]))));
                $query->andFilterWhere(
                        ['<=', 'DATE(post_at)', $datepost_to]
                );
            }
        }
        $query->andFilterWhere([
            'id' => $this->id,
            'news_cat_id' => $this->news_cat_id,
            'sort_order' => $this->sort_order,
            'created_at' => $this->created_at,
            'status' => $this->status,
            'source' => $this->source,
            'is_hot' => $this->is_hot,
            'is_system' => $this->is_system,
            'language' => $this->language,
            'id_related' => $this->id_related,
        ]);

        $query->andFilterWhere(['like', 'name', trim($this->name)])
                ->andFilterWhere(['like', 'author', $this->author])
                ->andFilterWhere(['like', 'short_description', $this->short_description])
                ->andFilterWhere(['like', 'description', $this->description]);

        return $dataProvider;
    }

    public static function getName($id) {
        if ($id) {
            $model = static::findOne($id);
            return $model ? $model->name : '';
        }
        return '';
    }

}
