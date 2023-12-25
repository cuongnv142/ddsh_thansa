<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use app\modules\admin\helpers\AdminHelper;

/* @var $this yii\web\View */
/* @var $model app\models\User */

$this->title = $model->email;
$this->params['breadcrumbs'][] = ['label' => 'Users', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-view">

    <h1><?= Html::encode($this->title) ?></h1>
    <?= AdminHelper::loadSuccessMessage(); ?>

    <p style="float:left;">
        <?= Html::a('<i class="icon-edit bigger-125"></i>Sửa thông tin', ['edit'], ['class' => 'btn btn-info']) ?>
        <?= Html::a('<i class="icon-compass bigger-125"></i>Đổi mật khẩu', ['changepwd'], ['class' => 'btn btn-info']) ?>
    </p>

    <?=
    DetailView::widget([
        'model' => $model,
        'attributes' => [
            'first_name',
            'email:email',
            'phone',
            'gender',
            ['label' => 'Ngày đăng ký', 'value' => ($model->created_at == '0000-00-00 00:00:00') ? null : date('d-m-Y H:i:s', strtotime($model->created_at))],
            ['label' => 'Ngày cập nhật', 'value' => ($model->updated_at == '0000-00-00 00:00:00') ? null : date('d-m-Y H:i:s', strtotime($model->updated_at))],
            ['label' => 'Đăng nhập lần cuối', 'value' => ($model->last_signined_time == '0000-00-00 00:00:00') ? null : date('d-m-Y H:i:s', strtotime($model->last_signined_time))],
            'status',
        ],
    ])
    ?>

</div>
