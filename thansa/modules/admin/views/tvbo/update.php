<?php

use yii\helpers\Html;

$this->title = 'Sửa Bộ Thực vật: ' . ' ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Bộ Thực vật', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'Sửa';
?>
<div class="page-header">
    <h1>
<?= Html::encode('Sửa Bộ Thực vật:') ?>
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