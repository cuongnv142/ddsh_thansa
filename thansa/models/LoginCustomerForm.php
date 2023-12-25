<?php

namespace app\models;

use Yii;
use yii\base\Model;

class LoginCustomerForm extends Model
{

    public $password;
    public $email;
    public $rememberMe = true;
    private $_customer = false;


    public function scenarios()
    {
        $scenarios = parent::scenarios();
        $scenarios['forgotpwd'] = ['email'];
        return $scenarios;
    }

    public function rules()
    {
        return [
            [['password'], 'required', 'message' =>  Yii::t('app', 'Mật khẩu không được để trống.')],
            [['email'], 'required', 'message' => Yii::t('app', 'Email không được để trống.')],
            ['rememberMe', 'boolean'],
            ['password', 'validatePassword'],
        ];
    }

    public function validatePassword($attribute, $params)
    {
        if (!$this->hasErrors()) {
            $customer = $this->getCustomer();
            if (!$customer || !$customer->validatePassword($this->password)) {
                $this->addError($attribute,  Yii::t('app','Email hoặc mật khẩu không chính xác'));
            }
        }
    }

    public function login()
    {
        if ($this->validate()) {
            return Yii::$app->customer->login($this->getCustomer(), $this->rememberMe ? 3600 * 24 * 30 : 0);
        } else {
            return false;
        }
    }

    public function loginbysocial($customer)
    {
        if ($customer) {
            if ($this->_customer === false) {
                $this->_customer = $customer;
            }
            return Yii::$app->customer->login($customer, 0);
        } else {
            return false;
        }
    }

    public function forgotpass()
    {
        if ($this->validate()) {
            return $this->sendmailForgotPass();
        } else {
            return false;
        }
    }

    /**
     * Finds customer by [[customername]]
     *
     * @return User|null
     */
    public function getCustomer()
    {
        if ($this->_customer === false) {
            $this->_customer = Customer::findByEmail($this->email);
        }
        return $this->_customer;
    }

}
