<?php

use yii\helpers\Html;

$this->title = 'Sửa tin: ' . ' ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Tin tức', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'Sửa';
?>
<div class="page-header">
    <div class="col-sm-12">
        <h1 class="float-left">
            <?= Html::encode('Sửa tin:') ?>
            <small>
                <i class="icon-double-angle-right"></i>
                <?= Html::encode($model->name) ?>
            </small>
        </h1>
    </div>

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