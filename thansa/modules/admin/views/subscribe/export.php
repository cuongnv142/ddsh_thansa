<?php

use app\components\ExcelGrid;

$title = 'dang-ky-lien-he';

$columns = [];
$columns[] = ['attribute' => 'name'];
$columns[] = ['attribute' => 'email'];
$columns[] = ['attribute' => 'phone',];
$columns[] = ['attribute' => 'note',];

$columns[] = [
    'attribute' => 'created_at',
    'format' => 'html',
    'value' => function ($model) {
        return date('d-m-Y H:i:s', strtotime($model->created_at));
    }
];

ExcelGrid::widget([
    'dataProvider' => $dataProvider,
    'filterModel' => $searchModel,
    'extension' => 'xlsx',
    'filename' => $title . date('dmYHis'),
    'properties' => [
        'title' => 'Danh sách khách gửi thông tin liên hệ',
        'subject' => 'Danh sách liên hệ',
        'category' => 'User',
        'keywords' => '',
        'manager' => '',
        'description' => 'Danh sách khách gửi thông tin liên hệ',
        'company' => 'VCCorp',
    ],
    'columns' => $columns
]);
