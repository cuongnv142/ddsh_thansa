<?php

use app\assets\AppAsset;
use yii\authclient\widgets\AuthChoice;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

$this->registerJsFile(Yii::getAlias('@web') . "/js/view/login.js", ['depends' => AppAsset::className()]);
?>
<!-- Modal Login -->
<div class="modal fade popup_lovegif popup_lovegif_login" id="vars_login" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <a href="javascript:void(0)" class="btn-close-popup" data-dismiss="modal">
                <img src="/images/ic-72.png" alt="">
            </a>
            <div class="popup_lovegif_content">
                <div class="lovegif_login_left">
                    <div class="lovegif_login_content">
                        <div class="lovegif_login_title">
                            <span>
                                Chào mừng bạn trở lại với LoveGifts
                            </span>
                            Đăng nhập tài khoản của bạn
                        </div>
                        <?php
                        $formLogin = ActiveForm::begin([
                                    'id' => 'login-form',
                                    'options' => [
                                        'class' => ''
                                    ],
                                    'fieldConfig' => [
                                        'template' => "{input}",
                                    ],
                                    'action' => ['site/logincustomer'],
                                    'validateOnBlur' => false,
                        ]);
                        echo Html::hiddenInput('url_referrer_login', Url::current(), ['id' => 'url_referrer_login']);
                        ?>
                        <div class="lovegif_login_row">
                            <?php
                            echo $formLogin->field($model, 'email')->begin();
                            echo Html::activeTextInput($model, 'email', ["class" => "form-control", 'placeholder' => 'Email']);
                            ?>
                            <?php echo Html::error($model, 'email', ['class' => 'help-block help-block-error']); ?>
                            <?php echo $formLogin->field($model, 'email')->end(); ?>
                        </div>
                        <div class="lovegif_login_row">
                            <?php
                            echo $formLogin->field($model, 'password')->begin();
                            echo Html::activePasswordInput($model, 'password', ["class" => "form-control", 'placeholder' => 'Mật khẩu']);
                            ?>
                            <a href="javascript:void(0);" class="btn_hide_pass">
                                <img src="/images/ic-hide-pass.png" />
                            </a>
                            <?php echo Html::error($model, 'password', ['class' => 'help-block help-block-error']); ?>
                            <?php echo $formLogin->field($model, 'password')->end(); ?>

                        </div>
                        <div class="lovegif_login_row">
                            <div class="lovegif_save_pass">
                                <div class="lovegif_pop_check">
                                    <input id="rememberLogin" name="LoginCustomerForm[rememberMe]" type="checkbox" class="community_check" value="1">
                                    <label for="rememberLogin"><span></span>Ghi nhớ đăng nhập</label>
                                </div> 
                            </div>
                            <a href="javascript:void(0);" onclick="showrecoverpwd()" class="lovegif_forgotpasss">
                                Quên mật khẩu?
                            </a>
                            <div class="clearfix"></div>
                        </div>
                        <div class="lovegif_login_box">
                            <button class="btn btn-login-pop" type="submit">
                                ĐĂNG NHẬP
                            </button>
                        </div>
                        <?php ActiveForm::end() ?>
                    </div>

                    <div class="lovegif_login_bot">
                        <div class="lovegif_login_txt">
                            <span>
                                Hoặc tạo tài khoản bằng :
                            </span>
                        </div>
                        <?php echo $this->render('view/_loginsocial') ?>

                        <div class="lovegif_login_links_register">
                            <span>
                                Bạn chưa có tài khoản? 
                            </span>
                            <a href="javascript:void(0);" onclick="showregister()">
                                Tạo tài khoản ngay
                            </a>
                        </div>
                    </div>
                </div>
                <div class="lovegif_login_right">
                    <img src="/images/img-popup-3007-1.png" alt="" />
                </div>
            </div>
        </div>
    </div>
