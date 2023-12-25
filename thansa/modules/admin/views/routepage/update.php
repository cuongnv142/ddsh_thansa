<?php

use yii\helpers\Html;

$this->title = 'Sửa';
$this->params['breadcrumbs'][] = ['label' => 'Route Page', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="page-header">
    <h1>
        <?= Html::encode('Sửa Route Page:') ?>
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
                'model'         => $model,
            ])
            ?>

        </div>
    </div>
</div>

