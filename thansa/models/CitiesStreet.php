<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "cities_street".
 *
 * @property string $id
 * @property integer $id_city
 * @property integer $id_district
 * @property string $name
 * @property integer $type
 * @property integer $sort_order
 * @property integer $status
 * @property integer $id_crawl
 * @property string $lat
 * @property string $lng
 */
class CitiesStreet extends \yii\db\ActiveRecord {

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return 'cities_street';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['id_city', 'id_district', 'type', 'sort_order', 'status', 'id_crawl'], 'integer'],
            [['name', 'lat', 'lng'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'id_city' => 'Id City',
            'id_district' => 'Id District',
            'name' => 'Name',
            'type' => 'Type',
            'sort_order' => 'Sort Order',
            'status' => 'Status',
            'id_crawl' => 'Id Crawl',
            'lat' => 'Lat',
            'lng' => 'Lng',
        ];
    }

    public static function getStreet() {
        $employees = self::find()
                ->select('id,name,id_city,id_district,type')
                ->where('status=1')
                ->orderBy('sort_order, name')
                ->asArray()
                ->all();
        return $employees;
    }

    public static function getStreetAray() {
        $street = self::getStreet();
        $streetArray = array();
        foreach ($street as $item) {
            $streetArray[$item['id_city']][$item['id_district']][] = $item;
        }
        return $streetArray;
    }

    public static function getStreetPostion() {
        $street = self::find()
                ->select('id,lat,lng')
                ->where(['status' => 1])
                ->asArray()
                ->all();
        $streetsArray = array();
        foreach ($street as $item) {
            $streetsArray[$item['id']][] = $item;
        }
        return $streetsArray;
    }

    public static function getNameById($id) {
        $street = self::findOne($id);
        if ($street) {
            return $street->name;
        }
        return '';
    }

}
