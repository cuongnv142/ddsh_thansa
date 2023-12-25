<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\LogSubscribeError */

$this->title = 'Create Log Subscribe Error';
$this->params['breadcrumbs'][] = ['label' => 'Log Subscribe Errors', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="log-subscribe-error-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
