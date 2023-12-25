<?php

use app\modules\admin\helpers\AdminHelper;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;

$this->title = 'Thông tin Site';
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
            <?=
            GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'columns' => [
                    [
                        'class' => 'yii\grid\ActionColumn',
                        'headerOptions' => ['width' => '60'],
                        'contentOptions' => ['style' => 'text-align:center'],
                        'template' => '{update}',
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
                        'attribute' => 'email',
                    ],
                    [
                        'attribute' => 'phone',
                    ],
                    AdminHelper::showHideLangList(),
                ],
            ]);
            ?>

        </div>
    </div>
</div>

