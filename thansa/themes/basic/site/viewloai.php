<?php

use app\assets\AppAsset;
use app\components\FileUpload;
use app\helpers\CustomizeHelper;
use app\modules\admin\models\AdminDtvHo;
use app\modules\admin\models\AdminDtvBo;
use app\modules\admin\models\AdminDtvLop;
use app\modules\admin\models\AdminDtvNganh;
use app\modules\admin\models\AdminDtvLoai;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$this->registerCssFile(Yii::getAlias('@web') . "/css/jquery.fancybox.min.css");
$this->registerJsFile(Yii::getAlias('@web') . "/js/jquery.fancybox.min.js", ['depends' => AppAsset::className()]);
?>
<div id="content">
    <div class="cover"><img src="/html/images/cover.png" width="1920" height="252" alt=""/></div>
    <div class="tintuc" id="trangchitiet">
        <div class="maincontent">
            <h2><span>Loài<span></span></span></h2>
            <p>Tên tiếng Việt: <b><?= $model['name'] ?></b>   </p>
            <p>Tên Khoa học: <b><?= $model['name_latinh'] ?></b>   </p>
            <p>Tên khác: <b><?= $model['ten_khac'] ?></b>   </p>
            <p><b>Thuộc: </b> </p>
            <?php
                $array_ho = AdminDtvHo::getParentNameTX([$model['id_dtv_ho']]);
                $array_bo = AdminDtvBo::getParentNameTX([$array_ho['id_dtv_bo']]);
                $array_lop = AdminDtvLop::getParentNameTX([$array_bo['id_dtv_lop']]);
                $array_nganh = AdminDtvNganh::getParentNameTX([$array_lop['id_dtv_nganh']]);
            ?>
                <p>Họ: <b><?= $array_ho['name'] ?></b></p> 
                <p>Bộ: <b><?= $array_bo['name'] ?></b></p> 
                <p>Lớp: <b><?= $array_lop['name'] ?></b></p> 
                <p>Ngành: <b><?= $array_nganh['name'] ?></b></p> 
                <p>Mức độ bảo tồn: </p> 
                <ol>
                    <li> IUCN: <?= isset(AdminDtvLoai::$arrMucDoBaoTonIUCN[$model['muc_do_bao_ton_iucn']]) ? AdminDtvLoai::$arrMucDoBaoTonIUCN[$model['muc_do_bao_ton_iucn']] : 'Không có';?></li>
                    <li> Sách đỏ VN: <?= isset(AdminDtvLoai::$arrMucDoBaoTonSDVN[$model['muc_do_bao_ton_sdvn']]) ? AdminDtvLoai::$arrMucDoBaoTonSDVN[$model['muc_do_bao_ton_sdvn']] : 'Không có';?></li>
                    <li> Nghị định 84: <?= isset(AdminDtvLoai::$arrMucDoBaoTonNDCP[$model['loai']][$model['muc_do_bao_ton_ndcp']]) ? AdminDtvLoai::$arrMucDoBaoTonNDCP[$model['loai']][$model['muc_do_bao_ton_ndcp']] : 'Không có';?></li>
                    <li> Nghị định chính phủ: <?= isset(AdminDtvLoai::$arrMucDoBaoTonNDCP[$model['loai']][$model['muc_do_bao_ton_nd64cp']]) ? AdminDtvLoai::$arrMucDoBaoTonNDCP[$model['loai']][$model['muc_do_bao_ton_nd64cp']] : 'Không có';?></li>
                </ol>
            <h2><span>Hình ảnh <span></span></span></h2>
            <div class="doitac duantieubieu">
                <ul>
                    <?php
                    if ($model['file_dinh_kem']) {
                        $json = json_decode($model['file_dinh_kem']);
                        foreach ($json as $value) {
                            ?>
                    <li> <a style="padding: 0;" href="<?= FileUpload::originalfile($value) ?>"
                                    data-fancybox="imagesdetail" class="fancybox">
                                    <img src="<?= FileUpload::originalfile($value) ?>" width="110" height="115" alt=""/>
                                </a>

                            </li>
                        <?php }
                        ?>
                    <?php } ?>  
                </ul>
            </div><!--end duantieubieu-->
            <br>
            <h2><span>Đặc điểm<span></span></span></h2>
            <div class="noidungchitiet">
                <?= $model['dac_diem'] ?>
            </div><!--end noidungchitiet-->
            <h2><span>Công dụng - Giá trị sử dụng<span></span></span></h2>
            <div class="noidungchitiet">
                <?= $model['gia_tri_su_dung'] ?>
            </div><!--end noidungchitiet-->
            <div style="clear:both;"></div>
            <?php if ($datarelated) { ?>
                <div class="tintuc" style="display: inline-block;margin-top: 100px;">
                    <div class="noibat">
                        <div class="tinnoibat" style="width: 100%">
                            <h3 style="font-size:36px;font-weight: normal;"><a href="javascript:;" style="font-weight: normal;">Loài tương tự<span></span></a></h3>
                            <div class="danhsachtin">
                                <?php
                                foreach ($datarelated as $key => $item) {
                                    $url = CustomizeHelper::createUrlLoai($item);
                                    ?>
                                    <div class="tin1">
                                        <p class="stt"><?= ($key + 1 < 10) ? '0' . ($key + 1) : ($key + 1) ?>.</p>
                                        <div class="noidung">
                                            <h4><a href="<?= $url ?>"><?= $item['name'] ?></a></h4>
                                            <ul>
                                                <li><a href="<?= $url ?>">chi tiết<i class="icon"></i></a></li>
                                            </ul>
                                        </div>
                                        <div style="clear:both;"></div>
                                    </div>
                                    <?php
                                }
                                ?>
                            </div>
                        </div>

                    </div>

                </div>
            <?php } ?>
        </div><!--end maincontent-->
    </div><!--end tintuc-->
</div><!--end content-->
