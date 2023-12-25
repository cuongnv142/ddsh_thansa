<?php

use app\modules\admin\helpers\AdminHelper;
use app\modules\admin\models\AdminBannerCat;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;

$this->title = 'Danh mục Banner';
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
        <div class="admin-banner-cat-index">
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
                        'attribute' => 'parent_id',
                        'format' => 'text', //raw, html
                        'filter' => ArrayHelper::map(AdminBannerCat::getBannerCatLevel(0, 0, $searchModel->language), 'id', 'name'),
                        'content' => function($data) {
                            return AdminBannerCat::getParentName($data->parent_id);
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
                    AdminHelper::showHideLangList(),
                    [
                        'attribute' => 'status',
                        'format' => 'raw', //raw, html
                        'filter' => AdminHelper::$arrStatus,
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