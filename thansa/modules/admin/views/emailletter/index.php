<?php

use app\modules\admin\helpers\AdminHelper;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;

$this->title = 'Đăng ký nhận tin';
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
                <?= Html::a('<i class="icon-download-alt bigger-125"></i>Export', str_replace('index', 'export', Url::current()), ['class' => 'btn btn-info']) ?>
            </p>
            <?=
            GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],
                    'email:email',
//            'status',
                    [
                        'attribute' => 'created_at',
                        'filter' => '<input class="form-control date-range-picker" value="' . $searchModel->created_at . '" type="text" name="AdminEmailLetter[created_at]" data-format="DD/MM/YYYY" />',
                        'format' => 'html',
                        'value' => function($model) {
                            return date('d-m-Y H:i', strtotime($model->created_at));
                        }
                    ],
                    [
                        'class' => 'yii\grid\ActionColumn',
                        'headerOptions' => ['width' => '60'],
                        'contentOptions' => ['style' => 'text-align:center'],
                        'template' => '{delete}',
                    ],
                ],
            ]);
            ?>


        </div>
    </div>
</div>

