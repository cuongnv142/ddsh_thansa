<?php

namespace app\widgets\menu;

use app\helpers\CustomizeHelper;
use Yii;
use yii\base\Widget;
use yii\db\Query;

class MenuWidgets extends Widget {

    public $params;

    public function init() {
        parent::init();
    }

    public function run() {
        $view = (isset($this->params['view'])) ? $this->params['view'] : '';
        if ($view) {
            $limit = (int) ((isset($this->params['limit'])) ? $this->params['limit'] : 20);
            $menu_group_id = (int) ((isset($this->params['menu_group_id'])) ? $this->params['menu_group_id'] : false);
            $title = ((isset($this->params['title'])) ? $this->params['title'] : '');
            $class_content = (isset($this->params['class_content'])) ? $this->params['class_content'] : '';
            $is_tree = (int) ((isset($this->params['is_tree'])) ? $this->params['is_tree'] : 0);
            if ($menu_group_id !== false) {
                if ($is_tree) {
                    $data = CustomizeHelper::getTreeMenuById(0, $menu_group_id, $limit);
                } else {
                    $query = new Query();
                    $query->select(['*']);
                    $query->from('menus');
                    $query->where(['menu_group_id' => $menu_group_id, 'status' => 1, 'language' => Yii::$app->language]);
                    $query->orderBy([
                        '(sort_order is null)' => SORT_ASC,
                        'sort_order' => SORT_ASC,
                    ]);
                    $query->limit($limit);
                    $data = $query->all();
                }
                return $this->render($view, [
                            'data' => $data,
                            'class_content' => $class_content,
                            'title' => $title,
                ]);
            }
        }
    }

}
