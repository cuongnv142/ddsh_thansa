<?php

namespace app\widgets\boxpage;

use yii\base\Widget;
use yii\db\Query;

class BoxpageWidgets extends Widget {

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
                $query->from('boxpage');
                $query->where(['id' => $id, 'status' => 1]);
                $boxpage = $query->one();

                $query = new Query();
                $query->select(['*']);
                $query->from('boxpage_media');
                $query->where(['boxpage_id' => $id]);
                $query->orderBy([
                    'sort_order' => SORT_ASC,
                ]);
                $query->limit(20);
                $boxpage_media = $query->all();
                return $this->render($view, [
                            'boxpage' => $boxpage,
                            'boxpage_media' => $boxpage_media,
                            'class_content' => $class_content,
                ]);
            }
        }
    }

}
