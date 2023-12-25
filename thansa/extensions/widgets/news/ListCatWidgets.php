<?php

namespace app\widgets\news;

use app\helpers\CustomizeHelper;
use yii\base\Widget;

class ListCatWidgets extends Widget {

    public $params;

    public function init() {
        parent::init();
    }

    public function run() {
        $view = (isset($this->params['view'])) ? $this->params['view'] : 'list_cat';
        if ($view) {
            $id_root = (int) ((isset($this->params['id_root'])) ? $this->params['id_root'] : 1);
            $data_cats = CustomizeHelper::getTreeNewsCatById($id_root);
            return $this->render($view, [
                        'data_cats' => $data_cats,
            ]);
        }
    }

}
