<?php

use yii\widgets\ListView;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\Pjax;

$this->title = 'Upload ảnh';
$this->params['breadcrumbs'][] = $this->title;
$request = Yii::$app->request;
?>
<input type="hidden" id="form-key-csrf" data-key-name="<?= Yii::$app->request->csrfParam ?>"
       data-key-value="<?= Yii::$app->request->getCsrfToken() ?>"/>
<style type="text/css">
    .ace-thumbnails > li > *:first-child {
        display: block;
        position: relative;
        width: 100%;
        height: 100%;
    }

    .cellimg {
        height: 180px;
        padding-bottom: 28px;
        width: 154px;
    }

    .cellimg img {
        bottom: 0;
        left: 0;
        margin: auto;
        max-width: 100%;
        position: absolute;
        right: 0;
        top: 0;
    }
</style>
<div class="col-sm-3">
    <h4>Danh sách thư mục</h4>
    <?php
    Pjax::begin(['id' => 'image_filter']);
    echo '<a style="display:none" id="fake-url" href="' . Url::current(['id_dir' => 'ID_DIR']) . '">Fake</a>';
    ?>
    <div id="jstree"></div>
    <?php
    Pjax::end();
    $idRoot = 1;
    $keyState = 'jstree2015';
    echo '<script>
        var keySateJsTree = "' . $keyState . '",
        uMkDir = "' . Url::toRoute('image/mkdir') . '",
        uRenameDir = "' . Url::toRoute('image/renamedir') . '",    
        uRemoveDir = "' . Url::toRoute('image/removedir') . '",    
        uFetchRoot = "' . Url::toRoute(['image/getroot', 'rid' => $idRoot]) . '",
        uFetchChildren = "' . Url::toRoute('image/getchildren') . '";';
    echo '</script>';
    $this->registerJs(
        '$("document").ready(function(){ 
                $("#image_filter").on("pjax:success", function() {
                    $.pjax.reload({container:"#image_result",async:false});
                });
                $("#checkAll").change(function () {
                    $("input.itemfile:checkbox").prop("checked", $(this).prop("checked"));
                });
            });');
    $this->registerJsFile('@web/js/tree/image.js', ['depends' => 'app\modules\admin\AdminAsset']);
    ?>

    <div class='form-group'>
        <input type='text' id='dirname_new' class='form-control' placeholder="Tên thư mục mới"/>
    </div>
    <button class='btn btn-primary' onclick='createNewImageDir();'>Tạo thư mục mới</button>

</div>
<div class="col-sm-9">
    <div class="row">
        <iframe name="up_iframe" src="" style="display:none" border="0"></iframe>
        <form onsubmit="$('#id_dir').val($('#id_dir_pjax').val());
                return true;" method="post" action="<?= Url::toRoute(['image/uploadfiles', 'change_name' => 0]) ?>"
              enctype="multipart/form-data" target="up_iframe">
            <div class="widget-main">
                <input multiple="multiple" type="file" name="inputfiles[]" class="file-input"/>
            </div>
            <input type="hidden" id="form-key-csrf" name="<?= Yii::$app->request->csrfParam ?>"
                   value="<?= Yii::$app->request->getCsrfToken() ?>"/>
            <input type="hidden" id="id_dir" name="id_dir" value="<?= $id_dir ?>"/>
            <div class="center">
                <div id="uploadSatus"></div>
                <button id="btnUploadNow" class="btn btn-primary" type="submit" onclick="uploadNow();"><i
                            class="icon-save bigger-110"></i> Upload
                </button>
            </div>
        </form>
    </div>
    <div class="row">
        <label><input type="checkbox" id="checkAll"/> Check all/Uncheck all</label>
        <button id="btnOpenNow" class="btn btn-success" type="button" onclick="open_allfile()"><i
                    class="icon-folder-open bigger-110"></i> Mở All File
        </button>
        <button id="btnDeleteNow" class="btn btn-danger" type="button" onclick="delete_allfile()"><i
                    class="icon-trash bigger-110"></i> Xóa File
        </button>

    </div>

    <?php Pjax::begin(['id' => 'image_result']); ?>
    <input type="hidden" id="id_dir_pjax" value="<?= $id_dir ?>"/>
    <div class="row" style="margin-top: 10px">
        <?=
        ListView::widget([
            'dataProvider' => $dataProvider,
            'itemView' => '_itemupload',
            'summary' => '',
            'itemOptions' => [
                'tag' => 'li',
                'class' => 'cellimg'
            ],
            'options' => [
                'tag' => 'ul',
                'class' => 'ace-thumbnails',
            ],
            'layout' => "{summary}\n{items}\n<div class='clearfix'></div>{pager}"
        ]);
        ?>
    </div>
    <?php Pjax::end(); ?>

