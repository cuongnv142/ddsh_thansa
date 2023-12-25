<?php

namespace app\widgets\header;

use yii\base\Widget;

class ActionHeadWidgets extends Widget {

    public $params;

    public function init() {
        parent::init();
    }
    public function run() {
        return $this->render('action_head', [
        ]);
    }

}
