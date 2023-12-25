<?php

use yii\helpers\Html;
use yii\helpers\Url;

$this->beginContent('@app/mail/layouts/template_system.php');
?>


<div style="background: rgb(255, 255, 255) none repeat scroll 0% 0%; padding: 20px">
    <div style="width: 100%; margin-top: 25px; font-size: 15px; font-family: arial; color: rgb(68, 68, 68); font-weight: normal; line-height: 25px;">
        Bạn đã sử dụng email này để đăng kí tài khoản trên <?= Yii::$app->params['appName'] ?>. Click vào nút bên dưới để xác thực tài khoản của bạn.
    </div>
    <div style="width: 100%; text-align: center; margin-top: 15px;">
        <a style="width: 206px;text-align: center;font-size: 18px;font-weight: bold;color: #FFF;text-decoration: none;background-color: #d73242;display: inline-block;border-radius:3px;-webkit-border-radius:3px;-moz-border-radius:3px;padding: 12px 0;line-height: 20px" 
           href="<?= Url::toRoute(['site/confirmregister', 'key' => base64_encode($user->token_key)], true) ?>">
            Xác nhận tài khoản
        </a>
    </div>
<!--    <div style="width: 100%; text-align: center; margin-top: 25px; font-family: arial; font-size: 14px; color: rgb(68, 68, 68);">
        Mã xác nhận trong trường hợp được yêu cầu: <font style="color: rgb(251, 76, 47); font-size: 16px; font-weight: bold;"><?php // echo $user->activation_code ?></font>
    </div>-->
    <div style="width: 100%; margin-top: 50px; font-size: 12px; font-family: arial; color: rgb(102, 102, 102); font-style: italic;">
        <font style="color: rgb(215, 50, 66); font-style: normal;">*</font> Nếu bạn không dùng email này để đăng ký tài khoản <?= Yii::$app->params['appName'] ?>, vui lòng bỏ qua email này, hệ thống sẽ hủy 
        yêu cầu sau 24h.
    </div>
</div>
<?php $this->endContent(); ?>