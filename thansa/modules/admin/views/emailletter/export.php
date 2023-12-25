<?php

use app\components\ExcelGrid;

ExcelGrid::widget([
    'dataProvider' => $dataProvider,
    'filterModel' => $searchModel,
    'extension' => 'xlsx',
    'filename' => 'danhsachnhantin',
    'properties' => [
        'title' => 'Danh sách Email đăng ký nhận thông tin',
        'subject' => 'Danh sách Email đăng ký nhận thông tin',
        'category' => 'User',
        'keywords' => '',
        'manager' => '',
        'description' => 'Danh sách Email đăng ký nhận thông tin',
        'company' => 'VCCorp',
    ],
    'columns' => [
        [
            'attribute' => 'email',
        ],
        [
            'attribute' => 'created_at',
            'format' => 'html',
            'value' => function($model) {
                return date('d-m-Y', strtotime($model->created_at));
            }
        ],
    ],
]);
