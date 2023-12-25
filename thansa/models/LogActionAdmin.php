<?php

namespace app\models;

use Yii;
use yii\data\ActiveDataProvider;

/**
 * This is the model class for table "log_action_admin".
 *
 * @property string $id
 * @property string $url
 * @property string $user_id
 * @property string $username
 * @property string $ip
 * @property string $module
 * @property string $controller
 * @property string $action
 * @property integer $id_object
 * @property string $name_object
 * @property string $created_at
 * @property string $befor_data
 * @property string $after_data
 */
class LogActionAdmin extends \yii\db\ActiveRecord
{
    

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'log_action_admin';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'id_object'], 'integer'],
            [['created_at'], 'safe'],
            [['befor_data', 'after_data'], 'string'],
            [['url', 'username', 'name_object'], 'string', 'max' => 255],
            [['ip'], 'string', 'max' => 64],
            [['module', 'controller', 'action'], 'string', 'max' => 128]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'url' => 'Url',
            'user_id' => 'User ID',
            'username' => 'Username',
            'ip' => 'Ip',
            'module' => 'Module',
            'controller' => 'Controller',
            'action' => 'Action',
            'id_object' => 'Id Object',
            'name_object' => 'Name Object',
            'created_at' => 'Ngày tạo',
            'befor_data' => 'Befor Data',
            'after_data' => 'After Data',
        ];
    }

    public function search($params)
    {
        $query = self::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                // Set the default sort by name ASC and created_at DESC.
                'defaultOrder' => [
                    'id' => SORT_DESC
                ]
            ],
        ]);

        $this->load($params);

        $query->andFilterWhere([
            'id' => $this->id,
            'user_id' => $this->user_id,
            'id_object' => $this->id_object,
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
        $query->andFilterWhere(['like', 'url', $this->url])
            ->andFilterWhere(['like', 'username', $this->username])
            ->andFilterWhere(['like', 'ip', $this->ip])
            ->andFilterWhere(['like', 'module', $this->module])
            ->andFilterWhere(['like', 'controller', $this->controller])
            ->andFilterWhere(['like', 'action', $this->action])
            ->andFilterWhere(['like', 'name_object', $this->name_object])
            ->andFilterWhere(['like', 'after_data', $this->after_data])
            ->andFilterWhere(['like', 'befor_data', $this->befor_data]);

        return $dataProvider;
    }

}
