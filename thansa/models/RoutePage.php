<?php

namespace app\models;

use yii\db\ActiveRecord;

/**
 * This is the model class for table "route_page".
 *
 * @property string $id
 * @property string $name
 * @property string $route
 */
class RoutePage extends ActiveRecord {

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return 'route_page';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['name', 'route'], 'required'],
            [['name', 'route'], 'string', 'max' => 255],
            [['name'], 'unique'],
            [['route'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'name' => 'Tiêu đề',
            'route' => 'Route page',
        ];
    }

}
