<?php

use app\modules\admin\helpers\AdminHelper;
use app\modules\admin\models\AdminUser;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;

$this->title = 'Quản lý User';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="page-header">
    <h1>
        <?= Html::encode($this->title) ?>
        <small>
            <i class="icon-double-angle-right"></i>
            Danh sách đổi mật khẩu
        </small>
    </h1>
</div>
<div class="row">
    <div class="col-xs-12">
        <?= AdminHelper::loadSuccessMessage(); ?>
        <div class="form-index">
            <?=
            GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'columns' => [
                    [
                        'class' => 'yii\grid\SerialColumn',
                        'header' => 'STT'
                    ],
                    [
                        'attribute' => 'email',
                        'format' => 'raw',
                        'value' => function($data) {
                            $url = Url::to(['update', 'id' => $data->id]);
                            return Html::a($data->email, $url, ['title' => $data->email]);
                        }
                    ],
                    [
                        'attribute' => 'phone',
                        'format' => 'raw',
                        'value' => function($data) {
                            $url = Url::to(['update', 'id' => $data->id]);
                            return Html::a($data->phone, $url, ['title' => $data->phone]);
                        }
                    ],
                    [
                        'attribute' => 'first_name',
                        'format' => 'text',
                    ],
                    [
                        'attribute' => 'status',
                        'format' => 'raw', //raw, html
                        'filter' => AdminUser::$dataStatus,
                        'content' => function($data) {
                            return AdminUser::$dataStatus[$data->status];
                        }
                    ],
                    [
                        'class' => 'yii\grid\ActionColumn',
                        'headerOptions' => ['width' => '60'],
                        'contentOptions' => ['style' => 'text-align:center'],
                        'template' => '{changepwd}',
                        'buttons' => [
                            'changepwd' => function ($url, $model, $key) {
                                return Html::a('<i class="icon-edit bigger-120"></i>', '#activity-modal', [
                                            'class' => 'activity-view-link',
                                            'title' => Yii::t('yii', 'Đổi mật khẩu'),
                                            'data-toggle' => 'modal',
                                            'data-target' => '#activity-modal',
                                            'data-id' => $key,
                                            'data-pjax' => 'false',
                                ]);
                            },
                        ],
                    ],
                ],
            ]);
            ?>
            <?php
            $this->registerJs(
                    'function init_click_handlers(){
                                                $(".activity-view-link").click(function(e) {
                                                          var fID = $(this).closest("tr").data("key");
                                                          $("#id_changepwd").val(fID);
                                                           $("button[type=\'reset\']").trigger("click");
//                                                          $("#activity-modal").modal("show");
                                                      });
                                            }
                                            init_click_handlers(); //first run
                                            $("#some_pjax_id").on("pjax:success", function() {
                                              init_click_handlers(); //reactivate links in grid after pjax update
                                            });
                                             $("#active-form").on("beforeSubmit", function (event, jqXHR, settings) {
                                                var form = $(this);
                                                if (form.find(".has-error").length) {
                                                    return false;
                                                }
                                                form.find(".field-adminuser-new_pass").removeClass("has-error").find(".help-block").html("");
                                                $.ajax({
                                                    url: form.attr("action"),
                                                    type: "post",
                                                    data: form.serialize(),
                                                    dataType: "json",
                                                    async: false,
                                                    success: function (response) {
                                                        if (response.new_pass) {
                                                            form.find(".field-adminuser-new_pass").removeClass("has-success").addClass("has-error").find(".help-block").html(response.new_pass);
                                                        }
                                                         if (response.success) {
                                                            alert("Đổi mật khẩu thành công");
                                                            $("#activity-modal").modal("hide");
                                                        }
                                                    }
                                                });
                                                return false;
                                            });

                                    ');
            ?>
        </div>
    </div>
</div>            
<!-- Modal -->
<div class="modal fade modal_css_login" id="activity-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body">
                <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
                <div class="page-header">
                    <h1>
                        <?php echo Html::encode('Đổi mật khẩu') ?>        
                    </h1>
                </div>
                <div class="row">
                    <div class="col-xs-12">
                        <div class="user-create">
                            <?=
                            $this->render('_form_editpwd', [
                                'model' => $model,
                            ])
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
