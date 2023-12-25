<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Bộ động vật */

$this->title = 'Tạo Bộ động vật';
$this->params['breadcrumbs'][] = ['label' => 'Bộ động vật', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="page-header">
    <h1>
        <?= Html::encode('Bộ động vật') ?>
        <small>
            <i class="icon-double-angle-right"></i>
            Thêm mới
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
