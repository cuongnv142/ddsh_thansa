<?php

use app\components\FileUpload;
use app\helpers\CustomizeHelper;
use yii\helpers\Url;

$sitecontact = CustomizeHelper::getSiteContact();
?>
<div id="footer">
    <div class="maincontent">
        <!--<a href="javascript:;" class="btnHotro"><i class="icon"></i>Hỗ trợ từ iTwood</a>-->
        <div class="info">
            <?php if ($sitecontact['link_logo_footer']) { ?>
                <div class="logo"><a href="<?= Url::base(true) ?>"><img src="<?= FileUpload::originalfile($sitecontact['link_logo_footer']) ?>" width="254" height="254" alt=""/></a></div>
            <?php } ?>
            <ul>
                <li>Địa chỉ: <?= $sitecontact['address'] ?></li>
                <li>Hotline: <?= $sitecontact['hotline'] ?></li>
                <li>Email: <?= $sitecontact['email'] ?></li>
            </ul>
        </div><!--end info-->
        <div class="subLink">
            <ul>
                <li><a href="<?= CustomizeHelper::createUrlGioiThieu() ?>">Giới thiệu</a></li>
                <li><a href="<?= CustomizeHelper::createUrlTruyXuatDV() ?>">Dữ liệu động vật</a></li>
                <li><a href="<?= CustomizeHelper::createUrlTruyXuatTV() ?>">Dữ liệu thực vật</a></li>
            </ul>
            <!--
            <ul class="social">
                <li><a href="<?= $sitecontact['link_face'] ?>"><i class="icon fb"></i>Facebook</a></li>
                <li><a href="<?= $sitecontact['link_twitter'] ?>"><i class="icon tw"></i>Twitter</a></li>
                <li><a href="<?= $sitecontact['link_insta'] ?>"><i class="icon insta"></i>Instagram</a></li>
                <li><a href="<?= $sitecontact['link_youtube'] ?>"><i class="icon yt"></i>Youtube</a></li>
            </ul> -->
        </div><!--end sublink-->
        <div style="clear:both;"></div>
        <p class="copyright">VNUFOREST © 2021 Allright Reserved.</p>
    </div><!--end maincontent-->
</div><!--end footer-->