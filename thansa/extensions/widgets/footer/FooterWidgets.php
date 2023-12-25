<?php
namespace app\widgets\footer;

use yii\base\Widget;


class FooterWidgets extends Widget {

    public $params;

    public function init() {
        parent::init();
    }

    public function run() {
        $view = (isset($this->params['view'])) ? $this->params['view'] : 'footer';
        return $this->render($view);
    }

}
