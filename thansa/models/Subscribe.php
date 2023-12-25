<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "subscribe".
 *
 * @property integer $id
 * @property string $name
 * @property string $phone
 * @property string $email
 * @property string $created_at
 * @property string $updated_at
 * @property integer $status
 * @property string $ip
 * @property integer $type
 * @property string $utm_campaign
 * @property string $utm_medium
 * @property string $utm_content
 * @property string $utm_source
 * @property string $utm_term
 * @property string $utm_referrer
 * @property string $cookies
 * @property string $note
 * @property string $phongban
 * @property integer $object_id
 * @property string $file
 */
class Subscribe extends ActiveRecord
{

    const TYPE_DEFAUT = 0;
    public static $arrType = [
    ];
    public static $arrStatus = [
        0 => 'Chờ duyệt',
        1 => 'Đã duyệt',
    ];

    public static function tableName()
    {
        return 'subscribe';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'email', 'phone'], 'required'],
            [['created_at', 'updated_at'], 'safe'],
            [['status', 'type'], 'integer'],
            [['type'], 'default', 'value' => 0],
            [['name', 'phone', 'email', 'ip', 'utm_campaign', 'utm_medium', 'utm_content', 'utm_source', 'utm_term', 'utm_referrer', 'phongban', 'file'], 'string', 'max' => 255],
            [['cookies'], 'string', 'max' => 1000],
            [['note'], 'string'],
            [['object_id'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Họ tên',
            'phone' => 'Điện thoại',
            'email' => 'Email liên lạc',
            'created_at' => 'Ngày đăng ký',
            'updated_at' => 'Updated At',
            'status' => 'Trạng thái',
            'ip' => 'ip',
            'type' => 'Cần hỗ trợ',
            'utm_campaign' => 'Utm Campaign',
            'utm_medium' => 'Utm Medium',
            'utm_content' => 'Utm Content',
            'utm_source' => 'Utm Source',
            'utm_term' => 'Utm Term',
            'utm_referrer' => 'Utm Referrer',
            'cookies' => 'Cookies',
            'note' => 'Nội dung tin nhắn',
            'phongban' => 'Phòng ban',
        ];
    }

    public function beforeSave($insert)
    {
        $cookies = Yii::$app->request->cookies;
        $utm_campaign = $cookies->getValue('utm_campaign_space', '');
        if ($utm_campaign) {
            $this->utm_campaign = $utm_campaign;
        }
        $utm_medium = $cookies->getValue('utm_medium_space', '');
        if ($utm_medium) {
            $this->utm_medium = $utm_medium;
        }
        $utm_content = $cookies->getValue('utm_content_space', '');
        if ($utm_content) {
            $this->utm_content = $utm_content;
        }
        $utm_source = $cookies->getValue('utm_source_space', '');
        if ($utm_source) {
            $this->utm_source = $utm_source;
        }
        $utm_term = $cookies->getValue('utm_term_space', '');
        if ($utm_term) {
            $this->utm_term = $utm_term;
        }
        $utm_referrer = $cookies->getValue('utm_referrer_space', '');
        if ($utm_referrer) {
            $this->utm_referrer = $utm_referrer;
        }
        if (parent::beforeSave($insert)) {
            if ($this->isNewRecord) {
                $this->created_at = date('Y-m-d H:i:s');
            }
            $this->updated_at = date('Y-m-d H:i:s');
        }
        return true;
    }

    public function getProject()
    {
        return $this->hasOne(Project::className(), ['id' => 'object_id']);
    }

    public function getRecruitment()
    {
        return $this->hasOne(Recruitment::className(), ['id' => 'object_id']);
    }

}
