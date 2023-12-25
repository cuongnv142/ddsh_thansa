<?php

use app\components\FileUpload;
use app\modules\admin\helpers\AdminHelper;
use app\modules\admin\models\AdminBoxpageCat;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
?>
<?= AdminHelper::showHideLangForm($model, $form, ['class' => 'col-xs-3 col-sm-3', 'disabled' => 'disabled']); ?>

<?= $form->field($model, 'name')->textInput(['maxlength' => 300, 'class' => 'col-xs-10 col-sm-8']) ?>
<?= $form->field($model, 'sub_name')->textInput(['maxlength' => 300, 'class' => 'col-xs-10 col-sm-8']) ?>

<?php
echo $form->field($model, 'boxpage_cat_id')->begin();
echo Html::activeLabel($model, 'boxpage_cat_id', ['class' => 'col-sm-3 control-label no-padding-right']);
?>
<div class="col-sm-9">
    <?= Html::activeDropDownList($model, 'boxpage_cat_id', ArrayHelper::map(AdminBoxpageCat::getBoxpagecatLevel(0, 0, $model->language), 'id', 'name'), ['prompt' => 'Danh mục', 'class' => 'width-40 chosen-select']) ?>
    <?= Html::error($model, 'boxpage_cat_id', ['class' => 'help-block']) #error      ?>
</div>
<?php
echo $form->field($model, 'boxpage_cat_id')->end();
?>

<?= $form->field($model, 'link')->textInput(['maxlength' => 300, 'class' => 'col-xs-10 col-sm-8', 'placeholder' => 'Nhập Link thì bình thường, còn dùng javascript thì cấu trúc javascript:function']) ?>

<?php
echo $form->field($model, 'src')->begin();
echo Html::activeLabel($model, 'src', ['class' => 'col-sm-3 control-label no-padding-right']);
?>
<div class="col-sm-3">
    <input type="file" name="src" class="file-image"/>
</div>
<?php
echo Html::error($model, 'src', ['class' => 'help-block']); //error
echo $form->field($model, 'src')->end();
?>
<?php if ($model->src) { ?>
    <div class="form-group">
        <label for="admincatre-image" class="col-sm-3 control-label no-padding-right"></label>
        <div class="col-sm-9">
            <span class="profile-picture">
                <?= Html::img(FileUpload::thumb_wmfile(200, $model->src), ['width' => 200]) ?>
            </span>
            <label>
                <input type="checkbox" class="ace" name="is_deleteimage">
                <span class="lbl"> Xóa file</span>
            </label>
        </div>
    </div>
<?php } ?>
<?= $form->field($model, 'sort_order')->textInput(['maxlength' => 4, 'class' => 'col-xs-3 col-sm-3 input-mask-int']) ?>
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
<?= $form->field($model, 'short_description')->textarea(['rows' => 6]) ?>
<?php
echo $form->field($model, 'description')->begin();
echo Html::activeLabel($model, 'description', ['class' => 'col-sm-3 control-label no-padding-right']);
?>
<div class="col-sm-9">
    <textarea class="ckeditor" id="editor" name="AdminBoxpage[description]"><?= $model->description ?></textarea>

    <?= Html::error($model, 'description', ['class' => 'help-block']) ?>
</div>
<?php
echo $form->field($model, 'description')->end();
?>