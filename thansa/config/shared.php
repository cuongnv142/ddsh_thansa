<?php

$params = require(__DIR__ . '/params.php');
$vendorDir = dirname(__DIR__) . '/vendor';

$config = [
    'id' => 'csdldongthucvat',
    'language' => 'vi',
    'timeZone' => 'Asia/Ho_Chi_Minh',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log', 'languageSwitcher'],
    'vendorPath' => $vendorDir,
    'extensions' => array_merge(
            require($vendorDir . '/yiisoft/extensions.php'), require($vendorDir . '/yiisoft/extensions/extensions.php')
    ),
    'aliases' => [
        '@mdm/admin' => '@vendor/yiisoft/extensions/yii2-admin',
        '@module/admin' => '@app/modules/admin',
        '@app/widgets' => '@app/extensions/widgets',
        '@kartik/grid' => '@vendor/yiisoft/extensions/yii2-grid',
        '@kartik/base' => '@vendor/yiisoft/extensions/yii2-krajee-base',
        '@kartik/editable' => '@vendor/yiisoft/extensions/yii2-editable',
        '@kartik/mpdf' => '@vendor/yiisoft/extensions/yii2-mpdf',
        '@kartik/popover' => '@vendor/yiisoft/extensions/yii2-popover-x',
        '@kartik/export' => '@vendor/yiisoft/extensions/yii2-export',
        '@bower' => '@vendor/bower-asset',
    ],
    'as beforeRequest' => [
        'class' => 'app\components\CApplication',
    ],
    'params' => $params,
    'modules' => [
        'right' => [
            'class' => 'mdm\admin\Module',
            'layout' => 'left-menu',
            'controllerMap' => [
                'assignment' => [
                    'class' => 'mdm\admin\controllers\AssignmentController',
                    'userClassName' => 'app\models\User',
                    'idField' => 'id',
                    'usernameField' => 'email'
                ]
            ],
            'menus' => [
                'assignment' => [
                    'label' => 'Grand Access' // change label
                ],
            ],
        ],
        'gridview' => [
            'class' => 'kartik\grid\Module'
        ],
        'admin' => [
            'class' => 'app\modules\admin\Module',
        ],
        'sitemap' => [
            'class' => '\himiklab\sitemap\Sitemap',
            'models' => [
            ],
            'urls' => [
            ],
            'enableGzip' => true, // default is false
            'cacheExpire' => 1, // 1 second. Default is 24 hours
        ],
    ],
    'as access' => [
        'class' => 'mdm\admin\components\AccessControl',
        'onlyModules' => ['admin', 'right'],
    ],
];

return $config;
