<?php

namespace app\widgets\banner;

use yii\base\Widget;
use yii\db\Query;

class BannerWidgets extends Widget {

    public $params;

    public function init() {
        parent::init();
    }

    public function run() {
        $view = (isset($this->params['view'])) ? $this->params['view'] : '';
        if ($view) {
            $id = (int) ((isset($this->params['id'])) ? $this->params['id'] : 0);
            $class_content = (isset($this->params['class_content'])) ? $this->params['class_content'] : '';
            if ($id) {
                $query = new Query();
                $query->select(['*']);
                $query->from('banner');
                $query->where(['id' => $id, 'status' => 1]);
                $banner = $query->one();
                return $this->render($view, [
                            'banner' => $banner,
                            'class_content' => $class_content,
                ]);
            }
        }
    }

}
