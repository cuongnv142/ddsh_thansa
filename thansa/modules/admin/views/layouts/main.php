<?php

use app\components\FileUpload;
use app\modules\admin\AdminAsset;
use app\widgets\admin\menu\AdminMenu;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\Breadcrumbs;


AdminAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8"/>
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <?= Html::csrfMetaTags() ?>
        <link rel="shortcut icon" href="<?= Url::base(true); ?>/favicon.ico?v=1.0" type="image/x-icon" />
        <title><?= Html::encode($this->title) ?></title>
        <?php $this->head() ?>
        <script type="text/javascript">
            var ckEditor_baseUrl = '<?= Yii::$app->request->BaseUrl ?>';
        </script>
    </head>
    <body>
        <?php $this->beginBody() ?>
        <div class="navbar navbar-default" id="navbar">
            <script type="text/javascript">
                try {
                    ace.settings.check('navbar', 'fixed')
                } catch (e) {
                }
            </script>

            <div class="navbar-container" id="navbar-container">
                <div class="navbar-header pull-left">
                    <a href="<?= Url::to(['/admin/default/index']); ?>" class="navbar-brand" style="height: 45px;">
                        <small>
                            <i class="icon-leaf"></i>
                            Admin
                        </small>
                    </a>
                </div>
                <div class="navbar-buttons navbar-header pull-right" role="navigation">
                    <ul class="nav ace-nav">
                        <li class="light-blue">
                            <a data-toggle="dropdown" href="#" class="dropdown-toggle">                                
                                <img class="nav-user-photo" src="<?= (Yii::$app->user->getIdentity()->avatar) ? FileUpload::thumb_wmfile(50, Yii::$app->user->getIdentity()->avatar) : (Yii::getAlias('@web') . '/images/user.jpg'); ?>" alt="" />
                                <span class="user-info">
                                    <small>Xin chào,</small>
                                    <?= ((Yii::$app->user->identity->first_name) ? Yii::$app->user->identity->first_name : (Yii::$app->user->identity->email ? Yii::$app->user->identity->email : Yii::$app->user->identity->phone)) ?>
                                </span>

                                <i class="icon-caret-down"></i>
                            </a>

                            <ul class="user-menu pull-right dropdown-menu dropdown-yellow dropdown-caret dropdown-close">
                                <li>
                                    <a href="<?= Url::home(); ?>">
                                        <i class="icon-home"></i>
                                        Website
                                    </a>
                                </li>

                                <li>
                                    <a href="<?= Url::to(['/admin/user/view']); ?>">
                                        <i class="icon-user"></i>
                                        Thông tin tài khoản
                                    </a>
                                </li>

                                <li class="divider"></li>

                                <li>
                                    <a href="<?= Url::to(['/site/logout']); ?>" data-method="post">
                                        <i class="icon-off"></i>
                                        Đăng xuất
                                    </a>
                                </li>
                            </ul>
                        </li>
                    </ul><!-- /.ace-nav -->
                </div><!-- /.navbar-header -->
            </div><!-- /.container -->
        </div>
        <div class="main-container" id="main-container">
            <script type="text/javascript">
                try {
                    ace.settings.check('main-container', 'fixed')
                } catch (e) {
                }
            </script>

            <div class="main-container-inner">
                <a class="menu-toggler" id="menu-toggler" href="#">
                    <span class="menu-text"></span>
                </a>

                <div class="sidebar" id="sidebar">
                    <script type="text/javascript">
                        try {
                            ace.settings.check('sidebar', 'fixed')
                        } catch (e) {
                        }
                    </script>
                    <?php
                    if (Yii::$app->controller->module->id == 'admin') {
                        $configMenu = require(__DIR__ . '/../../config/menu.php');
                    } elseif (Yii::$app->controller->module->id == 'crawler') {
                        # Menu cho Crawler
                        $configMenu = require(Yii::getAlias('@app') . DIRECTORY_SEPARATOR . 'modules/crawler/config/menu.php');
                    } else {
                        # Menu cho CRM
                        $configMenu = require(Yii::getAlias('@app') . DIRECTORY_SEPARATOR . 'modules/crm/config/menu.php');
                    }
                    echo AdminMenu::widget($configMenu);
                    ?>                    
                    <div class="sidebar-collapse" id="sidebar-collapse">
                        <i class="icon-double-angle-left" data-icon1="icon-double-angle-left" data-icon2="icon-double-angle-right"></i>
                    </div>

                    <script type="text/javascript">
                        try {
                            ace.settings.check('sidebar', 'collapsed')
                        } catch (e) {
                        }
                    </script>
                </div>

                <div class="main-content">
                    <div class="breadcrumbs" id="breadcrumbs">
                        <script type="text/javascript">
                            try {
                                ace.settings.check('breadcrumbs', 'fixed')
                            } catch (e) {
                            }
                        </script>
                        <?=
                        Breadcrumbs::widget([
                            'homeLink' => [
                                'label' => '<i class="icon-home home-icon"></i><a href="' . Url::to(['/admin']) . '">Trang chủ</a>',
                                'encode' => false,
                            ],
                            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
                        ])
                        ?>
                    </div>
                    <div class="page-content">
                        <?= $content ?>
                    </div>

                </div><!-- /.main-content -->

                <?php
                $cookies = Yii::$app->request->cookies;
                $acesettingsnavbar = $cookies->getValue('ace-settings-navbar', 'off');
                $acesettingssidebar = $cookies->getValue('ace-settings-sidebar', 'off');
                $acsettingsbreadcrumbs = $cookies->getValue('ace-settings-breadcrumbs', 'off');
                $acesettingsrtl = $cookies->getValue('ace-settings-rtl', 'off');
                $acesettingsaddcontainer = $cookies->getValue('ace-settings-add-container', 'off');
                $sidebarcollapse = $cookies->getValue('sidebar-collapse', 'off');
                $skincolorpicker = $cookies->getValue('skin-colorpicker', 'default');
                ?>


                <div class="ace-settings-container" id="ace-settings-container">
                    <div class="btn btn-app btn-xs btn-warning ace-settings-btn" id="ace-settings-btn">
                        <i class="icon-cog bigger-150"></i>
                    </div>

                    <div class="ace-settings-box" id="ace-settings-box">
                        <div>
                            <div class="pull-left">
                                <select id="skin-colorpicker" class="hide">
                                    <option data-skin="default" <?= ($skincolorpicker == 'default') ? 'selected="selected"' : '' ?> value="#438EB9">#438EB9</option>
                                    <option data-skin="skin-1" <?= ($skincolorpicker == 'skin-1') ? 'selected="selected"' : '' ?> value="#222A2D">#222A2D</option>
                                    <option data-skin="skin-2" <?= ($skincolorpicker == 'skin-2') ? 'selected="selected"' : '' ?> value="#C6487E">#C6487E</option>
                                    <option data-skin="skin-3"<?= ($skincolorpicker == 'skin-3') ? 'selected="selected"' : '' ?> value="#D0D0D0">#D0D0D0</option>
                                </select>
                            </div>
                            <span>&nbsp; Choose Skin</span>
                        </div>

                        <div>
                            <input type="checkbox" checked="<?= ($acesettingsnavbar == 'on' ? 'true' : 'false') ?>"  class="ace ace-checkbox-2" id="ace-settings-navbar" />
                            <label class="lbl" for="ace-settings-navbar"> Fixed Navbar</label>
                        </div>

                        <div>
                            <input type="checkbox" checked="<?= ($acesettingssidebar == 'on' ? 'true' : 'false') ?>" class="ace ace-checkbox-2" id="ace-settings-sidebar" />
                            <label class="lbl" for="ace-settings-sidebar"> Fixed Sidebar</label>
                        </div>

                        <div>
                            <input type="checkbox" checked="<?= ($acsettingsbreadcrumbs == 'on' ? 'true' : 'false') ?>" class="ace ace-checkbox-2" id="ace-settings-breadcrumbs" />
                            <label class="lbl" for="ace-settings-breadcrumbs"> Fixed Breadcrumbs</label>
                        </div>

                        <div>
                            <input type="checkbox" checked="<?= ($acesettingsrtl == 'on' ? 'true' : 'false') ?>" class="ace ace-checkbox-2" id="ace-settings-rtl" />
                            <label class="lbl" for="ace-settings-rtl"> Right To Left (rtl)</label>
                        </div>

                        <div>
                            <input type="checkbox" checked="<?= ($acesettingsaddcontainer == 'on' ? 'true' : 'false') ?>" class="ace ace-checkbox-2" id="ace-settings-add-container" />
                            <label class="lbl" for="ace-settings-add-container">
                                Inside
                                <b>.container</b>
                            </label>
                        </div>
                    </div>
                </div><!-- /#ace-settings-container -->
            </div><!-- /.main-container-inner -->

            <a href="#" id="btn-scroll-up" class="btn-scroll-up btn btn-sm btn-inverse">
                <i class="icon-double-angle-up icon-only bigger-110"></i>
            </a>
        </div><!-- /.main-container -->
        <?php $this->endBody() ?>
        <?php
        $this->registerJs(
                '$("document").ready(function(){ 
                   ace.settings.navbar_fixed(' . (($acesettingsnavbar == 'on') ? 'true' : 'false') . ');
                   ace.settings.sidebar_fixed(' . (($acesettingssidebar == 'on') ? 'true' : 'false') . ');
                   ace.settings.breadcrumbs_fixed(' . (($acsettingsbreadcrumbs == 'on') ? 'true' : 'false') . ');
                   ' . (($acsettingsbreadcrumbs == 'on') ? 'ace.switch_direction(jQuery);$("#ace-settings-rtl").prop( "checked", true );' : '') . ' 
                   ace.settings.main_container_fixed(' . (($acesettingsaddcontainer == 'on') ? 'true' : 'false') . ');
                   ' . (($sidebarcollapse == 'on') ? 'c=$("#sidebar").hasClass("menu-min");ace.settings.sidebar_collapsed(!c)' : '') . ' 
                   var d="' . $skincolorpicker . '";    
                   var c=$(document.body);c.removeClass("skin-1 skin-2 skin-3");
                   if(d!="default"){c.addClass(d)}
                   if(d=="skin-1"){$(".ace-nav > li.grey").addClass("dark")}else{$(".ace-nav > li.grey").removeClass("dark")}
                   if(d=="skin-2"){$(".ace-nav > li").addClass("no-border margin-1");$(".ace-nav > li:not(:last-child)").addClass("light-pink").find(\'> a > [class*="icon-"]\').addClass("pink").end().eq(0).find(".badge").addClass("badge-warning")}else{$(".ace-nav > li").removeClass("no-border margin-1");$(".ace-nav > li:not(:last-child)").removeClass("light-pink").find(\'> a > [class*="icon-"]\').removeClass("pink").end().eq(0).find(".badge").removeClass("badge-warning")}
                   if(d=="skin-3"){$(".ace-nav > li.grey").addClass("red").find(".badge").addClass("badge-yellow")}else{$(".ace-nav > li.grey").removeClass("red").find(".badge").removeClass("badge-yellow")}
                });'
        );
        ?>
        <script type="text/javascript">
            var baseUrl = '<?= Yii::$app->request->BaseUrl ?>';
            var urlUploadImage = '<?= Url::to(['/admin/default/uploadimage']); ?>';
            jQuery(function ($) {
                $('.dialogs,.comments').slimScroll({
                    height: '300px'
                });
                $("#skin-colorpicker").on("change", function () {
                    skin = $(this).find("option:selected").data("skin");
                    SetCookie('skin-colorpicker', skin, 365);
                });
                $("#sidebar-collapse").on("click", function () {
                    if ($("#sidebar").hasClass("menu-min")) {
                        SetCookie('sidebar-collapse', 'on', 365);
                    } else {
                        SetCookie('sidebar-collapse', 'off', 365);
                    }
                });
                $("#ace-settings-navbar").on("click", function () {
                    if ($(this).is(':checked')) {
                        SetCookie('ace-settings-navbar', 'on', 365);
                    } else {
                        SetCookie('ace-settings-navbar', 'off', 365);
                    }
                });
                $("#ace-settings-sidebar").on("click", function () {
                    if ($(this).is(':checked')) {
                        SetCookie('ace-settings-sidebar', 'on', 365);
                    } else {
                        SetCookie('ace-settings-sidebar', 'off', 365);
                    }
                });
                $("#ace-settings-breadcrumbs").on("click", function () {
                    if ($(this).is(':checked')) {
                        SetCookie('ace-settings-breadcrumbs', 'on', 365);
                    } else {
                        SetCookie('ace-settings-breadcrumbs', 'off', 365);
                    }
                });
                $("#ace-settings-rtl").on("click", function () {
                    if ($(this).is(':checked')) {
                        SetCookie('ace-settings-rtl', 'on', 365);
                    } else {
                        SetCookie('ace-settings-rtl', 'off', 365);
                    }
                });
                $("#ace-settings-add-container").on("click", function () {
                    if ($(this).is(':checked')) {
                        SetCookie('ace-settings-add-container', 'on', 365);
                    } else {
                        SetCookie('ace-settings-add-container', 'off', 365);
                    }
                });
            });
            function SetCookie(a, b, c) {
                Cookies.set(a, b, {
                    expires: c,
                    path: "/"
                })
            }
        </script>
    </body>

</html>
<?php $this->endPage() ?>
