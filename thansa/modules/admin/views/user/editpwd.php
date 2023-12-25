<?php

use yii\helpers\Html;
$this->title = 'Thay đổi mật khẩu';
$this->params['breadcrumbs'][] = ['label' => 'Quản lý User', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<!--<div class="page-header">
    <h1>
        <?php // echo Html::encode('Đổi mật khẩu') ?>        
    </h1>
</div>-->
<div class="row">
    <div class="col-xs-12">
        <div class="user-create">
            <?=
            $this->render('_form_editpwd', [
                'model' => $model,
            ])
            ?>
        </div>
    </div>
</div>

