<?php

use app\components\FileUpload;

if ($boxpage) {
    ?>
    <div class="banner-index">
        <!-- Swiper -->
        <div class="swiper mySwiper">
            <div class="swiper-wrapper">
                <?php
                if ($boxpage_media) {
                    foreach ($boxpage_media as $media) {
                        ?>  
                        <div class="swiper-slide">
                            <div class="banner-item">
                                <a title="">
                                    <img class="swiper-lazy" data-src="<?= FileUpload::originalfile($media['path']) ?>" alt="<?= $media['name'] ?>">
                                    <div class="swiper-lazy-preloader"></div>
                                </a>
                            </div>
                        </div>
                        <?php
                    }
                }
                ?>
            </div>
            <div class="swiper-pagination"></div>
        </div>
    </div>    
<?php } ?>