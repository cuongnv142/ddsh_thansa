<?php

namespace app\helpers;

use Yii;
use app\helpers\StringHelper;
use yii\db\Query;

class LogIPHelper {

    const totalcount = 5;

    public static function log_ip_login($username) {
        $count = 1;
        $ip = StringHelper::getIPAddress();
        $query = new Query();
        $query->select(['id', 'vcount']);
        $query->from('log_ip_login');
        $query->where(['ip' => $ip]);
        $data = $query->one();
        if (!empty($data)) {
            $id = $data['id'];
            $count = $data['vcount'] + 1;
            Yii::$app->db->createCommand()
                    ->update('log_ip_login', ['vcount' => $count, 'username' => $username], 'id=' . $id)
                    ->execute();
        } else {
            Yii::$app->db->createCommand()
                    ->insert('log_ip_login', [
                        'ip' => $ip,
                        'vcount' => 1,
                        'username' => $username,
                    ])
                    ->execute();
        }
        return $count;
    }

    public static function getcountlogin() {
        $ip = StringHelper::getIPAddress();
        $query = new Query();
        $query->select(['vcount']);
        $query->from('log_ip_login');
        $query->where(['ip' => $ip]);
        $vcount = $query->scalar();
        return $vcount;
    }

    public static function updatecountlogin($username) {
        $ip = StringHelper::getIPAddress();
        Yii::$app->db->createCommand()
                ->update('log_ip_login', ['vcount' => 0, 'username' => $username], 'ip=' . Yii::$app->db->quoteValue($ip))
                ->execute();
    }

}
