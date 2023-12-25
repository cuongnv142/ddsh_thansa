<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\modules\admin\models\AdminBannerCat */

$this->title = 'Thêm danh mục banner';
$this->params['breadcrumbs'][] = ['label' => 'Danh mục banner', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="page-header">
    <h1>
        <?= Html::encode('Danh mục banner') ?>
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
