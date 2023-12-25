<?php

use app\components\FileUpload;
use app\modules\admin\helpers\AdminHelper;
use app\widgets\admin\form\ActionButton;
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
                    'template' => "{label}\n<div class=\"col-sm-10\">{input}</div>\n<div class=\"col-sm-10 pull-right\">{error}</div>",
                    'labelOptions' => ['class' => 'col-sm-2 control-label no-padding-right'],
                ],]);
    ?>
    <?= AdminHelper::showHideLangForm($model, $form); ?>
    <?= $form->field($model, 'name')->textInput(['maxlength' => 255, 'class' => 'col-xs-10 col-sm-8']) ?>
    <?php
    echo $form->field($model, 'link_logo')->begin();
    echo Html::activeLabel($model, 'link_logo', ['class' => 'col-sm-2 control-label no-padding-right']);
    ?>
    <div class="col-sm-3">
        <input type="file" name="link_logo" class="file-image"/>
    </div>
    <?php
    echo Html::error($model, 'link_logo', ['class' => 'help-block']); //error
    echo $form->field($model, 'link_logo')->end();
    ?>
    <?php if ($model->link_logo) { ?>
        <div class="form-group">
            <label for="admincatre-image" class="col-sm-2 control-label no-padding-right"></label>
            <div class="col-sm-10">
                <span class="profile-picture">
                    <?= Html::img(FileUpload::thumb_wmfile(200, $model->link_logo), ['width' => 200]) ?>
                </span>
                <label>
                    <input type="checkbox" class="ace" name="is_deleteimage">
                    <span class="lbl"> Xóa file</span>
                </label>
            </div>
        </div>
    <?php } ?>

    <?php
    echo $form->field($model, 'link_logo_footer')->begin();
    echo Html::activeLabel($model, 'link_logo_footer', ['class' => 'col-sm-2 control-label no-padding-right']);
    ?>
    <div class="col-sm-3">
        <input type="file" name="link_logo_footer" class="file-image"/>
    </div>
    <?php
    echo Html::error($model, 'link_logo_footer', ['class' => 'help-block']); //error
    echo $form->field($model, 'link_logo_footer')->end();
    ?>
    <?php if ($model->link_logo_footer) { ?>
        <div class="form-group">
            <label for="admincatre-image" class="col-sm-2 control-label no-padding-right"></label>
            <div class="col-sm-10">
                <span class="profile-picture">
                    <?= Html::img(FileUpload::thumb_wmfile(200, $model->link_logo_footer), ['width' => 200]) ?>
                </span>
                <label>
                    <input type="checkbox" class="ace" name="is_deleteimagefooter">
                    <span class="lbl"> Xóa file</span>
                </label>
            </div>
        </div>
    <?php } ?>
    <?= $form->field($model, 'email')->textInput(['maxlength' => 255, 'class' => 'col-xs-10 col-sm-8']) ?>
    <?= $form->field($model, 'phone')->textInput(['maxlength' => 255, 'class' => 'col-xs-10 col-sm-8']) ?>
    <?= $form->field($model, 'hotline')->textInput(['maxlength' => 255, 'class' => 'col-xs-10 col-sm-8']) ?>
    <?= $form->field($model, 'fax')->textarea(['class' => 'autosize-transition form-control limited', 'maxlength' => 10000000]) ?>
    <?php // $form->field($model, 'fax')->textInput(['maxlength' => 255, 'class' => 'col-xs-10 col-sm-8']) ?>
    <?= $form->field($model, 'address')->textInput(['maxlength' => 255, 'class' => 'col-xs-10 col-sm-8']) ?>
    <?= $form->field($model, 'link_face')->textInput(['maxlength' => 255, 'class' => 'col-xs-10 col-sm-8']) ?>
    <?= $form->field($model, 'link_youtube')->textInput(['maxlength' => 255, 'class' => 'col-xs-10 col-sm-8']) ?>
    <?= $form->field($model, 'link_twitter')->textInput(['maxlength' => 255, 'class' => 'col-xs-10 col-sm-8']) ?>
    <?= $form->field($model, 'link_insta')->textInput(['maxlength' => 255, 'class' => 'col-xs-10 col-sm-8']) ?>
    <?= $form->field($model, 'link_zalo')->textInput(['maxlength' => 255, 'class' => 'col-xs-10 col-sm-8']) ?>
    <?= $form->field($model, 'link_messenger')->textInput(['maxlength' => 255, 'class' => 'col-xs-10 col-sm-8']) ?>
    <?php // $form->field($model, 'link_map')->textarea(['class' => 'autosize-transition form-control limited', 'maxlength' => 10000000]) ?>
    <?php // $form->field($model, 'link_favicon')->textInput(['maxlength' => 255, 'class' => 'col-xs-10 col-sm-8']) ?>
    <?= $form->field($model, 'embed_script_head')->textarea(['class' => 'autosize-transition form-control limited', 'maxlength' => 10000000]) ?>
    <?= $form->field($model, 'embed_script_body_begin')->textarea(['class' => 'autosize-transition form-control limited', 'maxlength' => 10000000]) ?>
    <?= $form->field($model, 'embed_script_body_end')->textarea(['class' => 'autosize-transition form-control limited', 'maxlength' => 10000000]) ?>
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


