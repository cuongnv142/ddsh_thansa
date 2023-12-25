<?php

use yii\helpers\Html;

$this->title = 'Cập nhật Danh mục tin tức: ' . ' ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Danh mục tin tức', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'Cập nhật';
?>
<div class="page-header">
    <h1>
        <?= Html::encode('Sửa Danh mục tin tức:') ?>
        <small>
            <i class="icon-double-angle-right"></i>
            <?= Html::encode($model->name) ?>
        </small>
    </h1>
</div>
<div class="row">
    <div class="col-xs-12">
        <div class="cat-re-create">
            <?=
            $this->render('_form', [
                'model' => $model,
            ])
            ?>

        </div>
    </div>
</div>
