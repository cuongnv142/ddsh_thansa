<?php

use yii\helpers\Html;

$this->title = 'Thay đổi mật khẩu';
$this->params['breadcrumbs'][] = ['label' => 'Quản lý User', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="page-header">
    <h1>
        <?= Html::encode('Đổi mật khẩu') ?>
        <?php
        if (Yii::$app->session->hasFlash('changepwadmin')) {
            echo '<small class="red"><i class="icon-bell bigger-110 purple"></i> ' . Yii::$app->session->getFlash("changepwadmin") . '</small>';
        }
        ?>

    </h1>
</div>
<div class="row">
    <div class="col-xs-12">

        <div class="user-create">
            <?=
            $this->render('_form_changepwd', [
                'model' => $model,
            ])
            ?>
        </div>
    </div>
</div>

