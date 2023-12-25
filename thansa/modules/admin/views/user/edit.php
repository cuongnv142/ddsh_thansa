<?php

use yii\helpers\Html;
$this->title = 'Sửa User';
$this->params['breadcrumbs'][] = ['label' => 'Thông tin tài khoản', 'url' => ['view']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="page-header">
    <h1>
        <?= Html::encode('Sửa thông tin User') ?>        
    </h1>
</div>
<div class="row">
    <div class="col-xs-12">
        <div class="user-create">
            <?=
            $this->render('_form_edit', [
                'model' => $model,
            ])
            ?>
        </div>
    </div>
</div>

