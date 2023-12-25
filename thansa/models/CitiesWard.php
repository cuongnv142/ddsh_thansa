<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "cities_ward".
 *
 * @property string $id
 * @property integer $cities_id
 * @property integer $cities_district_id
 * @property string $name
 * @property string $code
 * @property integer $type
 * @property integer $sort_order
 * @property integer $status
 * @property integer $id_crawl
 * @property string $lat
 * @property string $lng
 */
class CitiesWard extends \yii\db\ActiveRecord {

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return 'cities_ward';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['cities_id', 'cities_district_id', 'type', 'sort_order', 'status', 'id_crawl'], 'integer'],
            [['name', 'code', 'lat', 'lng'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'cities_id' => 'Id City',
            'cities_district_id' => 'Id District',
            'name' => 'Name',
            'code' => 'Code',
            'type' => 'Type',
            'sort_order' => 'Sort Order',
            'status' => 'Status',
            'id_crawl' => 'Id Crawl',
            'lat' => 'Lat',
            'lng' => 'Lng',
        ];
    }

    public static function getWard() {
        $employees = self::find()
                ->select('id,name,cities_id,cities_district_id,type')
                ->where('status=1')
                ->orderBy('sort_order, name')
                ->asArray()
                ->all();
        return $employees;
    }

    public static function getWardAray() {
        $ward = self::getWard();
        $wardArray = array();
        foreach ($ward as $item) {
            $wardArray[$item['cities_id']][$item['cities_district_id']][] = $item;
        }
        return $wardArray;
    }

    public static function getWardPostion() {
        $wards = self::find()
                ->select('id,lat,lng')
                ->where(['status' => 1])
                ->asArray()
                ->all();
        $wardsArray = array();
        foreach ($wards as $item) {
            $wardsArray[$item['id']][] = $item;
        }
        return $wardsArray;
    }

    public static function getNameById($id) {
        $wards = self::findOne($id);
        if ($wards) {
            return $wards->name;
        }
        return '';
    }

}
