<?php

namespace app\modules\admin\components;

use app\models\LogAction;
use Yii;
use yii\helpers\Url;
use yii\web\Controller;

class AdminController extends Controller {

    public $actionParams = [];
    public $layout = '@module/admin/views/layouts/main.php';

    public function returnLink($model) {
        $type_submit = Yii::$app->request->post('type_submit', 'edit');
        if ($type_submit == 'save') {
            return $this->redirect(['index']);
        }
        return $this->redirect(['update', 'id' => $model->id]);
    }

    public function redirectSuccessCreate($model) {
        Yii::$app->session->setFlash('success', 'Thêm mới thành công!');
        return $this->returnLink($model);
    }

    public function redirectSuccessUpdate($model) {
        Yii::$app->session->setFlash('success', 'Cập nhật thành công!');
        return $this->returnLink($model);
    }

    public function beforeAction($event) {
        Yii::$app->language = 'vi';
        $logAction = new LogAction();
        $logAction->url = Url::current([], true);
        $logAction->user_id = Yii::$app->user->identity->id;
        $logAction->username = Yii::$app->user->identity->email ? Yii::$app->user->identity->email : Yii::$app->user->identity->phone;
        $logAction->ip = Yii::$app->getRequest()->getUserIP();
        $logAction->module = $this->module->id;
        $logAction->controller = Yii::$app->controller->id;
        $logAction->action = Yii::$app->controller->action->id;
        $logAction->created_at = date('Y-m-d H:i:s');
        $logAction->save();
        return parent::beforeAction($event);
    }

    public function renderViewCreate($model) {
        return $this->render('create', ['model' => $model]);
    }

    public function renderViewUpdate($model) {
        return $this->render('update', ['model' => $model]);
    }

    public function exitErrorAjax($mes) {
        exit(json_encode(array('action' => "error", 'content' => $mes)));
    }

    public function exitSuccessAjax() {
        exit(json_encode(array('action' => "success", 'content' => '')));
    }

}
