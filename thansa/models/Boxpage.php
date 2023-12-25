<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "boxpage".
 *
 * @property int $id
 * @property int $boxpage_cat_id
 * @property string|null $name
 * @property string|null $sub_name
 * @property string|null $src
 * @property string|null $link
 * @property int $status
 * @property string|null $multitext
 * @property string|null $short_description
 * @property string|null $description
 * @property int $sort_order
 * @property string $created_at
 * @property string $updated_at
 * @property string|null $language
 * @property integer $id_related
 */
class Boxpage extends ActiveRecord {

    public $project = 'boxpage';

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return 'boxpage';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['name', 'boxpage_cat_id'], 'required'],
            [['boxpage_cat_id', 'status', 'sort_order', 'id_related'], 'integer'],
            [['multitext', 'description', 'short_description'], 'string'],
            [['created_at', 'updated_at'], 'safe'],
            [['name', 'sub_name'], 'string', 'max' => 255],
            [['src'], 'string', 'max' => 255],
            [['link'], 'string', 'max' => 500],
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
            'boxpage_cat_id' => 'Danh mục',
            'name' => 'Tiêu đề',
            'sub_name' => 'Tiêu đề phụ',
            'src' => 'Ảnh',
            'link' => 'Link',
            'multitext' => 'Thuộc tính',
            'short_description' => 'Mô tả ngắn',
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

    public function getLinkFull() {
        $urlHome = Yii::$app->homeUrl;
        if (strpos($this->link, 'http://') === 0 || strpos($this->link, 'https://') === 0) {
            $link = $this->link;
        } elseif (strpos($this->link, 'javascript') === 0) {
            $arr_item = explode(':', $this->link);
            if (isset($arr_item[1]) && !empty($arr_item[1])) {
                $link = 'javascript:void(0);" onclick="' . $arr_item[1];
            } else {
                $link = 'javascript:void(0);';
            }
        } else {
            $link = $urlHome . ltrim($this->link, '/');
        }
        return $link;
    }

}
