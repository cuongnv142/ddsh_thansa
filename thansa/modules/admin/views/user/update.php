<?php

use yii\helpers\Html;
$this->title = 'Sửa user';
$this->params['breadcrumbs'][] = ['label' => 'Quản lý User', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="page-header">
    <h1>
        <?= Html::encode('Quản lý User') ?>        
    </h1>
</div>
<div class="row">
    <div class="col-xs-12">
        <div class="user-create">
            <?=
            $this->render('_form_update', [
                'model' => $model,
            ])
            ?>
        </div>
    </div>
</div>

