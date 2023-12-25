<?php

namespace app\modules\admin\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\LogSubscribeError;

/**
 * AdminLogSubscribeError represents the model behind the search form about `app\models\LogSubscribeError`.
 */
class AdminLogSubscribeError extends LogSubscribeError
{

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = LogSubscribeError::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        $query->andFilterWhere([
            'id' => $this->id,
            'error_code' => $this->error_code,
            'created_at' => $this->created_at,
        ]);

        $query->andFilterWhere(['like', 'ip', $this->ip])
            ->andFilterWhere(['like', 'content', $this->content])
            ->andFilterWhere(['like', 'err_message', $this->err_message]);

        return $dataProvider;
    }
}
