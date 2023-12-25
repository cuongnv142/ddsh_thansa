<?php

namespace app\modules\admin\controllers;

use app\components\GoogleTranslate;
use app\modules\admin\components\AdminController;
use app\modules\admin\models\AdminBanner;
use app\modules\admin\models\AdminBannerCat;
use Yii;
use yii\filters\VerbFilter;
use yii\web\NotFoundHttpException;

class BannerController extends AdminController {

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
        $searchModel = new AdminBanner();
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
        $option = array();
        $option_id = Yii::$app->request->post('option_id');
        $option_target = Yii::$app->request->post('option_target');
        $option_style = Yii::$app->request->post('option_style');
        $option_class = Yii::$app->request->post('option_class');
        if ($option_id != '' || $option_target != '' || $option_style != '' || $option_class != '') {
            $option = array('option_id' => $option_id, 'option_class' => $option_class, 'option_style' => $option_style, 'option_target' => $option_target
            );
        }
        $model->multitext = json_encode(array('option' => $option));
        $model->setFieldUploadName('src')->uploadImage();
        $model->setFieldUploadName('src_mobile')->setIsImageDeleteName('is_deleteimagemobile')->uploadImage();
        return $model;
    }

    public function actionCreate() {
        $model = new AdminBanner();
        $model->language = 'vi';
        if (!$model->load(Yii::$app->request->post())) {
            return $this->renderViewCreate($model);
        }
        $model = $this->setParamModel($model);
        if ($model->hasErrors() || !$model->save()) {
            return $this->renderViewCreate($model);
        }
        $this->saveByLang($model);
        return $this->redirectSuccessCreate($model);
    }

    public function actionUpdate($id) {
        $model = $this->findModel($id);
        if (!$model->load(Yii::$app->request->post())) {
            return $this->renderViewUpdate($model);
        }
        $model = $this->setParamModel($model);
        if ($model->hasErrors() || !$model->save()) {
            return $this->renderViewUpdate($model);
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
        $new_model = new AdminBanner();
        $new_model->attributes = $model->attributes;
        $new_model->alias = $new_model->alias . '-new';
        if ($model->language == 'vi') {
            $new_model->language = 'en';
        } else {
            $new_model->language = 'vi';
        }
        $new_model->id_related = $model->id;
        $new_model->banner_cat_id = 0;
        if ($model->banner_cat_id) {
            $parent = AdminBannerCat::findOne($model->banner_cat_id);
            if ($parent) {
                $new_model->banner_cat_id = $parent->id_related;
            }
        }
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
        $text = $new_model->name;
        $result = GoogleTranslate::translate($source, $target, $text);
        if ($result) {
            $new_model->name = $result;
        }
        if ($new_model->description) {
            $text = $new_model->description;
            $result = GoogleTranslate::translate($source, $target, $text);
            if ($result) {
                $new_model->description = $result;
            }
        }
        $new_model->update();
    }

    public function actionDelete($id) {
        $this->findModel($id)->delete();
        return $this->redirect(['index']);
    }

    protected function findModel($id) {
        $model = AdminBanner::findOne($id);
        if (!$model) {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
        return $model;
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

    public function actionSavesortorder() {
        if (!Yii::$app->request->isAjax) {
            Yii::$app->end();
        }
        $order = (int) Yii::$app->request->post('order', 0);
        $id = Yii::$app->request->post('id', 0);
        $mes = "Có lỗi khi lưu dữ liệu";
        if (!$id) {
            $this->exitErrorAjax($mes);
        }
        $model = $this->findModel($id);
        if (!$model) {
            $this->exitErrorAjax($mes);
        }
        $model->sort_order = $order;
        if (!$model->save()) {
            $this->exitErrorAjax($mes);
        }
        $this->exitSuccessAjax();
    }

}
