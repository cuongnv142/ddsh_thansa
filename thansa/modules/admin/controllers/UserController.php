<?php

namespace app\modules\admin\controllers;

use app\models\CitiesDistrict;
use app\modules\admin\components\AdminController;
use app\modules\admin\models\AdminUser;
use Yii;
use yii\filters\VerbFilter;
use yii\web\NotFoundHttpException;

/**
 * UserController implements the CRUD actions for AdminUser model.
 */
class UserController extends AdminController {

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
        $searchModel = new AdminUser();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    public function actionExport() {
        $this->layout = false;
        $searchModel = new AdminUser();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams, false);

        return $this->renderPartial('export', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single AdminUser model.
     * @param string $id
     * @return mixed
     */
    public function actionView() {
        $id = Yii::$app->getUser()->getId();
        $model = $this->findModel($id);

        $model->city_name = ($model->cities_id) ? CitiesDistrict::getNameById($model->cities_id) : '';
        $model->district_name = ($model->cities_district_id) ? CitiesDistrict::getNameById($model->cities_district_id) : '';
        $model->status = AdminUser::$dataStatus[$model->status];

        return $this->render('view', [
                    'model' => $model,
        ]);
    }

    /**
     * Creates a new AdminUser model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function setParamModel($model) {
        if (!$model) {
            return $model;
        }
        $model->dob = ($model->dob) ? Yii::$app->getFormatter()->format($model->dob, ['date', 'yyyy-MM-dd']) : null;
        $model->cities_id = ($model->cities_id) ? $model->cities_id : 0;
        $model->cities_district_id = ($model->cities_district_id) ? $model->cities_district_id : 0;
        $model->setFieldUploadName('avatar')->uploadImage();
        if (!$model->gender) {
            $model->gender = 'OTHER';
        }
        return $model;
    }

    public function actionCreate() {
        $model = new AdminUser();
        $model->scenario = 'create';
        $model->loadDefaultValues();
        $model->is_admin = 1;
        if (!$model->load(Yii::$app->request->post())) {
            return $this->renderViewCreate($model);
        }
        $model = $this->setParamModel($model);
        $pass_code = $model->password;
        if ($model->password == $model->password_repeat) {
            $model->password_repeat = $model->password = $model->generatePassword($model->password);
        } else {
            $model->password = $model->generatePassword($model->password);
        }
        if (!$model->save()) {
            $model->dob = ($model->dob) ? Yii::$app->getFormatter()->format($model->dob, ['date', 'dd-MM-yyyy']) : '';
            $model->password = '';
            $model->password_repeat = '';
            return $this->renderViewCreate($model);
        }
        if ($model->role) {
            $this->saveRole($model->id, $model->role);
        }
        return $this->redirectSuccessCreate($model);
    }

    public function actionUpdate($id) {
        $model = $this->findModel($id);
        $model->scenario = 'update';
        $model->dob = ($model->dob) ? Yii::$app->getFormatter()->format($model->dob, ['date', 'dd-MM-yyyy']) : '';
        $old_role = $model->role;
        if (!$model->load(Yii::$app->request->post())) {
            return $this->renderViewUpdate($model);
        }
        $model = $this->setParamModel($model);
        if (!$model->save()) {
            $model->dob = ($model->dob) ? Yii::$app->getFormatter()->format($model->dob, ['date', 'dd-MM-yyyy']) : '';
            return $this->renderViewUpdate($model);
        }
        if ($old_role != $model->role) {
            $this->saveRole($model->id, $model->role);
        }
        return $this->redirectSuccessUpdate($model);
    }

    public function saveRole($user_id, $role) {
        if (!$user_id) {
            return;
        }
        if (!AdminUser::is_adminsupper() && $role == 'admin') {
            return false;
        }
        $command = Yii::$app->db->createCommand();
        if (!trim($role)) {
            $command->delete('auth_assignment', 'user_id=:user_id', array(':user_id' => $user_id))->execute();
        } else {
            $command->delete('auth_assignment', 'user_id=:user_id', array(':user_id' => $user_id))->execute();
            $query = 'insert ignore into auth_assignment(item_name,user_id) values("' . $role . '",' . $user_id . ')';
            $command = Yii::$app->db->createCommand($query)->execute();
        }
    }

    public function renderViewEdit($model) {
        return $this->render('edit', ['model' => $model]);
    }

    public function actionEdit() {
        $id = Yii::$app->getUser()->getId();
        $model = $this->findModel($id);
        $model->scenario = 'edit';
        $model->dob = ($model->dob) ? Yii::$app->getFormatter()->format($model->dob, ['date', 'dd-MM-yyyy']) : '';
        if (!$model->load(Yii::$app->request->post())) {
            return $this->renderViewEdit($model);
        }
        $model = $this->setParamModel($model);
        if (!$model->save()) {
            $model->dob = ($model->dob) ? Yii::$app->getFormatter()->format($model->dob, ['date', 'dd-MM-yyyy']) : '';
            return $this->renderViewEdit($model);
        }
        Yii::$app->session->setFlash('success', 'Cập nhật thành công!');
        return $this->redirect(['view']);
    }

    public function actionChangepwd() {
        $id = Yii::$app->getUser()->getId();
        $model = $this->findModel($id);
        $model->scenario = 'changepwd';
        if (!$model->load(Yii::$app->request->post()) || !$model->validate()) {
            return $this->render('changepwd', [
                        'model' => $model,
            ]);
        }
        $model->password = $model->generatePassword($model->new_pass);
        if (!$model->save(false)) {
            return $this->render('changepwd', [
                        'model' => $model,
            ]);
        }
        Yii::$app->session->setFlash('success', 'Thay đổi mật khẩu thành công!');
        return $this->redirect(['view']);
    }

    /**
     * Deletes an existing AdminUser model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionDelete($id) {
        $this->findModel($id)->delete();
        Yii::$app->session->setFlash('success', 'Xóa user thành công');
        return $this->redirect(['index']);
    }

    /**
     * Finds the AdminUser model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return AdminUser the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        $model = AdminUser::findOne($id);
        if (!$model) {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
        return $model;
    }

    public function actionListcpwd() {
        $searchModel = new AdminUser();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $model = new AdminUser();
        $model->scenario = 'editpwd';

        return $this->render('listcpwd', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
                    'model' => $model,
        ]);
    }

    public function actionEditpwd() {
        $param = Yii::$app->request->post('AdminUser');
        $id = (int) isset($param['id']) ? $param['id'] : 0;
        $model = $this->findModel($id);
        $model->scenario = 'editpwd';
        if (!$model->load(Yii::$app->request->post())) {
            echo $this->renderPartial('editpwd', [
                'model' => $model,
                    ], true);
            Yii::$app->end();
        }
        if (!$model->validate()) {
            echo json_encode($model->getFirstErrors());
            Yii::$app->end();
        }
        $model->password = $model->generatePassword($model->new_pass);
        if (!$model->save(false)) {
            Yii::$app->end();
        }
        echo json_encode(['success' => true]);
        Yii::$app->end();
    }

}
