<?php

namespace app\helpers;

use app\components\FileUpload;
use app\models\ProjectMedia;
use app\models\TagRel;
use Yii;
use yii\db\Query;
use yii\helpers\Url;

class CustomizeHelper {

    const _prefix = 'se_';
    const _prefix_attr = 'se_attr';

    public static $querySearch = [];
    public static $site_contact = [];
    public static $paramSort = [];

    public static function createUrlNewsCat($cat = '', $params = array(), $scheme = false) {
        $params[] = '/news/list';
        if (!$cat) {
            return Url::toRoute($params, $scheme);
        }
        if (is_array($cat)) {
            $params['cid'] = $cat['id'];
            $params['name'] = StringHelper::formatUrlKey($cat['name']);
        } else {
            $params['cid'] = $cat->id;
            $params['name'] = StringHelper::formatUrlKey($cat->name);
        }
        if (!isset($params['language'])) {
            $params['language'] = Yii::$app->language;
        }
        if ($params['language'] == 'vi') {
            unset($params['language']);
        }
        return Url::toRoute($params, $scheme);
    }

    public static function createUrlNewsTag($tag = '', $params = array(), $scheme = false) {
        $params[] = '/news/tag';
        if (!$tag) {
            return Url::toRoute($params, $scheme);
        }
        if (is_array($tag)) {
            $params['tid'] = $tag['id'];
            $params['name'] = StringHelper::formatUrlKey($tag['name']);
        } else {
            $params['tid'] = $tag->id;
            $params['name'] = StringHelper::formatUrlKey($tag->name);
        }
        return Url::toRoute($params, $scheme);
    }

    public static function createUrlNew($item, $params = array(), $scheme = false) {
        if (empty($item)) {
            return Yii::$app->homeUrl;
        }
        $params[] = '/news/view';
        if (is_array($item)) {
            $params['id'] = $item['id'];
            $params['alias'] = StringHelper::formatUrlKey($item['alias']);
        } else {
            $params['id'] = $item->id;
            $params['alias'] = StringHelper::formatUrlKey($item->alias);
        }
        if (!isset($params['language'])) {
            $params['language'] = Yii::$app->language;
        }
        if ($params['language'] == 'vi') {
            unset($params['language']);
        }

        return Url::toRoute($params, $scheme);
    }

    public static function createUrlGioiThieu($params = array(), $scheme = false) {
        $params[] = '/news/gioithieu';
        if (!isset($params['language'])) {
            $params['language'] = Yii::$app->language;
        }
        if ($params['language'] == 'vi') {
            unset($params['language']);
        }
        return Url::toRoute($params, $scheme);
    }

    public static function createUrlLoai($item, $params = array(), $scheme = false) {
        if (empty($item)) {
            return Yii::$app->homeUrl;
        }
        $params[] = '/site/viewloai';
        if (is_array($item)) {
            $params['id'] = $item['id'];
            $params['alias'] = StringHelper::formatUrlKey($item['name']);
        } else {
            $params['id'] = $item->id;
            $params['alias'] = StringHelper::formatUrlKey($item->name);
        }
        if (!isset($params['language'])) {
            $params['language'] = Yii::$app->language;
        }
        if ($params['language'] == 'vi') {
            unset($params['language']);
        }

        return Url::toRoute($params, $scheme);
    }

    public static function createUrlTruyXuatDV($params = array(), $scheme = false) {
        $params[] = '/site/truyxuat';
        if (!isset($params['language'])) {
            $params['language'] = Yii::$app->language;
        }
        if ($params['language'] == 'vi') {
            unset($params['language']);
        }
        return Url::toRoute($params, $scheme);
    }
    public static function createUrlTruyXuatTV($params = array(), $scheme = false) {
        $params[] = '/site/truyxuattv';
        if (!isset($params['language'])) {
            $params['language'] = Yii::$app->language;
        }
        if ($params['language'] == 'vi') {
            unset($params['language']);
        }
        return Url::toRoute($params, $scheme);
    }

// end create URL

    public static function getSiteContact() {
        $language = Yii::$app->language;
        if (count(self::$site_contact)) {
            return self::$site_contact;
        }
        $query = new Query();
        $query->select(['*']);
        $query->from('site_contact');
        $query->where(['language' => $language]);
        self::$site_contact = $query->one();
        return self::$site_contact;
    }

