<?php
use yii\helpers\Html;
use app\components\FileUpload;

$urlImg = FileUpload::thumb_wmfile(1230, $model->name);
?>
<?php if (isset($_GET['is_quick'])): ?>
<?=Html::img(FileUpload::thumb_wmfile(150, $model->name), ['id' => 'i-' . $model->id, 'onclick' => 'appendToCKEditorQuick("i-'.$model->id.'", true)', 'style' => 'cursor: pointer', 'data-use-src' => $urlImg, 'title' => 'Chèn và đóng cửa sổ'])?>
<?php else: ?>
<?=Html::img(FileUpload::thumb_wmfile(150, $model->name), ['id' => 'i-' . $model->id, 'onclick' => 'appendToCKEditor(this)', 'style' => 'cursor: pointer', 'data-use-src' => $urlImg])?>
<?php endif; ?>
<div class="tools tools-bottom active">
    <a href="javascript:void(0)" class="" onclick="appendToCKEditorQuick('i-<?=$model->id?>')" title="Chèn trực tiếp">
        <i class="icon-plus blue "></i>
    </a>
    <a href="javascript:void(0)" class="delete_file" onclick="delete_file(<?=$model->id?>, this);" title="Xóa">
        <i class="icon-remove red "></i>
    </a>
</div>

