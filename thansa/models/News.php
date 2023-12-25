<?php

namespace app\models;

use yii\db\ActiveRecord;

/**
 * This is the model class for table "news".
 *
 * @property string $id
 * @property integer $root_news_cat_id
 * @property integer $news_cat_id
 * @property string $image
 * @property string $short_description
 * @property string $description
 * @property string $title_seo
 * @property string $content_seo
 * @property string $key_seo
 * @property string $source
 * @property string $author
 * @property integer $sort_order
 * @property string $created_at
 * @property string $post_at
 * @property string $updated_at
 * @property integer $status
 * @property integer $is_hot
 * @property integer $is_system
 * @property integer $alias
 * @property string $language
 * @property integer $id_related
 */
class News extends ActiveRecord {

    public $tags;
    public $time_post;

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return 'news';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['name', 'news_cat_id'], 'required'],
            [['news_cat_id', 'sort_order', 'status', 'is_hot', 'is_system', 'root_news_cat_id', 'id_related'], 'integer'],
            [['short_description', 'description', 'source', 'author', 'title_seo', 'content_seo', 'key_seo'], 'string'],
            [['created_at', 'updated_at', 'post_at', 'time_post', 'tags'], 'safe'],
            [['name', 'alias'], 'string', 'max' => 300],
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
            'news_cat_id' => 'Danh mục',
            'name' => 'Tiêu đề',
            'alias' => 'Alias',
            'image' => 'Ảnh',
            'short_description' => 'Giới thiệu',
            'description' => 'Nội dung',
            'sort_order' => 'Thứ tự',
            'created_at' => 'Ngày tạo',
            'updated_at' => 'Cập nhật',
            'status' => 'Trạng thái',
            'is_hot' => 'Tin nổi bật',
            'is_system' => 'Tin hệ thống',
            'source' => 'Nguồn tin',
            'author' => 'Tác giả',
            'tags' => 'Tag',
            'title_seo' => 'Tiêu đề SEO',
            'content_seo' => 'Nội dung SEO',
            'key_seo' => 'Từ khóa SEO',
            'post_at' => 'Thời gian xuất bản',
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