    public static function getLinkFullBanner($model) {
        $urlHome = Yii::$app->homeUrl;
        if (!$model['link']) {
            return 'javascript:void(0);';
        }
        if (strpos($model['link'], 'http://') === 0 || strpos($model['link'], 'https://') === 0) {
            return $model['link'];
        }
        if (strpos($model['link'], 'javascript') !== 0) {
            return $urlHome . ltrim($model['link'], '/');
        }
        $arr_item = explode(':', $model['link']);
        if (isset($arr_item[1]) && !empty($arr_item[1])) {
            return 'javascript:void(0);" onclick="' . $arr_item[1];
        } else {
            return 'javascript:void(0);';
        }
    }

    public static function getTreeNewsCatById($id) {
        $reVal = [];
        if (!$id) {
            return $reVal;
        }
        $query = new Query();
        $query->select('*');
        $query->from('news_cat');
        $query->andFilterWhere(['parent_id' => $id, 'status' => 1]);
        $query->orderBy([
            'sort_order' => SORT_ASC,
        ]);
        $data = $query->all();
        if (!$data) {
            return $reVal;
        }
        foreach ($data as $item) {
            $child = self::getTreeNewsCatById($item['id']);
            $item['child'] = $child;
            $reVal[] = $item;
        }
        return $reVal;
    }

    public static function getTreeMenuById($id, $menu_group_id, $limit = 0) {
        $reVal = [];
        $query = new Query();
        $query->select('*');
        $query->from('menus');
        $query->andFilterWhere(['parent_id' => $id, 'menu_group_id' => $menu_group_id, 'status' => 1, 'language' => Yii::$app->language]);
        $query->orderBy([
            '(sort_order is null)' => SORT_ASC,
            'sort_order' => SORT_ASC,
        ]);
        if ($limit) {
            $query->limit($limit);
        }
        $data = $query->all();
        if (!$data) {
            return $reVal;
        }
        foreach ($data as $item) {
            $child = self::getTreeMenuById($item['id'], $menu_group_id);
            $item['child'] = $child;
            $reVal[] = $item;
        }
        return $reVal;
    }

    public static function countChildNewsCatByID($parent_id, $status = 1) {
        $query = new Query();
        $query->from('news_cat');
        $query->andFilterWhere(['parent_id' => $parent_id,]);
        if ($status !== false) {
            $query->andFilterWhere(['status' => $status]);
        }
        return $query->count();
    }

    public static function getNewsCatByID($id, $status = 1) {
        $query = new Query();
        $query->select('*');
        $query->from('news_cat');
        $query->andFilterWhere(['id' => $id,]);
        if ($status !== false) {
            $query->andFilterWhere(['status' => $status]);
        }
        return $query->one();
    }

    public static function getNewsByID($id, $status = 1) {
        $query = new Query();
        $query->select('*');
        $query->from('news');
        $query->andFilterWhere(['id' => $id,]);
        if ($status !== false) {
            $query->andFilterWhere(['status' => $status]);
        }
        return $query->one();
    }

    public static function getTagByID($tag, $status = 1) {
        $query = new Query();
        $query->select('*');
        $query->from('tag');
        $query->andFilterWhere(['id' => $tag,]);
        if ($status !== false) {
            $query->andFilterWhere(['status' => $status]);
        }
        return $query->one();
    }

    public static function getArrChildNewsCatId($id) {
        $query = new Query();
        $query->select('id');
        $query->from('news_cat');
        $query->andFilterWhere(['OR', ['parent_id' => $id], ['id' => $id]]);
        return $query->column();
    }

    public static function getChildNewsCatId($cat_id) {
        $query = new Query();
        $query->select('*');
        $query->from('news_cat');
        $query->andFilterWhere(['parent_id' => $cat_id, 'status' => 1]);
        $query->orderBy([
            'sort_order' => SORT_ASC,
        ]);
        return $query->all();
    }

    public static function createNewsByTagQuery($id_tag = 0, $where = [], $order = [], $limit = 0, $offset = 0) {
        $query = new Query();
        $query->select(['t.*']);
        $query->from('news t');
        $query->rightJoin('tag_rel r', 't.id=r.object_id');
        $query->andFilterWhere(['t.status' => 1, 'r.type' => TagRel::TYPE_NEWS]);
        if ($id_tag) {
            $query->andFilterWhere(['r.tag_id' => $id_tag]);
        }
        if ($where) {
            $query->andFilterWhere($where);
        }
        if ($limit) {
            $query->limit($limit);
        }
        if ($offset) {
            $query->offset($offset);
        }
        if (!empty($order)) {
            $query->orderBy($order);
        } else {
            $query->orderBy([
                't.id' => SORT_DESC,
            ]);
        }
        return $query;
    }

