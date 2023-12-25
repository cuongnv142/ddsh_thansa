<?php

namespace app\assets;

use yii\web\AssetBundle;

/**
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class AppAsset extends AssetBundle {

    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/bootstrap.min.css',
        'html/styles/slick.css',
        'html/styles/slick-theme.css',
        'html/styles/basicStyle.css',
        'html/styles/responsiveStyle.css',
    ];
    public $js = [
        'js/js.cookie.js',
        'html/js/slick.min.js',
        'html/js/jquery.easing.1.3.js',
//        'html/js/jquery.dropdown.js',
        'html/js/myScript.js',
        'js/sweetalert2.all.min.js',
        'js/global.js',
    ];
    public $depends = [
        'yii\web\JqueryAsset',
    ];

}
