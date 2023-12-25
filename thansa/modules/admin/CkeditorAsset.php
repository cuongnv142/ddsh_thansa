<?php

namespace app\modules\admin;

class CkeditorAsset extends \yii\web\AssetBundle {

     public $sourcePath = '@module/admin/assets';
    public $js = [
        'js/ckeditor/ckeditor.js',
    ];
    
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}
