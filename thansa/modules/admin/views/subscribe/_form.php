<?php

use app\modules\admin\helpers\AdminHelper;
use app\widgets\admin\form\ActionButton;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
?>
<?= AdminHelper::loadSuccessMessage(); ?>

<div class="news-cat-form">
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
    ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => 255]) ?>
    <?= $form->field($model, 'email')->textInput(['maxlength' => 255]) ?>
    <?= $form->field($model, 'phone')->textInput(['maxlength' => 255]) ?>
    <?= $form->field($model, 'kenh')->textInput(['maxlength' => 255]) ?>
    <?= $form->field($model, 'follower')->textInput(['maxlength' => 255]) ?>
    <?= $form->field($model, 'linh_vuc')->textInput(['maxlength' => 255]) ?>
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
