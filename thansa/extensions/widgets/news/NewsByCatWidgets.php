<?php

namespace app\widgets\news;

use app\helpers\CustomizeHelper;
use yii\base\Widget;

class NewsByCatWidgets extends Widget {

    public $params;

    public function init() {
        parent::init();
    }

    public function run() {
        $view = (isset($this->params['view'])) ? $this->params['view'] : 'news_list_first';
        if ($view) {
            $limit = (int) ((isset($this->params['limit'])) ? $this->params['limit'] : 20);
            $id = (int) ((isset($this->params['id'])) ? $this->params['id'] : 0);

            if ($id) {
                $cat = CustomizeHelper::getNewsCatByID($id);
                if ($cat) {
                    $query = CustomizeHelper::createNewsByCatQuery($id, [], [
                                't.is_hot' => SORT_DESC,
                                '(t.sort_order is null)' => SORT_ASC,
                                't.sort_order' => SORT_ASC,
                                    ], $limit);
                    $data = $query->all();
                    return $this->render($view, [
                                'data' => $data,
                                'cat' => $cat,
                    ]);
                }
            }
        }
    }

}
