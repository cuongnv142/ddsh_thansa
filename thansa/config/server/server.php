<?php

$config = require(__DIR__ . '/../shared.php');
$config['params'] = \yii\helpers\ArrayHelper::merge($config['params'], require(__DIR__ . '/params_env.php'));
$config['components'] = [
    'languageSwitcher' => [
        'class' => 'app\components\languageSwitcher',
    ],
    'i18n' => [
        'translations' => [
            'app*' => [
                'class' => 'yii\i18n\PhpMessageSource',
                'fileMap' => [
                    'app' => 'app.php',
                ],
            ],
        ],
    ],
    'formatter' => [
        'dateFormat' => 'dd-MM-yyyy',
        'decimalSeparator' => ',',
        'thousandSeparator' => '.',
        'currencyCode' => 'VND',
    ],
    'request' => [
        'enableCookieValidation' => false,
        'enableCsrfValidation' => false,
        'cookieValidationKey' => '',
    ],
    'cache' => [
        'class' => 'yii\caching\FileCache',
    ],
    'redis' => [
        'class' => 'yii\redis\Connection',
        'hostname' => 'localhost',
        'port' => 6379,
        'database' => 0,
    ],
    'session' => [
        'class' => 'yii\redis\Session',
        'redis' => [
            'hostname' => '10.5.28.20',
            'port' => 63858,
            'database' => 1,
            'password' => 'W2W3qwMUvU9KMTrZ',
        ],
        'name' => 'varsid',
    ],
    'user' => [
        'identityClass' => 'app\models\User',
        'enableAutoLogin' => false,
    ],
    'errorHandler' => [
        'errorAction' => 'site/error',
    ],
    'mailer' => [
        'class' => 'app\components\CustomeizeMailer',
    ],
    'log' => [
        'traceLevel' => YII_DEBUG ? 3 : 0,
        'targets' => [
            [
                'class' => 'yii\log\FileTarget',
                'levels' => ['error', 'warning'],
            ],
        ],
    ],
    'db' => require(__DIR__ . '/db.php'),
    'urlManager' => require(__DIR__ . '/../rewrite.php'),
    'view' => [
        'theme' => [
            'pathMap' => [
                '@app/views' => '@app/themes/basic',
            ],
        ],
    ],
    'authManager' => [
        'class' => 'yii\rbac\DbManager',
    ],
    'assetManager' => require(__DIR__ . '/../assetManager.php'),
    'authClientCollection' => [
        'class' => 'yii\authclient\Collection',
        'clients' => [
            'facebook' => [
                'class' => 'yii\authclient\clients\Facebook',
                'clientId' => '480552969768465',
                'clientSecret' => 'c58de2526e81d47c8cec0cff04012195',
            ],
            'google' => [
                'class' => 'yii\authclient\clients\Google',
                'clientId' => '400262443926-oqalj2e9ekk0h21fria860iltuv7gdvq.apps.googleusercontent.com',
                'clientSecret' => '19FzXbynY1PDo-K7BoOdXL8Q',
            ],
        ],
    ],
];
if (YII_ENV_DEV) {
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = 'yii\debug\Module';
}
return $config;
?>