</div>
<!--tạo tài khoản-->
<div class="modal fade popup_lovegif popup_lovegif_login" id="vars_regis" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <a href="javascript:void(0)" class="btn-close-popup" data-dismiss="modal">
                <img src="/images/ic-72.png" alt="">
            </a>
            <div class="popup_lovegif_content">
                <div class="lovegif_login_left">
                    <div class="lovegif_login_content">
                        <div class="lovegif_login_title">
                            <span>
                                Chào mừng thành viên mới
                            </span>
                            Vui lòng điền đầy đủ thông tin để tạo tài khoản mới
                        </div>
                        <?php
                        $formRegister = ActiveForm::begin([
                                    'id' => 'register-form',
                                    'options' => [
                                        'class' => ''
                                    ],
                                    'fieldConfig' => [
                                        'template' => "{input}",
                                    ],
                                    'action' => ['site/registercustomer'],
                                    'validateOnBlur' => false,
                        ]);
                        ?>
                        <div class="lovegif_login_row">
                            <?php
                            echo $formRegister->field($modelRegister, 'name')->begin();
                            echo Html::activeTextInput($modelRegister, 'name', ["class" => "form-control", 'placeholder' => 'Họ và tên']);
                            ?>
                            <?php echo Html::error($modelRegister, 'name', ['class' => 'help-block help-block-error']); ?>
                            <?php echo $formRegister->field($modelRegister, 'name')->end(); ?>
                        </div>
                        <div class="lovegif_login_row">
                            <?php
                            echo $formRegister->field($modelRegister, 'email')->begin();
                            echo Html::activeTextInput($modelRegister, 'email', ["class" => "form-control", 'id' => 'customer-email1', 'placeholder' => 'Nhập email']);
                            ?>
                            <?php echo Html::error($modelRegister, 'email', ['class' => 'help-block help-block-error']); ?>
                            <?php echo $formRegister->field($modelRegister, 'email')->end(); ?>
                        </div>
                        <div class="lovegif_login_row">
                            <?php
                            echo $formRegister->field($modelRegister, 'password')->begin();
                            echo Html::activePasswordInput($modelRegister, 'password', ["class" => "form-control", 'placeholder' => 'Mật khẩu']);
                            ?>
                            <a href="javascript:void(0);" class="btn_hide_pass">
                                <img src="/images/ic-hide-pass.png" />
                            </a>
                            <?php echo Html::error($modelRegister, 'password', ['class' => 'help-block help-block-error']); ?>
                            <?php echo $formRegister->field($modelRegister, 'password')->end(); ?>
                            <div class="note_passs">
                                *Nhập mật khẩu gồm 6 ký tự gồm có: Chữ viết thường, in hoa, số
                            </div>
                        </div>
                        <div class="lovegif_login_row">
                            <?php
                            echo $formRegister->field($modelRegister, 'password_repeat')->begin();
                            echo Html::activePasswordInput($modelRegister, 'password_repeat', ["class" => "form-control", 'placeholder' => 'Nhập lại mật khẩu']);
                            ?>
                            <a href="javascript:void(0);" class="btn_hide_pass">
                                <img src="/images/ic-hide-pass.png" />
                            </a>
                            <?php echo Html::error($modelRegister, 'password_repeat', ['class' => 'help-block help-block-error']); ?>
                            <?php echo $formRegister->field($modelRegister, 'password_repeat')->end(); ?>

                        </div>
                        <div class="lovegif_login_box" style="padding-top: 15px;">
                            <button class="btn btn-login-pop" type="submit">
                                TẠO TÀI KHOẢN
                            </button>
                        </div>
                        <?php ActiveForm::end() ?>
                    </div>

                    <div class="lovegif_login_bot">
                        <div class="lovegif_login_txt">
                            <span>
                                Hoặc tạo tài khoản bằng :
                            </span>
                        </div>
                        <?php echo $this->render('view/_loginsocial') ?>
                        <div class="lovegif_login_links_register">
                            <span>
                                Khi nhấn đăng ký tài khoản, đồng nghĩa bạn đã đồng ý tất cả 
                            </span>
                            <a href="#">
                                điều kiện sử dụng và chính sách của LoveGifts
                            </a>
                        </div>
                    </div>
                </div>
                <div class="lovegif_login_right">
                    <img src="/images/img-popup-3007-1.png" alt="" />
                </div>
            </div>
        </div>
    </div>
