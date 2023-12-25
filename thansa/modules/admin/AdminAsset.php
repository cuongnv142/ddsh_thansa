<?php

namespace app\modules\admin;

class AdminAsset extends \yii\web\AssetBundle {

    public $sourcePath = '@module/admin/assets';
    public $css = [
        'css/datepicker.css',
        'css/bootstrap-timepicker.css',
        'css/daterangepicker.css',
        'css/font-awesome.min.css',
        'css/colorbox.css',
        'css/chosen.css',
        'css/ace-fonts.css',
        'css/ace.min.css',
        'css/ace-rtl.min.css',
        'css/ace-skins.min.css',
        'css/styles.css',
        'css/star-rating.min.css',
        'js/tree/themes/default/style.min.css'
    ];
    public $js = [
        'js/ace-extra.min.js',
        'js/star-rating.min.js',
        'js/typeahead-bs2.min.js',
        'js/jquery-ui-1.10.3.custom.min.js',
        'js/jquery.ui.touch-punch.min.js',
        'js/jquery.slimscroll.min.js',
        'js/jquery.easy-pie-chart.min.js',
        'js/jquery.sparkline.min.js',
        'js/flot/jquery.flot.min.js',
        'js/flot/jquery.flot.time.js',
        'js/flot/date.js',
        'js/flot/jquery.flot.pie.min.js',
        'js/flot/jquery.flot.resize.min.js',
        'js/tree/jstree.min.js',
        'js/date-time/moment.min.js',
        'js/date-time/daterangepicker.min.js',
        'js/date-time/bootstrap-timepicker.min.js',
        'js/date-time/bootstrap-datepicker.min.js',
        'js/jquery.mask.min.js',
        'js/jquery.colorbox-min.js',
        'js/jquery.inputlimiter.1.3.1.min.js',
        'js/jquery.autosize.min.js',
        'js/chosen.jquery.min.js',
        'js/jquery.hotkeys.min.js',
        'js/bootstrap-wysiwyg.min.js',
        'js/bootstrap-tag.min.js',
        'js/ace-elements.min.js',
        'js/ace.min.js',
        'js/bootbox.min.js',
        'js/js.cookie.js',
        'js/global.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
        'app\modules\admin\CkeditorAsset'
    ];

}
