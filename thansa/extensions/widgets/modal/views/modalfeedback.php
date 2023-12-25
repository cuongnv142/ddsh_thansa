<?php

use app\assets\AppAsset;
use yii\helpers\Url;

$this->registerJsFile(Yii::getAlias('@web') . "/js/view/feedback.js", ['depends' => AppAsset::className()]);
?>
<div class="modal fade" id="formTuVan" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="container h-100 p-0">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="may-absolute">
                    <div class="may"></div>
                </div>
                <button type="button" class="close close-btn-form" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">
                        <svg width="14" height="14" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M14 1.41L12.59 0L7 5.59L1.41 0L0 1.41L5.59 7L0 12.59L1.41 14L7 8.41L12.59 14L14 12.59L8.41 7L14 1.41Z"
                                fill="#333333" />
                        </svg>
                    </span>
                </button>
                <div class="modal-body">
                    <div class="row m-0">
                        <div class="col-lg-6 col-12 p-0">
                            <div class="block-form">
                                <h2 class="title"><?= Yii::t('app', 'ĐĂNG KÝ NHẬN'); ?><br /><?= Yii::t('app', 'TƯ VẤN & ƯU ĐÃI MỚI NHẤT'); ?></h2>
                                <form id="feedback-form" class="form-default"  method="post">
                                    <input type="text" maxlength="255" class="form-control" id="feed_name" placeholder="<?= Yii::t('app', 'Họ tên'); ?>"/>
                                    <input type="email" maxlength="255" class="form-control" id="feed_email" placeholder="<?= Yii::t('app', 'Email'); ?>"/>
                                    <input type="tel" maxlength="255" class="form-control" id="feed_phone" placeholder="<?= Yii::t('app', 'Số điện thoại'); ?>"/>
                                    <a href="javascript:void(0)" onclick="submit_feedback()" class="btn-submit"><?= Yii::t('app', 'ĐĂNG KÝ NGAY'); ?></a>
                                </form>
                            </div>
                        </div>
                        <div class="col-lg-6 col-12 p-0 d-none d-lg-block">
                            <div class="block-image">
                                <img src="/template/images/popup-image.png" alt="">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    var url_savefeedback = '<?php echo Url::toRoute('site/subscriber'); ?>';
</script>