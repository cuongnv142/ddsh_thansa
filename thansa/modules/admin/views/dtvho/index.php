<?php

use app\modules\admin\helpers\AdminHelper;
use app\modules\admin\models\AdminDtvBo;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;

$this->title = 'Họ động vật';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="page-header">
    <h1>
        <?= Html::encode($this->title) ?>
        <small>
            <i class="icon-double-angle-right"></i>
            Danh sách
        </small>
    </h1>
</div>
<div class="row">
    <div class="col-xs-12">
        <?= AdminHelper::loadSuccessMessage(); ?>
        <div class="cat-re-index">
            <p>
                <?= Html::a('<i class="icon-plus-sign bigger-125"></i>Thêm mới', ['create'], ['class' => 'btn btn-info']) ?>
            </p>
            <?=
            GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'columns' => [
                    [
                        'class' => 'yii\grid\SerialColumn',
                        'header' => 'STT',
                        'headerOptions' => ['width' => '60'],
                    ],
                    [
                        'attribute' => 'name',
                        'format' => 'raw',
                        'value' => function($data) {
                            $url = Url::to(['update', 'id' => $data->id]);
                            return Html::a($data->name, $url, ['title' => $data->name]);
                        }
                    ],
                    [
                        'attribute' => 'name_latinh',
                        'format' => 'raw',
                    ],
                    [
                        'attribute' => 'id_dtv_bo',
                        'format' => 'raw',
                        'filter' => ArrayHelper::map(AdminDtvBo::find()->where(['loai' => $searchModel->loai])->orderBy('name')->all(), 'id', 'name'),
                        'value' => function($data) {
                            return AdminDtvBo::getParentName($data->id_dtv_bo);
                        }
                    ],
                    [
                        'attribute' => 'updated_at',
                        'filter' => false,
                        'label' => 'Ngày cập nhật',
                        'format' => 'html',
                        'value' => function($model) {
                            return date('d-m-Y', strtotime($model->updated_at));
                        },
                        'headerOptions' => ['width' => '120'],
                    ],
                    [
                        'attribute' => 'status',
                        'format' => 'raw', //raw, html
                        'filter' => AdminHelper::$arrStatus,
                        'headerOptions' => ['width' => '100'],
                        'content' => function($data) {
                            return Html::activeCheckbox($data, 'status', ['class' => 'ace ace-switch ace-switch-4', 'label' => '<span class="lbl"></span>', 'onclick' => 'setstatus(this)', 'lang' => $data->id]);
                        }
                    ],
                    [
                        'class' => 'yii\grid\ActionColumn',
                        'headerOptions' => ['width' => '60'],
                        'contentOptions' => ['style' => 'text-align:center'],
                        'template' => '{update} {delete}',
                        'buttons' => [],
                    ],
                ],
            ]);
            ?>

        </div>
    </div>
</div>
<?php
$this->registerJs(
        '$("document").ready(function(){ 
                 $(".apartment_text").blur(function() {
                     var id=$(this).attr("data-id");
                     var order=$(this).val();
                     var $apartment_text=$(this);
                     jQuery.ajax({
                             url: "' . Url::to(['savesortorder']) . '",
                             global: false,
                             type: "POST",
                             data: {"id": id, "order": order},
                             dataType: "json",
                             async: false,
                             success: function (data) {
                                 if (data.action == "success") {
                                    $apartment_text.removeClass("focus");
                                 } else if (data.action == "error") {
                                     alert(data.content);
                                 }
                             }
                         });
                     });
                  $(".apartment_text").keydown(function (e) {
                     if (e.keyCode == 13) {
                         var id=$(this).attr("data-id");
                         var order=$(this).val();
                         var $apartment_text=$(this);
                         jQuery.ajax({
                                 url: "' . Url::to(['savesortorder']) . '",
                                 global: false,
                                 type: "POST",
                                 data: {"id": id, "order": order},
                                 dataType: "json",
                                 async: false,
                                 success: function (data) {
                                     if (data.action == "success") {
                                        $apartment_text.removeClass("focus");
                                     } else if (data.action == "error") {
                                         alert(data.content);
                                     }
                                 }
                             });
                     }else{
                         $(this).addClass("focus");
                     }
                 });
             });'
);
?>
<script type="text/javascript">
    function setstatus(vthis) {
        var status = 0;
        var id = jQuery(vthis).attr('lang');
        if ($(vthis).is(':checked')) {
            status = 1;
        } else {
            status = 0;
        }
        if (id) {
            setstatusAjax(status, id, vthis);
        }
    }

    function setstatusAjax(status, id, vthis) {
        jQuery.ajax({
            url: '<?php echo Url::to(['setstatus']) ?>',
            global: false,
            type: "POST",
            data: {'status': status, 'id': id},
            dataType: "json",
            async: false,
            success: function (data) {
                if (data.action == "success") {
                } else if (data.action == "error") {
                    if (data.content) {
                        if (status) {
                            $(vthis).prop('checked', false);
                        } else {
                            $(vthis).prop('checked', true);

                        }
                        alert(data.content);
                    }
                }
            }
        });
    }
</script>
