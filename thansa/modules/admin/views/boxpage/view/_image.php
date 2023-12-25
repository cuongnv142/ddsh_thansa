<?php

use yii\data\ActiveDataProvider;
use yii\helpers\Url;
use yii\widgets\ListView;
use yii\widgets\Pjax;

$dataProvider = new ActiveDataProvider([
    'query' => $boxpageMedia,
    'pagination' => [
        'pageSize' => 30,
    ]
        ]);
?>
<iframe name="up_iframe" src="" style="display:none" border="0"></iframe>
<div class="widget-main">
    <a class="btn btn-primary" onclick="selectMoreFiles();            return false;">Thêm ảnh</a>
    <a class="btn btn-danger" onclick="delete_allfile();            return false;">Xóa ảnh</a>
</div>
<div class="row">
    <div class="col-xs-12">
        <div class="row-fluid">
            <?php
            Pjax::begin([
                'id' => 'pjax-media',
                'timeout' => false,
                'enablePushState' => true,
            ]);
            if ($boxpageMedia && $dataProvider->totalCount > 0) {
                ?>
                <?=
                ListView::widget([
                    'dataProvider' => $dataProvider,
                    'itemView' => '_itemMedia',
                    'summary' => '',
                    'itemOptions' => [
                        'tag' => 'li',
                    ],
                    'options' => [
                        'tag' => 'ul',
                        'class' => 'ace-thumbnails',
                    ],
                ]);
                ?>            
                <?php
            }
            Pjax::end();
            ?>
            <input type="hidden" id="file_deletes" name="file_deletes" value=""/>
            <input type="hidden" id="file_default" name="file_default" value=""/>
        </div>
    </div>
</div>
<hr/>


<script type="text/javascript">
    function delete_allfile() {
        var ids = [];
        $("input[name='delete_image[]']:checked").each(function () {
            ids.push($(this).val());
        });
        ids = ids.join(',');
        if (ids == '') {
            alert('Vui lòng chọn ảnh');
            return false;
        }
        var sure = confirm("Bạn có chắc là muốn xóa các ảnh này?");
        if (!sure)
            return;
        jQuery.ajax({
            url: '<?php echo Url::to(['deleteallimage']) ?>',
            global: false,
            type: "POST",
            data: {'ids': ids, 'boxpage_id': '<?= (int) $model->id ?>'},
            dataType: "json",
            async: false,
            success: function (obj) {
                if (obj.err === 0) {
                    $.pjax.reload({container: "#pjax-media", async: false});
                } else {
                    alert('Có lỗi xảy ra khi xóa ảnh');
                }
            }
        });
    }
    function delete_file(id, element) {
        if (id && element) {
            if (confirm("Bạn muốn xóa ảnh này?")) {
                var dataPost = {pair: id};
                jQuery.ajax({
                    url: '<?php echo Url::to(['boxpage/deleteimage']) ?>',
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

    function selectMoreFiles() {
        bootbox.dialog({
            title: "Up thêm file ảnh",
            message: '<div class="row">  ' +
                    '<div class="col-md-12"> ' +
                    '<form id="frm-images-up" class="form-horizontal" method="post" action="<?= Url::toRoute('boxpage/saveimages') ?>" enctype="multipart/form-data" target="up_iframe"> ' +
                    '<div class="form-group"> ' +
                    '<div class="widget-main">' +
                    '<p class="text-danger">Hướng dẫn: Chỉ nên upload khoảng 5 ảnh mỗi lần!</p>' +
                    '<input multiple="multiple" type="file" name="imagefiles[]" id="file-input-pop" />' +
                    '</div>' +
                    '<input name="boxpage_id" type="hidden" value="<?= $model->id ?>" />' +
                    '</div>' +
                    '</form> </div>  </div>',
            buttons: {
                success: {
                    label: "Upload",
                    className: "btn-success",
                    callback: function () {
                        $('#frm-images-up').submit();
//                        return false;
                    }
                }
            }
        }
        ).on('shown.bs.modal', function () {
            $('#file-input-pop').ace_file_input({
                style: 'well',
                btn_choose: 'Drop files here or click to choose',
                btn_change: null,
                no_icon: 'icon-cloud-upload',
                droppable: true,
                thumbnail: 'small', //large | fit
            });
        });
    }

    function uploadPopComplete() {
        $.pjax.reload({container: "#pjax-media", async: false});
        $("input#file-input-pop").data("ace_file_input").reset_input();
    }

    function edit_image_title(id_pair, e) {
        var title_old = e.getAttribute('data-title-old');
        var dialog = bootbox.dialog({
            title: "Đổi tiêu đề ảnh",
            message: '<div class="row">  ' +
                    '<div class="col-md-12"> ' +
                    '<form class="form-horizontal"> ' +
                    '<div class="form-group"> ' +
                    '<label class="col-md-2 control-label" for="_image_title">Tiêu đề</label> ' +
                    '<div class="col-md-10"> ' +
                    '<input id="_image_title" name="_image_title" type="text" placeholder="Tiêu đề file" class="form-control input-md" value="' + title_old + '"> ' +
                    '</div> ' +
                    '</div>' +
                    '</form> </div>  </div>',
            buttons: {
                success: {
                    label: "Save",
                    className: "btn-success",
                    callback: function () {
                        var title_new = $('#_image_title').val();
                        var dataPost = {'key': id_pair, 'title': title_new};
                        jQuery.ajax({
                            url: '<?php echo Url::to(['boxpage/savepdftitle']) ?>',
                            type: "POST",
                            data: dataPost,
                            dataType: "json",
                            success: function (obj) {
                                if (obj.err === 0) {
                                    alert('Đã cập nhật tiêu đề thành công');
                                    e.setAttribute('data-title-old', title_new);
                                    $('#image-tit-' + id_pair).attr('title', title_new);
                                    $('#image-tit-' + id_pair).html(obj.title_sort);
                                } else {
                                    alert('Có lỗi xảy ra khi lưu tiêu đề');
                                }
                            }
                        });
                    }
                }
            }
        }
        );
        dialog.init(function () {
            setTimeout(function () {
                $('#_image_title').focus();
            }, 1000);
        });
    }
</script>
<style>
    label, .lbl {
        vertical-align: text-bottom;
    }
</style>