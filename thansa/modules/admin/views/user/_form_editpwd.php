<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

?>

<div class="form-form user-form">

    <?php
    $form = ActiveForm::begin([
                'id' => 'active-form',
                'options' => [
                    'class' => 'form-horizontal',
                ],
                'fieldConfig' => [
                    'template' => "{label}\n<div class=\"col-sm-8\">{input}</div>\n<div class=\"col-lg-8 pull-right\">{error}</div>",
                    'labelOptions' => ['class' => 'col-sm-4 control-label no-padding-right'],
                ],
                'action' => ['editpwd'],
                'validateOnBlur' => false,
    ]);
    ?>
    <?php echo $form->field($model, 'id')->hiddenInput(['id' => 'id_changepwd'])->label(false); ?>
    <?= $form->field($model, 'new_pass')->passwordInput(['maxlength' => 128, 'class' => 'col-xs-10 col-sm-6']) ?>    
    <?= $form->field($model, 'retype_pass')->passwordInput(['maxlength' => 128, 'class' => 'col-xs-10 col-sm-6']) ?>   
    <div class="form-group">
        <div class="col-md-offset-3 col-md-9">
            <span class="help-block"><i>Mật khẩu là một chuỗi các ký tự quy định như sau:<br>
                    - Không chứa dấu cách trống.<br>
                    - Có độ dài ít nhất là 8 ký tự.<br>
                    - Có ít nhất một ký tự chữ cái viết thường (a-z).<br>
                    - Có ít nhất một ký tự chữ cái viết hoa (A-Z).<br>
                    - Có ít nhất một ký tự đặc biệt (@#$%^&+=).<br>
                    - Có ít nhất một ký tự số (0-9).</i></span>
        </div>
    </div>
    <div class="clearfix form-actions">
        <div class="col-md-offset-4 col-md-8">
            <?= Html::submitButton('<i class="icon-save bigger-110"></i> Lưu', ['class' => $model->isNewRecord ? 'btn btn-primary' : 'btn btn-primary']) ?>
            &nbsp; &nbsp; &nbsp;
            <?= Html::resetButton('<i class="icon-undo bigger-110"></i> Reset', ['class' => 'btn']); ?>
        </div>
    </div>
    <?php ActiveForm::end(); ?>    

</div>
