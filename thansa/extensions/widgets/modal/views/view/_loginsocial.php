<?php

use yii\authclient\widgets\AuthChoice;
?>

<?php
$authAuthChoice = AuthChoice::begin([
            'baseAuthUrl' => ['site/auth'],
            'options' => [
                'class' => 'auth-clients lovegif_login_mxh',
            ]
        ]);
?>
<?php foreach ($authAuthChoice->getClients() as $client) {
    ?>
    <?php
    if ($client->id == 'google') {
        echo '<div class="login_mxh_item">' . $authAuthChoice->clientLink($client, '<img src="/images/ic-pop2.png" alt="">', ['class' => 'btn-login-gg']) . '</div>';
    }
    if ($client->id == 'facebook') {
        echo '<div class="login_mxh_item">' . $authAuthChoice->clientLink($client, '<img src="/images/ic-pop1.png" alt="">', ['class' => 'btn-login-fb']) . '</div>';
    }
    ?>
<?php } ?>
<?php AuthChoice::end(); ?>
<!--    <div class="login_mxh_item">
        <a href="">
            <img src="/images/ic-pop3.png" alt="">
        </a>
    </div>-->