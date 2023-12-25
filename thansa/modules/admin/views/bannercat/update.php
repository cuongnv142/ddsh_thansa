<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\admin\models\AdminBannerCat */

$this->title = 'Sửa danh mục';
$this->params['breadcrumbs'][] = ['label' =>'Danh mục banner', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'Sửa';
?>
<div class="page-header">
    <h1>
        <?= Html::encode('Sửa danh mục banner:') ?>
        <small>
            <i class="icon-double-angle-right"></i>
            <?= Html::encode($model->name) ?>
        </small>
    </h1>
</div>
<div class="row">
    <div class="col-xs-12">
<div class="admin-banner-cat-update">
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
    </div>
</div>
