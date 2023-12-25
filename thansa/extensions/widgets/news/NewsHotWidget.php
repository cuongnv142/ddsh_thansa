<?php

namespace app\widgets\news;

use app\helpers\CustomizeHelper;
use yii\base\Widget;

class NewsHotWidget extends Widget {

    public $params;

    public function init() {
        parent::init();
    }

    public function run() {
        $view = (isset($this->params['view'])) ? $this->params['view'] : 'news_hot_by_cat';
        if ($view) {
            $limit = (int) ((isset($this->params['limit'])) ? $this->params['limit'] : 20);
            $id_cat = (int) ((isset($this->params['id_cat'])) ? $this->params['id_cat'] : 0);
            $query = CustomizeHelper::createNewsByCatQuery($id_cat, ['is_hot' => 1], [], $limit);
            $data = $query->all();
            return $this->render($view, [
                        'data' => $data,
            ]);
        }
    }

}
