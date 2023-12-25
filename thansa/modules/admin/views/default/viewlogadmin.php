<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use app\modules\admin\helpers\AdminHelper;

header('Content-type: application/json');
$this->title = 'Chi tiết Log Admin';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-view">
    <h1><?= Html::encode($this->title) ?></h1>
    <?=
    DetailView::widget([
        'model' => $model,
        'attributes' => [
            'url:url',
            'user_id',
            'username',
            'ip',
            'module',
            'controller',
            'action',
            'id_object',
            'name_object',
            ['label' => 'Ngày tạo', 'value' => ($model->created_at == '0000-00-00 00:00:00') ? null : date('d-m-Y H:i:s', strtotime($model->created_at))],
//            ['label' => 'DL đầu vào', 'value' => ($model->befor_data) ? AdminHelper::displayJsonTable($model->befor_data) : '', 'format' => 'raw'],
//            ['label' => 'DL đầu ra', 'value' => ($model->after_data) ? AdminHelper::displayJsonTable($model->after_data) : '', 'format' => 'raw'],
            ['label' => 'DL', 'value' => AdminHelper::displayJsonFromToTable($model->befor_data, $model->after_data), 'format' => 'raw'],
        ],
    ])
    ?>

</div>
