<?php

use yii\helpers\Url;
?>
<div id="modal-news" class="modal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="blue bigger">Danh sách tin tức</h4>
            </div>
            <div class="modal-body" style="height: 500px; overflow: auto;">
                <?php
                echo $this->render('_newslist', ['model' => $model]);
                ?>
            </div>
            <div class="modal-footer">
                <button class="btn btn-sm btn-primary" onclick="select_news(); $('#modal-news').modal('hide')">
                    <i class="icon-ok"></i>
                    Chọn
                </button>
                <button id="modal_cancel" class="btn btn-sm" data-dismiss="modal">
                    <i class="icon-remove"></i>
                    Hủy
                </button>
            </div>
        </div>
    </div>
</div>
<?php
$this->registerJs(
        '$("document").ready(function(){ 
            $("#modal-news").on("shown.bs.modal", function () {
                $.pjax.reload({container:"#pjax-news-list",async:false});
             });

            $("#pjax-news-list").on("pjax:success", function() {
                $(".select-on-check-all").on("click", function(e) {
                     select_allnews(this);
                });
                var chek_all=true;
                $(".selection_chk").each(function () {
                    if (!this.checked) {
                        chek_all=false;
                        return false;
                    }
                });
                if(chek_all){
                    $(".select-on-check-all").prop("checked", true);
                }
         });
    });'
);
?>
<script type="text/javascript">
    function select_allnews(el) {
        if (el) {
            var check = el.checked;
            var id = <?= (int) $model->id ?>;
            var ids = '';
            $(".selection_chk").each(function () {
                var id_news = $(this).val();
                if (parseInt(id) && parseInt(id_news) && check != this.checked) {
                    if (ids) {
                        ids += ';';
                    }
                    ids += id_news;

                }
            });
            if (ids) {
                jQuery.ajax({
                    url: '<?php echo Url::to(['tag/addallnews']) ?>',
                    type: "POST",
                    async: false,
                    data: {'id': id, 'news': ids, 'chk': check},
                    dataType: "json",
                    success: function (obj) {
                        if (obj.err === 0) {
                            $.pjax.reload({container: "#pjax-news", async: false});
                        }
                    }
                });
            }
        }
    }
    function select_news(el) {
        if (el) {
            var chk = 0;
            if (el.checked) {
                chk = 1;
            }
            var ids = $(el).val();
            var dataPost = 'news=' + ids + '&id=' + '<?= (int) $model->id ?>&chk=' + chk;
            jQuery.ajax({
                url: '<?php echo Url::to(['tag/addnews']) ?>',
                type: "POST",
                data: dataPost,
                dataType: "json",
                success: function (obj) {
                    if (obj.err === 0) {
                        $.pjax.reload({container: "#pjax-news", async: false});
                    }
                }
            });
        }
    }
    function delete_news(id_news) {
        if (!confirm("Bạn có chắc là sẽ xóa mục này không?")) {
            return false;
        }
        var dataPost = 'id_news=' + id_news + '&id=' + '<?= (int) $model->id ?>';
        jQuery.ajax({
            url: '<?php echo Url::to(['tag/removenews']) ?>',
            type: "POST",
            data: dataPost,
            dataType: "json",
            success: function (obj) {
                if (obj.err === 0) {
                    $.pjax.reload({container: "#pjax-news", async: false});
                }
            }
        });
    }

</script>