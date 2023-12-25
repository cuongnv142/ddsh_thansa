<?php

use app\helpers\CustomizeHelper;
use app\models\DtvLoai;
use app\models\DtvNganh;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\LinkPager;
use app\components\FileUpload;
use app\modules\admin\models\AdminDtvHo;
use app\modules\admin\models\AdminDtvBo;
use app\modules\admin\models\AdminDtvLop;
use app\modules\admin\models\AdminDtvNganh;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
?>
<div id="content">
    <div class="cover"><img src="/html/images/cover.png" width="1920" height="252" alt=""/></div>
    <div class="truyxuat" style="min-height: 600px;">
        <div class="maincontent">
        <marquee><h2>Cơ sở dữ liệu đa dạng sinh học về thực vật<span></span></h2></marquee>
            <?php
            $form = ActiveForm::begin(
                            [
                                'action' => ['truyxuattv'],
                                'method' => 'get',
                                'options' => [
                                ],
            ]);
            ?>
            <div class="row">
                <!--
                <div class="col-sm-3">
                    <div class="form-group">
                        <label >Giới</label>
                        <?= Html::dropDownList('id_dtv', $id_dtv, DtvNganh::$arrLoai, ['prompt1' => 'Loại', 'class' => 'form-control', 'id' => 'dtv', 'onchange' => 'selected_loai(this.value)']) ?>
                    </div>
                </div> -->
                <div class="col-sm-3">
                    <div class="form-group">
                        <label >Ngành</label>
                        <?php
                        $nganhsArray = CustomizeHelper::getNganhArray();
                        $lstNganh = (isset($nganhsArray[(int) $id_dtv])) ? $nganhsArray[(int) $id_dtv] : [];
                        echo Html::dropDownList('id_nganh', $id_nganh, ArrayHelper::map($lstNganh, 'id', 'name'), ['prompt' => 'Ngành', 'class' => 'form-control', 'id' => 'dtvnganh', 'onchange' => 'selected_nganh(this.value)'])
                        ?>
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="form-group">
                        <label >Lớp</label>
                        <?php
                        $lopsArray = CustomizeHelper::getLopArray();
                        $lstLop = (isset($lopsArray[(int) $id_nganh])) ? $lopsArray[(int) $id_nganh] : [];
                        echo Html::dropDownList('id_lop', $id_lop, ArrayHelper::map($lstLop, 'id', 'name'), ['prompt' => 'Lớp', 'class' => 'form-control', 'id' => 'dtvlop', 'onchange' => 'selected_lop(this.value)'])
                        ?>
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="form-group">
                        <label >Bộ</label>
                        <?php
                        $bosArray = CustomizeHelper::getBoArray();
                        $lstBo = (isset($bosArray[(int) $id_lop])) ? $bosArray[(int) $id_lop] : [];
                        echo Html::dropDownList('id_bo', $id_bo, ArrayHelper::map($lstBo, 'id', 'name'), ['prompt' => 'Bộ', 'class' => 'form-control', 'id' => 'dtvbo', 'onchange' => 'selected_bo(this.value)'])
                        ?>
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="form-group">
                        <label >Họ</label>
                        <?php
                        $hosArray = CustomizeHelper::getHoArray();
                        $lstHo = (isset($hosArray[(int) $id_lop])) ? $hosArray[(int) $id_lop] : [];
                        echo Html::dropDownList('id_ho', $id_ho, ArrayHelper::map($lstHo, 'id', 'name'), ['prompt' => 'Họ', 'class' => 'form-control', 'id' => 'dtvho'])
                        ?>
                    </div>
                </div>
                <div class="col-sm-12">
                    <div class="form-group">
                        <label >Mức độ bảo tồn</label>
                        <div class="row">
                            <div class="col-sm-3">
                                <?= Html::dropDownList('id_iucn', $id_iucn, DtvLoai::$arrMucDoBaoTonIUCN, ['prompt' => 'IUCN', 'class' => 'form-control']) ?>
                            </div>
                            <div class="col-sm-3">
                                <?= Html::dropDownList('id_sdvn', $id_sdvn, DtvLoai::$arrMucDoBaoTonSDVN, ['prompt' => 'Sách đỏ Việt Nam', 'class' => 'form-control']) ?>
                            </div>
                            <div class="col-sm-3">
                                <?php
                                $ndcpArray = DtvLoai::$arrMucDoBaoTonNDCP;
                                $lstNdcp = (isset($ndcpArray[(int) $id_dtv])) ? $ndcpArray[(int) $id_dtv] : [];
                                echo Html::dropDownList('id_ndcp', $id_ndcp, $lstNdcp, ['prompt' => 'Nghị định 84/NĐ-CP', 'class' => 'form-control', 'id' => 'dtv_ndcp'])
                                ?>
                            </div>
                            <div class="col-sm-3">
                                <?php
                                $ndcpArray = DtvLoai::$arrMucDoBaoTonNDCP;
                                $lstNdcp64 = (isset($ndcpArray[(int) $id_dtv])) ? $ndcpArray[(int) $id_dtv] : [];
                                echo Html::dropDownList('id_ndcp64', $id_ndcp64, $lstNdcp64, ['prompt' => 'Nghị định 64/NĐ-CP', 'class' => 'form-control', 'id' => 'dtv_ndcp64'])
                                ?>
                            </div>
                        </div>

                    </div>
                </div>
                <div class="col-sm-5">
                    <div class="form-group">
                        <label >Tên tiếng việt</label>
                        <?php
                        echo Html::textInput('name_tv', $name_tv, ['class' => 'form-control'])
                        ?>
                    </div>
                </div>
                <div class="col-sm-5">
                    <div class="form-group">
                        <label >Tên khoa học</label>
                        <?php
                        echo Html::textInput('name_kh', $name_kh, ['class' => 'form-control'])
                        ?>
                    </div>
                </div>
                <div class="col-sm-2">
                    <div class="form-group">
                        <label class="col-sm-12" >&nbsp;</label>
                        <?= Html::submitButton('<i class="icon-search"></i> Tìm kiếm', ['class' => 'btn btn-primary']) ?>
                    </div>
                </div>
            </div>
            <?php ActiveForm::end(); ?>
            <?php if ($data !== false) { ?>
                <div class="tintuc" style="display: inline-block;margin-top: 20px; width:100%">
                    <div class="noibat">
                        <div class="tinnoibat" style="width: 100%">
                            <h3><a href="javascript:;">Danh sách thực vật - Số lượng: <?= $count;?><span></span></a></h3>
                            <div class="danhsachtin">
                            <div class="row">
                                <?php
                                if ($data) {
                                    foreach ($data as $key => $item) {
                                        $url = CustomizeHelper::createUrlLoai($item);
                                        ?>
                                        
                                            <div class="tin1 col-sm-6">
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
                                                    <?php
                                                        $array_ho = AdminDtvHo::getParentNameTX([$item['id_dtv_ho']]);
                                                        $array_bo = AdminDtvBo::getParentNameTX([$array_ho['id_dtv_bo']]);
                                                        $array_lop = AdminDtvLop::getParentNameTX([$array_bo['id_dtv_lop']]);
                                                        $array_nganh = AdminDtvNganh::getParentNameTX([$array_lop['id_dtv_nganh']]);
                                                        

                                                    ?>
                                                    <h6 style="font-size:12px;"><?= $array_ho['name'] ?></h6> 
                                                    <h6 style="font-size:12px;"><?= $array_bo['name'] ?></h6> 
                                                    <h6 style="font-size:12px;"><?= $array_lop['name'] ?></h6> 
                                                    <h6 style="font-size:12px;"><?= $array_nganh['name'] ?></h6> 
                                                    <ul>
                                                        <li><a href="<?= $url ?>">chi tiết<i class="icon"></i></a></li>
                                                    </ul>
                                                </div>
                                                <div style="clear:both;"></div>
                                            </div>
                                        
                                        <?php
                                    }
                                } else {
                                    echo 'Không tìm thấy dữ liệu nào khớp với yêu cầu của bạn.<br>Hãy thử lại với cụm từ khác';
                                }
                                ?>
                            </div>      
                            </div>
                            <?php if ($pagination) {
                                ?>
                                <?php
                                echo LinkPager::widget([
                                    'pagination' => $pagination,
                                    'options' => ['class' => 'pagination'],
                                    'linkOptions' => [
                                        'class' => ''
                                    ],
                                    'maxButtonCount' => 5,
                                ]);
                                ?>                    
                            <?php }
                            ?>
                        </div>

                    </div>

                </div>
            <?php } ?>
        </div><!--end maincontent-->
    </div><!--end tintuc-->

