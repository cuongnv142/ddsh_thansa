<?php

namespace app\widgets\modal;

use yii\base\Widget;

class ModalFeedbackWidgets extends Widget {
    public $params;
    public function init() {
        parent::init();
    }
    public function run() {
        $view = (isset($this->params['view'])) ? $this->params['view'] : 'modalfeedback';
        return $this->render($view, [
        ]);
    }

}
