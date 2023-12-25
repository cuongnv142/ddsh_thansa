<?php

namespace app\controllers;

use app\components\CController;
use app\helpers\CustomizeHelper;
use app\helpers\StringHelper;
use app\models\TagRel;
use Yii;
use yii\data\ArrayDataProvider;
use yii\data\Pagination;
use yii\web\NotFoundHttpException;
use yii\web\Response;

class NewsController extends CController {

    public function getCatCurent($id_cat = 0) {
        $cat = false;
        if ($id_cat) {
            $cat = CustomizeHelper::getNewsCatByID($id_cat);
        }
        if ($cat) {
            return $cat;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function getTagCurent($id_tag = 0) {
        $tag = false;
        if ($id_tag) {
            $tag = CustomizeHelper::getTagByID($id_tag);
        }
        if ($tag) {
            return $tag;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionTag() {
        $id_tag = (int) Yii::$app->getRequest()->getQueryParam('tid', 0);
        $tag = $this->getTagCurent($id_tag);
        if ($tag) {
            $page_title = 'Tag: ' . $tag['name'];
            $page_description = $tag['name'];
            $page_keywords = $tag['name'];
            $this->generator_title_desSeo($page_title, $page_description, $page_keywords);

            $page = (int) Yii::$app->getRequest()->getQueryParam('page', 1);
            $pagecurrent = ($page - 1);
            $pageSize = 15;
            $offset = $pagecurrent * $pageSize;
            $query = CustomizeHelper::createNewsByTagQuery($tag['id'], [], [], $pageSize, $offset);
            $data = $query->all();
            $totalCount = (int) $query->limit(-1)->offset(-1)->orderBy([])->count();
            $dataProvider = new ArrayDataProvider([
                'allModels' => $data,
                'pagination' => false
            ]);
            $pagination = new Pagination(['totalCount' => $totalCount, 'defaultPageSize' => $pageSize]);
            $totalpage = ceil($totalCount / $pageSize);
            return $this->render('tags', [
                        'model' => $tag,
                        'dataProvider' => $dataProvider,
                        'pageSize' => $pageSize,
                        'pagecurrent' => $pagecurrent,
                        'pagination' => $pagination,
                        'totalpage' => $totalpage,
            ]);
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionShowmoretag() {
        if (Yii::$app->request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            $this->validateCSRF();
            $tagid = (int) Yii::$app->request->post('tagid', 0);
            $page = (int) Yii::$app->request->post('pagecurrent', 0);
            if (!$catid || $page < 2) {
                echo json_encode(['err' => 1, 'html' => '']);
                Yii::$app->end();
            }
            $pagecurrent = ($page - 1);
            $pageSize = 15;
            $offset = $pagecurrent * $pageSize;
            $query = CustomizeHelper::createNewsByTagQuery($tagid, [], [], $pageSize, $offset);
            $data = $query->all();
            $totalCount = (int) $query->limit(-1)->offset(-1)->orderBy([])->count();
            $totalpage = ceil($totalCount / $pageSize);
            $html = '';
            $is_show = 0;
            if ($data) {
                foreach ($data as $model) {
                    $html .= '<div class="item">' . $this->renderPartial('view/_itemnews_row', array('model' => $model)) . '</div>';
                }
                if ($totalpage > $page + 1) {
                    $is_show = 1;
                }
            }
            return ['err' => 0, 'is_show' => $is_show, 'html' => $html];
            Yii::$app->end();
        }
        Yii::$app->end();
    }

    public function actionList() {
        $cat_id = (int) Yii::$app->getRequest()->getQueryParam('cid', 0);
        if (!$cat_id) {
            $cat_id = 1;
        }
        $cat = $this->getCatCurent($cat_id);
        if ($cat) {
            $page_title = $cat['title_seo'] ? $cat['title_seo'] : $cat['name'];
            $page_description = strip_tags($cat['content_seo']);
            $page_keywords = strip_tags($cat['key_seo']);
            $this->generator_title_desSeo($page_title, $page_description, $page_keywords);
            $coun_child = CustomizeHelper::countChildNewsCatByID($cat['id']);
            if ($coun_child) {
                $view = 'list_first';
                $cat_ids = CustomizeHelper::getChildNewsCatId($cat['id']);
                return $this->render($view, [
                            'model' => $cat,
                            'cat_id' => $cat_id,
                            'cat_ids' => $cat_ids,
                ]);
            } else {
                $view = 'list';
                $query = CustomizeHelper::createNewsByCatQuery($cat['id'], [], [
                            't.is_hot' => SORT_DESC,
                            '(t.sort_order is null)' => SORT_ASC,
                            't.sort_order' => SORT_ASC,
                                ], 4);
                $data_hot = $query->all();
                $idhots = [];
                if ($data_hot) {
                    foreach ($data_hot as $item) {
                        $idhots[] = $item['id'];
                    }
                }
                $page = (int) Yii::$app->getRequest()->getQueryParam('page', 1);
                $pagecurrent = ($page - 1);
                $pageSize = 8;
                $offset = $pagecurrent * $pageSize;
                $where = [];
                if (!empty($idhots)) {
                    $where = ['NOT IN', 't.id', $idhots];
                }
                $query = CustomizeHelper::createNewsByCatQuery($cat['id'], $where, [], $pageSize, $offset);
                $data = $query->all();
                $totalCount = (int) $query->limit(-1)->offset(-1)->orderBy([])->count();
                $dataProvider = new ArrayDataProvider([
                    'allModels' => $data,
                    'pagination' => false
                ]);
                $pagination = new Pagination(['totalCount' => $totalCount, 'defaultPageSize' => $pageSize]);
                $totalpage = ceil($totalCount / $pageSize);
                return $this->render($view, [
                            'model' => $cat,
                            'dataProvider' => $dataProvider,
                            'pageSize' => $pageSize,
                            'pagecurrent' => $pagecurrent,
                            'pagination' => $pagination,
                            'totalpage' => $totalpage,
                            'data_hot' => $data_hot,
                ]);
            }
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    private function validateCSRF() {
        $request = Yii::$app->request;
        if (!$request->isPost) {
            echo json_encode(['err' => 998]);
            Yii::$app->end();
        }
        $request->enableCsrfValidation = true;
        $ok = $request->validateCsrfToken();
        if (!$ok) {
            echo json_encode(['err' => 999]);
            Yii::$app->end();
        }
    }

    public function actionShowmore() {
        if (Yii::$app->request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            $this->validateCSRF();
            $catid = (int) Yii::$app->request->post('catid', 0);
            $page = (int) Yii::$app->request->post('pagecurrent', 0);
            if (!$catid || $page < 2) {
                echo json_encode(['err' => 1, 'html' => '']);
                Yii::$app->end();
            }

            $query = CustomizeHelper::createNewsByCatQuery($catid, [], [
                        't.is_hot' => SORT_DESC,
                        '(t.sort_order is null)' => SORT_ASC,
                        't.sort_order' => SORT_ASC,
                            ], 4);
            $data_hot = $query->all();
            $idhots = [];
            if ($data_hot) {
                foreach ($data_hot as $item) {
                    $idhots[] = $item['id'];
                }
            }

            $where = [];
            if (!empty($idhots)) {
                $where = ['NOT IN', 't.id', $idhots];
            }

            $pagecurrent = ($page - 1);
            $pageSize = 15;
            $offset = $pagecurrent * $pageSize;
            $query = CustomizeHelper::createNewsByCatQuery($catid, $where, [], $pageSize, $offset);
            $data = $query->all();
            $totalCount = (int) $query->limit(-1)->offset(-1)->orderBy([])->count();
            $totalpage = ceil($totalCount / $pageSize);
            $html = '';
            $is_show = 0;
            if ($data) {
                foreach ($data as $model) {
                    $html .= '<div class="item">' . $this->renderPartial('view/_itemnews_row', array('model' => $model)) . '</div>';
                }
                if ($totalpage > $page + 1) {
                    $is_show = 1;
                }
            }
            return ['err' => 0, 'is_show' => $is_show, 'html' => $html];
            Yii::$app->end();
        }
        Yii::$app->end();
    }

    public function getNewsCurent() {
        $id_news = Yii::$app->getRequest()->getQueryParam('id', '');
        $news = false;
        if ($id_news) {
            $news = CustomizeHelper::getNewsByID($id_news);
        }
        if ($news) {
            return $news;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionGioithieu() {
        $id_news = 1;
        $news = CustomizeHelper::getNewsByID($id_news);
        if ($news) {
            return $this->render('gioithieu', [
                        'model' => $news,
            ]);
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionView() {
        $news = $this->getNewsCurent();
        if ($news) {
            $alias = Yii::$app->getRequest()->getQueryParam('alias', '');
            if ($alias != StringHelper::formatUrlKey($news['alias'])) {
                $url = CustomizeHelper::createUrlNew($news);
                $this->redirect($url, 301);
            }
            $cat = $this->getCatCurent($news['news_cat_id']);
            $page_title = $news['title_seo'] ? $news['title_seo'] : $news['name'];
            $page_description = strip_tags($news['content_seo']);
            $page_keywords = strip_tags($news['key_seo']);
            $this->generator_title_desSeo($page_title, $page_description, $page_keywords);
            $datarelated = CustomizeHelper::getNewsByCat($news['news_cat_id'], ['<>', 'id', $news['id']], [], 3);
            $tags = TagRel::getTagsByTypeArray($news['id'], TagRel::TYPE_NEWS);
            return $this->render('view', [
                        'model' => $news,
                        'cat' => $cat,
                        'tags' => $tags,
                        'datarelated' => $datarelated,
            ]);
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

}
