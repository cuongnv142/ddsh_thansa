<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\modules\admin\helpers\AdminHelper;
?>
<?= $form->field($model, 'name')->textInput(['maxlength' => 255, 'class' => 'col-xs-10 col-sm-8']) ?>
<?= $form->field($model, 'tag')->textInput(['maxlength' => 255, 'class' => 'col-xs-10 col-sm-8']) ?>
<?= $form->field($model, 'page_title')->textInput(['maxlength' => 255]) ?>
<?= $form->field($model, 'page_description')->textarea(['class' => 'autosize-transition form-control limited', 'maxlength' => 160]) ?>
<?= $form->field($model, 'title_seobox')->textInput(['maxlength' => 255]) ?>
<?php
echo $form->field($model, 'des_seobox')->begin();
echo Html::activeLabel($model, 'des_seobox', ['class' => 'col-sm-3 control-label no-padding-right']);
?>
<div class="col-xs-10 col-sm-8">
    <textarea class="ckeditor" id="editor_des_seobox" name="<?= Html::getInputName($model, 'des_seobox') ?>"><?= $model->des_seobox ?></textarea>
    <?php echo Html::error($model, 'des_seobox', ['class' => 'help-block']); //error  ?>
</div>
<?php
echo $form->field($model, 'des_seobox')->end();
?>
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
<?php
echo $form->field($model, 'feature_tag')->begin();
echo Html::activeLabel($model, 'feature_tag', ['class' => 'col-sm-3 control-label no-padding-right']);
?>
<div class="col-sm-9">
    <?php echo Html::activeCheckbox($model, 'feature_tag', ['class' => 'ace ace-switch ace-switch-4', 'label' => '<span class="lbl"></span>']); ?>
</div>
<?php
echo Html::error($model, 'feature_tag', ['class' => 'help-block']); //error
echo $form->field($model, 'feature_tag')->end();
?>