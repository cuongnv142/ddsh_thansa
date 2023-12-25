<?php

namespace app\modules\admin\controllers;

use app\components\FileUpload;
use app\modules\admin\components\AdminController;
use app\modules\admin\models\AdminDtvLoai;
use app\modules\admin\models\AdminDtvNganh;
use Yii;
use yii\filters\VerbFilter;
use yii\web\NotFoundHttpException;
use yii\web\UploadedFile;

/**
 * DtvloaiController implements the CRUD actions for DtvLoai model.
 */
class DtvloaiController extends AdminController {

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
     * Lists all DtvLoai models.
     * @return mixed
     */
    public function actionIndex() {
        $searchModel = new AdminDtvLoai();
        $searchModel->loai = AdminDtvNganh::DONG_VAT;
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
        $model->loai = (int) $model->loai;
        $model->muc_do_bao_ton_iucn = (int) $model->muc_do_bao_ton_iucn;
        $model->muc_do_bao_ton_sdvn = (int) $model->muc_do_bao_ton_sdvn;
        $model->muc_do_bao_ton_ndcp = (int) $model->muc_do_bao_ton_ndcp;
        $model->status = (int) $model->status;
        $model->id_dtv_ho = ((int) $model->id_dtv_ho) ? (int) $model->id_dtv_ho : NULL;
        if (Yii::$app->request->post('is_deleteifile_dinh_kem') == 'on') {
            $model->file_dinh_kem = NULL;
        }
        $files = UploadedFile::getInstancesByName('file_dinh_kem');
        $file_dinh_kems = [];
        if ($model->file_dinh_kem) {
            $file_dinh_kems = json_decode($model->file_dinh_kem, true);
        }
        if ($files) {
            foreach ($files as $file) {
                $filename = FileUpload::upload($file, 'dtv_loai');
                if ($filename['action']) {
                    $file_dinh_kems[] = $filename['filename'];
                }
            }
        }
        if (count($file_dinh_kems)) {
            $model->file_dinh_kem = json_encode($file_dinh_kems);
        }
        return $model;
    }

    public function actionCreate() {
        $model = new AdminDtvLoai();
        $model->loai = AdminDtvNganh::DONG_VAT;
        if (!$model->load(Yii::$app->request->post())) {
            return $this->renderViewCreate($model);
        }
        $model = $this->setParamModel($model);
        if ($model->hasErrors() || !$model->save()) {
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
        if ($model->hasErrors() || !$model->save()) {
            return $this->renderViewUpdate($model);
        }
        return $this->redirectSuccessUpdate($model);
    }

    public function actionDelete($id) {
        $this->findModel($id)->delete();
        return $this->redirect(['index']);
    }

    protected function findModel($id) {
        $model = AdminDtvLoai::findOne($id);
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

}
