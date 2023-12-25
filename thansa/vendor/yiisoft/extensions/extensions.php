<?php

$vendorDir = dirname(__DIR__);

return array(
    'extensions/yii2-jui' =>
    array(
        'name' => 'extensions/yii2-jui',
        'version' => '2.0.0',
        'alias' =>
        array(
            '@yii/jui' => $vendorDir . '/extensions/yii2-jui',
        ),
    ),
    'extensions/zalo' =>
    array(
        'name' => 'extensions/zalo',
        'version' => '2.0.0',
        'alias' =>
        array(
            '@Zalo' => $vendorDir . '/extensions/zalo/src',
        ),
    ),
//    'extensions/yii2-admin' =>
//    array(
//        'name' => 'extensions/yii2-admin',
////        'version' => '2.0.0',
//        'alias' =>
//        array(
//            '@mdm/admin' => $vendorDir . '/extensions/yii2-admin',
//        ),
//    ),
//    array(
//        'name' => 'extensions/widgets',
//        'version' => '2.0.0',
//        'alias' =>
//        array(
//            '@app/widgets' => $vendorDir . '/extensions/widgets',
//        ),
//    ),
);
