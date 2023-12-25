<?php

namespace app\widgets\admin\form;

use yii\base\Widget;

class ActionButton extends Widget {

    public $params;

    public function init() {
        parent::init();
    }

    public function run() {
        if (isset($this->params['formId']) && ($this->params['formId'])) {
            return $this->render('actionbutton', $this->params);
        }
    }

}
