<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\admin\models\AdminLogSubscribeError */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Danh sách đăng ký lỗi';
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
        <?= \app\modules\admin\helpers\AdminHelper::loadSuccessMessage(); ?>
    </div>
    <div class="col-xs-12">
        <div class="cta-index">
            <p>
                <?= Html::a('<i class="icon-plus-sign bigger-125"></i>Thêm mới', ['create'], ['class' => 'btn btn-info']) ?>
            </p>
            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],

                    [
                        'attribute' => 'ip',
                        'format' => 'raw',
                        'value' => function ($data) {
                            return $data->ip;
                        }
                    ],
                    [
                        'attribute' => 'error_code',
                        'format' => 'raw', //raw, html
                        'filter' => \app\models\LogSubscribeError::getStatusErrors(),
                        'content' => function ($data) {
                            $errorCode = \app\models\LogSubscribeError::getStatusErrors();
                            return isset($errorCode[$data->error_code]) ? $errorCode[$data->error_code] : $data->error_code;
                        }
                    ],
                    [
                        'attribute' => 'err_message',
                        'format' => 'raw', //raw, html
                        'headerOptions' => [
                            'style' => 'width:20%'
                        ],
                        'content' => function ($data) {
                            return $data->err_message;
                        }
                    ],
                    [
                        'attribute' => 'content',
                        'format' => 'raw', //raw, html
                        'headerOptions' => [
                            'style' => 'width:50%'
                        ],
                        'content' => function ($data) {
                            return $data->content;
                        }
                    ],
                    [
                        'attribute' => 'created_at',
                        'format' => 'raw', //raw, html
                        'filter' => false,
                        'content' => function ($data) {
                            return ($data->created_at) ? date('d-m-Y H:i:s', strtotime($data->created_at)) : '';
                        }
                    ]
                ],
            ]); ?>
        </div>
    </div>
</div>
