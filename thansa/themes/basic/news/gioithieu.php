<?php

use app\helpers\CustomizeHelper;

$url_share = CustomizeHelper::createUrlNew($model, [], true);
?>
<div id="content">
    <div class="cover"><img src="/html/images/cover.png" width="1920" height="252" alt=""/></div>

    <div class="tintuc" id="trangchitiet">
        <div class="maincontent">
            <h1><?= $model['name'] ?></h1>
            <p class="time"><i class="icon"></i><?= date('d-m-Y', strtotime($model['created_at'])) ?>   </p>
            <div class="noidungchitiet">
                <?= $model['description'] ?>
            </div><!--end noidungchitiet-->
        </div><!--end maincontent-->
    </div><!--end tintuc-->
</div><!--end content-->
