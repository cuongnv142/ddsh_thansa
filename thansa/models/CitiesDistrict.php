<?php

namespace app\models;

use yii\db\ActiveRecord;

/**
 * This is the model class for table "cities_district".
 *
 * @property string $id
 * @property string $name
 * @property string $code
 * @property integer $type
 * @property integer $parent_id
 * @property integer $sort_order
 * @property integer $sort_order_footer
 * @property integer $status
 * @property integer $crawl_id
 * @property string $lat
 * @property string $lng
 * @property integer $is_home
 * @property string $alias
 */
class CitiesDistrict extends ActiveRecord {

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return 'cities_district';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['type', 'parent_id', 'sort_order', 'sort_order_footer', 'status', 'crawl_id', 'is_home'], 'integer'],
            [['name', 'code', 'lat', 'lng', 'alias'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'name' => 'Tiêu đề',
            'code' => 'Mã',
            'type' => 'Kiểu',
            'parent_id' => 'Tỉnh thành',
            'sort_order' => 'Thứ tự',
            'sort_order_footer' => 'Thứ tự chân trang',
            'status' => 'Trạng thái',
            'crawl_id' => 'Id Crawl',
            'lat' => 'Lat',
            'lng' => 'Lng',
            'is_home' => 'Hiện chân trang',
            'alias' => 'Alias',
        ];
    }

    public static function getCities() {

        $cities = self::find();
        $cities->select(['id', 'name', 'code']);
        $cities->where(['status' => 1, 'parent_id' => 0]);
        $cities->orderBy([
            '(sort_order=0)' => SORT_ASC,
            'sort_order' => SORT_ASC,
            'name' => SORT_ASC,
        ]);
        $cities->asArray();
        return $cities->all();
    }

    public static function getCitiesPostion() {
        $cities = self::find()
                ->select('id,lat,lng')
                ->where(['status' => 1, 'parent_id' => 0])
                ->asArray()
                ->all();
        $citiessArray = array();
        foreach ($cities as $item) {
            $citiessArray[$item['id']][] = $item;
        }
        return $citiessArray;
    }

    public static function getDistrictsPostion() {
        $districts = self::find()
                ->select('id,lat,lng')
                ->where('parent_id>0')
                ->asArray()
                ->all();
        $districtsArray = array();
        foreach ($districts as $item) {
            $districtsArray[$item['id']][] = $item;
        }
        return $districtsArray;
    }

    public static function getDistricts() {
        $employees = self::find()
                ->select('id,name,parent_id,code')
                ->where('status=1 AND parent_id>0')
                ->orderBy([
                    'parent_id' => SORT_ASC,
                    '(sort_order=0)' => SORT_ASC,
                    'sort_order' => SORT_ASC,
                    'name' => SORT_ASC,
                ])
                ->asArray()
                ->all();
        return $employees;
    }

    public static function getDistrictsByCities($id_city) {
        if ($id_city) {
            $employees = self::find()
                    ->select('id,name,parent_id,code')
                    ->where('status=1 AND parent_id=' . (int) $id_city)
                    ->orderBy([
                        '(sort_order=0)' => SORT_ASC,
                        'sort_order' => SORT_ASC,
                        'name' => SORT_ASC,
                    ])
                    ->asArray()
                    ->all();
            return $employees;
        }
        return false;
    }

    public static function getDistrictsAray() {
        $districts = self::getDistricts();
        $districtsArray = array();
        foreach ($districts as $item) {
            $districtsArray[$item['parent_id']][] = $item;
        }
        return $districtsArray;
    }

    public static function getNameById($id) {
        $cities = self::findOne($id);
        if ($cities) {
            return $cities->name;
        }
        return '';
    }

}