</div>

<!--Khôi phục mật khẩu-->
<div class="modal fade popup_lovegif popup_lovegif_accuracy" id="vars_recoverpwd" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <a href="javascript:void(0)" class="btn-close-popup" data-dismiss="modal">
                <img src="/images/ic-72.png" alt="">
            </a>
            <div class="lovegif_accuracy_content">               
                <div class="lovegif_accuracy__main">
                    <div class="lovegif_accuracy__top">
                        <a href="javascript:void(0);" onclick="showlogin()">
                            <img src="/images/ic-pop4.png" alt="" /> Quay lại
                        </a>
                    </div>
                    <div class="lovegif_accuracy__title">
                        <span class="d-block">
                            Khôi phục mật khẩu
                        </span>
                    </div>
                    <?php
                    $formRecoverPwd = ActiveForm::begin([
                                'id' => 'recoverpwd-form',
                                'options' => [
                                    'class' => 'form-default'
                                ],
                                'fieldConfig' => [
                                    'template' => "{input}",
                                ],
                                'action' => ['site/forgotcustomerpwd'],
                                'validateOnBlur' => false,
                    ]);
                    ?>
                    <div class="lovegif_login_row">
                        <?php
                        echo $formRecoverPwd->field($modelRecoverPass, 'email')->begin();
                        echo Html::activeTextInput($modelRecoverPass, 'email', ["class" => "form-control", 'placeholder' => 'Email']);
                        ?>
                        <?php echo Html::error($modelRecoverPass, 'email', ['class' => 'help-block help-block-error']); ?>
                        <?php echo $formRecoverPwd->field($modelRecoverPass, 'email')->end(); ?>
                    </div>
                    <div class="lovegif_accuracy_box">
                        <button class="btn btn-login-pop" type="submit">
                            Lấy mật khẩu
                        </button>
                    </div>
                    <?php ActiveForm::end() ?>
                </div>
            </div>
        </div>
    </div>
</div>

<!--Đổi mật khẩu-->
<div class="modal fade popup_lovegif popup_lovegif_accuracy" id="vars_editPwd" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <a href="javascript:void(0)" class="btn-close-popup" data-dismiss="modal">
                <img src="/images/ic-72.png" alt="">
            </a>
            <div class="lovegif_accuracy_content">
                <div class="lovegif_accuracy__main">
                    <div class="lovegif_accuracy__title">
                        <span class="d-block">
                            Đổi mật khẩu
                        </span>
                    </div>
                    <?php
                    $formEditPwd = ActiveForm::begin([
                                'id' => 'editPwd-form',
                                'options' => [
                                    'class' => 'form-default'
                                ],
                                'fieldConfig' => [
                                    'template' => "{input}",
                                ],
                                'action' => ['site/changecustomerpwd'],
                                'validateOnBlur' => false,
                    ]);
                    ?>
                    <?php
                    echo $formEditPwd->field($modelEditPass, 'id')->hiddenInput(['id' => 'changepwd_activation_id']);
                    echo $formEditPwd->field($modelEditPass, 'activation_code')->hiddenInput(['id' => 'changepwd_activation_code']);
                    ?>

                    <div class="lovegif_login_row">
                        <?php
                        echo $formEditPwd->field($modelEditPass, 'new_password')->begin();
                        echo Html::activePasswordInput($modelEditPass, 'new_password', ["class" => "form-control", 'placeholder' => 'Mật khẩu']);
                        ?>
                        <?php echo Html::error($modelEditPass, 'new_password', ['class' => 'help-block help-block-error']); ?>
                        <?php echo $formEditPwd->field($modelEditPass, 'new_password')->end(); ?>
                    </div>
                    <div class="lovegif_login_row">
                        <?php
                        echo $formEditPwd->field($modelEditPass, 'new_password_repeat')->begin();
                        echo Html::activePasswordInput($modelEditPass, 'new_password_repeat', ["class" => "form-control", 'placeholder' => 'Nhập lại mật khẩu']);
                        ?>
                        <?php echo Html::error($modelEditPass, 'new_password_repeat', ['class' => 'help-block help-block-error']); ?>
                        <?php echo $formEditPwd->field($modelEditPass, 'new_password_repeat')->end(); ?>
                    </div>
                    <div class="lovegif_accuracy_box">
                        <button class="btn btn-login-pop" type="submit">
                            Đổi mật khẩu
                        </button>
                    </div>
                    <?php ActiveForm::end() ?>
                </div>
            </div>
        </div>
    </div>
