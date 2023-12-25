<?php

use app\helpers\CustomizeHelper;
use app\widgets\banner\BannerCatWidgets;
use app\components\FileUpload;

$dv = CustomizeHelper::getDTVLoaiByType(1, 10);
$tv = CustomizeHelper::getDTVLoaiByType(0, 10);
?>
<div id="content">
    <?php
    echo BannerCatWidgets::widget([
        'params' => [
            'id' => 1,
            'limit' => 10,
            'view' => 'banner_slidehome',
            'class_content' => '',
        ]
    ]);
    ?>
    <!--
    <div class="gioithieu">
        <div class="scrollicon"><img src="/html/images/icon_slide.png" width="54" height="54" alt=""/><span></span></div>
        <div class="maincontent">
            <h2>Đa dạng sinh học động thực vật Bắc Hướng Hoá</h2>
            <p>Truy xuất và quản lý nguồn gốc động thực vật là một yêu cầu nghiêm túc và chính đáng của người dân vì mục đích phát triển nền lâm nghiệp bền vững và nói không với việc gây mất rừng.</p>
            <ul>
                <li><img src="/html/images/icon_ketnoi.png" width="200" height="200" alt=""/></li>
                <li><img src="/html/images/icon_hiendai.png" width="200" height="200" alt=""/></li>
                <li><img src="/html/images/icon_minhbach.png" width="200" height="200" alt=""/></li>
                <li><img src="/html/images/icon_hieuqua.png" width="200" height="200" alt=""/></li>
            </ul>
        </div><!--end maincontent-->
    <!--</div><!--end gioithieu-->

    <div class="tintuc">
        <div class="maincontent">
            <div class="noibat">
                <div class="tinnoibat">
                    <h3><a href="javascript:;">Danh sách động vật mới trong cơ sở dữ liệu<span></span></a></h3>
                    <div class="danhsachtin">
                        <?php
                        if ($dv) {
                            foreach ($dv as $key => $item) {
                                $url = CustomizeHelper::createUrlLoai($item);
                                ?>
                                <div class="tin1" style="margin-right: 20px; height: 150px;">
                                    <p class="stt"><?= ($key + 1 < 10) ? '0' . ($key + 1) : ($key + 1) ?>.</p>
                                    <div class="noidung">
                                    <?php
                                    $data = "/html/images/no_image.jpeg";
                                    if ($item['file_dinh_kem']) {
                                        
                                        $json = json_decode($item['file_dinh_kem']);
                                        foreach ($json as $value) {
                                            $data = FileUpload::originalfile($value);
                                        }
                                    }
                                    ?>
                                    <img src="<?= $data ?>" width="150" height="150"  alt="" style="float: left;margin-right: 10px;"/>
                                        <h4><a href="<?= $url ?>"><?= $item['name'] ?></a></h4>
                                        <h6><?= $item['gia_tri_su_dung'] ?></a></h6>
                                        <ul>
                                            <li><a href="<?= $url ?>">chi tiết<i class="icon"></i></a></li>
                                        </ul>
                                    </div>
                                    <div style="clear:both;"></div>
                                </div>
                                <?php
                            }
                        }
                        ?>

                    </div><!--end danhsachtin-->
                </div><!--end tinnoibat-->
                <div class="tinnoibat">
                    <h3><a href="javascript:;">Danh sách thực vật mới trong cơ sở dữ liệu<span></span></a></h3>
                    <div class="danhsachtin">
                        <?php
                        if ($tv) {
                            foreach ($tv as $key => $item) {
                                $url = CustomizeHelper::createUrlLoai($item);
                                ?>
                                <div class="tin1">
                                    <p class="stt"><?= ($key + 1 < 10) ? '0' . ($key + 1) : ($key + 1) ?>.</p>
                                    <div class="noidung">
                                    <?php
                                    $data = "/html/images/no_image.jpeg";
                                    if ($item['file_dinh_kem']) {
                                        
                                        $json = json_decode($item['file_dinh_kem']);
                                        foreach ($json as $value) {
                                            $data = FileUpload::originalfile($value);
                                        }
                                    }
                                    ?>
                                    <img src="<?= $data ?>" width="150" height="150"  alt="" style="float: left;margin-right: 10px;"/>
                                        <h4><a href="<?= $url ?>"><?= $item['name'] ?></a></h4>
                                        <h6><?= $item['gia_tri_su_dung'] ?></a></h6>
                                        <ul>
                                            <li><a href="<?= $url ?>">chi tiết<i class="icon"></i></a></li>
                                        </ul>
                                    </div>
                                    <div style="clear:both;"></div>
                                </div>
                                <?php
                            }
                        }
                        ?>
                    </div>
                </div>
                <div style="clear:both;"></div>
            </div>

        </div>
    </div>
</div><!--end content-->

