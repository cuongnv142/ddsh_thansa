<?php

use app\components\FileUpload;
use app\modules\admin\helpers\AdminHelper;
use app\modules\admin\models\AdminMenus;
use app\modules\admin\models\AdminNewsCat;
use app\widgets\admin\form\ActionButton;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

$newscats = AdminNewsCat::getNewsCatLevel(0, 0,$model->language);
$parent_ids = AdminMenus::getMenusLevel($model->id, $model->level, 0, $model->language);
?>
<?= AdminHelper::loadSuccessMessage(); ?>

<div class="news-cat-form">
    <?php
    $form = ActiveForm::begin([
                'id' => 'active-form',
                'options' => [
                    'class' => 'form-horizontal',
                    'enctype' => 'multipart/form-data',
                ],
                'fieldConfig' => [
                    'template' => "{label}\n<div class=\"col-sm-9\">{input}</div>\n<div class=\"col-lg-9 pull-right\">{hint}</div>\n<div class=\"col-lg-9 pull-right\">{error}</div>",
                    'labelOptions' => ['class' => 'col-sm-3 control-label no-padding-right'],
                ],]);
    ?>
    <?= AdminHelper::showHideLangForm($model, $form, ['class' => 'col-xs-3 col-sm-3', 'disabled' => 'disabled']); ?>
    <?php
    echo $form->field($model, 'menu_group_id')->dropDownList(AdminMenus::$arrGroupMenu, ['class' => 'width-40 chosen-select', 'onchange' => 'selected_groupmenu(this.value)']);
    ?>
    <?= $form->field($model, 'name')->textInput(['maxlength' => 300, 'class' => 'col-xs-10 col-sm-8']) ?>
    <?php
    echo $form->field($model, 'parent_id')->dropDownList(ArrayHelper::map($parent_ids, 'id', 'name'), ['prompt' => 'Menu gốc', 'class' => 'width-40 chosen-select']);
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

    <?php
    echo $form->field($model, 'image_hover')->begin();
    echo Html::activeLabel($model, 'image_hover', ['class' => 'col-sm-3 control-label no-padding-right']);
    ?>
    <div class="col-sm-3">
        <input type="file" name="image_hover" class="file-image" />
    </div>
    <?php
    echo Html::error($model, 'image_hover', ['class' => 'help-block']); //error
    echo $form->field($model, 'image_hover')->end();
    ?>
    <?php if ($model->image_hover) { ?>
        <div class="form-group">
            <label for="admincatre-image_hover" class="col-sm-3 control-label no-padding-right"></label>    
            <div class="col-sm-9">
                <span class="profile-picture">
                    <?= Html::img(FileUpload::thumb_wmfile(200, $model->image_hover), ['width' => 200]) ?>
                </span>
                <label>
                    <input type="checkbox" class="ace" name="is_deleteimage_hover">
                    <span class="lbl"> Xóa ảnh</span>
                </label>
            </div>
        </div>
    <?php } ?>
    <?php
    echo $form->field($model, 'type_menu')->dropDownList(AdminMenus::$arrTypeMenu, ['class' => 'width-40 chosen-select', 'onchange' => 'selected_typemenu(this.value)']);
    ?>
    <?= $form->field($model, 'link_menu')->textInput(['maxlength' => 300, 'class' => 'col-xs-10 col-sm-8', 'placeholder' => 'Sử dụng cho Menu dạng Link']) ?>
    <?php
    echo $form->field($model, 'id_object')->dropDownList(ArrayHelper::map($newscats, 'id', 'name'), ['prompt' => 'Sử dụng cho Menu dạng Danh mục tin tức', 'class' => 'width-40 chosen-select']);
    ?>
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
<?php
$js = <<<JS
selected_typemenu($('#adminmenus-type_menu').val());
selected_groupmenu($('#adminmenus-menu_group_id').val());
JS;

$this->registerJs($js);
?>
<script type="text/javascript">
    var newscats = '<?php echo addslashes(json_encode($newscats)); ?>';
    newscats = eval('(' + newscats + ')');
    var parent_ids = '<?php echo addslashes(json_encode($parent_ids)); ?>';
    parent_ids = eval('(' + parent_ids + ')');
    function selected_typemenu(value) {
        var v_selected = jQuery('#adminmenus-id_object').val();
        jQuery('#adminmenus-id_object').html('');
        $("#adminmenus-id_object").prop('disabled', true);
        if (value == 1) {
            $("#adminmenus-id_object").prop('disabled', false)
            for (var i in newscats) {
                var selected = '';
                if (newscats[i].id == v_selected) {
                    selected = 'selected="selected"';
                }
                jQuery('#adminmenus-id_object').append('<option value="' + newscats[i].id + '" ' + selected + '>' + newscats[i].name + '</option>');
            }
        } else {
            jQuery('#adminmenus-id_object').html('<option value="" >Sử dụng cho Menu dạng Danh mục tin tức</option>');
        }
        $("#adminmenus-id_object").trigger("chosen:updated");

        $("#adminmenus-link_menu").prop('disabled', true);
        if (value == 2) {
            $("#adminmenus-link_menu").prop('disabled', false)
        } else {
            $("#adminmenus-link_menu").val('');
        }
    }

    function selected_groupmenu(value) {
        var v_selected = jQuery('#adminmenus-parent_id').val();
        jQuery('#adminmenus-parent_id').html('');
        jQuery('#adminmenus-parent_id').html('<option value="" >Menu gốc</option>');
        for (var i in parent_ids) {
            if (parent_ids[i].menu_group_id == value) {
                var selected = '';
                if (parent_ids[i].id == v_selected) {
                    selected = 'selected="selected"';
                }
                jQuery('#adminmenus-parent_id').append('<option value="' + parent_ids[i].id + '" ' + selected + '>' + parent_ids[i].name + '</option>');
            }
        }
        $("#adminmenus-parent_id").trigger("chosen:updated");
    }
</script>