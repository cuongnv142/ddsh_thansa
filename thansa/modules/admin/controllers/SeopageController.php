<?php

namespace app\modules\admin\controllers;

use app\components\GoogleTranslate;
use app\models\RoutePage;
use app\modules\admin\components\AdminController;
use app\modules\admin\helpers\AdminHelper;
use app\modules\admin\models\AdminSeoPage;
use Yii;
use yii\filters\VerbFilter;
use yii\helpers\Url;
use yii\web\NotFoundHttpException;

/**
 * SeopageController implements the CRUD actions for SeoPage model.
 */
class SeopageController extends AdminController {

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

    /**
     * Lists all SeoPage models.
     * @return mixed
     */
    public function actionIndex() {
        $searchModel = new AdminSeoPage();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    public function setParam($model, $model_old) {
        if (!$model) {
            return $model;
        }
        $model->is_change_face = false;
        if ($model->face_image != $model_old->face_image || $model->face_title != $model_old->face_title || $model->face_description != $model_old->face_description) {
            $model->is_change_face = true;
        }
        $model->setFieldUploadName('face_image')->setIsImageDeleteName('is_deletefaceimage')->uploadImage();
        return $model;
    }

    public function removeCacheFace($route_name) {
        $url = Url::toRoute(['/' . $route_name], true);
        $reval = AdminHelper::removeCacheFace($url);
    }

    public function actionCreate() {
        $model = new AdminSeoPage();
        $model->language = 'vi';
        $model_old = new AdminSeoPage();
        if (!$model->load(Yii::$app->request->post())) {
            return $this->renderViewCreate($model);
        }
        $seoRoute = ($model->route_id) ? RoutePage::findOne($model->route_id) : null;
        $model->route_name = ($seoRoute) ? $seoRoute->route : null;
        $model = $this->setParam($model, $model_old);
        if (!$model->save()) {
            return $this->renderViewCreate($model);
        }
        if ($model->is_change_face) {
            $this->removeCacheFace($model->route_name);
        }
        $this->saveByLang($model);
        return $this->redirectSuccessCreate($model);
    }

    public function actionUpdate($id) {
        $model = $this->findModel($id);
        $model_old = $this->findModel($id);
        if (!$model->load(Yii::$app->request->post())) {
            return $this->renderViewUpdate($model);
        }
        $model = $this->setParam($model, $model_old);
        if (!$model->save()) {
            return $this->renderViewUpdate($model);
        }
        if ($model->is_change_face) {
            $this->removeCacheFace($model->route_name);
        }
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
        $new_model = new AdminSeoPage();
        $new_model->attributes = $model->attributes;
        if ($model->language == 'vi') {
            $new_model->language = 'en';
        } else {
            $new_model->language = 'vi';
        }
        $new_model->id_related = $model->id;
        if ($new_model->save()) {
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
        $text = $new_model->page_title;
        $result = GoogleTranslate::translate($source, $target, $text);
        if ($result) {
            $new_model->page_title = $result;
        }
        if ($new_model->page_keywords) {
            $text = $new_model->page_keywords;
            $result = GoogleTranslate::translate($source, $target, $text);
            if ($result) {
                $new_model->page_keywords = $result;
            }
        }
        if ($new_model->page_description) {
            $text = $new_model->page_description;
            $result = GoogleTranslate::translate($source, $target, $text);
            if ($result) {
                $new_model->page_description = $result;
            }
        }
        if ($new_model->face_title) {
            $text = $new_model->face_title;
            $result = GoogleTranslate::translate($source, $target, $text);
            if ($result) {
                $new_model->face_title = $result;
            }
        }

        if ($new_model->face_description) {
            $text = $new_model->face_description;
            $result = GoogleTranslate::translate($source, $target, $text);
            if ($result) {
                $new_model->face_description = $result;
            }
        }
        $new_model->update();
    }

    public function actionDelete($id) {
        $this->findModel($id)->delete();
        return $this->redirect(['index']);
    }

    protected function findModel($id) {
        $model = AdminSeoPage::findOne($id);
        if (!$model) {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
        return $model;
    }

}
