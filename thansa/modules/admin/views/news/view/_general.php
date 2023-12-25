<?php

use app\components\FileUpload;
use app\modules\admin\helpers\AdminHelper;
use app\modules\admin\models\AdminNewsCat;
use app\modules\admin\models\AdminTag;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
?>
<?= AdminHelper::showHideLangForm($model, $form, ['class' => 'col-xs-3 col-sm-3', 'disabled' => 'disabled']); ?>
<?php
if ((int) $model->id) {
    echo $form->field($model, 'name')->textInput(['maxlength' => 300, 'class' => 'col-xs-10 col-sm-8']);
} else {
    echo $form->field($model, 'name')->textInput(['maxlength' => 300, 'class' => 'col-xs-10 col-sm-8', 'onkeyup' => 'safetitle(this,"adminnews-alias")']);
}
echo $form->field($model, 'alias')->textInput(['maxlength' => 300, 'class' => 'col-xs-10 col-sm-8']);
?>

<?php
echo $form->field($model, 'news_cat_id')->begin();
echo Html::activeLabel($model, 'news_cat_id', ['class' => 'col-sm-3 control-label no-padding-right']);
?>
<div class="col-sm-9">
    <?= Html::activeDropDownList($model, 'news_cat_id', ArrayHelper::map(AdminNewsCat::getNewsCatLevel(0, 0, $model->language), 'id', 'name'), ['prompt' => 'Danh mục', 'class' => 'width-40 chosen-select']) ?>
    <?= Html::error($model, 'news_cat_id', ['class' => 'help-block']) #error  ?>
</div>
<?php
echo $form->field($model, 'news_cat_id')->end();
?>

<?php
echo $form->field($model, 'tags')->begin();
echo Html::activeLabel($model, 'tags', ['class' => 'col-sm-3 control-label no-padding-right']);
?>
<div class="col-sm-9">
    <?php echo Html::activeTextInput($model, 'tags', ['maxlength' => 255, 'tagClass' => 'col-xs-12 col-sm-12', 'class' => 'form-field-tags', 'data-source' => AdminTag::getListTags(), 'placeholder' => 'Nhập tag']); ?>
    <span class="help-inline">
        <span class="middle">(Nhập tag cách nhau bằng Enter)</span>
    </span>
</div>
<?php
echo $form->field($model, 'tags')->end();
?>
<?php
echo $form->field($model, 'image')->begin();
echo Html::activeLabel($model, 'image', ['class' => 'col-sm-3 control-label no-padding-right']);
?>
<div class="col-sm-3">
    <input type="file" name="image" class="file-image"/>
</div>
<?php
echo Html::error($model, 'image', ['class' => 'help-block']); //error
echo $form->field($model, 'image')->end();
?>
<?php if ($model->image) { ?>
    <div class="form-group">
        <label class="col-sm-3 control-label no-padding-right"></label>
        <div class="col-sm-9">
            <span class="profile-picture">
                <?= Html::img(FileUpload::thumb_wmfile(200, $model->image), ['width' => 200]) ?>
            </span>
            <label>
                <input type="checkbox" class="ace" name="is_deleteimage">
                <span class="lbl"> Xóa ảnh</span>
            </label>
        </div>
    </div>
<?php } ?>

<?php
//echo $form->field($model, 'author')->textInput(['maxlength' => 300, 'class' => 'col-xs-10 col-sm-8']);
?>
<?= $form->field($model, 'short_description')->textarea(['rows' => 6]) ?>

<?php
echo $form->field($model, 'description')->begin();
echo Html::activeLabel($model, 'description', ['class' => 'col-sm-3 control-label no-padding-right']);
?>
<div class="col-sm-9">
    <textarea class="ckeditor" id="editor" name="AdminNews[description]"><?= $model->description ?></textarea>

    <?= Html::error($model, 'description', ['class' => 'help-block']) ?>
</div>
<?php
echo $form->field($model, 'description')->end();
?>
<?php
echo $form->field($model, 'is_hot')->begin();
echo Html::activeLabel($model, 'is_hot', ['class' => 'col-sm-3 control-label no-padding-right']);
?>
<div class="col-sm-9">
    <?php echo Html::activeCheckbox($model, 'is_hot', ['class' => 'ace ace-switch ace-switch-4', 'label' => '<span class="lbl"></span>']); ?>
</div>
<?php
echo Html::error($model, 'is_hot', ['class' => 'help-block']); //error
echo $form->field($model, 'is_hot')->end();
?>
<?php
//echo $form->field($model, 'is_system')->begin();
//echo Html::activeLabel($model, 'is_system', ['class' => 'col-sm-3 control-label no-padding-right']);
?>
<!--<div class="col-sm-9">
<?php // echo Html::activeCheckbox($model, 'is_system', ['class' => 'ace ace-switch ace-switch-4', 'label' => '<span class="lbl"></span>']); ?>
</div>-->
<?php
//echo Html::error($model, 'is_system', ['class' => 'help-block']); //error
//echo $form->field($model, 'is_system')->end();
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