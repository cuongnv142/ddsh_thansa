<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\EmailLetter */

$this->title = 'Create Email Letter';
$this->params['breadcrumbs'][] = ['label' => 'Email Letters', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="email-letter-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
