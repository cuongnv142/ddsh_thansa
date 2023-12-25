<?php

namespace app\models;

use app\helpers\StringHelper;
use app\models\Tag;
use yii\db\ActiveRecord;
use yii\db\Query;

/**
 * This is the model class for table "tag_rel".
 *
 * @property string $tag_id
 * @property string $object_id
 * @property integer $type
 * @property integer $sort_order
 */
class TagRel extends ActiveRecord {

    public static $ids = [];
    public static $arrType = [
        1 => 'Tin tức',
    ];

    const TYPE_NEWS = 1;

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return 'tag_rel';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['tag_id', 'object_id', 'type'], 'required'],
            [['tag_id', 'object_id', 'type', 'sort_order'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'tag_id' => 'Tag ID',
            'object_id' => 'Object ID',
            'type' => 'Type',
            'sort_order' => 'Sort Order',
        ];
    }

    public static function getTagsByType($object_id, $type) {
        $reVal = '';
        if ((int) $object_id) {
            $query = new Query();
            $query->select(['GROUP_CONCAT(t.name SEPARATOR ";") AS tags']);
            $query->from('tag_rel tr');
            $query->leftJoin('tag t', 'tr.tag_id=t.id');
            $query->where(['tr.object_id' => $object_id, 'tr.type' => $type]);
            $query->groupBy('tr.object_id');
            $reVal = $query->scalar();
        }
        return $reVal;
    }

    public static function getTagsByTypeArray($object_id, $type) {
        $reVal = '';
        if ((int) $object_id) {
            $query = new Query();
            $query->select('t.name,t.tag,t.id');
            $query->from('tag_rel tr');
            $query->leftJoin('tag t', 'tr.tag_id=t.id');
            $query->where(['tr.object_id' => $object_id, 'tr.type' => $type]);
            $query->groupBy('t.id');
            $reVal = $query->all();
        }
        return $reVal;
    }

    public static function saveMultilTag($tags, $object_id, $type) {
        TagRel::deleteAll(['object_id' => $object_id, 'type' => $type]);
        if ($tags) {
            $arrTag = explode(';', $tags);
            for ($i = 0; $i < count($arrTag); $i++) {
                $name = trim($arrTag[$i]);
                $tag = Tag::find()->andFilterWhere(['name' => $name])->one();
                if ($tag === NULL) {
                    $tag = new Tag();
                    $tag->name = $name;
                    $tag->tag = StringHelper::formatUrlKey($name);
                    $tag->status = 1;
                    $tag->save();
                }
                if ((int) $tag->id) {
                    $tagrel = new TagRel();
                    $tagrel->tag_id = $tag->id;
                    $tagrel->object_id = $object_id;
                    $tagrel->type = $type;
                    $tagrel->sort_order = 0;
                    $tagrel->save();
                }
            }
        }
    }

}
