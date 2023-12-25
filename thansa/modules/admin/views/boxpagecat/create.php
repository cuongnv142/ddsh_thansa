<?php

use yii\helpers\Html;



$this->title = 'Thêm danh mục';
$this->params['breadcrumbs'][] = ['label' => 'Danh mục', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="page-header">
    <h1>
        <?= Html::encode('Danh mục') ?>
        <small>
            <i class="icon-double-angle-right"></i>
            Thêm mới
        </small>
    </h1>
</div>
<div class="row">
    <div class="col-xs-12">

<div class="admin-banner-cat-create">
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
    </div>
</div>
