<?php

use app\components\FileUpload;
use app\helpers\CustomizeHelper;
use app\widgets\breadcrumb\BreadcrumbWidgets;
use app\widgets\news\ListCatWidgets;

$url_share = CustomizeHelper::createUrlNew($model, [], true);
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
                        <div class="varsnews_row">
                            <div class="varsnews_row_left">
                                <div class="newssecondary_box">
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="newssecondary_content">
                                                <h3 class="newssecondary_content_title">
                                                    <?= $model['name'] ?>
                                                </h3>
                                                <span class="news_date">
                                                    <?= date('d/m/Y', strtotime($model['created_at'])) ?>   
                                                </span>
                                                <div class="newssecondary_content_txt">
                                                    <?= $model['description'] ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="newssecondary_bdip">
                                    <div class="newssecondary_tag">

                                        <div class="newssecondary_tag_left">
                                            <?php
                                            if ($tags) {
                                                $html = '';
                                                foreach ($tags as $tag) {
                                                    if ($html) {
                                                        $html .= ', ';
                                                    }
                                                    $html .= '<a href="' . CustomizeHelper::createUrlNewsTag($tag) . '">#' . $tag['name'] . '</a>';
                                                }
                                                if ($html) {
                                                    echo $html;
                                                }
                                            }
                                            ?>
                                        </div>
                                        <div class="newssecondary_tag_right">
                                            <span>
                                                Chia sẻ bài viết
                                            </span>
                                            <a href="https://www.facebook.com/sharer/sharer.php?u=<?= $url_share ?>" target="_blank" onclick="javascript:window.open(this.href, '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=300,width=600');
                                                    return false;"><img src="/images/ic-79.png" alt="" /></a>
                                            <a href="https://www.instagram.com/?url=<?= $url_share ?>" target="_blank" onclick="javascript:window.open(this.href, '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=300,width=600');
                                                return false;"><img src="/images/ic-insta.png" alt="" width="25px" height="25px" /></a>
                                            <a href="https://twitter.com/intent/tweet?url=<?= $url_share ?>" target="_blank" onclick="javascript:window.open(this.href, '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=300,width=600');
                                                    return false;"><img src="/images/ic-81.png" alt="" /></a>
                                        </div>
                                        <div class="clearfix"></div>
                                    </div>
                                    <div class="comment__facebook">
                                        <div class="fb-comments" data-href="<?= $url_share ?>" data-width="100%" data-numposts="5"></div>
                                    </div>
                                </div>
                                <?php if ($datarelated) { ?>
                                    <div class="newssecondary_category">
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <h5 class="newssecondary_category_title">
                                                    TIN CÙNG CHUYÊN MỤC
                                                </h5>
                                            </div>
                                            <?php
                                            foreach ($datarelated as $item) {
                                                $url = CustomizeHelper::createUrlNew($item);
                                                ?>
                                                <div class="col-md-4">
                                                    <a href="<?= $url ?>" class="section2_body_item">
                                                        <span class="section2_body_item_img">
                                                            <img src="<?= FileUpload::thumb_wmfile(350, $item['image']) ?>" alt="">
                                                        </span>
                                                        <span class="section2_body_item_box">
                                                            <span class="news_hot_title">
                                                                <?= $item['name'] ?>
                                                            </span>
                                                            <span class="news_date">
                                                                <?= date('d/m/Y', strtotime($item['created_at'])) ?>    
                                                            </span>
                                                        </span>
                                                    </a>
                                                </div>
                                            <?php }
                                            ?>
                                        </div>
                                    </div>
                                <?php } ?>
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
