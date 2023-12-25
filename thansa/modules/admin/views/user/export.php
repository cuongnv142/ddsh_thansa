<?php

use app\components\ExcelGrid;
use app\models\CitiesDistrict;
use app\modules\admin\helpers\AdminHelper;
use app\modules\admin\models\AdminUser;

ExcelGrid::widget([
    'dataProvider' => $dataProvider,
    'filterModel' => $searchModel,
    'extension' => 'xlsx',
    'filename' => 'danhsachnguoidung',
    'properties' => [
        'title' => 'Danh sach khach hang dang ky',
        'subject' => 'Danh sach khach hang dang ky',
        'category' => 'User',
        'keywords' => '',
        'manager' => '',
        'description' => 'Danh sach khach hang dang ky',
        'company' => 'VCCorp',
    ],
    'columns' => [
        [
            'attribute' => 'email',
            'format' => 'raw',
            'value' => function($data) {
                return $data->email;
            },
        ],
        [
            'attribute' => 'phone',
            'format' => 'raw',
            'value' => function($data) {
                return $data->phone;
            }
        ],
        [
            'attribute' => 'id_city',
            'format' => 'text',
            'content' => function($data) {
                return CitiesDistrict::getNameById($data->id_city);
            }
        ],
        [
            'attribute' => 'created_at',
            'format' => 'html',
            'value' => function($model) {
                return date('d-m-Y', strtotime($model->created_at));
            }
        ],
        [
            'attribute' => 'updated_at',
            'label' => 'Ngày cập nhật',
            'format' => 'html',
            'value' => function($model) {
                return date('d-m-Y', strtotime($model->updated_at));
            },
        ],
        [
            'attribute' => 'status',
            'format' => 'raw', //raw, html
            'content' => function($data) {
                return AdminUser::$dataStatus[$data->status];
            }
        ],
    ],
]);
