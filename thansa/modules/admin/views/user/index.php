<?php

use app\modules\admin\helpers\AdminHelper;
use app\modules\admin\models\AdminUser;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;
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
            Danh sách
        </small>
    </h1>
</div>
<div class="row">
    <div class="col-xs-12">
        <?= AdminHelper::loadSuccessMessage(); ?>
        <div class="form-index">

            <?php
            $gridColumns = [
                [
                    'class' => 'yii\grid\SerialColumn',
                    'header' => 'STT',
                    'headerOptions' => ['width' => '60'],
                ],
                [
                    'attribute' => 'email',
                    'format' => 'raw',
                    'value' => function ($data) {
                        $url = Url::to(['update', 'id' => $data->id]);
                        return Html::a($data->email, $url, ['title' => $data->email]);
                    },
                ],
                [
                    'attribute' => 'phone',
                    'format' => 'raw',
                    'value' => function ($data) {
                        $url = Url::to(['update', 'id' => $data->id]);
                        return Html::a($data->phone, $url, ['title' => $data->phone]);
                    }
                ],
                [
                    'attribute' => 'created_at',
                    'filter' => '<input class="form-control date-range-picker" value="' . $searchModel->created_at . '" type="text" name="AdminUser[created_at]" data-format="DD/MM/YYYY" />',
                    'format' => 'html',
                    'value' => function ($model) {
                        return date('d-m-Y', strtotime($model->created_at));
                    }
                ],
                [
                    'attribute' => 'last_signined_time',
                    'filter' => false,
                    'format' => 'html',
                    'value' => function ($model) {
                        return ($model->last_signined_time) ? date('d-m-Y H:i:s', strtotime($model->last_signined_time)) : '';
                    }
                ],
                [
                    'attribute' => 'status',
                    'format' => 'raw', //raw, html
                    'filter' => AdminUser::$dataStatus,
                    'content' => function ($data) {
                        return AdminUser::$dataStatus[$data->status];
                    }
                ],
                [
                    'attribute' => 'role',
                    'format' => 'raw', //raw, html
                    'filter' => ArrayHelper::map(AdminHelper::getArrRoles(), 'name', 'description'),
                    'content' => function ($data) {
                        return AdminHelper::getRoleName($data->role);
                    },
                    'visible' => AdminUser::is_adminsupper(),
                ],
                [
                    'class' => 'yii\grid\ActionColumn',
                    'headerOptions' => ['width' => '60'],
                    'contentOptions' => ['style' => 'text-align:center'],
                    'template' => '{update} {delete}',
                ],
            ];
            ?>
            <div>
                <?= Html::a('<i class="icon-plus-sign bigger-125"></i>Thêm mới', ['create'], ['class' => 'btn btn-info']) ?>
            </div>

            <?=
            GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'columns' => $gridColumns,
            ]);
            ?>
        </div>
    </div>
</div>
