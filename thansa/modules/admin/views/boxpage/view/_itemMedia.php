<?php

use app\components\FileUpload;
use yii\helpers\StringHelper;
?>  
<a data-pjax="0" href="<?php echo FileUpload::originalfile($model->path) ?>" data-rel="colorbox">
    <img alt="150x150" src="<?php echo FileUpload::thumbfile(150, 150, $model->path) ?>" width="150" />
</a>
<div class="tools tools-bottom active" style="height: auto; color: white">
    <a href="javascript:void(0)" class="sort_file" title="Thứ tự">
        <input type="text" maxlength="4" class="input-mask-sort" name="sort_image[<?php echo $model->id ?>]" value="<?php echo $index + 1 ?>"/>
    </a>
    <a href="javascript:void(0)" class="delete_file" onclick="delete_file('<?php echo $model->id ?>', this)" title="Xóa">
        <i class="icon-remove red "></i>
    </a>
    <a href="javascript:void(0)" title="Đổi tiêu đề" data-title-old="<?= $model->name ?>" onclick="edit_image_title('<?php echo $model->id ?>', this)">
        <i class="icon-edit blue"></i>
    </a>
    <div class="checkbox-inline" style="padding: 0;">
        <label>
            <input name="delete_image[]" type="checkbox" value="<?php echo $model->id ?>" class="ace">
            <span class="lbl"></span>
        </label>
    </div>
    <br />
    <span id="image-tit-<?php echo $model->id ?>" title="<?= $model->name ?>"><?= StringHelper::truncate($model->name, 15) ?> </span>
</div>

<?php if ($model->boxpage_id == 0):
    ?>
    <input type="hidden" name="map_image[<?php echo $model->id ?>]" value="1"/>
<?php endif; ?>