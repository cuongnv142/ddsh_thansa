<?php

use app\components\FileUpload;
use app\helpers\CustomizeHelper;

$url = CustomizeHelper::createUrlNew($model);
?>
<div class="newssecondary_row">
    <a href="<?= $url ?>" class="newssecondary_row_img">
        <img src="<?= FileUpload::thumb_wmfile(350, $model['image']) ?>" alt="">
    </a>
    <div class="newssecondary_row_body">
        <a class="newssecondary_top_title" href="<?= $url ?>">
            <?= $model['name'] ?>
        </a>
        <span class="news_date">
            <?= date('d/m/Y', strtotime($model['created_at'])) ?>        
        </span>
        <div class="newssecondary_top_txt">
            <?= $model['short_description'] ?>
        </div>
    </div>
</div>