</div>

<script type="text/javascript">
    function open_allfile() {
        var checked_checkboxes = jQuery("input.itemfile:checked");
        if (checked_checkboxes.length) {
            checked_checkboxes.each(function () {
                var value = jQuery(this).val();
                document.getElementById("itemlink_" + value).click();
            });
        } else {
            alert('Bạn chưa chọn file để mở');
        }
    }

    function delete_allfile() {
        var checked_checkboxes = jQuery("input.itemfile:checked");
        if (checked_checkboxes.length) {
            var ids = "";
            checked_checkboxes.each(function () {
                var value = jQuery(this).val();
                if (ids) {
                    ids += ",";
                }
                ids += value;

            });
            if (ids) {
                if (confirm("Bạn muốn xóa các ảnh này?")) {
                    var csrfParam = $('#form-key-csrf').attr('data-key-name');
                    var csrfToken = $('#form-key-csrf').attr('data-key-value');
                    var dataPost = {ids: ids};
                    dataPost[csrfParam] = csrfToken;
                    jQuery.ajax({
                        url: '<?php echo Url::to(['image/deletesimage']) ?>',
                        type: "POST",
                        data: dataPost,
                        dataType: "json",
                        success: function (obj) {
                            if (obj.err === 0) {
                                checked_checkboxes.each(function () {
                                    $(this).parents('li').remove();
                                });
                            } else {
                                alert('Có lỗi xảy ra khi xóa ảnh');
                            }
                        }
                    });
                }
            }
        } else {
            alert('Bạn chưa chọn file để xóa');
        }
    }

    function delete_file(id, element) {
        if (id && element) {
            if (confirm("Bạn muốn xóa ảnh này?")) {
                var csrfParam = $('#form-key-csrf').attr('data-key-name');
                var csrfToken = $('#form-key-csrf').attr('data-key-value');
                //alert('Like comment co id =' + id);
                var dataPost = {id: id};
                dataPost[csrfParam] = csrfToken;

                jQuery.ajax({
                    url: '<?php echo Url::to(['image/deleteimage']) ?>',
                    type: "POST",
                    data: dataPost,
                    dataType: "json",
                    success: function (obj) {
                        if (obj.err === 0) {
                            $(element).parents('li').remove();
                        } else {
                            alert('Có lỗi xảy ra khi xóa ảnh');
                        }
                    }
                });
            }
        }
        return false;
    }

    function createNewImageDir() {
        var name = $('#dirname_new').val();
        var id_parent = $('#id_dir_pjax').val();
        var csrfParam = $('#form-key-csrf').attr('data-key-name');
        var csrfToken = $('#form-key-csrf').attr('data-key-value');
        var dataPost = {name: name, id_parent: id_parent};
        $('#dirname_new').val('');
        dataPost[csrfParam] = csrfToken;
        jQuery.ajax({
            url: '<?php echo Url::to(['image/mkdir']) ?>',
            type: "POST",
            data: dataPost,
            dataType: "json",
            success: function (obj) {
                if (obj.err === 0) {
                    var ref = $('#jstree').jstree(true),
                        sel = ref.get_selected();
                    if (!sel.length) {
                        ref.create_node('#', {id: obj.id, text: obj.name});
                    } else {
                        sel = sel[0];
                        if (sel == 'h0') {
                            ref.create_node('#', {id: obj.id, text: obj.name});
                        } else {
                            sel = ref.create_node(sel, {id: obj.id, text: obj.name});
                        }
                    }
                } else {
                    if (obj.err == 1) {
                        alert('Tên thư mục không được để trống');
                    } else if (obj.err == 2) {
                        alert('Tên thư mục không được quá dài');
                    } else if (obj.err == 3) {
                        alert('Tên thư mục chỉ được có các ký tự a-z A-Z 0-9 CÁCH và _ -');
                    } else {
                        alert('Có lỗi xảy ra khi tạo thư mục');
                    }
                }
            }
        });
    }

    function uploadNow() {
        $('#uploadSatus').html('Đang upload...').addClass('text-sucess');
        $('#btnUploadNow').hide();
    }

    function uploadComplete() {
        // Reset upload form
        $("div.ace-file-input a.remove").trigger("click");
        // Co the goi code goc thay vi trigger click o tren: $("input.file-input").data("ace_file_input").reset_input();

        $.pjax.reload({container: "#image_result", async: false});

        $('#uploadSatus').html('').removeClass('text-sucess');
        $('#btnUploadNow').show();
    }
</script>
