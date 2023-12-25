<?php

use app\modules\admin\helpers\AdminHelper;
use app\widgets\admin\form\ActionButton;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
?>
<?= AdminHelper::loadSuccessMessage(); ?>
<div class="news-form">

    <?php
    $form = ActiveForm::begin([
                'id' => 'active-form',
                'options' => [
                    'class' => 'form-horizontal',
                    'enctype' => 'multipart/form-data',
                ],
                'fieldConfig' => [
                    'template' => "{label}\n<div class=\"col-sm-9\">{input}</div>\n<div class=\"col-lg-9 pull-right\">{error}</div>",
                    'labelOptions' => ['class' => 'col-sm-3 control-label no-padding-right'],
                ],]);
    $tab = Yii::$app->getRequest()->getQueryParam('tab', '');
    ?>
    <div class="tabbable">
        <ul class="nav nav-tabs padding-12 tab-color-blue background-blue" id="myTab4">
            <li class="active">
                <a data-toggle="tab" href="#info">Chi tiết tin</a>
            </li>
            <li class="">
                <a data-toggle="tab" href="#seo">SEO</a>
            </li>
        </ul>

        <div class="tab-content">
            <div id="info" class="tab-pane in active ">
                <?=
                $this->render('view/_general', [
                    'form' => $form,
                    'model' => $model,
                ])
                ?>
            </div>
            <div id="seo" class="tab-pane ">
                <?= $this->render('view/_seo', ['form' => $form, 'model' => $model]) ?>
            </div>
        </div>
    </div>
    <?=
    ActionButton::widget([
        'params' => [
            'formId' => 'active-form',
            'btn_back' => Html::a('<i class="icon-share-alt bigger-110 "></i> Quay lại', Url::toRoute('index'), ['class' => 'btn']),
        ]
    ])
    ?>
    <?php ActiveForm::end(); ?>
</div>