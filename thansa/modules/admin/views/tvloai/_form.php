<?php

use app\modules\admin\helpers\AdminHelper;
use app\modules\admin\models\AdminDtvHo;
use app\modules\admin\models\AdminDtvLoai;
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
    <?= $form->field($model, 'id_dtv_ho')->dropDownList(ArrayHelper::map(AdminDtvHo::find()->where(['loai' => $model->loai])->orderBy('name')->all(), 'id', 'name'), ['prompt' => 'Lựa chọn', 'class' => 'width-40 chosen-select']) ?>
    <?= $form->field($model, 'name')->textInput(['maxlength' => 300, 'class' => 'col-xs-10 col-sm-8']) ?>

    <?= $form->field($model, 'name_latinh')->textInput(['maxlength' => 300, 'class' => 'col-xs-10 col-sm-8']) ?>
    <?= $form->field($model, 'ten_khac')->textInput(['maxlength' => 300, 'class' => 'col-xs-10 col-sm-8']) ?>
    <?= $form->field($model, 'phan_bo')->textInput(['maxlength' => 300, 'class' => 'col-xs-10 col-sm-8']) ?>
    <?= $form->field($model, 'nguon_tai_lieu')->textInput(['maxlength' => 300, 'class' => 'col-xs-10 col-sm-8']) ?>
    <?php
    echo $form->field($model, 'muc_do_bao_ton_iucn')->begin();
    echo Html::activeLabel($model, 'muc_do_bao_ton_iucn', ['class' => 'col-sm-3 control-label no-padding-right']);
    ?>
    <div class="col-sm-2">
        <?php echo Html::activeDropDownList($model, 'muc_do_bao_ton_iucn', AdminDtvLoai::$arrMucDoBaoTonIUCN, ['prompt' => 'IUCN', 'class' => 'width-98 chosen-select']); ?>
    </div>
    <div class="col-sm-2">
        <?php echo Html::activeDropDownList($model, 'muc_do_bao_ton_sdvn', AdminDtvLoai::$arrMucDoBaoTonSDVN, ['prompt' => 'Sách đỏ Việt Nam', 'class' => 'width-98 chosen-select']); ?>
    </div>
    <div class="col-sm-2">
        <?php echo Html::activeDropDownList($model, 'muc_do_bao_ton_ndcp', AdminDtvLoai::$arrMucDoBaoTonNDCP[$model->loai], ['prompt' => 'Nghị định 32-CP', 'class' => 'width-98 chosen-select']); ?>
    </div>
    <?php
    echo Html::error($model, 'muc_do_bao_ton_iucn', ['class' => 'help-block']); //error
    echo $form->field($model, 'muc_do_bao_ton_iucn')->end();
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
    echo $form->field($model, 'file_dinh_kem')->begin();
    echo Html::activeLabel($model, 'file_dinh_kem', ['class' => 'col-sm-3 control-label no-padding-right']);
    ?>
    <div class="col-sm-9">
        <input multiple="" type="file" name="file_dinh_kem[]" class="file-images"/>
    </div>
    <?php
    echo Html::error($model, 'file_dinh_kem', ['class' => 'help-block']); //error
    echo $form->field($model, 'file_dinh_kem')->end();
    ?>
    <?php if ($model->file_dinh_kem) { ?>
        <div class="form-group">
            <div class="col-sm-3">&nbsp;</div>
            <div class="col-sm-9">
                <span class="profile-picture">
                    <?= AdminDtvLoai::getHtmlfiledinhkem($model->file_dinh_kem) ?>
                </span>
                <label>
                    <input type="checkbox" class="ace" name="is_deleteifile_dinh_kem">
                    <span class="lbl"> Xóa ảnh</span>
                </label>
            </div>
        </div>
    <?php } ?>  
    <?= $form->field($model, 'gia_tri_su_dung')->textarea(['rows' => 6, 'class' => 'col-xs-10 col-sm-8']) ?>
    <?php
    echo $form->field($model, 'dac_diem')->begin();
    echo Html::activeLabel($model, 'dac_diem', ['class' => 'col-sm-3 control-label no-padding-right']);
    ?>
    <div class="col-sm-9">
        <textarea class="ckeditor" id="editor" name="AdminDtvLoai[dac_diem]"><?= $model->dac_diem ?></textarea>

        <?= Html::error($model, 'dac_diem', ['class' => 'help-block']) ?>
    </div>
    <?php
    echo $form->field($model, 'dac_diem')->end();
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

<style type="text/css">
    .ace-file-input input[type="file"] {
        position: fixed; 
    }
</style>