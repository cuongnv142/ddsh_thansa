<?php

namespace app\models;

use yii\db\ActiveRecord;
use yii\db\Query;

/**
 * This is the model class for table "tag".
 *
 * @property string $id
 * @property string $name
 * @property string $tag
 * @property string $title_seobox
 * @property string $des_seobox
 * @property integer $feature_tag
 * @property integer $status
 * @property string $page_title
 * @property string $page_description
 */
class Tag extends ActiveRecord {

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return 'tag';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['name', 'tag'], 'required'],
            [['status', 'feature_tag'], 'integer'],
            [['name', 'page_title', 'title_seobox'], 'string', 'max' => 255],
            [['des_seobox'], 'string'],
            [['tag'], 'unique'],
            [['page_description'], 'string', 'max' => 160]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'name' => 'Tiêu đề',
            'status' => 'Trạng thái',
            'page_title' => 'Page Title',
            'page_description' => 'Page Description',
            'tag' => 'Alias',
            'feature_tag' => 'Feature Tag',
            'title_seobox' => 'Tiêu đề SEO BOX',
            'des_seobox' => 'Mô tả SEO BOX'
        ];
    }

    public static function getListTags() {
        $reVal = '';
        $query = new Query();
        $query->select(['name']);
        $query->from('tag');
        $data = $query->column();
        if ($data) {
            $reVal = implode(';', $data);
        }
        return $reVal;
    }

}
