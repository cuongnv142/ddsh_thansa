<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "email_letter".
 *
 * @property int $id
 * @property string|null $email
 * @property int|null $status
 * @property string|null $created_at
 * @property string|null $language
 */
class EmailLetter extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'email_letter';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['status'], 'integer'],
            [['created_at'], 'safe'],
            [['email'], 'string', 'max' => 255],
            [['language'], 'string', 'max' => 50],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'email' => 'Email',
            'status' => 'Trạng thái',
            'created_at' => 'Ngày đăng ký',
            'language' => 'Ngôn ngữ',
        ];
    }
    public function beforeSave($insert) {

        if (parent::beforeSave($insert)) {
            if ($this->isNewRecord) {
                $this->created_at = date('Y-m-d H:i:s');
            }
        }
        return true;
    }
}
