<?php

/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace yii\jui;

use yii\web\AssetBundle;

/**
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class JuiAsset extends AssetBundle {

    public $sourcePath = '@bower/jquery-ui';
    public $js = [
//        'jquery-ui.js',
        'jquery-ui.min.js'
    ];
    public $css = [
//        'jquery-ui.css',
        'jquery-ui.min.css'
    ];
    public $jsOptions = [
//        'defer' => 'true',
    ];
    public $depends = [
        'yii\web\JqueryAsset',
    ];

}
