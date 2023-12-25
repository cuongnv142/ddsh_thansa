<?php

use app\components\FileUpload;
use app\modules\admin\helpers\AdminHelper;
use app\modules\admin\models\AdminBoxpagecat;
use app\widgets\admin\form\ActionButton;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
?>
<?= AdminHelper::loadSuccessMessage(); ?>
<div class="admin-banner-cat-form">

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
    <?= AdminHelper::showHideLangForm($model, $form, ['class' => 'col-xs-3 col-sm-3', 'disabled' => 'disabled']); ?>
    <?= $form->field($model, 'name')->textInput(['maxlength' => 300, 'class' => 'col-xs-10 col-sm-8']) ?>
    <?php
    echo $form->field($model, 'parent_id')->dropDownList(ArrayHelper::map(AdminBoxpagecat::getBoxpagecatLevel($model->id, $model->level, $model->language), 'id', 'name'), ['prompt' => 'Danh mục gốc', 'class' => 'width-40 chosen-select']);
    ?>
    <?php
    echo $form->field($model, 'image')->begin();
    echo Html::activeLabel($model, 'image', ['class' => 'col-sm-3 control-label no-padding-right']);
    ?>
    <div class="col-sm-3">
        <input type="file" name="image" class="file-image" />
    </div>
    <?php
    echo Html::error($model, 'image', ['class' => 'help-block']); //error
    echo $form->field($model, 'image')->end();
    ?>
    <?php if ($model->image) { ?>
        <div class="form-group">
            <label for="admincatre-image" class="col-sm-3 control-label no-padding-right"></label>    
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

    <?php
    echo $form->field($model, 'description')->begin();
    echo Html::activeLabel($model, 'description', ['class' => 'col-sm-3 control-label no-padding-right']);
    ?>
    <div class="col-sm-9">
        <textarea class="ckeditor" id="editor" name="<?= Html::getInputName($model, 'description') ?>"><?= $model->description ?></textarea>
        <?php echo Html::error($model, 'description', ['class' => 'help-block']); //error   ?>
    </div>
    <?php
    echo $form->field($model, 'description')->end();
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
