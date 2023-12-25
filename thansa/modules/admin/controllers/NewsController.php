<?php

namespace app\modules\admin\controllers;

use app\components\GoogleTranslate;
use app\helpers\StringHelper;
use app\models\NewsCatRel;
use app\models\TagRel;
use app\modules\admin\components\AdminController;
use app\modules\admin\models\AdminNews;
use app\modules\admin\models\AdminNewsCat;
use Yii;
use yii\filters\VerbFilter;
use yii\web\NotFoundHttpException;

class NewsController extends AdminController {

    public function behaviors() {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
    }

    public function actionIndex() {
        $searchModel = new AdminNews();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    public function setParamModel($model) {
        if (!$model) {
            return $model;
        }
        $model->sort_order = (int) $model->sort_order;
        $model->alias = ($model->alias) ? StringHelper::formatUrlKey($model->alias) : StringHelper::formatUrlKey($model->name);
        $model->post_at = date('Y-m-d H:i:s');
        $model->news_cat_id = ((int) $model->news_cat_id) ? (int) $model->news_cat_id : '';
        $model->root_news_cat_id = (int) $this->getIdCatFirst($model->news_cat_id);
        $model->uploadImage();
        return $model;
    }

    public function getIdCatFirst($new_models_cat_id) {
        $reVal = 0;
        $cat = AdminNewsCat::findOne($new_models_cat_id);
        if (!$cat) {
            return $reVal;
        }
        if ((int) $cat->parent_id == 0) {
            return $new_models_cat_id;
        }
        $arr = explode('/', $cat->path);
        if (isset($arr[1])) {
            return $arr[1];
        }
        return $reVal;
    }

    public function actionCreate() {
        $model = new AdminNews();
        $model->language = 'vi';
        if (!$model->load(Yii::$app->request->post())) {
            return $this->renderViewCreate($model);
        }
        $model = $this->setParamModel($model);
        if ($model->hasErrors() || !$model->save()) {
            return $this->renderViewCreate($model);
        }
        $this->saveCategories($model);
        TagRel::saveMultilTag($model->tags, $model->id, TagRel::TYPE_NEWS);
        $this->saveByLang($model);
        return $this->redirectSuccessCreate($model);
    }

    public function actionUpdate($id) {
        $model = $this->findModel($id);
        $oldCat = $model->news_cat_id;
        $model->tags = TagRel::getTagsByType($model->id, TagRel::TYPE_NEWS);
        if (!$model->load(Yii::$app->request->post())) {
            return $this->renderViewUpdate($model);
        }
        $model = $this->setParamModel($model);
        if ($model->hasErrors() || !$model->save()) {
            return $this->renderViewUpdate($model);
        }
        $this->saveCategories($model);
        TagRel::saveMultilTag($model->tags, $model->id, TagRel::TYPE_NEWS);
        if (!$model->id_related) {
            $this->saveByLang($model);
        }
        return $this->redirectSuccessUpdate($model);
    }

    public function saveByLang($model) {
        if (!$model) {
            return;
        }
        if (count(Yii::$app->params['languages']) < 2) {
            return;
        }
        $new_model = new AdminNews();
        $new_model->attributes = $model->attributes;
        $new_model->alias = $new_model->alias . '-new';
        if ($model->language == 'vi') {
            $new_model->language = 'en';
        } else {
            $new_model->language = 'vi';
        }
        $new_model->id_related = $model->id;
        $new_model->news_cat_id = 0;
        if ($model->news_cat_id) {
            $parent = AdminNewsCat::findOne($model->news_cat_id);
            if ($parent) {
                $new_model->news_cat_id = $parent->id_related;
            }
        }
        if ($model->root_news_cat_id) {
            $parent = AdminNewsCat::findOne($model->root_news_cat_id);
            if ($parent) {
                $new_model->root_news_cat_id = $parent->id_related;
            }
        }
        if ($new_model->save()) {
            $this->saveCategories($new_model);
            TagRel::saveMultilTag($model->tags, $new_model->id, TagRel::TYPE_NEWS);
            $model->id_related = $new_model->id;
            $model->update();
            $this->translate($new_model);
        }
    }

    public function translate($new_model) {
        if (!$new_model) {
            return;
        }
        if ($new_model->language == 'vi') {
            $source = 'en';
            $target = 'vi';
        } else {
            $source = 'vi';
            $target = 'en';
        }
        $text = $new_model->name;
        $result = GoogleTranslate::translate($source, $target, $text);
        if ($result) {
            $new_model->name = $result;
            $new_model->alias = StringHelper::formatUrlKey($new_model->name);
        }
        if ($new_model->short_description) {
            $text = $new_model->short_description;
            $result = GoogleTranslate::translate($source, $target, $text);
            if ($result) {
                $new_model->short_description = $result;
            }
        }

        if ($new_model->description) {
            $text = $new_model->description;
            $result = GoogleTranslate::translate($source, $target, $text);
            if ($result) {
                $new_model->description = $result;
            }
        }
        if ($new_model->title_seo) {
            $text = $new_model->title_seo;
            $result = GoogleTranslate::translate($source, $target, $text);
            if ($result) {
                $new_model->title_seo = $result;
            }
        }
        if ($new_model->content_seo) {
            $text = $new_model->content_seo;
            $result = GoogleTranslate::translate($source, $target, $text);
            if ($result) {
                $new_model->content_seo = $result;
            }
        }
        if ($new_model->key_seo) {
            $text = $new_model->key_seo;
            $result = GoogleTranslate::translate($source, $target, $text);
            if ($result) {
                $new_model->key_seo = $result;
            }
        }
        $new_model->update();
    }

    public function saveCategories($model) {
        if (!$model) {
            return;
        }
        if (!$model->news_cat_id) {
            $command = Yii::$app->db->createCommand();
            $command->delete('news_cat_rel', 'news_id=:news_id', array(':news_id' => $model->id))->execute();
            return;
        }
        $new_modelsCat = AdminNewsCat::findOne($model->news_cat_id);
        if (!$new_modelsCat) {
            return;
        }
        $categories = explode('/', $new_modelsCat->path);
        try {
            $catIn = implode(',', $categories);
            $command = Yii::$app->db->createCommand();
            $command->delete('news_cat_rel', 'news_id=:news_id and news_cat_id NOT IN (' . $catIn . ')', array(':news_id' => $model->id))->execute();
            foreach ($categories as $catId) {
                if ($catId) {
                    $query = 'insert ignore into news_cat_rel(news_cat_id,news_id) values(' . $catId . ',' . $model->id . ')';
                    $command = Yii::$app->db->createCommand($query)->execute();
                }
            }
        } catch (Exception $e) {
            
        }
    }

    public function actionDelete($id) {
        $this->findModel($id)->delete();
        NewsCatRel::deleteAll(['news_id' => $id]);
        return $this->redirect(['index']);
    }

    protected function findModel($id) {
        $model = AdminNews::findOne($id);
        if (!$model) {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
        return $model;
    }

    public function actionSetis_hot() {
        if (!Yii::$app->request->isAjax) {
            Yii::$app->end();
        }
        $is_hot = Yii::$app->request->post('is_hot', 0);
        $id = Yii::$app->request->post('id', 0);
        $mes = "Có lỗi khi lưu dữ liệu";
        if (!$id) {
            $this->exitErrorAjax($mes);
        }
        $model = $this->findModel($id);
        if (!$model) {
            $this->exitErrorAjax($mes);
        }
        $model->is_hot = (int) $is_hot;
        if (!$model->save()) {
            $this->exitErrorAjax($mes);
        }
        $this->exitSuccessAjax();
    }

    public function actionSetstatus() {
        if (!Yii::$app->request->isAjax) {
            Yii::$app->end();
        }
        $status = Yii::$app->request->post('status', 0);
        $id = Yii::$app->request->post('id', 0);
        $mes = "Có lỗi khi lưu dữ liệu";
        if (!$id) {
            $this->exitErrorAjax($mes);
        }
        $model = $this->findModel($id);
        if (!$model) {
            $this->exitErrorAjax($mes);
        }
        $model->status = (int) $status;
        if (!$model->save()) {
            $this->exitErrorAjax($mes);
        }
        $this->exitSuccessAjax();
    }

}
