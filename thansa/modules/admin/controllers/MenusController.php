<?php

namespace app\modules\admin\controllers;

use app\components\GoogleTranslate;
use app\modules\admin\components\AdminController;
use app\modules\admin\models\AdminMenus;
use app\modules\admin\models\AdminNewsCat;
use Yii;
use yii\filters\VerbFilter;
use yii\web\NotFoundHttpException;

/**
 * MenusController implements the CRUD actions for AdminMenus model.
 */
class MenusController extends AdminController {

    /**
     * {@inheritdoc}
     */
    public function behaviors() {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all AdminMenus models.
     * @return mixed
     */
    public function actionIndex() {
        $searchModel = new AdminMenus();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    public function actionCreate() {
        $model = new AdminMenus();
        $model->language = 'vi';
        if (!$model->load(Yii::$app->request->post())) {
            return $this->renderViewCreate($model);
        }
        $model->setParamModel();
        if ($model->hasErrors() || !$model->save()) {
            return $this->renderViewCreate($model);
        }
        $model->path = $model->createPath();
        if (!$model->save()) {
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
        $model->setParamModel();
        if ($model->hasErrors() || !$model->save()) {
            return $this->renderViewUpdate($model);
        }
        $model->updateChildren();
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
        $new_model = new AdminMenus();
        $new_model->attributes = $model->attributes;
        if ($model->language == 'vi') {
            $new_model->language = 'en';
        } else {
            $new_model->language = 'vi';
        }
        $new_model->id_related = $model->id;
        $new_model->parent_id = 0;
        if ($model->parent_id) {
            $parent = AdminMenus::findOne($model->parent_id);
            if ($parent) {
                $new_model->parent_id = $parent->id_related;
            }
        }
        if ($model->id_object) {
            if ($model->type_menu == 1) {
                $new_modelscat = AdminNewsCat::findOne($model->id_object);
                if ($new_modelscat) {
                    $new_model->id_object = $new_modelscat->id_related;
                }
            }
        }
        $new_model->gen_url = $new_model->genUrlPath();
        if ($new_model->save()) {
            $new_model->path = $new_model->createPath();
            $new_model->update();
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
        $new_model->update();
    }

    public function actionDelete($id) {
        $this->findModel($id)->delete();
        return $this->redirect(['index']);
    }

    protected function findModel($id) {
        $model = AdminMenus::findOne($id);
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
