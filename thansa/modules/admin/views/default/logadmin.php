<?php

use yii\helpers\Html;
use yii\grid\GridView;
use app\modules\admin\helpers\AdminHelper;
use yii\helpers\Url;

$this->title = 'Log Admin';
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
        <div class="form-index">
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
                    ],
                    [
                        'attribute' => 'url',
                        'format' => 'raw',
                        'value' => function($data) {
                            $url = Url::to($data->url);
                            $title = $data->name_object;
                            return Html::a($data->url, $url, ['title' => $title, 'target' => '_blank']);
                        }
                            ],
                            'username',
                            'ip',
                            'module',
                            'controller',
                            'action',
                            [
                                'attribute' => 'created_at',
                                'filter' => '<input class="form-control date-range-picker" value="' . $searchModel->created_at . '" type="text" name="LogActionAdmin[created_at]" data-format="DD/MM/YYYY" />',
                                'format' => 'html',
                                'value' => function($model) {
                                    return date('d-m-Y', strtotime($model->created_at));
                                }
                            ],
                            [
                                'class' => 'yii\grid\ActionColumn',
                                'headerOptions' => ['width' => '60'],
                                'contentOptions' => ['style' => 'text-align:center'],
                                'template' => '{view} {delete}',
                                'urlCreator' => function ($action, $model, $key, $index) {
                            if ($action === 'view') {
                                $url = Url::to(['viewlogadmin', 'id' => $model->id]);
                                return $url;
                            }
                            if ($action === 'delete') {
                                $url = Url::to(['deletelogadmin', 'id' => $model->id]);
                                return $url;
                            }
                        },
                            ],
                        ],
                    ]);
                    ?>
        </div>
    </div>
</div>