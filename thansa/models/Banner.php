<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "banner".
 *
 * @property string $id
 * @property integer $banner_cat_id
 * @property string $name
 * @property string $src
 * @property string $src_mobile
 * @property string $link
 * @property integer $width
 * @property integer $height
 * @property integer $type
 * @property string $multitext
 * @property string $description
 * @property integer $sort_order
 * @property string $created_at
 * @property string $updated_at
 * @property integer $status
 * @property string $language
 * @property integer $id_related
 */
class Banner extends ActiveRecord {

    public $project = 'banner';

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return 'banner';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['type', 'sort_order', 'status', 'width', 'height', 'id_related'], 'integer'],
            [['name', 'banner_cat_id'], 'required'],
            [['width', 'height'], 'default', 'value' => 0],
            [['multitext', 'description'], 'string'],
            [['created_at', 'updated_at'], 'safe'],
            [['name'], 'string', 'max' => 300],
            [['src', 'src_mobile'], 'string', 'max' => 255],
            [['link'], 'string', 'max' => 400],
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
            'banner_cat_id' => 'Danh mục',
            'name' => 'Tiêu đề',
            'src' => 'Ảnh',
            'src_mobile' => 'Ảnh mobile',
            'link' => 'Link',
            'width' => 'Chiều rộng',
            'height' => 'Chiều cao',
            'type' => 'Loại',
            'multitext' => 'Thuộc tính',
            'description' => 'Mô tả',
            'sort_order' => 'Sắp xếp',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
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
