<?php

namespace app\models;

use \Yii;
use yii\base\Model;

/**
 * LoginForm is the model behind the login form.
 */
class LoginForm extends Model {

    public $username;
    public $password;
    public $email;
    public $rememberMe = true;
    private $_user = false;
    public $key_code;
    public $captcha;

    /**
     * @return array the validation rules.
     */
    public function scenarios() {
        $scenarios = parent::scenarios();
        $scenarios['forgotpwd'] = ['email'];
        $scenarios['logintwosteps'] = ['key_code'];
        $scenarios['logincaptcha'] = ['email', 'password', 'captcha', 'rememberMe'];
        return $scenarios;
    }

    public function rules() {
        return [
            [['password'], 'required', 'message' => 'Mật khẩu không được để trống.'],
            [['email'], 'required', 'message' => 'Email/Số điện thoại không được để trống.'],
            ['rememberMe', 'boolean'],
            ['password', 'validatePassword'],
            [['key_code',], 'required', 'on' => ['logintwosteps'], 'message' => 'Mã OTP không được để trống'],
            ['captcha', 'required', 'message' => 'Mã xác thực không được để trống.', 'on' => 'logincaptcha'],
            ['captcha', 'captcha', 'message' => 'Mã xác thực không chính đúng.', 'on' => 'logincaptcha'],
        ];
    }

    /**
     * Validates the password.
     * This method serves as the inline validation for password.
     *
     * @param string $attribute the attribute currently being validated
     * @param array $params the additional name-value pairs given in the rule
     */
    public function validatePassword($attribute, $params) {
        if (!$this->hasErrors()) {
            $user = $this->getUser();
            if (!$user || !$user->validatePassword($this->password)) {
                $this->addError($attribute, 'Email/Số điện thoại hoặc mật khẩu không chính xác');
            }
        }
    }

    /**
     * Logs in a user using the provided username and password.
     * @return boolean whether the user is logged in successfully
     */
    public function login() {
         if ($this->validate()) {
            return Yii::$app->user->login($this->getUser(), $this->rememberMe ? 3600 * 24 * 30 : 0);
        } else {
            return false;
        }
    }

    public function loginbysocial($user) {
        if ($user) {
            if ($this->_user === false) {
                $this->_user = $user;
            }
            return Yii::$app->user->login($user, 0);
        } else {
            return false;
        }
    }

    public function forgotpass() {
        if ($this->validate()) {
            return $this->sendmailForgotPass();
        } else {
            return false;
        }
    }

    /**
     * Finds user by [[username]]
     *
     * @return User|null
     */
    public function getUser() {
        if ($this->_user === false) {
            $this->_user = User::findByEmailPhone($this->email);
        }
        return $this->_user;
    }

}
