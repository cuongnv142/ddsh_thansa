<?php

namespace app\models;

use app\helpers\StringHelper;
use Yii;

/**
 * This is the model class for table "log_subscribe_error".
 *
 * @property string $id
 * @property string $ip
 * @property integer $error_code
 * @property string $content
 * @property string $err_message
 * @property string $created_at
 */
class LogSubscribeError extends \yii\db\ActiveRecord
{
    const ERROR_CODE_TYPE = 1;
    const ERROR_CODE_EMAIL = 2;
    const ERROR_CODE_PHONE = 3;
    const ERROR_CODE_ADDRESS = 4;
    const ERROR_CODE_MAX_FILE = 5;
    const ERROR_CODE_FILE = 6;
    const ERROR_CODE_SAVE = 7;
    const ERROR_CODE_MISS_CSRF = 8;
    const ERROR_CODE_MISS_CAPTCHA = 9;
    const ERROR_CODE_FAIL_CAPTCHA = 10;
    const ERROR_CODE_WRONG_METHOD = 11;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'log_subscribe_error';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['error_code'], 'integer'],
            [['content', 'err_message'], 'string'],
            [['created_at'], 'safe'],
            [['ip'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'ip' => 'Ip',
            'error_code' => 'Error Code',
            'content' => 'Content',
            'err_message' => 'Err Message',
            'created_at' => 'Created At',
        ];
    }

    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            if ($this->isNewRecord) {
                $this->created_at = date('Y-m-d H:i:s');
            }
        }
        return true;
    }

    public static function storeLog($errorCode, $message = '', $data = '')
    {
        $model = new self();
        $model->error_code = $errorCode;
        $model->err_message = $message;
        $model->content = (is_string($data)) ? $data : json_encode($data);
        $model->ip = StringHelper::getIPAddress();
        return $model->save();
    }

    public static function getStatusErrors()
    {
        return [
            self::ERROR_CODE_TYPE => 'Type sai định dạng',
            self::ERROR_CODE_EMAIL => 'Email sai định dạng',
            self::ERROR_CODE_PHONE => 'SĐT sai định dạng',
            self::ERROR_CODE_MAX_FILE => 'Vượt quá số lượng file',
            self::ERROR_CODE_FILE => 'File bị sai định dạng',
            self::ERROR_CODE_SAVE => 'Lỗi lưu dữ liệu',
            self::ERROR_CODE_MISS_CSRF => 'Lỗi thiếu _csrf',
            self::ERROR_CODE_MISS_CAPTCHA => 'Lỗi thiếu captcha',
            self::ERROR_CODE_FAIL_CAPTCHA => 'Captcha bị sai',
            self::ERROR_CODE_WRONG_METHOD => 'Sai method',
        ];
    }
}
