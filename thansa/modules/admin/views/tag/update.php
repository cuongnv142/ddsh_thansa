<?php

use yii\helpers\Html;
use app\modules\admin\models\AdminSeoPage;

$this->title = 'Sửa';
$this->params['breadcrumbs'][] = ['label' => 'Tag', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="page-header">
    <h1>
        <?= Html::encode('Sửa Tag:') ?>
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
                'model'         => $model,
                'data_news'     =>  $data_news
            ])
            ?>

        </div>
    </div>
</div>

