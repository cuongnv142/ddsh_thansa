<?php

namespace app\modules\admin;

use yii\helpers\Url;

class Module extends \yii\base\Module
{

    public $layout = '@module/admin/views/layouts/main.php';

    public function init()
    {
        parent::init();
        // custom initialization code goes here
        \Yii::$app->setComponents([
            'user' => [
                'class' => '\yii\web\User',
                'identityClass' => 'app\models\User',
                'enableAutoLogin' => false,
            ],
            'request' => [
                'class' => 'yii\web\Request',
                'enableCookieValidation' => false,
                'enableCsrfValidation' => false,
                'cookieValidationKey' => '',
            ],
        ]);
    }

}
