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
    'session' => [
        'name' => 'csdldongthucvat',
        'timeout' => 86400
    ],
    'redis' => [
        'class' => 'yii\redis\Connection',
        'hostname' => '10.5.28.20',
        'port' => 63879,
        'database' => 5,
        'password' => '7Gek5HMpZVUxJK8Z',
    ],
    'user' => [
        'identityClass' => 'app\models\User',
        'enableAutoLogin' => true,
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
                'clientId' => '',
                'clientSecret' => '',
            ],
            'google' => [
                'class' => 'yii\authclient\clients\Google',
                'clientId' => '',
                'clientSecret' => '',
            ],
        ],
    ],
];
if (YII_ENV_DEV) {
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = 'yii\debug\Module';
    $config['bootstrap'][] = 'gii';
    $config['modules']['gii']['class'] = 'yii\gii\Module';
    $config['modules']['gii']['allowedIPs'] = ['127.0.0.1', '::1'];
}
return $config;
?>