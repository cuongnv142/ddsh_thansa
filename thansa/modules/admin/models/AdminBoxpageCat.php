<?php

namespace app\modules\admin\models;

use app\models\BoxpageCat;
use app\modules\admin\behaviors\LogActionBehavior;
use Yii;
use yii\data\ActiveDataProvider;
use yii\db\Query;
use app\modules\admin\behaviors\SetterImageBehavior;

/**
 * AdminBoxpageCat represents the model behind the search form about `app\models\BoxpageCat`.
 */
class AdminBoxpageCat extends BoxpageCat {

    use SynLevelPathTrait;

    public function behaviors() {
        return [
            LogActionBehavior::className(),
            SetterImageBehavior::className()
        ];
    }

    public function search($params) {
        $query = BoxpageCat::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => Yii::$app->params['defaultPageSizeAdmin'],
            ],
            'sort' => [
                // Set the default sort by name ASC and created_at DESC.
                'defaultOrder' => [
                    'id' => SORT_DESC
                ]
            ]
        ]);

        $this->load($params);

        $query->andFilterWhere([
            'id' => $this->id,
            'parent_id' => $this->parent_id,
            'level' => $this->level,
            'sort_order' => $this->sort_order,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'status' => $this->status,
            'language' => $this->language,
            'id_related' => $this->id_related,
        ]);

        $query->andFilterWhere(['like', 'name', trim($this->name)])
                ->andFilterWhere(['like', 'path', $this->path])
                ->andFilterWhere(['like', 'image', $this->image])
                ->andFilterWhere(['like', 'description', $this->description]);

        return $dataProvider;
    }

    public static function getBoxpageCatLevel($id = 0, $level = 0, $language = '') {
        $data_option = array();
        $id = (int) $id;
        $level = (int) $level;
        if (!$level && !$id) {
            $level = 100;
        }
        $query = New Query();
        $query->select('id,level,name,parent_id')
                ->from(BoxpageCat::tableName())
                ->where('id<>:vid AND level <= :vlevel')
                ->addParams(["vid" => $id, "vlevel" => $level])
                ->orderBy("level ASC,id");
        if ($language) {
            $query->andWhere(['language' => $language]);
        }
        $command = $query->createCommand();
        $arr = $command->queryAll();
        for ($i = 0, $n = count($arr); $i < $n; $i++) {
            if ($arr[$i]['level'] == 1) {
                $arr[$i]['name'] = str_repeat('- ', $arr[$i]['level'] + 0) . $arr[$i]['name'];
                array_push($data_option, $arr[$i]);
                $id = $arr[$i]['id'];
                unset($arr[$i]);
                $data_option = array_merge($data_option, self::getarr_Boxpagecat($arr, $id));
            } else {
                break;
            }
        }
        return $data_option;
    }

    public static function getarr_Boxpagecat($options = array(), $id = 0) {
        $data_option = array();
        foreach ($options as $i => $item) {
            if ($item['parent_id'] == (int) $id) {
                $item['name'] = str_repeat('- ', $item['level'] + 0) . $item['name'];
                array_push($data_option, $item);
                unset($options[$i]);
                $data_option = array_merge($data_option, self::getarr_Boxpagecat($options, $item['id']));
            }
        }
        return $data_option;
    }

    public static function getParentName($parent_id) {
        if ($parent_id) {
            $model = static::findOne($parent_id);
            return $model ? $model->name : 'Danh mục gốc';
        }
        return 'Danh mục gốc';
    }

    public function setParamModel() {
        $this->level = $this->createLevel(); // method in SynLevelPathTrait
        $this->parent_id = $this->parent_id ? (int) $this->parent_id : static::parentid_default;
        $this->sort_order = (int) $this->sort_order;
        $this->uploadImage(); // method in SetterImageBehavior
    }

    # end code tu viet
}
