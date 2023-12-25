<?php

namespace app\models;

use \Yii;

/**
 * This is the model class for table "banner_cat".
 *
 * @property string $id
 * @property string $name
 * @property integer $parent_id
 * @property string $path
 * @property integer $level
 * @property string $image
 * @property string $description
 * @property integer $sort_order
 * @property string $created_at
 * @property string $updated_at
 * @property integer $status
 * @property string $language
 * @property integer $id_related
 */
class BannerCat extends \yii\db\ActiveRecord {

    const parentid_default = 0;
    const level_default = 1;

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return 'banner_cat';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['name'], 'required'],
            [['parent_id', 'level', 'sort_order', 'status', 'id_related'], 'integer'],
            [['description'], 'string'],
            [['created_at', 'updated_at'], 'safe'],
            [['name'], 'string', 'max' => 300],
            [['path'], 'string', 'max' => 100],
            [['image'], 'string', 'max' => 255],
            [['language'], 'string', 'max' => 50],
            [['language'], 'default', 'value' => 'vi'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'name' => 'Tiêu đề',
            'parent_id' => 'Danh mục cha',
            'path' => 'Path',
            'level' => 'Cấp độ',
            'image' => 'Ảnh',
            'description' => 'Mô tả',
            'sort_order' => 'Thứ tự',
            'created_at' => 'Ngày tạo',
            'updated_at' => 'Ngày sửa',
            'status' => 'Trạng thái',
            'language' => 'Ngôn ngữ',
            'id_related' => 'Tin liên quan',
        ];
    }

    public function beforeSave($insert) {
        if (parent::beforeSave($insert)) {
            if ($this->isNewRecord) {
                $this->created_at = date('Y-m-d H:i:s');
            }
            $this->updated_at = date('Y-m-d H:i:s');
        }
        return true;
    }

}
