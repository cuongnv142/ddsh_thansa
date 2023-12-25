<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Lớp Thực vật */

$this->title = 'Tạo Lớp Thực vật';
$this->params['breadcrumbs'][] = ['label' => 'Lớp Thực vật', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="page-header">
    <h1>
        <?= Html::encode('Lớp Thực vật') ?>
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
