<?php

use yii\helpers\Html;
use yii\grid\GridView;
use app\modules\admin\helpers\AdminHelper;
use yii\helpers\Url;
use yii\widgets\Pjax;
use yii\helpers\ArrayHelper;
use app\modules\admin\models\AdminNews;
use app\models\TagRel;

$searchModel = new AdminNews();
$dataProviderdeal = $searchModel->search(Yii::$app->request->queryParams);

TagRel::$ids = TagRel::find()->select('object_id')->andFilterWhere(['tag_id' => $model->id, 'type' => TagRel::TYPE_NEWS])->column();
?>
<?php
Pjax::begin([
    'id' => 'pjax-news-list',
    'timeout' => false,
    'enablePushState' => false,
]);
?>
<div class="row">
    <div class="col-xs-12">
        <div class="form-index">
            <?=
            GridView::widget([
                'dataProvider' => $dataProviderdeal,
                'filterModel' => $searchModel,
                'options' => [
                    'id' => 'news-list'
                ],
                'columns' => [
                    [
                        'class' => 'yii\grid\SerialColumn',
                        'header' => 'STT'
                    ],
                    [
                        'class' => 'yii\grid\CheckboxColumn',
                        'checkboxOptions' => function($model, $key, $index, $column) {
                            return ['value' => $model->id, 'onchange' => 'select_news(this)', 'class' => 'selection_chk', 'checked' => (in_array($model->id, TagRel::$ids)) ? true : false];
                        },
                        'name' => 'news'
                    ],
                    [
                        'attribute' => 'name',
                        'format' => 'raw',
                        'value' => function($data) {
                            $url = Url::to(['/admin/news/update', 'id' => $data->id]);
                            return Html::a($data->name, $url, ['title' => $data->name, 'target' => '_blank', 'data-pjax' => 'false']);
                        }
                    ],
                    [
                        'attribute' => 'status',
                        'format' => 'raw', //raw, html
                        'filter' => AdminHelper::$arrStatus,
                        'content' => function($data) {
                            return AdminHelper::$arrStatus[(int) $data->status];
                        }
                    ],
                ],
            ]);
            ?>

        </div>
    </div>
</div>
<?php Pjax::end(); ?>