</div>
<!--xác thực tài khoản-->
<div class="modal fade popup_lovegif popup_lovegif_accuracy" id="vars_accuracy" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <a href="javascript:void(0)" class="btn-close-popup" data-dismiss="modal">
                <img src="/images/ic-72.png" alt="">
            </a>
            <div class="lovegif_accuracy_content">
                <div class="lovegif_accuracy__top">
                    <a href="">
                        <img src="/images/ic-pop4.png" alt="" /> Quay lại
                    </a>
                </div>
                <div class="lovegif_accuracy__main">
                    <div class="lovegif_accuracy__title">
                        <span class="d-block">
                            Xác thực tài khoản
                        </span>
                        Để bảo vệ tài khoản của bạn khi kích hoạt<br />
                        Hãy xác thực tài khoản qua email hoặc SMS
                    </div>
                    <form>
                        <div class="lovegif_login_row">
                            <div class="lovegif_accuracy_left">
                                <select class="form-control" >
                                    <option>
                                        Chọn hình thức xác thực tài khoản
                                    </option>
                                    <option>
                                        Xác thực qua OTP SMS
                                    </option>
                                    <option>
                                        Xác thực qua email
                                    </option>
                                </select>
                            </div>
                            <a class="btn btn-mxt" href="">
                                Gửi mã xác thực <i class="ic-pop6"></i>
                            </a>
                            <div class="clearfix"></div>
                        </div>
                        <div class="lovegif_login_row">
                            <input type="text" class="form-control" placeholder="Họ và tên" />
                        </div>
                    </form>
                    <div class="lovegif_accuracy_box">
                        <a class="btn btn-login-pop" href="javascript:void(0)" data-toggle="modal" data-target="#vars_sucess">
                            Kích hoạt
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!--kích hoạt thành công-->
<div class="modal fade popup_lovegif popup_lovegif_accuracy" id="vars_sucess" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <a href="javascript:void(0)" class="btn-close-popup" data-dismiss="modal">
                <img src="/images/ic-72.png" alt="">
            </a>
            <div class="lovegif_accuracy_content">
                <div class="lovegif_accuracy__main">
                    <div class="lovegif_sucess_img">
                        <img src="/images/img-pop-3007-2.png" alt="">
                    </div>
                    <div class="lovegif_accuracy__title">
                        <span class="d-block">
                            Tạo tài khoản thành công<br />
                            Chúc mừng bạn đã kích hoạt thành công tài khoản.
                        </span>
                        Hãy bổ sung thông tin để bảo vệ tài khoản và  trải nghiệm tốt hơn
                    </div>
                    <div class="lovegif_accuracy_box lovegif_sucess_box">
                        <a class="btn btn-login-pop" href="javascript:void(0)">
                            VỀ TRANG CÁ NHÂN
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
