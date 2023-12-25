<?php

use app\components\FileUpload;
use app\helpers\CustomizeHelper;
use yii\helpers\Url;

$sitecontact = CustomizeHelper::getSiteContact();
$controller = Yii::$app->controller->id;
$action = Yii::$app->controller->action->id;
?>
<div id="header">
    <div class="maincontent">
        <div class="contact">
            <div class="logo" style="float:left;"><a href="<?= Url::base(true) ?>"><img src="<?= FileUpload::originalfile($sitecontact['link_logo']) ?>" width="70" height="70" alt=""/></a>
            </div>
            <div class="lang custom-select1">
                <?//= $sitecontact['name'] ?>
                <div>
                    CƠ SỞ DỮ LIỆU BẢO TỒN ĐA DẠNG SINH HỌC
                </div>
                <div>
                    Ban quản lý Khu dự trữ thiên nhiên Thần Sa - Phượng Hoàng
                </div>
            </div><!--end lang-->

            <ul class="rightContact">
            <!--    
            <li>
                    <i class="icon phone"></i>
                    <span>Hotline<span><?= $sitecontact['hotline'] ?></span></span>
                </li> -->
                <!--
                <li>
                    <i class="icon email"></i>
                    <span>Email<span><?= $sitecontact['email'] ?></span></span>
                </li> -->
                <li>
                    <i class="icon map"></i>
                    <span>Địa chỉ<span><?= $sitecontact['address'] ?></span></span>
                </li>
            </ul>
            <div style="clear:both;"></div>
        </div><!--end contact-->

        <div class="header2">

            <?php if ($sitecontact['link_logo']) { ?>
               <!-- <div class="logo" style="margin-left: 10%;"><a href="<?= Url::base(true) ?>"><img src="<?= FileUpload::originalfile($sitecontact['link_logo']) ?>" width="61" height="61" alt=""/></a></div> -->
            <?php } ?>
            <div class="nav">
                <a href="javascript:;" class="navBtn"><span></span><span></span><span></span></a>
                <ul>
                    <li><a href="<?= Url::base(true) ?>" id="homeBtn" class="active"><span>Trang chủ</span>&nbsp;</a></li>
                    <li><a href="<?= CustomizeHelper::createUrlGioiThieu() ?>">Giới thiệu</a></li>
                    <li><a href="<?= CustomizeHelper::createUrlTruyXuatDV() ?>">CSDL động vật</a></li>
                    <li><a href="<?= CustomizeHelper::createUrlTruyXuatTV() ?>">CSDL thực vật</a></li>
                    <!--<li><a href="<?//= CustomizeHelper::createUrlTruyXuatCT() ?>">CSDL côn trùng</a></li>-->
                    <li><a href="<?= Url::toRoute('site/login') ?>">Đăng nhập</a></li>
                </ul>
            </div><!--end nav-->
            <div style="clear:both;"></div>
        </div><!--header2-->
    </div><!--end maincontent-->
</div><!--end header-->