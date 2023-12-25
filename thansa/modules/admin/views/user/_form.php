<?php

use app\models\User;
use app\modules\admin\helpers\AdminHelper;
use app\modules\admin\models\AdminUser;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
?>

<div class="form-form user-form">

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
                ],
    ]);
    ?>

    <?= $form->field($model, 'first_name')->textInput(['maxlength' => 255, 'class' => 'col-xs-10 col-sm-4']) ?>
    <?= $form->field($model, 'email')->textInput(['maxlength' => 255, 'class' => 'col-xs-10 col-sm-6']) ?>
    <?= $form->field($model, 'password')->passwordInput(['maxlength' => 128, 'class' => 'col-xs-10 col-sm-6']) ?>
    <?= $form->field($model, 'password_repeat')->passwordInput(['maxlength' => 128, 'class' => 'col-xs-10 col-sm-6']) ?>
    <?= $form->field($model, 'phone')->textInput(['maxlength' => 255, 'class' => 'col-xs-8 col-sm-6']) ?>           
    <?= $form->field($model, 'gender')->dropDownList(['MALE' => 'Nam', 'FEMALE' => 'Nữ', 'OTHER' => 'Khác'], ['class' => 'width-40 chosen-select']); ?>
    <?= $form->field($model, 'status')->dropDownList(User::$dataStatus, ['class' => 'width-20 chosen-select']); ?>
    <?php
        echo $form->field($model, 'role')->dropDownList(ArrayHelper::map(AdminHelper::getArrRoles(), 'name', 'description'), ['prompt' => 'Phân quyền tài khoản', 'class' => 'width-40 chosen-select']);
    ?>
    <div class="clearfix form-actions">
        <div class="col-md-offset-3 col-md-9">
            <?= Html::submitButton($model->isNewRecord ? '<i class="icon-save bigger-110"></i> Lưu lại' : '<i class="icon-save bigger-110"></i> Sửa', ['class' => $model->isNewRecord ? 'btn btn-primary' : 'btn btn-primary']) ?>
            &nbsp; &nbsp; &nbsp;
            <?= Html::resetButton('<i class="icon-undo bigger-110"></i> Reset', ['class' => 'btn']); ?>
        </div>
    </div>

    <?php ActiveForm::end(); ?>


</div>
