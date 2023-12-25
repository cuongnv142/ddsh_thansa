<?php
use yii\helpers\Html;

$this->beginContent('@app/mail/layouts/template_system.php');
?>

<div style="background: rgb(255, 255, 255) none repeat scroll 0% 0%; padding: 20px;">
    <div style="width: 100%; margin-top: 25px; font-size: 15px; font-family: arial; color: rgb(68, 68, 68); font-weight: normal; line-height: 25px; margin-bottom: 100px;">
        Cám ơn bạn đã tin tưởng và tạo tài khoản trên <?= Yii::$app->params['appName'] ?>.<br>
        Ngay từ bây giờ bạn đã có thể sử dụng các tính năng tương tác của website
    </div>

</div>
<?php $this->endContent(); ?>