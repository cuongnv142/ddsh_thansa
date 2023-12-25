<?php

use app\components\FileUpload;
use app\modules\admin\helpers\AdminHelper;
use app\modules\admin\models\AdminBannerCat;
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
    <?= AdminHelper::showHideLangForm($model, $form, ['class' => 'col-xs-3 col-sm-3', 'disabled' => 'disabled']); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => 300, 'class' => 'col-xs-10 col-sm-8']) ?>

    <?php
    echo $form->field($model, 'banner_cat_id')->begin();
    echo Html::activeLabel($model, 'banner_cat_id', ['class' => 'col-sm-3 control-label no-padding-right']);
    ?>
    <div class="col-sm-9">
        <?= Html::activeDropDownList($model, 'banner_cat_id', ArrayHelper::map(AdminBannerCat::getBannerCatLevel(0, 0, $model->language), 'id', 'name'), ['prompt' => 'Danh mục', 'class' => 'width-40 chosen-select']) ?>
        <?= Html::error($model, 'banner_cat_id', ['class' => 'help-block']) #error      ?>
    </div>
    <?php
    echo $form->field($model, 'banner_cat_id')->end();
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

    <?php
    echo $form->field($model, 'src_mobile')->begin();
    echo Html::activeLabel($model, 'src_mobile', ['class' => 'col-sm-3 control-label no-padding-right']);
    ?>
    <div class="col-sm-3">
        <input type="file" name="src_mobile" class="file-image"/>
    </div>
    <?php
    echo Html::error($model, 'src_mobile', ['class' => 'help-block']); //error
    echo $form->field($model, 'src_mobile')->end();
    ?>
    <?php if ($model->src_mobile) { ?>
        <div class="form-group">
            <label for="admincatre-image" class="col-sm-3 control-label no-padding-right"></label>
            <div class="col-sm-9">
                <span class="profile-picture">
                    <?= Html::img(FileUpload::thumb_wmfile(200, $model->src_mobile), ['width' => 200]) ?>
                </span>
                <label>
                    <input type="checkbox" class="ace" name="is_deleteimagemobile">
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

    <?php
    echo $form->field($model, 'description')->begin();
    echo Html::activeLabel($model, 'description', ['class' => 'col-sm-3 control-label no-padding-right']);
    ?>
    <div class="col-sm-9">
        <textarea class="ckeditor" id="editor" name="AdminBanner[description]"><?= $model->description ?></textarea>

        <?= Html::error($model, 'description', ['class' => 'help-block']) ?>
    </div>
    <?php
    echo $form->field($model, 'description')->end();
    ?>
    <?php
    $muti_option = json_decode($model['multitext'], true);
    $option_price = $option_percent = $option_id = $option_class = $option_style = $option_target = $option_gift = $option_label = '';
    if (isset($muti_option['option'])) {
        $option_id = isset($muti_option['option']['option_id']) ? $muti_option['option']['option_id'] : '';
        $option_class = isset($muti_option['option']['option_class']) ? $muti_option['option']['option_class'] : '';
        $option_style = isset($muti_option['option']['option_style']) ? $muti_option['option']['option_style'] : '';
        $option_target = isset($muti_option['option']['option_target']) ? $muti_option['option']['option_target'] : '_self';
    } else {
        $option_target = '_self';
    }
    $arr_tag = array("_blank" => "_blank", "_self" => "_self", "_parent" => "_parent", "_top" => "_top", "framename" => "framename");
    ?>
    <div class="form-group">
        <label class="col-sm-3 control-label no-padding-right" for="banner-multitext">Thuộc tính</label>
        <div class="col-sm-9">
            <div class="control-group" id="fields">
                <div class="row">

                    <div class="col-sm-6">
                        <div class="form-group">
                            <div class="col-sm-3">ID:</div>
                            <div class="col-sm-9"><?= Html::textInput('option_id', $option_id, ['maxlength' => 255, 'class' => 'col-xs-9']) ?></div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <div class="col-sm-3">Target:</div>
                            <div class="col-sm-9">
                                <?= Html::dropDownList('option_target', $option_target, $arr_tag, ['class' => 'col-xs-9']) ?>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-6">
                        <div class="form-group">
                            <div class="col-sm-3">Style:</div>
                            <div class="col-sm-9">
                                <?= Html::textarea('option_style', $option_style, ['maxlength' => 255, 'class' => 'col-xs-9']) ?>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <div class="col-sm-3">Class:</div>
                            <div class="col-sm-9">
                                <?= Html::textarea('option_class', $option_class, ['maxlength' => 255, 'class' => 'col-xs-9']) ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
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

