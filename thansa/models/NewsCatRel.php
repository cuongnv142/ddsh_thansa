<?php

namespace app\models;

use yii\redis\ActiveRecord;

/**
 * This is the model class for table "news_cat_rel".
 *
 * @property int $news_id
 * @property int $news_cat_id
 * @property string|null $created_at
 */
class NewsCatRel extends ActiveRecord {

    /**
     * {@inheritdoc}
     */
    public static function tableName() {
        return 'news_cat_rel';
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['news_id', 'news_cat_id'], 'required'],
            [['news_id', 'news_cat_id'], 'integer'],
            [['created_at'], 'safe'],
            [['news_id', 'news_cat_id'], 'unique', 'targetAttribute' => ['news_id', 'news_cat_id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'news_id' => 'News ID',
            'news_cat_id' => 'News Cat ID',
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
