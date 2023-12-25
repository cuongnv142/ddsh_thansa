<?php

use app\assets\AppAsset;
use app\helpers\CustomizeHelper;
use yii\helpers\Html;
use yii\helpers\Url;

AppAsset::register($this);
$sitecontact = CustomizeHelper::getSiteContact();
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
    <head>
        <meta charset="<?= Yii::$app->charset ?>">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="language" content="vi"/>
        <?php
        if (isset($_SERVER['HTTP_USER_AGENT']) && (strpos($_SERVER['HTTP_USER_AGENT'], 'MSIE') !== false)) {
            header('Cache-Control: max-age=86400');
            header('X-UA-Compatible: IE=edge,chrome=1');
        }
        ?>
        <meta name="copyright" content="<?= Url::base(true) ?>"/>
        <meta http-equiv="audience" content="General"/>
        <meta name="resource-type" content="Document"/>
        <meta name="distribution" content="Global"/>
        <meta name="revisit-after" content="1 days"/>
        <meta name="GENERATOR" content="<?= Url::base(true) ?>"/>
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"/>
        <meta property="og:site_name" content="<?= Url::base(true) ?>"/>
        <meta property="og:type" content="website"/>
        <meta property="og:locale" content="vi_VN"/>
        <?= Html::csrfMetaTags() ?>
        <link rel="shortcut icon" href="<?= Url::base(true); ?>/favicon.ico?v=1.1" type="image/x-icon"/>
        <?php echo (isset($this->blocks['info_facebook'])) ? $this->blocks['info_facebook'] : '' ?>
        <?php echo (isset($this->blocks['meta_index_follow'])) ? $this->blocks['meta_index_follow'] : '<meta name="robots" content="index, follow">' ?>
        <title><?= Html::encode($this->title) ?></title>
        <?php $this->head() ?>
        <script>
            var is_login = 0;
            var url_home = '<?php echo Url::base(true); ?>';
            var url_register_feedback = '<?= Url::toRoute('/site/feedback') ?>';
            var url_morenews = '<?php echo Url::toRoute('news/showmore'); ?>';
            var url_morenewstag = '<?php echo Url::toRoute('news/showmoretag'); ?>';
            var alert_email_success = '<?php echo Yii::t('app', 'Bạn đã đăng ký nhận bản tin thành công!'); ?>';
            var alert_send_contact_success = '<?php echo Yii::t('app', 'Bạn đã gửi thông tin thành công!'); ?>';
            var alert_email_null = '<?php echo Yii::t('app', 'Vui lòng nhập Email!'); ?>';
            var alert_email_fail = '<?php echo Yii::t('app', 'Vui lòng nhập email hợp lệ!'); ?>';
            var alert_email_err = '<?php echo Yii::t('app', 'Có lỗi khi lưu dữ liệu!'); ?>';
            var alert_name_null = '<?php echo Yii::t('app', 'Vui lòng nhập Họ tên!'); ?>';
            var alert_phone_null = '<?php echo Yii::t('app', 'Vui lòng nhập số điện thoại!'); ?>';
            var alert_phone_fail = '<?php echo Yii::t('app', 'Số điện thoại không đúng!'); ?>';
             var alert_thongbao = '<?php echo Yii::t('app', 'Thông báo'); ?>';

        </script>
        <?php
        if (YII_ENV == 'prod') {
            if (isset($sitecontact['embed_script_head'])) {
                echo $sitecontact['embed_script_head'];
            }
        }
        ?>

    </head>
    <body class="body_<?= Yii::$app->language ?>">
        <?php
        if (YII_ENV == 'prod') {
            if (isset($sitecontact['embed_script_body_begin'])) {
                echo $sitecontact['embed_script_body_begin'];
            }
        }
        ?>
        <?php $this->beginBody() ?>
        <?= $content ?>
        <?php $this->endBody() ?>
        <?php
        if (YII_ENV == 'prod') {
            if (isset($sitecontact['embed_script_body_end'])) {
                echo $sitecontact['embed_script_body_end'];
            }
        }
        ?>
        <div id="fb-root"></div>
        <script async defer crossorigin="anonymous" src="https://connect.facebook.net/vi_VN/sdk.js#xfbml=1&version=v9.0&appId=364039924275618&autoLogAppEvents=1" nonce="Sj5KHr66"></script>
        <script src="https://sp.zalo.me/plugins/sdk.js"></script>
    </body>
</html>
<?php $this->endPage() ?>
