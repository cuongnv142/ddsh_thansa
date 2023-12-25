<?php

namespace app\modules\admin\models;

use app\models\User;
use app\modules\admin\behaviors\LogActionBehavior;
use app\modules\admin\behaviors\SetterImageBehavior;
use Yii;
use yii\data\ActiveDataProvider;
use yii\helpers\ArrayHelper;

/**
 * AdminUser represents the model behind the search form about `app\models\User`.
 */
class AdminUser extends User {

    public function behaviors() {
        return [
            LogActionBehavior::className(),
            SetterImageBehavior::className()
        ];
    }

    public function search($params, $pageSize = true) {
        $query = User::find();
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
                // Set the default sort by name ASC and created_at DESC.
                'defaultOrder' => [
                    'id' => SORT_DESC
                ]
            ]
        ]);

        $this->load($params);
        $query->from('user t');
        $query->andFilterWhere([
            't.id' => $this->id,
            't.cities_id' => $this->cities_id,
            't.cities_district_id' => $this->cities_district_id,
            't.dob' => $this->dob,
            't.updated_at' => $this->updated_at,
            't.last_signined_time' => $this->last_signined_time,
            't.is_admin' => $this->is_admin,
            't.status' => $this->status,
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
                            ['>=', 'DATE(t.created_at)', $date_from]
                    );
                }
            }
            if ($date_to) {
                $arrD = explode('/', $date_to);
                if (count($arrD) == 3) {
                    $date_to = date('Y-m-d', strtotime(implode('-', array($arrD[2], $arrD[1], $arrD[0]))));
                    $query->andFilterWhere(
                            ['<=', 'DATE(t.created_at)', $date_to]
                    );
                }
            }
        }
        $query->andFilterWhere(['like', 'first_name', $this->first_name])
                ->andFilterWhere(['like', 'password', $this->password])
                ->andFilterWhere(['like', 'email', $this->email])
                ->andFilterWhere(['like', 'phone', $this->phone])
                ->andFilterWhere(['like', 'avatar', $this->avatar])
                ->andFilterWhere(['like', 'gender', $this->gender])
                ->andFilterWhere(['like', 'address', $this->address]);
        if (!self::is_adminsupper()) {
            $query->andFilterWhere(['<>', 't.status', -3])
                    ->andFilterWhere(['<>', 't.role', 'admin']);
        }
        return $dataProvider;
    }

    function attributeLabels() {
        return ArrayHelper::merge(parent::attributeLabels(), [
                    'city_name' => 'Tỉnh / Thành Phố',
                    'district_name' => 'Quận / Huyện',
        ]);
    }

    public static function getName($id = 0) {
        if ($id) {
            $model = static::findOne($id);
            if ($model) {
                if ($model->first_name) {
                    return ($model->first_name . ' - ' . $model->email);
                } else {
                    return $model->email;
                }
            }
        }
        return '';
    }

}
