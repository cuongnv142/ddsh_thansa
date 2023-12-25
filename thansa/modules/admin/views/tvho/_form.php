<?php

use app\modules\admin\helpers\AdminHelper;
use app\modules\admin\models\AdminDtvBo;
use app\widgets\admin\form\ActionButton;
use yii\helpers\ArrayHelper;
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
                    'template' => "{label}\n<div class=\"col-sm-9\">{input}</div>\n<div class=\"col-lg-9 pull-right\">{error}</div>",
                    'labelOptions' => ['class' => 'col-sm-3 control-label no-padding-right'],
                ],]);
    ?>
    <?= $form->field($model, 'id_dtv_bo')->dropDownList(ArrayHelper::map(AdminDtvBo::find()->where(['loai' => $model->loai])->orderBy('name')->all(), 'id', 'name'), ['prompt' => 'Lựa chọn', 'class' => 'width-40 chosen-select']) ?>
    <?= $form->field($model, 'name')->textInput(['maxlength' => 300, 'class' => 'col-xs-10 col-sm-8']) ?>

    <?= $form->field($model, 'name_latinh')->textInput(['maxlength' => 300, 'class' => 'col-xs-10 col-sm-8']) ?>

    <?php
    echo $form->field($model, 'status')->begin();
    echo Html::activeLabel($model, 'status', ['class' => 'col-sm-3 control-label no-padding-right']);
    ?>
    <div class="col-sm-9">
        <?php echo Html::activeCheckbox($model, 'status', ['class' => 'ace ace-switch ace-switch-4', 'label' => '<span class="lbl"></span>']); ?>
    </div>
    <?php
    echo Html::error($model, 'status', ['class' => 'help-block']); //error
    echo $form->field($model, 'status')->end();
    ?>
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

