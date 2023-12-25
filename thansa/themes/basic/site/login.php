<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Login';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="widget-main">
    <div class="space-6"></div>
    <?php
    $form = ActiveForm::begin([
                'id' => 'login-form',
                'options' => ['class' => 'form-default'],
                'fieldConfig' => [
                    'template' => "{input}",
                ],
                'enableClientValidation' => false,
    ]);
    ?>
    <fieldset>
        <label class="block clearfix">
            <span class="block input-icon input-icon-right">
                <?php
                echo $form->field($model, 'email')->begin();
                echo Html::activeTextInput($model, 'email', ["class" => "form-control", 'placeholder' => 'Email']);
                ?>
                <?php echo Html::error($model, 'email', ['class' => 'help-block']); ?>
                <?php echo $form->field($model, 'email')->end(); ?>
                <i class="icon-envelope"></i>
            </span>
        </label>
        <label class="block clearfix">
            <span class="block input-icon input-icon-right">
                <?php
                echo $form->field($model, 'password')->begin();
                echo Html::activePasswordInput($model, 'password', ["class" => "form-control"]);
                ?>
                <?php echo Html::error($model, 'password', ['class' => 'help-block']); ?>
                <?php echo $form->field($model, 'password')->end(); ?>
                <i class="icon-lock"></i>
            </span>
        </label>
        <div class="space"></div>
        <div class="clearfix">
            <label class="inline">
                <input type="checkbox" value="1" class="ace" name="LoginForm[rememberMe]" />
                <span class="lbl"> Remember Me</span>
            </label>
            <button type="submit" class="width-35 pull-right btn btn-sm btn-primary">
                <i class="icon-key"></i>
                Login
            </button>
        </div>

        <div class="space-4"></div>
    </fieldset>
    <?php ActiveForm::end(); ?>
</div>