    public static function createNewsByCatQuery($id_cat = 0, $where = [], $order = [], $limit = 0, $offset = 0) {
        $language = Yii::$app->language;
        $query = new Query();
        $query->select(['t.*']);
        $query->from('news t');
        $query->where(['language' => $language]);
        $query->andFilterWhere(['status' => 1]);
        if ($id_cat) {
            $query->leftJoin('news_cat_rel r', 't.id=r.news_id');
            $query->andFilterWhere(['r.news_cat_id' => $id_cat]);
            $query->groupBy('t.id');
        }
        if ($where) {
            $query->andFilterWhere($where);
        }
        if ($limit) {
            $query->limit($limit);
        }
        if ($offset) {
            $query->offset($offset);
        }
        if (!empty($order)) {
            $query->orderBy($order);
        } else {
            $query->orderBy([
                't.id' => SORT_DESC,
            ]);
        }
        return $query;
    }

    public static function getNewsByCat($cat_id, $where = [], $order = [], $limit = 0, $offset = 0) {
        $query = self::createNewsByCatQuery($cat_id, $where, $order, $limit, $offset);
        $data = $query->all();
        return $data;
    }

    public static function getDTVLoaiByType($type, $limit) {
        $query = new Query();
        $query->select(['t.*']);
        $query->from('dtv_loai t');
        $query->andFilterWhere(['t.status' => 1, 't.loai' => $type]);
        if ($limit) {
            $query->limit($limit);
        }
        $query->orderBy([
            't.id' => SORT_DESC,
        ]);
        return $query->all();
    }

    public static function getLoaiByID($id, $status = 1) {
        $query = new Query();
        $query->select('*');
        $query->from('dtv_loai');
        $query->andFilterWhere(['id' => $id,]);
        if ($status !== false) {
            $query->andFilterWhere(['status' => $status]);
        }
        return $query->one();
    }

    public static function getNganhArray() {
        $query = new Query();
        $query->select('*');
        $query->from('dtv_nganh');
        $query->andFilterWhere(['status' => 1]);
        $data = $query->all();
        $nganh = [];
        if ($data) {
            foreach ($data as $item) {
                $nganh[$item['loai']][] = $item;
            }
        }
        return $nganh;
    }

    public static function getLopArray() {
        $query = new Query();
        $query->select('*');
        $query->from('dtv_lop');
        $query->andFilterWhere(['status' => 1]);
        $data = $query->all();
        $nganh = [];
        if ($data) {
            foreach ($data as $item) {
                $nganh[$item['id_dtv_nganh']][] = $item;
            }
        }
        return $nganh;
    }

    public static function getBoArray() {
        $query = new Query();
        $query->select('*');
        $query->from('dtv_bo');
        $query->andFilterWhere(['status' => 1]);
        $data = $query->all();
        $nganh = [];
        if ($data) {
            foreach ($data as $item) {
                $nganh[$item['id_dtv_lop']][] = $item;
            }
        }
        return $nganh;
    }

    public static function getHoArray() {
        $query = new Query();
        $query->select('*');
        $query->from('dtv_ho');
        $query->andFilterWhere(['status' => 1]);
        $data = $query->all();
        $nganh = [];
        if ($data) {
            foreach ($data as $item) {
                $nganh[$item['id_dtv_bo']][] = $item;
            }
        }
        return $nganh;
    }

    public static function createLoaiQuery($loai = '', $where = [], $order = [], $limit = 0, $offset = 0) {
        $query = new Query();
        $query->select(['t.*']);
        $query->from('dtv_loai t');
        $query->leftJoin('dtv_ho ho', 'ho.id=t.id_dtv_ho');
        $query->leftJoin('dtv_bo bo', 'bo.id=ho.id_dtv_bo');
        $query->leftJoin('dtv_lop lop', 'lop.id=bo.id_dtv_lop');
        $query->leftJoin('dtv_nganh nganh', 'nganh.id=lop.id_dtv_nganh');
        $query->andFilterWhere(['t.status' => 1]);
        if ($loai != '') {
            $query->andFilterWhere(['t.loai' => $loai]);
        }
        if ($where) {
            $query->andFilterWhere($where);
        }
        if ($limit) {
            $query->limit($limit);
        }
        if ($offset) {
            $query->offset($offset);
        }
        if (!empty($order)) {
            $query->orderBy($order);
        } else {
            $query->orderBy([
                't.id' => SORT_DESC,
            ]);
        }
        $query->groupBy('t.id');
        return $query;
    }

}
