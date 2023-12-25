<?php

use yii\helpers\Html;
use yii\grid\GridView;
use app\modules\admin\helpers\AdminHelper;
use yii\helpers\Url;

$this->title = 'Route Pages';
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
                        'header' => 'STT'
                    ],
                    [
                        'attribute' => 'route',
//                        'format' => 'raw',
//                        'value' => function($data) {
//                            $url = Url::to(['update', 'id' => $data->id]);
//                            return Html::a($data->route, $url, ['title' => $data->route]);
//                        }
                    ],
                    [
                        'attribute' => 'name',
//                        'format' => 'raw',
//                        'value' => function($data) {
//                            $url = Url::to(['update', 'id' => $data->id]);
//                            return Html::a($data->name, $url, ['title' => $data->name]);
//                        }
                    ],
                    [
                        'class' => 'yii\grid\ActionColumn',
                        'headerOptions' => ['width' => '60'],
                        'contentOptions' => ['style' => 'text-align:center'],
                        'template' => '{update} {delete}',
                    ],
                ],
            ]);
            ?>

        </div>
    </div>
</div>

