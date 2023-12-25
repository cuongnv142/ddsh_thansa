<?php

namespace app\modules\admin\controllers;

use app\components\FileUpload;
use app\components\GoogleTranslate;
use app\models\BoxpageMedia;
use app\modules\admin\components\AdminController;
use app\modules\admin\models\AdminBoxpage;
use app\modules\admin\models\AdminBoxpageCat;
use Yii;
use yii\filters\VerbFilter;
use yii\helpers\StringHelper;
use yii\web\NotFoundHttpException;
use yii\web\UploadedFile;

class BoxpageController extends AdminController {

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
        $searchModel = new AdminBoxpage();
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
        $model->setFieldUploadName('src')->uploadImage();
        return $model;
    }

    public function getBoxpageMedia() {
        $sessionKey = 'boxpage_tmp_image_ids';
        $idList = Yii::$app->session->get($sessionKey);
        $boxpageMedia = null;
        if ($idList === null || !is_array($idList)) {
            return $boxpageMedia;
        }
        $boxpageMedia = BoxpageMedia::find();
        $boxpageMedia->andFilterWhere([
            'id' => $idList,
        ]);
        $boxpageMedia->andFilterWhere(
                [
                    'in', 'sub_type', [BoxpageMedia::IMAGE_THUONG],
                ]
        );
        $boxpageMedia->andFilterWhere(
                [
                    'in', 'type', [FileUpload::type_image],
                ]
        );
        $boxpageMedia->orderBy('sort_order');
        return $boxpageMedia;
    }

    public function renderViewCreate($model) {
        return $this->render('create', [
                    'model' => $model,
                    'boxpageMedia' => $this->getBoxpageMedia(),
        ]);
    }

    public function actionCreate() {
        $model = new AdminBoxpage();
        $model->language = 'vi';
        if (!$model->load(Yii::$app->request->post())) {
            return $this->renderViewCreate($model);
        }
        $model = $this->setParamModel($model);
        if ($model->hasErrors() || !$model->save()) {
            return $this->renderViewCreate($model);
        }
        $this->uploadFiles($model);
        $this->saveByLang($model);
        return $this->redirectSuccessCreate($model);
    }

    public function uploadFiles($model) {
        if (!$model) {
            return;
        }
        $sort_file = Yii::$app->request->post('sort_image', array());
        if (!count($sort_file)) {
            return;
        }
        foreach ($sort_file as $key => $value) {
            $boxpageMedia = BoxpageMedia::findOne($key);
            if ($boxpageMedia) {
                $boxpageMedia->sort_order = (int) $value;
                $boxpageMedia->update();
            }
        }
        $map_file = Yii::$app->request->post('map_image', array());
        if (!$map_file) {
            return;
        }
        foreach ($map_file as $key => $value) {
            $itemMedia = BoxpageMedia::findOne($key);
            if ($itemMedia) {
                $itemMedia->boxpage_id = $model->id;
                $itemMedia->update();
            }
        }
        $sessionKey = 'boxpage_tmp_image_ids';
        Yii::$app->session->remove($sessionKey);
    }

    public function getBoxpageMediaUpdate($id) {
        $boxpageMedia = BoxpageMedia::find();
        $boxpageMedia->andFilterWhere([
            'boxpage_id' => $id,
        ]);
        $boxpageMedia->andFilterWhere(
                [
                    'in', 'sub_type', [BoxpageMedia::IMAGE_THUONG],
                ]
        );
        $boxpageMedia->andFilterWhere(
                [
                    'in', 'type', [FileUpload::type_image],
                ]
        );
        $boxpageMedia->orderBy('sort_order');
        return $boxpageMedia;
    }

    public function renderViewUpdate($model) {
        return $this->render('update', [
                    'model' => $model,
                    'boxpageMedia' => $this->getBoxpageMediaUpdate($model->id),
        ]);
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
        $this->uploadFiles($model);
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
        $new_model = new AdminBoxpage();
        $new_model->attributes = $model->attributes;
        if ($model->language == 'vi') {
            $new_model->language = 'en';
        } else {
            $new_model->language = 'vi';
        }
        $new_model->id_related = $model->id;
        $new_model->boxpage_cat_id = 0;
        if ($model->boxpage_cat_id) {
            $parent = AdminBoxpageCat::findOne($model->boxpage_cat_id);
            if ($parent) {
                $new_model->boxpage_cat_id = $parent->id_related;
            }
        }
        if ($new_model->save()) {
            $boxpageMedia = BoxpageMedia::find();
            $boxpageMedia->andFilterWhere([
                'boxpage_id' => $model->id,
            ]);
            $data = $boxpageMedia->all();
            if ($data) {
                foreach ($data as $item) {
                    $new_media = new BoxpageMedia();
                    $new_media->attributes = $item->attributes;
                    $new_media->boxpage_id = $new_model->id;
                    $new_media->id = NULL;
                    $new_media->save();
                }
            }
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
        if ($new_model->sub_name) {
            $text = $new_model->sub_name;
            $result = GoogleTranslate::translate($source, $target, $text);
            if ($result) {
                $new_model->sub_name = $result;
            }
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
        $new_model->update();
    }

    public function actionDelete($id) {
        $this->findModel($id)->delete();
        BoxpageMedia::deleteAll(['boxpage_id' => $id]);
        return $this->redirect(['index']);
    }

    protected function findModel($id) {
        $model = AdminBoxpage::findOne($id);
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

    public function actionSaveimages() {
        $user = Yii::$app->user->getIdentity();
        if ($user === null) {
            echo 'Bạn chưa đăng nhập';
            Yii::$app->end();
        }
        $userId = Yii::$app->user->identity->id;
        $request = Yii::$app->request;
        $boxpage_id = (int) $request->post('boxpage_id');
        $files = UploadedFile::getInstancesByName('imagefiles');
        $hasFile = false;
        $hasError = false;
        $msg = '';
        if (!$files) {
            $this->getErrorUpFile($hasError, $hasFile, $msg);
            Yii::$app->end();
        }
        foreach ($files as $file) {
            $hasFile = true;
            $filename = FileUpload::upload($file, 'project');
            if (!$filename['action']) {
                $hasError = true;
                $msg = $filename['mes'];
                continue;
            }
            $boxpageMedia = new BoxpageMedia();
            $boxpageMedia->boxpage_id = $boxpage_id;
            $boxpageMedia->name = '';
            $boxpageMedia->path = $filename['filename'];
            $boxpageMedia->type = FileUpload::type_image;
            $boxpageMedia->sub_type = BoxpageMedia::IMAGE_THUONG;
            $boxpageMedia->is_default = 0;
            $boxpageMedia->sort_order = 999;
            if (!$boxpageMedia->save()) {
                continue;
            }
            if ($boxpage_id == 0) {
                $sessionKey = 'boxpage_tmp_image_ids';
                $idList = Yii::$app->session->get($sessionKey);
                if ($idList === null || !is_array($idList)) {
                    $idList = array();
                }
                $idList[] = $boxpageMedia->id;
                Yii::$app->session->set($sessionKey, $idList);
            }
        }
        $this->getErrorUpFile($hasError, $hasFile, $msg);
        Yii::$app->end();
    }

    public function getErrorUpFile($hasError, $hasFile, $msg) {
        echo '<script>
            var hasError = ' . ($hasError ? 'true' : 'false') . ';
            var hasFile = ' . ($hasFile ? 'true' : 'false') . ';
            if (!hasFile) {
                window.parent.alert("Không có file nào được đẩy lên!");
            } else if (hasError) {
                window.parent.alert(\'' . ($msg ? $msg : 'Có lỗi xảy ra trong quá trình upload!') . '\');
            }
            window.parent.uploadPopComplete();
         </script>';
    }

    public function actionDeleteimage() {
        $request = Yii::$app->request;
        $id_image = (int) $request->post('pair');
        if (!$id_image) {
            echo json_encode(['err' => 2]);
            Yii::$app->end();
        }
        $model = BoxpageMedia::findOne($id_image);
        if (!$model) {
            echo json_encode(['err' => 1]);
            Yii::$app->end();
        }
        $model->delete();
        echo json_encode(['err' => 0]);
        Yii::$app->end();
    }

    public function actionDeleteallimage() {
        $request = Yii::$app->request;
        $ids = $request->post('ids', '');
        $boxpage_id = (int) $request->post('boxpage_id');
        if (!$ids) {
            echo json_encode(['err' => 2]);
            Yii::$app->end();
        }
        $arrId = explode(',', $ids);
        foreach ($arrId as $id_opro) {
            $model = BoxpageMedia::findOne($id_opro);
            if ($model && $model->boxpage_id == $boxpage_id) {
                $model->delete();
            }
        }
        echo json_encode(['err' => 0]);
        Yii::$app->end();
    }

    public function actionSavepdftitle() {
        $key = (int) Yii::$app->request->post('key', 0);
        $title = Yii::$app->request->post('title');
        if (!$key) {
            Yii::$app->end();
        }
        $boxpageMedia = BoxpageMedia::findOne($key);
        if (!$boxpageMedia) {
            Yii::$app->end();
        }
        $boxpageMedia->name = (string) $title;
        $boxpageMedia->update();
        echo json_encode(['err' => 0, 'title_sort' => StringHelper::truncate($title, 15)]);
        Yii::$app->end();
    }

}
