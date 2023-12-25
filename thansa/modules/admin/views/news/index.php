<?php

use app\components\FileUpload;
use app\modules\admin\helpers\AdminHelper;
use app\modules\admin\models\AdminNewsCat;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;

$this->title = 'Tin tức';
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
        <div class="news-index">
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
                        'attribute' => 'image',
                        'filter' => false,
                        'format' => 'raw',
                        'value' => function ($data) {
                            return Html::img(FileUpload::thumb_wmfile(200, $data->image), ['width' => 60]);
                        },
                        'headerOptions' => ['width' => '80'],
                    ],
                    [
                        'attribute' => 'name',
                        'format' => 'raw',
                        'value' => function ($data) {
                            $url = Url::to(['update', 'id' => $data->id]);
                            return Html::a($data->name, $url, ['title' => $data->name]);
                        }
                    ],
                    [
                        'attribute' => 'news_cat_id',
                        'filter' => ArrayHelper::map(AdminNewsCat::getNewsCatLevel(0, 0, $searchModel->language), 'id', 'name'),
                        'format' => 'raw',
                        'value' => function ($data) {
                            return AdminNewsCat::getParentName($data->news_cat_id);
                        },
                    ],
                    [
                        'attribute' => 'is_hot',
                        'format' => 'raw', //raw, html
                        'filter' => AdminHelper::$arrIsHot,
                        'content' => function ($data) {
                            return Html::activeCheckbox($data, 'is_hot', ['class' => 'ace ace-switch ace-switch-4', 'label' => '<span class="lbl"></span>', 'onclick' => 'setis_hot(this)', 'lang' => $data->id]);
                        }
                    ],
                    [
                        'attribute' => 'status',
                        'format' => 'raw', //raw, html
                        'filter' => AdminHelper::$arrStatus,
                        'content' => function ($data) {
                            return Html::activeCheckbox($data, 'status', ['class' => 'ace ace-switch ace-switch-4', 'label' => '<span class="lbl"></span>', 'onclick' => 'setstatus(this)', 'lang' => $data->id]);
                        }
                    ],
                    AdminHelper::showHideLangList(),
                    [
                        'class' => 'yii\grid\ActionColumn',
                        'headerOptions' => ['width' => '60'],
                        'contentOptions' => ['style' => 'text-align:center'],
                        'template' => '{update} &nbsp; {delete}',
                    ],
                ],
            ]);
            ?>

        </div>
    </div>
</div>
<script type="text/javascript">
    function setis_hot(vthis) {
        var is_hot = 0;
        var id = jQuery(vthis).attr('lang');
        if ($(vthis).is(':checked')) {
            is_hot = 1;
        } else {
            is_hot = 0;
        }
        if (id) {
            setis_hotAjax(is_hot, id, vthis);
        }
    }

    function setis_hotAjax(is_hot, id, vthis) {
        jQuery.ajax({
            url: '<?php echo Url::to(['setis_hot']) ?>',
            global: false,
            type: "POST",
            data: {'is_hot': is_hot, 'id': id},
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
