<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Họ Thực vật */

$this->title = 'Tạo Họ Thực vật';
$this->params['breadcrumbs'][] = ['label' => 'Họ Thực vật', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="page-header">
    <h1>
        <?= Html::encode('Họ Thực vật') ?>
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
