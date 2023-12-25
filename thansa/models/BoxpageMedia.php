<?php

namespace app\models;

use yii\db\ActiveRecord;

/**
 * This is the model class for table "boxpage_media".
 *
 * @property int $id
 * @property int|null $boxpage_id
 * @property string|null $name
 * @property string|null $path
 * @property string|null $path_video
 * @property int|null $type
 * @property int|null $sub_type
 * @property int|null $is_default
 * @property int|null $sort_order
 * @property string|null $created_at
 */
class BoxpageMedia extends ActiveRecord {

    const IMAGE_THUONG = 10;
    const IMAGE_NOIDUNG = 11;
    const VIDEO_THUONG = 20;
    const TAILIEU_PDF = 30;
    const YOUTUBE = 40;

    /**
     * {@inheritdoc}
     */
    public static function tableName() {
        return 'boxpage_media';
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['boxpage_id', 'type', 'sub_type', 'is_default', 'sort_order'], 'integer'],
            [['created_at'], 'safe'],
            [['name', 'path', 'path_video'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'boxpage_id' => 'Id Project',
            'name' => 'Name',
            'path' => 'Path',
            'path_video' => 'Path Video',
            'type' => 'Type',
            'sub_type' => 'Sub Type',
            'is_default' => 'Is Default',
            'sort_order' => 'Sort Order',
            'created_at' => 'Created At',
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
