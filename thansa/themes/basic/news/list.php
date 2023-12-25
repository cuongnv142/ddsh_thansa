<?php

use app\assets\AppAsset;
use app\components\FileUpload;
use app\helpers\CustomizeHelper;
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
                                <?php if ($data_hot) { ?>
                                    <div class="newssecondary_box">
                                        <div class="row">
                                            <?php
                                            foreach ($data_hot as $key => $item) {
                                                $url = CustomizeHelper::createUrlNew($item);
                                                if ($key == 0) {
                                                    ?>
                                                    <div class="col-lg-12">
                                                        <div class="newssecondary_top">
                                                            <a href="<?= $url ?>" class="newssecondary_top_img">
                                                                <img src="<?= FileUpload::thumb_wmfile(850, $model['image']) ?>" alt="">
                                                            </a>
                                                            <div class="newssecondary_top_body">
                                                                <div class="newssecondary_top_content">
                                                                    <a class="newssecondary_top_title" href="<?= $url ?>">
                                                                        <?= $item['name'] ?>
                                                                    </a>
                                                                    <span class="news_date">
                                                                        <?= date('d/m/Y', strtotime($model['created_at'])) ?>         
                                                                    </span>
                                                                    <div class="newssecondary_top_txt">
                                                                        <?= $item['short_description'] ?>
                                                                    </div>
                                                                    <a href="<?= $url ?>" class="news_links">
                                                                        Tìm hiểu thêm <i class="ic-45"></i>
                                                                    </a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                <?php } else {
                                                    ?>
                                                    <div class="col-md-4">
                                                        <a href="<?= $url ?>" class="section2_body_item">
                                                            <span class="section2_body_item_img">
                                                                <img src="<?= FileUpload::thumb_wmfile(350, $model['image']) ?>" alt="">
                                                            </span>
                                                            <span class="section2_body_item_box">
                                                                <span class="news_hot_title">
                                                                    <?= $item['name'] ?>
                                                                </span>
                                                                <span class="news_date">
                                                                    <?= date('d/m/Y', strtotime($model['created_at'])) ?>            
                                                                </span>
                                                            </span>
                                                        </a>
                                                    </div>
                                                    <?php
                                                }
                                            }
                                            ?>
                                        </div>
                                    </div>
                                <?php } ?>
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
                                        <a href="javascript:void(0)" onclick="showmorenews()" lang="<?= $totalpage ?>" catid="<?= $model['id']; ?>" class="btn btn_newssecondary">
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

<script type="text/javascript">
    var pagecurrent = 1;
</script>


