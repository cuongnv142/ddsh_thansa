<?php
/**
 * Created by PhpStorm.
 * User: Tony
 * Date: 06/5/2021
 * Time: 3:38 PM
 */

namespace app\modules\admin\behaviors;

use yii\base\Behavior;
use yii\db\ActiveRecord;
use app\models\LogActionAdmin;
use yii\helpers\Url;
use Yii;


class LogActionBehavior extends Behavior
{
    private $_logActionAdmin;

    public function events()
    {
        return [
            ActiveRecord::EVENT_INIT => 'beforeSaveLog',
            ActiveRecord::EVENT_AFTER_FIND => 'beforeSaveLog',
            ActiveRecord::EVENT_AFTER_INSERT => 'afterSaveLog',
            ActiveRecord::EVENT_AFTER_UPDATE => 'afterSaveLog',
        ];
    }

    public function setLogActionAdmin()
    {
        $this->_logActionAdmin = new LogActionAdmin();
    }

    public function getLogActionAdmin()
    {
        if (is_null($this->_logActionAdmin)) {
            $this->setLogActionAdmin();
        }
        return $this->_logActionAdmin;
    }

    public function beforeSaveLog($event)
    {
        $this->getLogActionAdmin()->befor_data = empty($this->owner->getAttributes()) ? '' : json_encode($this->owner->getAttributes());
    }

    public function afterSaveLog($event)
    {
        $logAction = $this->getLogActionAdmin();
        $logAction->url = Url::current([], true);
        $logAction->user_id = Yii::$app->user->identity->id;
        $logAction->username = Yii::$app->user->identity->email ? Yii::$app->user->identity->email : Yii::$app->user->identity->phone;
        $logAction->ip = Yii::$app->getRequest()->getUserIP();
        $logAction->module = Yii::$app->controller->module->id;
        $logAction->controller = \Yii::$app->controller->id;
        $logAction->action = Yii::$app->controller->action->id;
        $logAction->id_object = $this->owner->getPrimaryKey();
        $logAction->name_object = isset($this->owner->name) ? $this->owner->name : '';
        $logAction->created_at = date('Y-m-d H:i:s');
        $logAction->after_data = empty($this->owner->getAttributes()) ? '' : json_encode($this->owner->getAttributes());
        $logAction->save();
    }

}