<?php

return [
//    'class'=>'yii\web\AssetManager',
    'appendTimestamp' => true,
    'bundles' => [
        'yii\bootstrap\BootstrapAsset' => [
            'sourcePath' => null,
            'basePath' => '@webroot',
            'baseUrl' => '@web',
            'js' => [
                'vendors/bootstrap3/js/bootstrap.min.js'
            ],
            'css' => [
                'vendors/bootstrap3/css/bootstrap.min.css',
            ]
        ],
        'yii\bootstrap\BootstrapPluginAsset' => [
            'sourcePath' => null,
            'basePath' => '@webroot',
            'baseUrl' => '@web',
            'js' => [
                'vendors/bootstrap3/js/bootstrap.min.js'
            ],
        ],
        'yii\web\JqueryAsset' => [
            'sourcePath' => null,
            'basePath' => '@webroot',
            'baseUrl' => '@web',
            'js' => [
                'vendors/jquery/jquery.min.js'
            ],
        ],
        'yii\web\YiiAsset' => [
            'sourcePath' => null,
            'basePath' => '@webroot',
            'baseUrl' => '@web',
            'js' => [
                'vendors/core/yii.js'
            ],
        ],
        'yii\widgets\PjaxAsset' => [
            'sourcePath' => null,
            'basePath' => '@webroot',
            'baseUrl' => '@web',
            'js' => [
                'vendors/core/jquery.pjax.js'
            ],
            'depends' => [
                'yii\web\JqueryAsset'
            ]
        ],
        'yii\validators\ValidationAsset' => [
            'sourcePath' => null,
            'basePath' => '@webroot',
            'baseUrl' => '@web',
            'js' => [
                'vendors/core/yii.validation.js'
            ],
        ],
        'yii\grid\GridViewAsset' => [
            'sourcePath' => null,
            'basePath' => '@webroot',
            'baseUrl' => '@web',
            'js' => [
                'vendors/core/yii.gridView.js'
            ],
        ],
        'yii\widgets\ActiveFormAsset' => [
            'sourcePath' => null,
            'basePath' => '@webroot',
            'baseUrl' => '@web',
            'js' => [
                'vendors/core/yii.activeForm.js'
            ],
        ],
        'yii\widgets\MaskedInputAsset' => [
            'sourcePath' => null,
            'basePath' => '@webroot',
            'baseUrl' => '@web',
            'js' => [
                'vendors/jquery.inputmask/dist/jquery.inputmask.bundle.min.js'
            ],
            'depends' => [
                'yii\web\JqueryAsset'
            ]
        ],
        'yii\jui\JuiAsset' => [
            'sourcePath' => null,
            'basePath' => '@webroot',
            'baseUrl' => '@web',
            'js' => [
                'vendors/jquery-ui/jquery-ui.min.js'
            ],
            'css' => [
                'vendors/jquery-ui/jquery-ui.min.css'
            ]
        ],
        'app\modules\admin\AdminAsset' => [
            'sourcePath' => null,
            'basePath' => '@webroot',
            'baseUrl' => '@web',
            'js' => [
                'modules/admin/assets/js/ace-extra.min.js',
                'modules/admin/assets/js/star-rating.min.js',
                'modules/admin/assets/js/typeahead-bs2.min.js',
                'modules/admin/assets/js/jquery-ui-1.10.3.custom.min.js',
                'modules/admin/assets/js/jquery.ui.touch-punch.min.js',
                'modules/admin/assets/js/jquery.slimscroll.min.js',
                'modules/admin/assets/js/jquery.easy-pie-chart.min.js',
                'modules/admin/assets/js/jquery.sparkline.min.js',
                'modules/admin/assets/js/flot/jquery.flot.min.js',
                'modules/admin/assets/js/flot/jquery.flot.time.js',
                'modules/admin/assets/js/flot/date.js',
                'modules/admin/assets/js/flot/jquery.flot.pie.min.js',
                'modules/admin/assets/js/flot/jquery.flot.resize.min.js',
                'modules/admin/assets/js/tree/jstree.min.js',
                'modules/admin/assets/js/date-time/moment.min.js',
                'modules/admin/assets/js/date-time/daterangepicker.min.js',
                'modules/admin/assets/js/date-time/bootstrap-timepicker.min.js',
                'modules/admin/assets/js/date-time/bootstrap-datepicker.min.js',
                'modules/admin/assets/js/jquery.mask.min.js',
                'modules/admin/assets/js/jquery.colorbox-min.js',
                'modules/admin/assets/js/jquery.inputlimiter.1.3.1.min.js',
                'modules/admin/assets/js/jquery.autosize.min.js',
                'modules/admin/assets/js/chosen.jquery.min.js',
                'modules/admin/assets/js/jquery.hotkeys.min.js',
                'modules/admin/assets/js/bootstrap-wysiwyg.min.js',
                'modules/admin/assets/js/bootstrap-tag.min.js',
                'modules/admin/assets/js/ace-elements.min.js',
                'modules/admin/assets/js/ace.min.js',
                'modules/admin/assets/js/bootbox.min.js',
                'modules/admin/assets/js/js.cookie.js',
                'modules/admin/assets/js/global.js',
                 'modules/admin/assets/js/admin.js'
            ],
            'css' => [
                'modules/admin/assets/css/datepicker.css',
                'modules/admin/assets/css/bootstrap-timepicker.css',
                'modules/admin/assets/css/daterangepicker.css',
                'modules/admin/assets/css/font-awesome.min.css',
                'modules/admin/assets/css/colorbox.css',
                'modules/admin/assets/css/chosen.css',
                'modules/admin/assets/css/ace-fonts.css',
                'modules/admin/assets/css/ace.min.css',
                'modules/admin/assets/css/ace-rtl.min.css',
                'modules/admin/assets/css/ace-skins.min.css',
                'modules/admin/assets/css/styles.css',
                'modules/admin/assets/css/star-rating.min.css',
                'modules/admin/assets/js/tree/themes/default/style.min.css'
            ]
        ],
        'app\modules\admin\CkeditorAsset' => [
            'sourcePath' => null,
            'basePath' => '@webroot',
            'baseUrl' => '@web',
            'js' => [
                'vendors/ckeditor/ckeditor.js'
            ],
            'css' => [
            ]
        ],
        'mdm\admin\AdminAsset' => [
            'sourcePath' => null,
            'basePath' => '@webroot',
            'baseUrl' => '@web',
            'css' => [
                'vendors/rights/main.css',
                'vendors/rights/list-item.css'
            ]
        ],
    ]
];