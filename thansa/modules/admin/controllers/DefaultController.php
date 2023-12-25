<?php

namespace app\modules\admin\controllers;

use app\components\FileUpload;
use app\models\LogActionAdmin;
use app\modules\admin\components\AdminController;
use Yii;
use yii\web\NotFoundHttpException;
use yii\web\UploadedFile;

class DefaultController extends AdminController {

    const _duration = 600;

    public function actionIndex() {
        $this->getView()->title = Yii::$app->params['appName'] . ' Admin';
        return $this->render('index', [
        ]);
    }

    public function actionUploadimage() {
        $reVal = array();
        $reVal['action'] = false;
        $file = UploadedFile::getInstanceByName('file');
        if (!$file) {
            echo json_encode($reVal);
            \Yii::$app->end();
        }
        $filename = FileUpload::upload($file, 'editor');
        if (!$filename['action']) {
            echo json_encode($reVal);
            \Yii::$app->end();
        }
        $reVal['action'] = true;
        $reVal['url'] = FileUpload::originalfile($filename['filename']);
        echo json_encode($reVal);
        \Yii::$app->end();
    }

    public function actionLogadmin() {
        $searchModel = new LogActionAdmin();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        return $this->render('logadmin', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    public function actionDeletelogadmin($id) {
        $this->findModelLogAdmin($id)->delete();
        return $this->redirect(['logadmin']);
    }

    protected function findModelLogAdmin($id) {
        $model = LogActionAdmin::findOne($id);
        if (!$model) {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
        return $model;
    }

    public function actionViewlogadmin($id) {
        $model = $this->findModelLogAdmin($id);
        return $this->render('viewlogadmin', [
                    'model' => $model,
        ]);
    }

}
