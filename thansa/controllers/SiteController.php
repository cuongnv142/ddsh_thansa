<?php

namespace app\controllers;

use app\components\CController;
use app\helpers\CustomizeHelper;
use app\helpers\LogIPHelper;
use app\models\EmailLetter;
use app\models\LoginForm;
use app\models\LogSubscribeError;
use app\models\Subscribe;
use app\models\User;
use Yii;
use yii\data\Pagination;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\helpers\HtmlPurifier;
use yii\helpers\Json;
use yii\helpers\Url;
use yii\validators\EmailValidator;
use yii\web\NotFoundHttpException;

class SiteController extends CController {

    public $successUrl = '';

    public function behaviors() {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    public function actions() {
        return [
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_DEV ? 'testme' : null,
            ],
            'auth' => [
                'class' => 'yii\authclient\AuthAction',
                'successCallback' => [$this, 'successCallback'],
            ],
        ];
    }

    public function actionError() {
        return $this->render('error', [
        ]);
    }

    public function actionIndex() {

        $languageNew = Yii::$app->request->get('language', '');
        if (Yii::$app->language != 'vi') {
            if (!$languageNew) {
                return $this->redirect(['/site/index', 'language' => Yii::$app->language]);
            }
        }

        return $this->render('index');
    }

    public function getLoaiCurent() {
        $id_news = Yii::$app->getRequest()->getQueryParam('id', '');
        $loai = false;
        if ($id_news) {
            $loai = CustomizeHelper::getLoaiByID($id_news);
        }
        if ($loai) {
            return $loai;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionViewloai() {
        $loai = $this->getLoaiCurent();
        if ($loai) {

            $datarelated = CustomizeHelper::createLoaiQuery($loai['loai'], ['<>', 't.id', $loai['id']], [], 5)->all();
            return $this->render('viewloai', [
                        'model' => $loai,
                        'datarelated' => $datarelated,
            ]);
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
    // Danh sách động vật
    public function actionTruyxuat() {
        //$id_dtv = Yii::$app->getRequest()->getQueryParam('id_dtv', '');
        $id_dtv = 1;
        //if ($id_nganh = (int) Yii::$app->getRequest()->getQueryParam('id_nganh', 0)) {
            $id_nganh = (int) Yii::$app->getRequest()->getQueryParam('id_nganh', 0);
        //} else {
        //    $id_nganh = 1;
        //}
        $id_lop = (int) Yii::$app->getRequest()->getQueryParam('id_lop', 0);
        $id_bo = (int) Yii::$app->getRequest()->getQueryParam('id_bo', 0);
        $id_ho = (int) Yii::$app->getRequest()->getQueryParam('id_ho', 0);
        $id_iucn = (int) Yii::$app->getRequest()->getQueryParam('id_iucn', 0);
        $id_sdvn = (int) Yii::$app->getRequest()->getQueryParam('id_sdvn', 0);
        $id_ndcp = (int) Yii::$app->getRequest()->getQueryParam('id_ndcp', 0);
        $id_ndcp64 = (int) Yii::$app->getRequest()->getQueryParam('id_ndcp64', 0);
        $name_kh = Yii::$app->getRequest()->getQueryParam('name_kh', '');
        $name_tv = Yii::$app->getRequest()->getQueryParam('name_tv', '');
        $page = (int) Yii::$app->getRequest()->getQueryParam('page', 1);
        $pagecurrent = ($page - 1);
        $pageSize = 20;
        $offset = $pagecurrent * $pageSize;
        $where = [];

        if ($id_dtv != '') {
            if (empty($where)) {
                $where[] = 'AND';
            }
            $where[] = ['t.loai' => (int) $id_dtv];
        }
        $id_dtv = (int) $id_dtv;

        if ($id_nganh) {
            if (empty($where)) {
                $where[] = 'AND';
            }
            $where[] = ['nganh.id' => $id_nganh];
        }
        if ($id_lop) {
            if (empty($where)) {
                $where[] = 'AND';
            }
            $where[] = ['lop.id' => $id_lop];
        }
        if ($id_bo) {
            if (empty($where)) {
                $where[] = 'AND';
            }
            $where[] = ['bo.id' => $id_bo];
        }
        if ($id_ho) {
            if (empty($where)) {
                $where[] = 'AND';
            }
            $where[] = ['id_dtv_ho' => $id_ho];
        }
        if ($id_iucn) {
            if (empty($where)) {
                $where[] = 'AND';
            }
            $where[] = ['muc_do_bao_ton_iucn' => $id_iucn];
        }
        if ($id_sdvn) {
            if (empty($where)) {
                $where[] = 'AND';
            }
            $where[] = ['muc_do_bao_ton_sdvn' => $id_sdvn];
        }
        if ($id_ndcp) {
            if (empty($where)) {
                $where[] = 'AND';
            }
            $where[] = ['muc_do_bao_ton_ndcp' => $id_ndcp];
        }
        if ($id_ndcp64) {
            if (empty($where)) {
                $where[] = 'AND';
            }
            $where[] = ['muc_do_bao_ton_nd64cp' => $id_ndcp64];
        }
        if ($name_tv) {
            if (empty($where)) {
                $where[] = 'AND';
            }
            $where[] = ['like', 't.name', $name_tv];
        }
        if ($name_kh) {
            if (empty($where)) {
                $where[] = 'AND';
            }
            $where[] = ['like', 't.name_latinh', $name_kh];
        }
        // Tổng quan về động vật


        
        $data = false;
        $pagination = false;
        if (!empty($where)) {
            $query = CustomizeHelper::createLoaiQuery('', $where, [], $pageSize, $offset);
            $data = $query->all();
            $totalCount = (int) $query->limit(-1)->offset(-1)->orderBy([])->count();
            $pagination = new Pagination(['totalCount' => $totalCount, 'defaultPageSize' => $pageSize]);
        }

        return $this->render('truyxuat', [
                    'count' => $totalCount,
                    'data' => $data,
                    'pageSize' => $pageSize,
                    'pagecurrent' => $pagecurrent,
                    'pagination' => $pagination,
                    'id_dtv' => $id_dtv,
                    'id_nganh' => $id_nganh,
                    'id_lop' => $id_lop,
                    'id_bo' => $id_bo,
                    'id_ho' => $id_ho,
                    'id_iucn' => $id_iucn,
                    'id_sdvn' => $id_sdvn,
                    'id_ndcp' => $id_ndcp,
                    'id_ndcp64' => $id_ndcp64,
                    'name_kh' => $name_kh,
                    'name_tv' => $name_tv,
        ]);
    }
    // Danh sách thực vật
    public function actionTruyxuattv() {

        //$id_dtv = Yii::$app->getRequest()->getQueryParam('id_dtv', '');
        $id_dtv = 0;
        //if ($id_nganh = (int) Yii::$app->getRequest()->getQueryParam('id_nganh', 0)) {
        $id_nganh = (int) Yii::$app->getRequest()->getQueryParam('id_nganh', 0);
       // } else {
           // $id_nganh = 1;
        //}
        $id_lop = (int) Yii::$app->getRequest()->getQueryParam('id_lop', 0);
        $id_bo = (int) Yii::$app->getRequest()->getQueryParam('id_bo', 0);
        $id_ho = (int) Yii::$app->getRequest()->getQueryParam('id_ho', 0);
        $id_iucn = (int) Yii::$app->getRequest()->getQueryParam('id_iucn', 0);
        $id_sdvn = (int) Yii::$app->getRequest()->getQueryParam('id_sdvn', 0);
        $id_ndcp = (int) Yii::$app->getRequest()->getQueryParam('id_ndcp', 0);
        $id_ndcp64 = (int) Yii::$app->getRequest()->getQueryParam('id_ndcp64', 0);
        $name_kh = Yii::$app->getRequest()->getQueryParam('name_kh', '');
        $name_tv = Yii::$app->getRequest()->getQueryParam('name_tv', '');
        $page = (int) Yii::$app->getRequest()->getQueryParam('page', 1);
        $pagecurrent = ($page - 1);
        $pageSize = 20;
        $offset = $pagecurrent * $pageSize;
        $where = [];

        //if ($id_dtv != '') {
            //if (empty($where)) {
                $where[] = 'AND';
            //}
            $where[] = ['t.loai' => (int) $id_dtv];

        //}
        
        $id_dtv = (int) $id_dtv;

        if ($id_nganh) {
            if (empty($where)) {
                $where[] = 'AND';
            }
            $where[] = ['nganh.id' => $id_nganh];
        }
        if ($id_lop) {
            if (empty($where)) {
                $where[] = 'AND';
            }
            $where[] = ['lop.id' => $id_lop];
        }
        if ($id_bo) {
            if (empty($where)) {
                $where[] = 'AND';
            }
            $where[] = ['bo.id' => $id_bo];
        }
        if ($id_ho) {
            if (empty($where)) {
                $where[] = 'AND';
            }
            $where[] = ['id_dtv_ho' => $id_ho];
        }
        if ($id_iucn) {
            if (empty($where)) {
                $where[] = 'AND';
            }
            $where[] = ['muc_do_bao_ton_iucn' => $id_iucn];
        }
        if ($id_sdvn) {
            if (empty($where)) {
                $where[] = 'AND';
            }
            $where[] = ['muc_do_bao_ton_sdvn' => $id_sdvn];
        }
        if ($id_ndcp) {
            if (empty($where)) {
                $where[] = 'AND';
            }
            $where[] = ['muc_do_bao_ton_ndcp' => $id_ndcp];
        }
        if ($id_ndcp64) {
            if (empty($where)) {
                $where[] = 'AND';
            }
            $where[] = ['muc_do_bao_ton_nd64cp' => $id_ndcp64];
        }
        if ($name_tv) {
            if (empty($where)) {
                $where[] = 'AND';
            }
            $where[] = ['like', 't.name', $name_tv];
        }
        if ($name_kh) {
            if (empty($where)) {
                $where[] = 'AND';
            }
            $where[] = ['like', 't.name_latinh', $name_kh];
        }
        $data = false;
        $pagination = false;
        if (!empty($where)) {
            $query = CustomizeHelper::createLoaiQuery('', $where, [], $pageSize, $offset);
            $data = $query->all();
            $totalCount = (int) $query->limit(-1)->offset(-1)->orderBy([])->count();
            $pagination = new Pagination(['totalCount' => $totalCount, 'defaultPageSize' => $pageSize]);
            
        }        

        return $this->render('truyxuattv', [
                    'count' => $totalCount,
                    'data' => $data,
                    'pageSize' => $pageSize,
                    'pagecurrent' => $pagecurrent,
                    'pagination' => $pagination,
                    'id_dtv' => $id_dtv,
                    'id_nganh' => $id_nganh,
                    'id_lop' => $id_lop,
                    'id_bo' => $id_bo,
                    'id_ho' => $id_ho,
                    'id_iucn' => $id_iucn,
                    'id_sdvn' => $id_sdvn,
                    'id_ndcp' => $id_ndcp,
                    'id_ndcp64' => $id_ndcp64,
                    'name_kh' => $name_kh,
                    'name_tv' => $name_tv,
        ]);
    }

    public function actionFeedback() {
        if (Yii::$app->request->isAjax) {
            $this->validateCSRF();
            $email = trim(Yii::$app->request->post('email', ''));
            $email = strtolower($email);
            $validator = new EmailValidator();
            if (!$validator->validate($email)) {
                echo json_encode(['err' => 1, 'msg' => 'Email không hợp lệ!']);
                Yii::$app->end();
            }
            $subcriber = EmailLetter::findOne(['email' => $email]);
            if ($subcriber === null) {
                $subcriber = new EmailLetter();
                $subcriber->email = $email;
                $subcriber->status = 0;
                $subcriber->language = Yii::$app->language;
                if ($subcriber->save()) {
                    echo json_encode(['err' => 0, 'status' => 1]);
                    Yii::$app->end();
                }
            } else {
                echo json_encode(['err' => 0, 'status' => 1]);
                Yii::$app->end();
            }
            echo json_encode(['err' => 1, 'msg' => 'Lỗi dữ liệu']);
        }
        Yii::$app->end();
    }

    public function actionSubscriber() {
        if (Yii::$app->request->isAjax) {
            $this->validateCSRF();
            $name = trim(Yii::$app->request->post('fullname', ''));
            $email = trim(Yii::$app->request->post('email', ''));
            $phone = Yii::$app->request->post('phone', '');
            $note = Yii::$app->request->post('note', '');

            $email = strtolower($email);
            if ($name == '' || strlen($name) >= 255) {
                echo json_encode(['err' => 1, 'msg' => 'Tên người liên hệ không hợp lệ!']);
                Yii::$app->end();
            }

            $validator = new EmailValidator();
            if (!$validator->validate($email)) {
                echo json_encode(['err' => 1, 'msg' => 'Email không hợp lệ!']);
                Yii::$app->end();
            }
            $user = new User();
            if (!$user->checkvalidatePhone($phone)) {
                echo json_encode(['err' => 1, 'msg' => 'Số điện thoại không hợp lệ!']);
                Yii::$app->end();
            }
            $subcriber = new Subscribe();
            $subcriber->name = HtmlPurifier::process($name);
            $subcriber->email = $email;
            $subcriber->phone = $phone;
            $subcriber->note = HtmlPurifier::process($note);
            if ($subcriber->save()) {
                $result = ['err' => 0, 'status' => 1];
                echo json_encode($result);
                Yii::$app->end();
            }
            echo json_encode(['err' => 1, 'msg' => 'Lỗi dữ liệu']);
        }
        Yii::$app->end();
    }

    public function actionLogin() {
        $this->layout = '@app/modules/admin/views/layouts/login.php';
        if (!Yii::$app->user->isGuest) {
            return $this->redirect(['/admin/']);
        }
        $totalcount = LogIPHelper::totalcount;
        $count = 0;
        $model = new LoginForm();
        $count = LogIPHelper::getcountlogin();
        if ($count > $totalcount) {
            $model->scenario = 'logincaptcha';
            $model->addError('password', 'Email/Số điện thoại hoặc mật khẩu không chính xác!');
            return $this->render('login', [
                        'model' => $model,
                        'count' => $count,
                        'totalcount' => $totalcount,
            ]);
        }
        if ($model->load(Yii::$app->request->post())) {
            if ($model->login()) {
                LogIPHelper::updatecountlogin($model->email);
                $user = User::findOne(Yii::$app->user->identity->id);
                if ($user) {
                    $user->scenario = 'last_signined';
                    $user->last_signined_time = date('Y-m-d H:i:s');
                    $user->save();
                }
                $url = Yii::$app->getUser()->getReturnUrl();
                if ($url && $url != Url::to(['/site/logout'])) {
                    return $this->redirect(['/admin/']);
                } else {
                    return $this->redirect(['/admin/']);
                }
            } else {
                $count = LogIPHelper::log_ip_login($model->email);
                if ($count > $totalcount) {
                    $model->scenario = 'logincaptcha';
                }
            }
        }
        return $this->render('login', [
                    'model' => $model,
                    'count' => $count,
                    'totalcount' => $totalcount,
        ]);
    }

    public function actionLogout() {
        Yii::$app->user->logout();
        return $this->redirect(['/site/login']);
    }

    private function validateCSRF() {
        $request = Yii::$app->request;
        if (!$request->isPost) {
            LogSubscribeError::storeLog(LogSubscribeError::ERROR_CODE_WRONG_METHOD, 'Lỗi sai method', Json::encode(Yii::$app->request->post()));
            echo json_encode(['err' => 998]);
            Yii::$app->end();
        }
        $request->enableCsrfValidation = true;
        $ok = $request->validateCsrfToken();
        if (!$ok) {
            LogSubscribeError::storeLog(LogSubscribeError::ERROR_CODE_MISS_CSRF, 'Lỗi miss _csrf', Json::encode(Yii::$app->request->post()));
            echo json_encode(['err' => 999]);
            Yii::$app->end();
        }
    }

}
