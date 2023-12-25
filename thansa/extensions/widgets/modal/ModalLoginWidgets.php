<?php

namespace app\widgets\modal;

use app\models\Customer;
use app\models\LoginCustomerForm;
use app\models\RegisterCustomerForm;
use yii\base\Widget;

class ModalLoginWidgets extends Widget
{
    public $params;
    public function init()
    {
        parent::init();
    }


    public function run()
    {
        $model = new LoginCustomerForm();

        $modelRegister = new Customer();
        $modelRegister->scenario = 'create_ajax';

        $modelRecoverPass = new LoginCustomerForm();
        $modelRecoverPass->scenario = 'forgotpwd';

        $modelEditPass = new Customer();
        $modelEditPass->scenario = 'changepwd_new';
        $view = (isset($this->params['view'])) ? $this->params['view'] : 'modallogin';
        return $this->render($view, [
            'model' => $model,
            'modelRegister' => $modelRegister,
            'modelRecoverPass' => $modelRecoverPass,
            'modelEditPass' => $modelEditPass,
        ]);
    }

}
