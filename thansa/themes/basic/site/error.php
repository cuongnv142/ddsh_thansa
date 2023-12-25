<?php
$this->title = '404';

use yii\helpers\Url;
?>

<div class="construction_404">
    <div class="construction_404_content">
        <div class="construction_404_c">
            <h5>
                404
            </h5>
            <div class="construction_404_txt">
                <span>
                    <?= Yii::t('app', 'KHÔNG TÌM THẤY TRANG'); ?>
                    
                </span>
                <?= Yii::t('app', 'Trang đã bị xóa hoặc địa chỉ URL không đúng'); ?>
                
            </div>
            <div class="construction_404_box">
                <a href="<?= Url::home(true) ?>" class="btn btn-404">
                    <?= Yii::t('app', 'QUAY VỀ TRANG CHỦ'); ?>
                    
                </a>
            </div>
        </div>
    </div>
</div>

