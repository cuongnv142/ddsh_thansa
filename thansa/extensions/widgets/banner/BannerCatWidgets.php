<?php

namespace app\widgets\banner;

use yii\base\Widget;
use yii\db\Query;

class BannerCatWidgets extends Widget {

    public $params;

    public function init() {
        parent::init();
    }

    public function run() {
        $view = (isset($this->params['view'])) ? $this->params['view'] : '';
        if ($view) {
            $limit = (int) ((isset($this->params['limit'])) ? $this->params['limit'] : 20);
            $id = (int) ((isset($this->params['id'])) ? $this->params['id'] : 0);
            $title = ((isset($this->params['title'])) ? $this->params['title'] : '');
            $class_content = (isset($this->params['class_content'])) ? $this->params['class_content'] : '';
            if ($id) {
                $query = new Query();
                $query->select(['*']);
                $query->from('banner_cat');
                $query->where(['id' => $id]);
                $bannercat = $query->one();
                if ($bannercat) {
                    $query = new Query();
                    $query->select(['*']);
                    $query->from('banner');
                    $query->where(['banner_cat_id' => $id, 'status' => 1]);
                    $query->orderBy([
                        '(sort_order is null)' => SORT_ASC,
                        'sort_order' => SORT_ASC,
                    ]);
                    $query->limit($limit);
                    $data = $query->all();
                    return $this->render($view, [
                        'data' => $data,
                        'bannercat' => $bannercat,
                        'class_content' => $class_content,
                        'title' => $title,
                    ]);
                }
            }
        }
    }

}
