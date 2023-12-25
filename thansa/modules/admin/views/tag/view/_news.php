<?php

use app\components\FileUpload;
use app\modules\admin\helpers\AdminHelper;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\widgets\Pjax;
?>
<?php
Pjax::begin([
    'id' => 'pjax-news',
    'timeout' => false,
    'enablePushState' => false,
]);
?>
<div class="row">
    <div class="col-xs-12">
        <div class="form-index">
            <p>
                <?= Html::a('<i class="icon-plus-sign bigger-125"></i>Chọn tin tức', "#modal-news", ["data-toggle" => "modal", 'class' => 'btn btn-info']) ?>
            </p>
            <?=
            GridView::widget([
                'dataProvider' => $data_news,
                'options' => [
                    'id' => 'news'
                ],
                'columns' => [
                    [
                        'class' => 'yii\grid\SerialColumn',
                        'header' => 'STT'
                    ],
                    [
                        'attribute' => 'image',
                        'filter' => false,
                        'format' => 'raw',
                        'value' => function($data) {
                            return Html::img(FileUpload::thumb_wmfile(200, $data->image), ['width' => 60]);
                        },
                    ],
                    [
                        'attribute' => 'name',
                        'format' => 'raw',
                    ],
                    [
                        'attribute' => 'status',
                        'format' => 'raw', //raw, html
                        'filter' => AdminHelper::$arrStatus,
                        'content' => function($data) {
                            return AdminHelper::$arrStatus[(int) $data->status];
                        }
                    ],
                    [
                        'class' => 'yii\grid\ActionColumn',
                        'headerOptions' => ['width' => '60'],
                        'contentOptions' => ['style' => 'text-align:center'],
                        'template' => '{mydelete}',
                        'buttons' => [
                            'mydelete' => function ($url, $model, $key) {
                                return Html::a('<span class="glyphicon glyphicon-trash"></span>', 'javascript:void(0);', [
                                            'title' => Yii::t('yii', 'Delete'),
                                            'onclick' => 'delete_news(' . $model->id . ')',
                                            'data-pjax' => '0',
                                ]);
                            }
                        ]
                    ],
                ],
            ]);
            ?>

        </div>
    </div>
</div>
<?php Pjax::end(); ?>
              