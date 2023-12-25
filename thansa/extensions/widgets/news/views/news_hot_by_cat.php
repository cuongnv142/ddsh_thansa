<?php

use app\components\FileUpload;
use app\helpers\CustomizeHelper;

if ($data) {
    ?>
    <div class="privacy-selling-slide">
        <div class="title-page">
            <div class="container">
                <h2 class="title-component text-center">
                    <?= Yii::t('app', 'CHÍNH SÁCH BÁN HÀNG'); ?>
                </h2>
            </div>
        </div>
        <div class="privacy-slides">
            <div class="row m-0">
                <div class="col-xl-6 col-12 p-0 d-none d-xl-block">
                    <div class="image-getsrc">
                        <a href="" title="">
                            <img src="" alt="">
                        </a>
                    </div>
                </div>
                <div class="col-12 col-xl-6 d-flex flex-column-reverse flex-xl-column p-0">
                    <div class="gallery-subtitle">
                        <!-- Swiper -->
                        <div class="swiper mySwiper overflow-hidden">
                            <div class="swiper-wrapper">
                                <?php
                                foreach ($data as $model) {
                                    $url = CustomizeHelper::createUrlNew($model);
                                    ?>
                                    <div class="swiper-slide">
                                        <div class="box-subtitle">
                                            <h2 class="title"><?= $model['name'] ?></h2>
                                            <div class="sub"><?= nl2br($model['short_description']) ?></div>
                                            <a href="<?= $url ?>" title="" class="links-detail">
                                                <span><?= Yii::t('app', 'Xem chi tiết'); ?></span>
                                                <span>
                                                    <svg width="19" height="8" viewBox="0 0 19 8" fill="none"
                                                         xmlns="http://www.w3.org/2000/svg">
                                                        <path d="M19 4L15 0V3H0V5H15V8L19 4Z" fill="#0E495C" />
                                                    </svg>
                                                </span>
                                            </a>
                                        </div>
                                    </div>                                    
                                    <?php
                                }
                                ?>
                            </div>
                            <div class="navinate">
                                <div class="swiper-button-prev"></div>
                                <div class="swiper-button-next"></div>
                            </div>
                        </div>
                    </div>
                    <div class="gallery-images">
                        <!-- Swiper -->
                        <div class="swiper mySwiper overflow-hidden">
                            <div class="swiper-wrapper">
                                <?php
                                foreach ($data as $model) {
                                    $url = CustomizeHelper::createUrlNew($model);
                                    ?>
                                    <div class="swiper-slide">
                                        <div class="gallery-item">
                                            <div class="gallery-image">
                                                <a href="<?= $url ?>" title="">
                                                    <img src="<?= FileUpload::thumb_wmfile(850, $model['image']) ?>" alt="">
                                                </a>
                                            </div>
                                            <a href="<?= $url ?>" title="" class="gallery-title">
                                                <?= $model['name'] ?>
                                            </a>
                                        </div>
                                    </div>
                                    <?php
                                }
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

<?php } ?>