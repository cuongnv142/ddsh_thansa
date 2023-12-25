<?php

namespace app\models;

use yii\db\ActiveRecord;

/**
 * This is the model class for table "boxpage_cat".
 *
 * @property int $id
 * @property string|null $name
 * @property string|null $language
 * @property int $parent_id
 * @property string|null $path
 * @property int $level
 * @property string|null $image
 * @property int|null $status
 * @property string|null $description
 * @property int|null $sort_order
 * @property string $created_at
 * @property string $updated_at
 * @property integer $id_related
 */
class BoxpageCat extends ActiveRecord {

    const parentid_default = 0;
    const level_default = 1;

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return 'boxpage_cat';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['name'], 'required'],
            [['parent_id', 'level', 'status', 'sort_order', 'id_related'], 'integer'],
            [['description'], 'string'],
            [['created_at', 'updated_at'], 'safe'],
            [['name', 'image'], 'string', 'max' => 255],
            [['language'], 'string', 'max' => 50],
            [['language'], 'default', 'value' => 'vi'],
            [['path'], 'string', 'max' => 100],
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
