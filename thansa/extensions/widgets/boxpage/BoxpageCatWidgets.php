<?php

namespace app\widgets\boxpage;

use Yii;
use app\helpers\Mobile_Detect;
use yii\base\Widget;
use yii\db\Query;

class BoxpageCatWidgets extends Widget {

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
            $is_media = ((isset($this->params['is_media'])) ? $this->params['is_media'] : false);
            if ($id) {
                $query = new Query();
                $query->select(['*']);
                $query->from('boxpage_cat');
                $query->where(['id' => $id]);
                $boxpagecat = $query->one();
                if ($boxpagecat) {
                    $query = new Query();
                    $query->select(['*']);
                    $query->from('boxpage');
                    $query->where(['boxpage_cat_id' => $id, 'status' => 1]);
                    $query->andWhere(['language' => \Yii::$app->language]);
                    $query->orderBy([
                        '(sort_order =0)' => SORT_ASC,
                        'sort_order' => SORT_ASC,
                    ]);
                    $query->limit($limit);
                    $data = $query->all();
                    if ($is_media) {
                        $data_new = [];
                        foreach ($data as $item) {
                            $query = new Query();
                            $query->select(['*']);
                            $query->from('boxpage_media');
                            $query->where(['boxpage_id' => $item['id']]);
                            $query->orderBy([
                                'sort_order' => SORT_ASC,
                            ]);
                            $query->limit(20);
                            $item['media'] = $query->all();
                            $data_new[] = $item;
                        }
                        $data = $data_new;
                    }

                    return $this->render($view, [
                                'data' => $data,
                                'boxpagecat' => $boxpagecat,
                                'class_content' => $class_content,
                                'title' => $title,
                    ]);
                }
            }
        }
    }

}
