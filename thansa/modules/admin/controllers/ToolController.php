<?php

namespace app\modules\admin\controllers;

use app\modules\admin\components\AdminController;
use Yii;

class ToolController extends AdminController {

    public function actionCheckuploadfile() {
        if (Yii::$app->request->isPost) {
            var_dump($_FILES);
        }
        return $this->render('checkupload');
    }

}