</div><!--end content-->
<script type="text/javascript">
    var listnganh = '<?php echo addslashes(json_encode($nganhsArray)); ?>';
    listnganh = eval('(' + listnganh + ')');
    var listlop = '<?php echo addslashes(json_encode($lopsArray)); ?>';
    listlop = eval('(' + listlop + ')');
    var listbo = '<?php echo addslashes(json_encode($bosArray)); ?>';
    listbo = eval('(' + listbo + ')');
    var listho = '<?php echo addslashes(json_encode($hosArray)); ?>';
    listho = eval('(' + listho + ')');

    var listndcp = '<?php echo addslashes(json_encode($ndcpArray)); ?>';
    listndcp = eval('(' + listndcp + ')');
    function selected_loai(value) {
        jQuery('#dtvnganh').html('<option value="" selected="selected">Ngành</option>');
        jQuery('#dtvlop').html('<option value="" selected="selected">Lớp</option>');
        jQuery('#dtvbo').html('<option value="" selected="selected">Bộ</option>');
        jQuery('#dtvho').html('<option value="" selected="selected">Họ</option>');
        if (typeof listnganh[value] != 'undefined') {
            for (var i in listnganh[value]) {
                jQuery('#dtvnganh').append('<option value="' + listnganh[value][i].id + '">' + listnganh[value][i].name + '</option>');
            }
        }
        jQuery('#dtv_ndcp').html('<option value="" selected="selected">Nghị định 32-CP</option>');
        if (typeof listndcp[value] != 'undefined') {
            for (var i in listndcp[value]) {
                jQuery('#dtv_ndcp').append('<option value="' + i + '">' + listndcp[value][i] + '</option>');
            }
        }
    }

    function selected_nganh(value) {
        jQuery('#dtvlop').html('<option value="" selected="selected">Lớp</option>');
        jQuery('#dtvbo').html('<option value="" selected="selected">Bộ</option>');
        jQuery('#dtvho').html('<option value="" selected="selected">Họ</option>');
        if (typeof listlop[value] != 'undefined') {
            for (var i in listlop[value]) {
                jQuery('#dtvlop').append('<option value="' + listlop[value][i].id + '">' + listlop[value][i].name + '</option>');
            }
        }
    }
    function selected_lop(value) {
        jQuery('#dtvbo').html('<option value="" selected="selected">Bộ</option>');
        jQuery('#dtvho').html('<option value="" selected="selected">Họ</option>');
        if (typeof listbo[value] != 'undefined') {
            for (var i in listbo[value]) {
                jQuery('#dtvbo').append('<option value="' + listbo[value][i].id + '">' + listbo[value][i].name + '</option>');
            }
        }
    }
    function selected_bo(value) {
        jQuery('#dtvho').html('<option value="" selected="selected">Họ</option>');
        if (typeof listho[value] != 'undefined') {
            for (var i in listho[value]) {
                jQuery('#dtvho').append('<option value="' + listho[value][i].id + '">' + listho[value][i].name + '</option>');
            }
        }
    }
</script>