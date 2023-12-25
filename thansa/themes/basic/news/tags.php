<?php

use app\assets\AppAsset;
use app\widgets\breadcrumb\BreadcrumbWidgets;
use app\widgets\news\ListCatWidgets;
use yii\widgets\ListView;

$this->registerJsFile(Yii::getAlias('@web') . "/js/view/news.js", ['depends' => AppAsset::className()]);
?>
<div class="varsnews_main">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <?php
                echo BreadcrumbWidgets::widget();
                ?>
                <div class="varsnews_hot">
                    <div class="varsnews_top">
                        <div class="varsnews_top_title">
                            <?= $model['name'] ?>
                        </div>
                        <div class="varsnews_row">
                            <div class="varsnews_row_left">
                                <?php
                                if ($dataProvider->totalCount > 0) {
                                    echo ListView::widget([
                                        'dataProvider' => $dataProvider,
                                        'itemView' => 'view/_itemnews_row',
                                        'summary' => '',
                                        'layout' => "{items}",
                                        'itemOptions' => [
                                            'class' => 'item',
                                        ],
                                        'options' => [
                                            'class' => 'list-news-wrap',
                                            'id' => 'list-news',
                                        ],
                                    ]);
                                }
                                ?>

                                <?php
                                if ($pagination && $totalpage > 1) {
                                    ?>
                                    <div class="newssecondary_box_btn">
                                        <a href="javascript:void(0)" onclick="showmorenewstag()" lang="<?= $totalpage ?>" tagid="<?= $model['id']; ?>" class="btn btn_newssecondary">
                                            Xem thêm
                                        </a>
                                    </div>
                                <?php }
                                ?>
                            </div>
                            <div class="varsnews_row_right">
                                <?php
                                echo ListCatWidgets::widget();
                                ?>
                                <div class="hot_right_list">
                                    <div class="news_row_title">
                                        Gợi ý sản phẩm cho bạn
                                    </div>
                                    <div class="news_row_right">
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <div class="vars_item">
                                                    <div class="vars_item_img">
                                                        <img src="images/img-9.png" alt="">
                                                        <div class="vars_item_add">
                                                            <span>
                                                                Vali Brother 808-20 màu đen
                                                            </span>
                                                            <button type="submit" class="btn btn_add_sp">
                                                                Chọn
                                                            </button>
                                                        </div>
                                                    </div>
                                                    <a href="#" class="section2_center_txt">
                                                        <span class="price_txt">
                                                            Đèn Led Night Light công nghệ mới
                                                        </span>
                                                        <span class="price_number_df">154.000 <span>đ</span></span>
                                                        <span class="price_number_s">
                                                            535.000 đ
                                                        </span>
                                                    </a>
                                                </div>
                                            </div>
                                            <div class="col-lg-12">
                                                <div class="vars_item">
                                                    <div class="vars_item_img">
                                                        <img src="images/img-9.png" alt="">
                                                        <div class="vars_item_add">
                                                            <span>
                                                                Vali Brother 808-20 màu đen
                                                            </span>
                                                            <button type="submit" class="btn btn_add_sp">
                                                                Chọn
                                                            </button>
                                                        </div>
                                                    </div>
                                                    <a href="#" class="section2_center_txt">
                                                        <span class="price_txt">
                                                            Đèn Led Night Light công nghệ mới
                                                        </span>
                                                        <span class="price_number_df">154.000 <span>đ</span></span>
                                                        <span class="price_number_s">
                                                            535.000 đ
                                                        </span>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
