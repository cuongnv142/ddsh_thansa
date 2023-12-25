<?php

namespace app\models;

use \Yii;

/**
 * This is the model class for table "image_general".
 *
 * @property string $id
 * @property integer $id_object
 * @property integer $id_user
 * @property string $name
 * @property integer $type
 * @property string $created_at
 * @property integer $status
 * @property integer $mode
 */
class ImageGeneral extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'image_general';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id','object_id', 'user_id', 'type', 'status', 'mode'], 'integer'],
            [['created_at'], 'safe'],
            [['name'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'object_id' => 'Id Object',
            'user_id' => 'Id User',
            'name' => 'Name',
            'type' => 'Type',
            'created_at' => 'Created At',
            'status' => 'Status',
            'mode' => 'Mode',
        ];
    }
}
