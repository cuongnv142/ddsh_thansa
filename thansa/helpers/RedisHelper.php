<?php

namespace app\helpers;

use Exception;
use Yii;
use yii\db\Query;

class RedisHelper {

    const KEY_ALLSEOPAGE = 'Seopage';

    public static function setAllSeopage() {
        $query = new Query();
        $query->select(['*']);
        $query->from('seo_page');
        $data = $query->all();

        if ($data) {
            $reVal = [];
            foreach ($data as $item) {
                $reVal[$item['route_name']] = $item;
            }
            Yii::$app->redis->set(self::KEY_ALLSEOPAGE, json_encode($reVal));
        }
    }

    public static function getAllSeopage() {
        try {
            $zones = Yii::$app->redis->mget(self::KEY_ALLSEOPAGE);
            if (!empty($zones)) {
                $zones = json_decode($zones[0], true);
            }
            return $zones;
        } catch (Exception $ex) {
            return null;
        }
        return null;
    }

}
