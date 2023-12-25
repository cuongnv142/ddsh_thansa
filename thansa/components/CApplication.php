<?php

namespace app\components;

use yii\base\Behavior;
use yii\web\Application;

class CApplication extends Behavior {

    public function events() {
        return[
            Application::EVENT_BEFORE_REQUEST => 'checkBeforeRequest',
        ];
    }

    public static function checkBeforeRequest() {
        
    }

}

?>
