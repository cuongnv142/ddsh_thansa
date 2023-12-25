<?php

use app\components\FileUpload;
use app\modules\admin\helpers\AdminHelper;
use app\modules\admin\models\AdminRoutePage;
use app\widgets\admin\form\ActionButton;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
?>
<?= AdminHelper::loadSuccessMessage(); ?>
<div class="form-form">
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
                ],
    ]);
    ?>
   <?= AdminHelper::showHideLangForm($model, $form); ?>
    <?= $form->field($model, 'route_id')->dropDownList(ArrayHelper::map(AdminRoutePage::find()->orderBy('name')->all(), 'id', 'name'), ['prompt' => 'Chọn trang', 'class' => 'width-40 chosen-select']) ?>
    <?= $form->field($model, 'page_title')->textInput(['maxlength' => 255]) ?>
    <?= $form->field($model, 'page_keywords')->textarea(['class' => 'autosize-transition form-control limited', 'maxlength' => 160]) ?>
    <?= $form->field($model, 'page_description')->textarea(['class' => 'autosize-transition form-control limited', 'maxlength' => 160]) ?>
    <?php echo $form->field($model, 'face_title')->textInput(['maxlength' => 255, 'class' => 'col-xs-10 col-sm-8']) ?>
    <?php
    echo $form->field($model, 'face_image')->begin();
    echo Html::activeLabel($model, 'face_image', ['class' => 'col-sm-2 control-label no-padding-right']);
    ?>
    <div class="col-sm-3">
        <input type="file" name="face_image" class="file-image" />
    </div>
    <div class="col-sm-6">
        <span class="help-inline">
            <span class="middle">(Min:600x315)</span>
        </span>
    </div>
    <?php
    echo Html::error($model, 'face_image', ['class' => 'help-block', 'style' => 'display: inline-block; padding: 10px 0px 0px 20px;']); //error
    echo $form->field($model, 'face_image')->end();
    ?>
    <?php if ($model->face_image) { ?>
        <div class="form-group group-image">
            <label  class="col-sm-2 control-label no-padding-right"></label>    
            <div class="col-sm-10">
                <span class="profile-picture">
                    <?= Html::img(FileUpload::thumb_wmfile(200, $model->face_image),['width'=>200]) ?>
                </span>
                <label>
                    <input type="checkbox" class="ace" name="is_deletefaceimage">
                    <span class="lbl"> Xóa ảnh</span>
                </label>
            </div>
        </div>
    <?php } ?>
    <?= $form->field($model, 'face_description')->textarea(['class' => 'autosize-transition form-control limited', 'maxlength' => 160]) ?>

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

