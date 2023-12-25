<?php

namespace app\modules\admin\controllers;

use app\modules\admin\components\AdminController;
use app\modules\admin\models\AdminSubscribe;
use Yii;
use yii\filters\VerbFilter;
use yii\web\NotFoundHttpException;

/**
 * SubscribeController implements the CRUD actions for AdminSubscribe model.
 */
class SubscribeController extends AdminController {

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

    public function actionExport() {
        $this->layout = false;
        $searchModel = new AdminSubscribe();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams, false);

        return $this->renderPartial('export', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    public function actionIndex() {
        $searchModel = new AdminSubscribe();
        $type = 0;
        $searchModel->type = $type;
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
                    'type' => $type,
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Creates a new AdminSubscribe model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate() {
        $model = new AdminSubscribe();

        if (!$model->load(Yii::$app->request->post())) {
            return $this->renderViewCreate($model);
        }
        if (!$model->save()) {
            return $this->renderViewCreate($model);
        }
        return $this->redirectSuccessCreate($model);
    }

    /**
     * Updates an existing AdminSubscribe model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id) {
        $model = $this->findModel($id);
        if (!$model->load(Yii::$app->request->post())) {
            return $this->renderViewUpdate($model);
        }
        if (!$model->save()) {
            return $this->renderViewUpdate($model);
        }
        return $this->redirectSuccessUpdate($model);
    }

    /**
     * Deletes an existing AdminSubscribe model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionDelete($id) {

        $model = $this->findModel($id);
        $type = $model->type;
        $model->delete();
        if ($type) {
            return $this->redirect(['index', 'type' => $type]);
        } else {
            return $this->redirect(['index']);
        }
    }

    /**
     * Finds the AdminSubscribe model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return AdminSubscribe the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        $model = AdminSubscribe::findOne($id);
        if (!$model) {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
        return $model;
    }

}
