<?php

use app\widgets\footer\FooterWidgets;
use app\widgets\header\ActionHeadWidgets;
use yii\helpers\Html;

$this->beginContent('@app/themes/basic/layouts/main.php');
?>
<div id="container">
    <?php
    echo ActionHeadWidgets::widget([
        'params' => [
            'view' => 'action_head',
        ]
    ]);
    ?>
    <?= $content ?>
    <?php
    echo FooterWidgets::widget([
        'params' => [
            'view' => 'footer',
        ]
    ]);
    ?>
</div>
<div id="bg_loading" style="display: none;">
    <div id="ajax-loading">
        <?= Html::img(Yii::getAlias('@web') . "/images/loader_2.gif", ['alt' => 'Loading...']) ?> Loading ...
    </div>
</div>
<input type="hidden" id="form-key-csrf-csdldongthucvat" data-key-name="<?= Yii::$app->request->csrfParam ?>" data-key-value="<?= Yii::$app->request->getCsrfToken() ?>"/>
<style>
    #ajax-loading {
        background-color: #fff;
        border: 1px solid #ccc;
        -webkit-border-radius: 3px;
        -moz-border-radius: 3px;
        border-radius: 3px;
        -moz-background-clip: padding;
        -webkit-background-clip: padding-box;
        background-clip: padding-box;
        -webkit-box-shadow: 0 5px 10px rgba(0, 0, 0, 0.2);
        -moz-box-shadow: 0 5px 10px rgba(0, 0, 0, 0.2);
        box-shadow: 0 5px 10px rgba(0, 0, 0, 0.2);
        left: 45%;
        padding: 15px 20px;
        position: fixed;
        top: 45%;
        z-index: 99999;
    }
    #bg_loading {
        display: none;
        background: rgba(0, 0, 0, 0.5) none repeat scroll 0 0;
        float: left;
        height: 100%;
        left: 0;
        position: fixed;
        top: 0;
        width: 100%;
        z-index: 999999;
    }
</style>
<?php $this->endContent(); ?>