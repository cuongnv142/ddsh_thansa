<?php

namespace app\modules\admin\models;

use app\models\RoutePage;
use app\modules\admin\behaviors\LogActionBehavior;
use Yii;
use yii\data\ActiveDataProvider;

/**
 * AdminRoutePage represents the model behind the search form about `app\models\RoutePage`.
 */
class AdminRoutePage extends RoutePage {

    public function behaviors()
    {
        return [
            LogActionBehavior::className()
        ];
    }
    public function search($params) {
        $query = RoutePage::find();

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
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
                ->andFilterWhere(['like', 'route', $this->route]);

        return $dataProvider;
    }

    public static function getName($id) {
        if ($id) {
            $model = static::findOne($id);
            return $model ? $model->name : '';
        }
        return '';
    }

    public static function getRoute($id) {
        if ($id) {
            $model = static::findOne($id);
            return $model ? $model->route : '';
        }
        return '';
    }

}
