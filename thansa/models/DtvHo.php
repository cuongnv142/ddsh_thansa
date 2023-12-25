<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "dtv_ho".
 *
 * @property int $id
 * @property string|null $name
 * @property string|null $name_latinh
 * @property int|null $loai Phân loại: 0: thực vât, 1: động vật
 * @property int|null $id_dtv_bo
 * @property int|null $status
 * @property string|null $created_at
 * @property int|null $created_by
 * @property string|null $updated_at
 * @property int|null $updated_by
 */
class DtvHo extends ActiveRecord {

    /**
     * {@inheritdoc}
     */
    public static function tableName() {
        return 'dtv_ho';
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['name','loai','id_dtv_bo'], 'required'],
            [['loai', 'id_dtv_bo', 'status', 'created_by', 'updated_by'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['name', 'name_latinh'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
             'name' => 'Tên tiếng việt',
            'name_latinh' => 'Tên Latinh',
            'loai' => 'Phân loại',
            'status' => 'Trạng thái',
            'id_dtv_bo' => 'Bộ',
            'created_at' => 'Created At',
            'created_by' => 'Created By',
            'updated_at' => 'Updated At',
            'updated_by' => 'Updated By',
        ];
    }

    public function beforeSave($insert) {
        if (parent::beforeSave($insert)) {
            if ($this->isNewRecord) {
                $this->created_at = date('Y-m-d H:i:s');
                $this->created_by = (int) Yii::$app->getUser()->getId();
            }

            $this->updated_at = date('Y-m-d H:i:s');
            $this->updated_by = (int) Yii::$app->getUser()->getId();
        }
        return true;
    }

}
