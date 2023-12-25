<?php

namespace app\modules\admin\models;

use app\helpers\CustomizeHelper;
use app\models\Menus;
use app\modules\admin\behaviors\LogActionBehavior;
use app\modules\admin\behaviors\SetterImageBehavior;
use Yii;
use yii\data\ActiveDataProvider;
use yii\db\Query;
use yii\helpers\Url;

class AdminMenus extends Menus {

    use SynLevelPathTrait;

    public function behaviors() {
        return [
            LogActionBehavior::className(),
            SetterImageBehavior::className()
        ];
    }

    public function search($params) {
        $query = Menus::find();

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
            'menu_group_id' => $this->menu_group_id,
            'type_menu' => $this->type_menu,
            'id_object' => $this->id_object,
            'parent_id' => $this->parent_id,
            'level' => $this->level,
            'status' => $this->status,
            'sort_order' => $this->sort_order,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'id_related' => $this->id_related,
        ]);

        $query->andFilterWhere(['like', 'language', $this->language])
                ->andFilterWhere(['like', 'gen_url', $this->gen_url])
                ->andFilterWhere(['like', 'name', $this->name])
                ->andFilterWhere(['like', 'path', $this->path])
                ->andFilterWhere(['like', 'image', $this->image]);

        return $dataProvider;
    }

    public static function getMenusLevel($id = 0, $level = 0, $menu_group_id = 0, $language = '') {
        $data_option = array();
        $id = (int) $id;
        $level = (int) $level;
        if (!$level && !$id) {
            $level = 100;
        }
        $query = New Query();
        $query->select('*')
                ->from(Menus::tableName())
                ->where('id<>:vid AND level <= :vlevel')
                ->addParams(["vid" => $id, "vlevel" => $level])
                ->orderBy("level ASC,id");
        if ($menu_group_id) {
            $query->andFilterWhere(['menu_group_id' => $menu_group_id]);
        }
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
                $data_option = array_merge($data_option, self::getarr_Menus($arr, $id));
            } else {
                break;
            }
        }
        return $data_option;
    }

    public static function getarr_Menus($options = array(), $id = 0) {
        $data_option = array();
        foreach ($options as $i => $item) {
            if ($item['parent_id'] == (int) $id) {
                $item['name'] = str_repeat('- ', $item['level'] + 0) . $item['name'];
                array_push($data_option, $item);
                unset($options[$i]);
                $data_option = array_merge($data_option, self::getarr_Menus($options, $item['id']));
            }
        }
        return $data_option;
    }

    public static function getParentName($parent_id) {
        if ($parent_id) {
            $model = static::findOne($parent_id);
            return $model ? $model->name : 'Menu gốc';
        }
        return 'Menu gốc';
    }

    public function setParamModel() {
        $this->level = $this->createLevel(); // method in SynLevelPathTrait
        $this->parent_id = $this->parent_id ? (int) $this->parent_id : static::parentid_default;
        $this->sort_order = (int) $this->sort_order;
        $this->type_menu = (int) $this->type_menu;
        $this->menu_group_id = (int) $this->menu_group_id;
        $this->id_object = (int) $this->id_object;
        if ($this->type_menu != 1) {
            $this->id_object = 0;
        }
        if ($this->type_menu != 2) {
            $this->link_menu = '';
        }
        $this->gen_url = $this->genUrlPath();
        $this->uploadImage(); // method in SetterImageBehavior
        $this->setFieldUploadName('image_hover')->setIsImageDeleteName('is_deleteimage_hover')->uploadImage();
    }

    public function genUrlPath() {
        $gen_url = '';
        $params = [];
        switch ($this->type_menu) {
            case 0:
                $params[0] = '/site/index';
                $gen_url = Url::toRoute($params);
                break;
            case 1:
                if ($this->id_object) {
                    $cat = AdminNewsCat::findOne($this->id_object);
                    if ($cat) {
                        $gen_url = CustomizeHelper::createUrlNewsCat($cat, ['language' => $this->language]);
                    }
                }
                break;
            case 3:
                $gen_url = '#';
                break;
            case 4:
                $gen_url = CustomizeHelper::createUrlTongQuan(['language' => $this->language]);
                break;
            case 5:
                $gen_url = CustomizeHelper::createUrlViTri(['language' => $this->language]);
                break;
            case 6:
                $gen_url = CustomizeHelper::createUrlPhanKhu(['language' => $this->language]);
                break;
            case 7:
                $gen_url = CustomizeHelper::createUrlVirtual(['language' => $this->language]);
                break;
        }
        return $gen_url;
    }

}
