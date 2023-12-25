<?php

use app\components\FileUpload;
use app\helpers\CustomizeHelper;

if ($data) {
    ?>
    <div class="slide">
        <?php
        foreach ($data as $key => $banner) {
            $oOption = json_decode($banner['multitext']);
            $id_banner = '';
            if ($oOption && isset($oOption->option) && isset($oOption->option->option_id)) {
                $id_banner = $oOption->option->option_id;
            }
            $style_banner = '';
            if ($oOption && isset($oOption->option) && isset($oOption->option->option_style)) {
                $style_banner = $oOption->option->option_style;
            }
            $tar_banner = '_self';
            if ($oOption && isset($oOption->option) && isset($oOption->option->option_target)) {
                $tar_banner = $oOption->option->option_target;
            }
            $class_banner = '';
            if ($oOption && isset($oOption->option) && isset($oOption->option->option_class)) {
                $class_banner = $oOption->option->option_class;
            }
            $url = CustomizeHelper::getLinkFullBanner($banner);
            ?>
            <div class="slide1">
                <a id="<?= $id_banner ?>" class="<?= $class_banner ?>" style="<?= $style_banner ?>" href="<?= $url ?>" target="<?= $tar_banner ?>">
                    <img src="<?= FileUpload::originalfile($banner['src']) ?>" width="1920" height="773" alt="<?= $banner['name'] ?>"/>
                    <h5><?= $banner['name'] ?></h5>
                </a>
            </div><!--end slide1-->

            <?php
        }
        ?>
    </div><!--end slide-->
<?php } ?>