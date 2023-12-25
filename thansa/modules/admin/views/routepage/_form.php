
<?php

use app\modules\admin\helpers\AdminHelper;
use app\widgets\admin\form\ActionButton;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
?>
<?= AdminHelper::loadSuccessMessage(); ?>
<div class="banner-form">
    <?php
    $form = ActiveForm::begin([
                'id' => 'active-form',
                'options' => [
                    'class' => 'form-horizontal',
                    'enctype' => 'multipart/form-data',
                ],
                'fieldConfig' => [
                    'template' => "{label}\n<div class=\"col-sm-10\">{input}</div>\n<div class=\"col-sm-10 pull-right\">{error}</div>",
                    'labelOptions' => ['class' => 'col-sm-2 control-label no-padding-right'],
                ],]);
    ?>
    <?= $form->field($model, 'route')->textInput(['maxlength' => 300, 'class' => 'col-xs-10 col-sm-8']) ?>
    <?= $form->field($model, 'name')->textInput(['maxlength' => 300, 'class' => 'col-xs-10 col-sm-8']) ?>

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


