<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "log_action".
 *
 * @property string $id
 * @property string $url
 * @property integer $user_id
 * @property string $username
 * @property string $ip
 * @property string $module
 * @property string $controller
 * @property string $action
 * @property string $created_at
 */
class LogAction extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'log_action';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id'], 'integer'],
            [['created_at'], 'safe'],
            [['url', 'username'], 'string', 'max' => 255],
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
            'created_at' => 'Created At',
        ];
    }
}
