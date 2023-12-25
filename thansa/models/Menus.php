<?php

namespace app\models;

use yii\db\ActiveRecord;

/**
 * This is the model class for table "menus".
 *
 * @property int $id
 * @property string|null $language
 *  @property int|null $menu_group_id
 * @property int|null $type_menu
 * @property int|null $id_object
 * @property string|null $gen_url
 * @property string|null $name
 * @property int $parent_id
 * @property string|null $path
 * @property int $level
 * @property string|null $image
 * @property string|null $image_hover
 * @property int|null $status
 * @property int|null $sort_order
 * @property string $created_at
 * @property string $updated_at
 * @property int|null $id_related
 * @property string|null $link_menu
 */
class Menus extends ActiveRecord {

    const parentid_default = 0;
    const level_default = 1;

    public static $arrTypeMenu = [
        0 => 'Trang chủ',
        4 => 'Tổng quan',
        5 => 'Vị trí',
        6 => 'Phân khu',
        7 => 'VIRTUAL',
        1 => 'Danh mục tin tức',
        2 => 'Link',
        3 => 'Label',
    ];
    public static $arrGroupMenu = [
        0 => 'Menu header',
        1 => 'Menu footer',
    ];

    /**
     * {@inheritdoc}
     */
    public static function tableName() {
        return 'menus';
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['name'], 'required'],
            [['type_menu', 'id_object', 'parent_id', 'level', 'status', 'sort_order', 'id_related', 'menu_group_id'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['language'], 'string', 'max' => 50],
            [['language'], 'default', 'value' => 'vi'],
            [['gen_url', 'name', 'image', 'image_hover', 'image_hover', 'link_menu'], 'string', 'max' => 255],
            [['path'], 'string', 'max' => 100],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'language' => 'Ngôn ngữ',
            'menu_group_id' => 'Nhóm menu',
            'type_menu' => 'Kiểu menu',
            'id_object' => 'Danh mục tin tức',
            'gen_url' => 'Gen Url',
            'name' => 'Tiêu đề',
            'parent_id' => 'Menu cha',
            'path' => 'Path',
            'level' => 'Cấp độ',
            'image' => 'Ảnh',
            'image_hover' => 'Ảnh hover',
            'sort_order' => 'Thứ tự',
            'created_at' => 'Ngày tạo',
            'updated_at' => 'Ngày sửa',
            'status' => 'Trạng thái',
            'id_related' => 'Menu liên quan',
            'link_menu' => 'Link menu',
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
