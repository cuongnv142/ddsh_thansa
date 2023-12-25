<?php

namespace app\models;

use app\helpers\RedisHelper;
use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "seo_page".
 *
 * @property string $id
 * @property integer $route_id
 * @property string $route_name
 * @property string $page_title
 * @property string $page_keywords
 * @property string $page_description
 * @property string $face_title
 * @property string $face_image
 * @property string $face_description
 * @property string $multitext
 * @property string $language
 * @property integer $id_related
 */
class SeoPage extends ActiveRecord {

    public static $data;
    public $is_change_face;
    public $project = 'customize';

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return 'seo_page';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['route_id'], 'required'],
            [['route_id', 'id_related'], 'integer'],
            [['multitext'], 'string'],
            [['route_name', 'page_title', 'page_keywords', 'page_description', 'face_title', 'face_image', 'face_description'], 'string', 'max' => 255],
            [['is_change_face'], 'safe'],
            [['route_id', 'language'], 'unique', 'targetAttribute' => ['route_id', 'language'], 'message' => 'Thông tin seo cho ngôn ngữ này đã tồn tại!'],
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
            'route_id' => 'Route Page',
            'route_name' => 'Route Name',
            'page_title' => 'Page Title',
            'page_keywords' => 'Page Keywords',
            'page_description' => 'Page Description',
            'face_title' => 'Tiêu đề share Facebook',
            'face_image' => 'Ảnh share Facebook',
            'face_description' => 'Mô tả share Facebook',
            'multitext' => 'Multitext',
            'language' => 'Ngôn ngữ',
            'id_related' => 'Tin liên quan',
        ];
    }

    public static function getDataCache($route_name) {
        $data = RedisHelper::getAllSeopage();
        if (isset($data[$route_name])) {
            return $data[$route_name];
        } else {
            return null;
        }
    }

    public static function getData($route_name) {
        $data = self::$data;
        if (isset($data[$route_name])) {
            return $data[$route_name];
        } else {
            $seopage = self::find()->select('page_title, page_description,page_keywords, face_title, face_image, face_description')->where('route_name =:route_name AND language=:language', [':route_name' => $route_name, ':language' => Yii::$app->language])->asArray()->one();
            $data[$route_name] = $seopage;
            self::$data = $data;
            return $seopage;
        }
    }

}
