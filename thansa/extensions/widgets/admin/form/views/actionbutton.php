<?php

use yii\helpers\Html;
?>
<div class="clearfix form-actions-top">
    <div class="col-md-">
        <?= Html::a('<i class="icon-save bigger-110 "></i> Lưu', 'javascript:void(0);', ['class' => 'btn btn-primary submit-form', "type" => "save"]) . '&nbsp; &nbsp; &nbsp;'; ?>
        <?= Html::a('<i class="icon-edit bigger-110 "></i> Lưu & Sửa', 'javascript:void(0);', ['class' => 'btn btn-primary submit-form', "type" => "edit"]) . '&nbsp; &nbsp; &nbsp;'; ?>

        <?php
        if (isset($btn_first) && $btn_first) {
            if (is_array($btn_first)) {
                foreach ($btn_first as $item) {
                    echo $item . '&nbsp; &nbsp; &nbsp;';
                }
            } else {
                echo $btn_first . '&nbsp; &nbsp; &nbsp;';
            }
        }
        if (isset($btn_back) && $btn_back) {
            echo $btn_back . '&nbsp; &nbsp; &nbsp;';
        }
        if (isset($btn_last) && $btn_last) {
            if (is_array($btn_last)) {
                foreach ($btn_last as $item) {
                    echo $item . '&nbsp; &nbsp; &nbsp;';
                }
            } else {
                echo $btn_last . '&nbsp; &nbsp; &nbsp;';
            }
        }
        ?>

    </div>
</div>
<div class="clearfix form-actions">
    <div class="col-md-offset-2 col-md-10">
        <input type="hidden" name="type_submit" id="typesub" value="save">
        <?= Html::a('<i class="icon-save bigger-110 "></i> Lưu', 'javascript:void(0);', ['class' => 'btn btn-primary submit-form', "type" => "save"]) . '&nbsp; &nbsp; &nbsp;'; ?>
        <?= Html::a('<i class="icon-edit bigger-110 "></i> Lưu & Sửa', 'javascript:void(0);', ['class' => 'btn btn-primary submit-form', "type" => "edit"]) . '&nbsp; &nbsp; &nbsp;'; ?>

        <?php
        if (isset($btn_first) && $btn_first) {
            if (is_array($btn_first)) {
                foreach ($btn_first as $item) {
                    echo $item . '&nbsp; &nbsp; &nbsp;';
                }
            } else {
                echo $btn_first . '&nbsp; &nbsp; &nbsp;';
            }
        }
        if (isset($btn_back) && $btn_back) {
            echo $btn_back . '&nbsp; &nbsp; &nbsp;';
        }
        if (isset($btn_last) && $btn_last) {
            if (is_array($btn_last)) {
                foreach ($btn_last as $item) {
                    echo $item . '&nbsp; &nbsp; &nbsp;';
                }
            } else {
                echo $btn_last . '&nbsp; &nbsp; &nbsp;';
            }
        }
        ?>

    </div>
</div>
<?php
$this->registerJs(
        '$("document").ready(function(){ 
         jQuery(".submit-form").click(function () {
            var check_required = true;
            if ($(".required_input").length) {
                $(".required_input").each(function () {
                    var value = $.trim($(this).val());
                    if (!value) {
                        check_required = false;
                        $(this).addClass("tooltip-error");
                    } else {
                        $(this).removeClass("tooltip-error");
                    }

                });
            }
            if(check_required){
                jQuery("#typesub").val(jQuery(this).attr("type"));
                document.getElementById("' . $formId . '").submit();
            }else{
                $(".required_input.tooltip-error").tooltip({title:"Không được để trống ô",trigger:"manual"}).tooltip("show");
                jQuery("html, body").animate({scrollTop: 0}, 500);
            }
        });
    });
    jQuery(window).scroll(function () {    
      if ($(this).scrollTop() > 50) {
        jQuery(".form-actions-top").css({"top": 0,"right":0});
      }else{
      jQuery(".form-actions-top").css({"top": 50,"right":175});
      }
     });'
);
?>
<style>
    .form-actions-top {
        background: #f5f5f5 none repeat scroll 0 0;
        display: inline-block;
        position: fixed;
        right: 175px;
        top: 50px;
        z-index: 999;
    }
</style>