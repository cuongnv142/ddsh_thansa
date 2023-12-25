<?php

use yii\helpers\Html;
use app\components\FileUpload;
?>
<a id="itemlink_<?= $model->id ?>" title="<?= $model->name ?>" href="<?php echo FileUpload::originalfile($model->name) ?>" target="_blank" data-pjax='false'>
    <?php
    if ($model->type == FileUpload::type_pdf) {
        echo ' <img alt="150x150" src="https://static12.zamba.vn/thumb/150_150/rb_up_es/general/icon-pdf.png" />';
    } else {
        echo Html::img(FileUpload::thumb_wmfile(150, $model->name), ['id' => 'i-' . $model->id, 'style' => 'cursor: pointer']);
    }
    ?>
</a>
<div class="tools tools-bottom active">
    <input class="itemfile" type="checkbox" id="itemfile_<?= $model->id ?>" name="itemfile[<?= $model->id ?>]" value="<?= $model->id ?>"/>
    <a href="javascript:void(0)" class="delete_file" onclick="delete_file(<?= $model->id ?>, this);" title="Xóa">
        <i class="icon-remove red "></i>
    </a>
</div>

