<?php

return [
    'class' => 'yii\web\UrlManager',
    'enablePrettyUrl' => true,
    'showScriptName' => false,
    'suffix' => '',
    'rules' => [
        '<language:\w{2}>' => '/site/index',
        '' => 'site/index',
        'admin' => 'admin/default/index',
        'dang-nhap-admin' => 'site/login',
        'tin-tuc/<name:[\d\w\-_]+>-c<cid:\d+>' => '/news/list',
        'tin-tuc' => 'news/list',
        'tin-tuc/<alias:[\d\w\-_]+>-n<id:\d+>' => 'news/view',
        '<alias:[\d\w\-_]+>-l<id:\d+>' => '/site/viewloai',
        'gioi-thieu' => 'news/gioithieu',
        'truy-xuat' => 'site/truyxuat',
        //======================
        'dang-ky-lien-he' => 'site/subscriber',
        ['pattern' => 'sitemap', 'route' => 'sitemap/default/index', 'suffix' => '.xml'],
        '<controller:\w+>/<action:\w+>/<id:\d+>-<title:[\d\w\-_]+>' => '<controller>/<action>',
        '<controller:\w+>/<action:\w+>' => '<controller>/<action>',
        '<module:\w+>/<controller:\w+>/<action:\w+>' => '<module>/<controller>/<action>',
    ],
];
