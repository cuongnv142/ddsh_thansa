<?php

use app\components\FileUpload;
use app\modules\admin\helpers\AdminHelper;
use app\modules\admin\models\AdminRoutePage;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;

$this->title = 'Seo Page';
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
                        'label' => 'Ảnh Face',
                        'attribute' => 'face_image',
                        'filter' => false,
                        'format' => 'raw',
                        'value' => function($data) {
                            return Html::img(FileUpload::thumb_wmfile(60, $data->face_image));
                        },
                        'headerOptions' => ['width' => '80'],
                    ],
                    [
                        'attribute' => 'route_id',
                        'format' => 'raw',
                        'filter' => ArrayHelper::map(AdminRoutePage::find()->orderBy('name')->all(), 'id', 'name'),
                        'value' => function($data) {
                            $url = Url::to(['update', 'id' => $data->id]);
                            $name = AdminRoutePage::getName($data->route_id);
                            return Html::a($name, $url, ['title' => $name]);
                        }
                    ],
                    [
                        'attribute' => 'page_title',
                    ],
                    [
                        'attribute' => 'page_keywords',
                    ],
                    AdminHelper::showHideLangList(),
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