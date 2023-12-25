<?php
/**
 * Created by PhpStorm.
 * User: Tony
 * Date: 12/5/2021
 * Time: 10:18 AM
 */

namespace app\modules\admin\models;


trait SynLevelPathTrait
{
    public function createLevel()
    {
        $parent = static::findOne($this->parent_id);
        if ($parent) {
            return (int)$parent->level + 1;
        }
        return static::level_default;
    }

    public function createPath()
    {
        $parent = static::findOne($this->parent_id);
        if ($parent && $parent->path) {
            return $parent->path . '/' . $this->id;
        }
        return static::parentid_default . '/' . $this->id;
    }

    public function updateChildren()
    {
        $this->level = $this->createLevel();
        $this->path = $this->createPath();
        if (!$this->update()) {
            return;
        }
        $children = static::find()->where(['parent_id' => $this->id])->all();
        if (count($children) == 0) {
            return;
        }
        foreach ($children as $child) {
            $child->updateChildren();
        }
    }
}