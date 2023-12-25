<?php

namespace app\modules\admin\controllers;

use app\helpers\StringHelper;
use app\models\News;
use app\models\TagRel;
use app\modules\admin\components\AdminController;
use app\modules\admin\models\AdminTag;
use Yii;
use yii\data\ActiveDataProvider;
use yii\filters\VerbFilter;
use yii\web\NotFoundHttpException;

/**
 * TagController implements the CRUD actions for AdminTag model.
 */
class TagController extends AdminController {

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
     * Lists all AdminTag models.
     * @return mixed
     */
    public function actionIndex() {
        $searchModel = new AdminTag();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Creates a new AdminTag model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function setParamModel($model) {
        if (!$model) {
            return $model;
        }
        $model->status = (int) $model->status;
        if ($model->tag) {
            return $model;
        }
        $model->tag = StringHelper::formatUrlKey($model->name);
        return $model;
    }

    public function actionCreate() {
        $model = new AdminTag();
        if (!$model->load(Yii::$app->request->post())) {
            return $this->renderViewCreate($model);
        }
        $model = $this->setParamModel($model);
        if (!$model->save()) {
            return $this->renderViewCreate($model);
        }
        return $this->redirectSuccessCreate($model);
    }

    public function renderViewUpdate($model) {

        $news = News::find();
        $news->select('d.*');
        $news->from(News::tableName() . ' d');
        $news->leftJoin(TagRel::tableName() . ' tr', 'tr.object_id=d.id');
        $news->andFilterWhere([
            'tr.type' => TagRel::TYPE_NEWS,
            'tr.tag_id' => $model->id
        ]);
        $news->orderBy('tr.sort_order');

        $data_news = new ActiveDataProvider([
            'query' => $news
        ]);


        return $this->render('update', [
                    'model' => $model,
                    'data_news' => $data_news
        ]);
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
     * Deletes an existing AdminTag model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionDelete($id) {
        $tag_all = TagRel::find()
                ->andFilterWhere(['tag_id' => $id])
                ->all();
        if ($tag_all) {
            TagRel::deleteAll(['tag_id' => $id]);
        }
        $this->findModel($id)->delete();
        return $this->redirect(['index']);
    }

    /**
     * Finds the AdminTag model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return AdminTag the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        $model = AdminTag::findOne($id);
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
        $model = AdminTag::findOne($id);
        if (!$model) {
            $this->exitErrorAjax($mes);
        }
        $model->status = (int) $status;
        if (!$model->save()) {
            $this->exitErrorAjax($mes);
        }
        $this->exitSuccessAjax();
    }

    public function actionAddallnews() {
        if (!Yii::$app->request->isAjax) {
            Yii::$app->end();
        }
        $id = (int) Yii::$app->getRequest()->post('id');
        $ids = Yii::$app->getRequest()->post('news');
        $chk = Yii::$app->getRequest()->post('chk');
        if (!$id || !$ids) {
            Yii::$app->end();
        }
        $tag = AdminTag::findOne(['id' => $id]);
        if (!$tag) {
            Yii::$app->end();
        }
        $arr_news = explode(';', $ids);
        for ($i = 0; $i < count($arr_news); $i++) {
            if ((int) $arr_news[$i]) {
                if ($chk == 'true') {
                    $model = TagRel::findOne(['type' => TagRel::TYPE_NEWS, 'object_id' => $arr_news[$i], 'tag_id' => $id]);
                    if (!$model) {
                        $record = new TagRel();
                        $record->object_id = $arr_news[$i];
                        $record->type = TagRel::TYPE_NEWS;
                        $record->tag_id = $id;
                        $record->sort_order = 0;
                        $record->save();
                    }
                } else {
                    TagRel::deleteAll(['tag_id' => $id, 'type' => TagRel::TYPE_NEWS, 'object_id' => $arr_news[$i]]);
                }
            }
        }

        echo json_encode(['err' => 0]);

        Yii::$app->end();
    }

    public function actionAddnews() {
        if (!Yii::$app->request->isAjax) {
            Yii::$app->end();
        }
        $id = (int) Yii::$app->getRequest()->post('id');
        $ids = (int) Yii::$app->getRequest()->post('news');
        $chk = (int) Yii::$app->getRequest()->post('chk');
        if (!$id || !$ids) {
            Yii::$app->end();
        }
        $tag = AdminTag::findOne(['id' => $id]);
        if (!$tag) {
            Yii::$app->end();
        }
        if (!$chk) {
            TagRel::deleteAll(['tag_id' => $id, 'type' => TagRel::TYPE_NEWS, 'object_id' => $ids]);
            echo json_encode(['err' => 0]);

            Yii::$app->end();
        }
        $model = TagRel::findOne(['type' => TagRel::TYPE_NEWS, 'object_id' => $ids, 'tag_id' => $id]);
        if (!$model) {
            $record = new TagRel();
            $record->object_id = $ids;
            $record->type = TagRel::TYPE_NEWS;
            $record->tag_id = $id;
            $record->sort_order = 0;
            $record->save();
        }
        echo json_encode(['err' => 0]);
        Yii::$app->end();
    }

    public function actionRemovenews() {
        $id = \Yii::$app->getRequest()->post('id');
        $id_deal = \Yii::$app->getRequest()->post('id_news');

        $model = TagRel::findOne(['tag_id' => $id, 'object_id' => $id_deal, 'type' => TagRel::TYPE_NEWS]);
        if ($model) {
            $model->delete();
        }
        echo json_encode(['err' => 0]);
        Yii::$app->end();
    }

}
