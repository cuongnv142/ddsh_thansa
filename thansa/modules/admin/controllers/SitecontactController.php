<?php

namespace app\modules\admin\controllers;

use app\modules\admin\components\AdminController;
use app\modules\admin\models\AdminSiteContact;
use Yii;
use yii\filters\VerbFilter;
use yii\web\NotFoundHttpException;

/**
 * SitecontactController implements the CRUD actions for AdminSiteContact model.
 */
class SitecontactController extends AdminController {

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
     * Lists all AdminSiteContact models.
     * @return mixed
     */
    public function actionIndex() {
        $searchModel = new AdminSiteContact();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    public function setParamModel($model) {
        if ($model) {
            $model->setFieldUploadName('link_logo')->uploadImage();
            $model->setFieldUploadName('link_logo_footer')->setIsImageDeleteName('is_deleteimagefooter')->uploadImage();
        }
        return $model;
    }

    public function actionCreate() {
        $model = new AdminSiteContact();
        if (!$model->load(Yii::$app->request->post())) {
            return $this->renderViewCreate($model);
        }
        $model = $this->setParamModel($model);
        if (!$model->save()) {
            return $this->renderViewCreate($model);
        }
        return $this->redirectSuccessCreate($model);
    }

    public function actionUpdate($id) {
        $model = $this->findModel($id);

        if (!$model->load(Yii::$app->request->post())) {
            return $this->renderViewUpdate($model);
        }
        $model = $this->setParamModel($model);
        if (!$model->save()) {
            return $this->renderViewUpdate($model);
        }
        return $this->redirectSuccessUpdate($model);
    }

    /**
     * Deletes an existing AdminSiteContact model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionDelete($id) {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the AdminSiteContact model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return AdminSiteContact the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        $model = AdminSiteContact::findOne($id);
        if (!$model) {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
        return $model;
    }

}
