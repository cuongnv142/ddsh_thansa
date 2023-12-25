<?php

namespace app\modules\admin\controllers;

use yii\data\ActiveDataProvider;
use yii\web\UploadedFile;
use app\components\FileUpload;
use \Yii;
use app\models\ImageGeneral;
use yii\validators\FileValidator;
use app\models\ImageGeneralDirectory;
use app\modules\admin\components\AdminController;

class ImageController extends AdminController {

    public function actionBrowse() {
        $this->layout = false;

        $id_dir = (int) Yii::$app->request->get('id_dir');
        $searchModel = new ImageGeneral();
        $query = ImageGeneral::find()
                ->filterWhere(['id_dir' => $id_dir])
                ->orderBy(['id' => SORT_DESC]);
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 150,
            ],
        ]);

        $arrDir = $this->nodetree();


        return $this->render('browse', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
                    'arrDir' => $arrDir,
                    'id_dir' => $id_dir
        ]);
    }

    private function nodetree($param = array()) {
        $refs = array();
        $list = array();

        $nodes = Yii::$app->db->createCommand('select * from image_general_directory where id>2')->queryAll();

        foreach ($nodes as $data) {
            $thisref = &$refs[$data['id']];
            $thisref['parent_id'] = $data['parent_id'];
            $thisref['text'] = $data['name'];
            if ($data['parent_id'] == 0) {
                $list[$data['id']] = &$thisref;
            } else {
                $refs[$data['parent_id']]['children'][$data['id']] = &$thisref;
            }
        }
        return $list;
    }

    public function actionUpload() {
        $user = Yii::$app->user->getIdentity();
        $funcNum = Yii::$app->request->get('CKEditorFuncNum');
        $url = '';
        $message = '';
        if ($user === null) {
            $message = 'Bạn chưa đăng nhập';
            $this->getErrorUpload($funcNum, $url, $message);
            \Yii::$app->end();
        }
        $file = UploadedFile::getInstanceByName('upload');
        if (!$file) {
            $this->getErrorUpload($funcNum, $url, $message);
            \Yii::$app->end();
        }
        $config = ['extensions' => 'jpg, png, jpeg, bmp, gif', 'maxSize' => 1024 * 1024 * 5];
        $validator = new FileValidator($config);
        if (!$validator->validate($file, $error)) {
            $message = $error;
            $this->getErrorUpload($funcNum, $url, $message);
            \Yii::$app->end();
        }
        $filename = FileUpload::upload($file, 'editor');
        if (!$filename['action']) {
            $message = $filename['mes'];
            $this->getErrorUpload($funcNum, $url, $message);
            \Yii::$app->end();
        }
        $url = FileUpload::originalfile($filename['filename']);
        $imageDeal = new ImageGeneral();
        $imageDeal->object_id = 0;
        $imageDeal->user_id = Yii::$app->user->identity->id;
        $imageDeal->name = $filename['filename'];
        $imageDeal->created_at = date('Y-m-d H:i:s');
        $imageDeal->status = 1;
        if (strpos($file->type, 'image') !== false) {
            $imageDeal->type = FileUpload::type_image;
        } else {
            $imageDeal->type = FileUpload::type_video;
        }
        $imageDeal->save();

        $this->getErrorUpload($funcNum, $url, $message);
        \Yii::$app->end();
    }

    public function getErrorUpload($funcNum, $url, $message) {
        echo "<script type='text/javascript'>window.parent.CKEDITOR.tools.callFunction($funcNum, '$url', '$message');</script>";
    }

    public function actionUploadfiles() {
        $user = Yii::$app->user->getIdentity();
        if ($user === null) {
            $message = 'Bạn chưa đăng nhập';
            echo $message;
            \Yii::$app->end();
        }
        $userId = \Yii::$app->user->identity->id;
        $request = Yii::$app->request;
        $id_dir = $request->post('id_dir');
        $files = UploadedFile::getInstancesByName('inputfiles');
        $change_name = Yii::$app->request->get('change_name', '');
        $hasError = 0;
        $mesError = '';
        $isEmpty = true;
        if (!$files) {
            $this->getErrorUpFile($hasError, $mesError, $isEmpty);
            Yii::$app->end();
        }
        foreach ($files as $file) {
            $isEmpty = false;
            $name = '';
            if ($change_name == '0') {
                $name = $file->baseName . '.' . $file->extension;
            }
            $file_type = FileUpload::type_image;
            if ($file->extension == 'pdf') {
                $file_type = FileUpload::type_pdf;
            }

            $filename = FileUpload::upload($file, 'editor', $file_type, 1, $name);
            if (!$filename['action']) {
                if (isset($filename['mes'])) {
                    $mesError = $filename['mes'];
                }
                $hasError = 1;
                continue;
            }
            $imageDeal = new ImageGeneral();
            $imageDeal->object_id = 0;
            $imageDeal->user_id = Yii::$app->user->identity->id;
            $imageDeal->name = $filename['filename'];
            $imageDeal->created_at = date('Y-m-d H:i:s');
            $imageDeal->status = 1;
            $imageDeal->id_dir = $id_dir;
            $imageDeal->type = $this->getTypeFile($file->type);
            $imageDeal->save();
        }

        $this->getErrorUpFile($hasError, $mesError, $isEmpty);
        Yii::$app->end();
    }

    public function getTypeFile($type) {
        if (strpos($type, 'image') !== false) {
            return FileUpload::type_image;
        }
        if (strpos($type, 'pdf') !== false) {
            return FileUpload::type_pdf;
        }
        return FileUpload::type_video;
    }

    public function getErrorUpFile($hasError, $mesError, $isEmpty) {
        if ($hasError !== 0) {
            if (!$mesError) {
                $mesError = 'Upload file lỗi do quá nặng!';
            }
            echo '<script>
                window.parent.alert(\'' . $mesError . '\');
                </script>';
        }
        if ($isEmpty) {
            echo '<script>
                window.parent.alert("Không có file nào được upload lên! Chưa chọn file hoặc file quá nặng?");
                </script>';
        }
        echo '<script>
                window.parent.uploadComplete();
             </script>';
    }

    public function actionDelete() {
        $request = Yii::$app->request;
        $id = $request->post('id');
        $model = ImageGeneral::findOne($id);
        if (!$model) {
            echo json_encode(['err' => 1]);
            Yii::$app->end();
        }
        $model->delete();
        echo json_encode(['err' => 0]);
        Yii::$app->end();
    }

    public function actionDeleteimage() {
        $request = Yii::$app->request;
        $id = $request->post('id');
        $model = ImageGeneral::findOne($id);
        if (!$model) {
            echo json_encode(['err' => 1]);
            Yii::$app->end();
        }
        FileUpload::deletefile($model->name);
        $model->delete();
        echo json_encode(['err' => 0]);
        Yii::$app->end();
    }

    public function actionMkdir() {
        $user = Yii::$app->user->getIdentity();
        if ($user === null) {
            echo json_encode(['err' => 403]);
            Yii::$app->end();
        }
        $request = Yii::$app->request;
        $id_parent = (int) $request->post('id_parent');
        $name = $request->post('name');
        $err = 0;
        if (strlen($name) < 1) {
            $err = 1;
        } elseif (strlen($name) > 255) {
            $err = 2;
        } elseif (!preg_match('@^[0-9 A-Za-z_' . preg_quote('-', '@') . ']+$@', $name)) {
            $err = 3;
        }

        if ($err !== 0) {
            echo json_encode(['err' => $err]);
            Yii::$app->end();
        }
        $dir = new ImageGeneralDirectory();
        $dir->parent_id = $id_parent;
        $dir->name = $name;
        $dir->save();
        echo json_encode(['err' => 0, 'id' => $dir->id, 'name' => $name, 'children' => false]);
        Yii::$app->end();
    }

    public function actionRenamedir() {
        $request = Yii::$app->request;
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $id = (int) str_replace('h', '', $request->post('id'));
        $name = $request->post('name_new');
        $err = 0;
        if (strlen($name) < 1) {
            $err = 1;
        } elseif (strlen($name) > 255) {
            $err = 2;
        } elseif (!preg_match('@^[0-9 A-Za-z_' . preg_quote('-', '@') . ']+$@', $name)) {
            $err = 3;
        }

        if ($err !== 0) {
            echo json_encode(['err' => $err]);
            Yii::$app->end();
        }
        $dir = ImageGeneralDirectory::findOne(['id' => $id]);
        if ($dir !== null) {
            $dir->name = $name;
            $dir->save();
        }
        echo json_encode(['err' => 0]);
        Yii::$app->end();
    }

    public function actionRemovedir() {
        $user = Yii::$app->user->getIdentity();
        if ($user === null) {
            echo json_encode(['err' => 403]);
            Yii::$app->end();
        }
        $request = Yii::$app->request;
        $id = (int) str_replace('h', '', $request->post('id'));
        $err = 0;
        $dir = ImageGeneralDirectory::findOne(['id' => $id]);
        if ($dir) {
            $err = 404;
            echo json_encode(['err' => $err]);
            Yii::$app->end();
        }
        $nbChild = ImageGeneralDirectory::find()->filterWhere(['parent_id' => $id])->count();
        if ($nbChild > 0) {
            $err = 1;
            echo json_encode(['err' => $err]);
            Yii::$app->end();
        }
        $image = ImageGeneral::findOne(['id_dir' => $id]);
        if ($image !== null) {
            $err = 2; // Con anh
            echo json_encode(['err' => $err]);
            Yii::$app->end();
        }

        if ($err !== 0) {
            echo json_encode(['err' => $err]);
            Yii::$app->end();
        }
        $dir->delete();
        echo json_encode(['err' => 0]);
        Yii::$app->end();
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

    public function actionGetroot() {
        $id = (int) (Yii::$app->request->get('rid'));
        $model = ImageGeneralDirectory::findOne($id);
        if (!$model && $id == 1) {
            $model = new ImageGeneralDirectory();
            $model->id = 1;
            $model->name = 'Root';
            $model->parent_id = 0;
            $model->save();
        }
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        if ($id == 0) {
            $roots = [];
            $roots[] = array('id' => 'h0', 'text' => 'NONE', 'children' => false);
            $rows = ImageGeneralDirectory::find()->andFilterWhere(['parent_id' => 0])->andFilterWhere(['>', 'id', 3])->all();
            foreach ($rows as $row) {
                $hasChild = ImageGeneralDirectory::find()->andFilterWhere(['parent_id' => $row->id])->count() > 0;
                $roots[] = array('id' => 'h' . $row->id, 'text' => $row->name, 'children' => $hasChild);
            }
        } else {
            $roots = [];
            $rows = ImageGeneralDirectory::find()->andFilterWhere(['id' => $id])->all();
            foreach ($rows as $row) {
                $hasChild = ImageGeneralDirectory::find()->andFilterWhere(['parent_id' => $row->id])->count() > 0;
                $roots[] = array('id' => 'h' . $row->id, 'text' => $row->name, 'children' => $hasChild);
            }
        }
        return $roots;
    }

    public function actionGetchildren() {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $id = (int) str_replace('h', '', Yii::$app->request->get('id'));
        $roots = [];

        $rows = ImageGeneralDirectory::find()->andFilterWhere(['parent_id' => $id])->all();
        foreach ($rows as $row) {
            $hasChild = ImageGeneralDirectory::find()->andFilterWhere(['parent_id' => $row->id])->count() > 0;
            $roots[] = array('id' => 'h' . $row->id, 'text' => $row->name, 'children' => $hasChild);
        }

        return $roots;
    }

    public function actionGetatree() {
        $id = (int) Yii::$app->request->get('id');
        $leaf = ImageGeneralDirectory::findOne(['id' => $id]);
        $me = $leaf;
        while (true) {
            if ($me->parent_id != 0) {
                $parent = ImageGeneralDirectory::findOne(['id' => $leaf->parent_id]);
                $me = $parent;
            } else {
                break;
            }
        }
        return $parent->id;
    }

    /**
     * Kiem tra xem cau hinh upload cua server toi da la bao nhieu
     */
    public function actionGetserverinfo() {
        $keys = ['upload_max_filesize', 'post_max_size', 'memory_limit'];
        echo 'PHP Version: ' . PHP_VERSION . '<br />';
        foreach ($keys as $key) {
            echo "<strong>$key</strong>: " . ini_get($key) . '<br/>';
        }
    }

    public function actionUploadimage() {
        $id_dir = (int) Yii::$app->request->get('id_dir', 1);
        if (!$id_dir) {
            $id_dir = 1;
        }
        $searchModel = new ImageGeneral();
        $query = ImageGeneral::find()
                ->filterWhere(['id_dir' => $id_dir])
                ->orderBy(['id' => SORT_DESC]);
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 150,
            ],
        ]);
        return $this->render('uploadimage', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
                    'id_dir' => $id_dir
        ]);
    }

    public function actionDeletesimage() {
//        $this->validateCSRF();
        $request = Yii::$app->request;
        $ids = $request->post('ids');
        if (!$ids) {
            echo json_encode(['err' => 1]);
            Yii::$app->end();
        }
        $arr = explode(',', $ids);
        for ($i = 0; $i < count($arr); $i++) {
            $model = ImageGeneral::findOne($arr[$i]);
            if (!$model) {
                continue;
            }
            FileUpload::deletefile($model->name);
            $model->delete();
        }
        echo json_encode(['err' => 0]);

        Yii::$app->end();
    }

}
