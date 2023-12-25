<?php

namespace app\models;

use \Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "image_general_directory".
 *
 * @property integer $id
 * @property string $name
 * @property integer $parent_id
 */
class ImageGeneralDirectory extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'image_general_directory';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['parent_id'], 'integer'],
            [['name'], 'string', 'max' => 32]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'parent_id' => 'Parent ID'
        ];
    }

    public static function getDirectoryFull($id)
    {
        $paths = [];
        if ($id) {
            $item = self::findOne($id);
            if ($item) {
                $paths[] = $item->name;
                if ($item->parent_id) {
                    $paths = ArrayHelper::merge($paths, self::getDirectoryFull($item->parent_id));
                }
            }
        }
      return $paths;
    }
}
