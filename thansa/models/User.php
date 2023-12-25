<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;

/**
 * This is the model class for table "user".
 *
 * @property string $id
 * @property string $cities_id
 * @property string $cities_district_id
 * @property string $first_name
 * @property string $password
 * @property string $email
 * @property string $phone
 * @property string $avatar
 * @property string $gender
 * @property string $dob
 * @property string $address
 * @property string $created_at
 * @property string $updated_at
 * @property string $last_signined_time
 * @property integer $is_admin
 * @property integer $status
 * @property string $secret_key
 * @property string $role
 */
class User extends ActiveRecord implements IdentityInterface {

    public $project = 'user';
    public $current_pass, $new_pass, $retype_pass, $password_repeat;
    public $authKey;
    public static $dataStatus = [0 => 'None', '1' => 'Kích hoạt', -1 => 'Khóa'];
    public $captcha;
    public $city_name;
    public $district_name;
    public $emailphone;
    public static $dataIsSendMail = [0 => 'Chưa gửi', 1 => 'Đã gửi'];

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return 'user';
    }

    public function scenarios() {
        $scenarios = parent::scenarios();
        $scenarios['create'] = ['id', 'first_name', 'cities_id', 'cities_district_id', 'avatar', 'gender', 'address', 'dob', 'email', 'password', 'password_repeat', 'phone', 'created_at', 'updated_at', 'is_admin', 'role', 'status'];
        $scenarios['update'] = ['first_name', 'cities_id', 'cities_district_id', 'avatar', 'gender', 'address', 'dob', 'updated_at', 'phone', 'type', 'status', 'role', 'is_admin'];
        $scenarios['edit'] = ['first_name', 'cities_id', 'cities_district_id', 'phone', 'avatar', 'gender', 'address', 'dob', 'updated_at'];
        $scenarios['changepwd'] = ['password', 'current_pass', 'new_pass', 'retype_pass'];
        $scenarios['editpwd'] = ['new_pass', 'retype_pass'];
        $scenarios['forgotpwd'] = ['new_pass', 'retype_pass'];
        $scenarios['last_signined'] = ['id', 'last_signined_time', 'secret_key'];
        return $scenarios;
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['cities_id', 'cities_district_id', 'is_admin', 'status'], 'integer'],
            [['avatar', 'gender', 'address'], 'string'],
            [['created_at', 'updated_at', 'last_signined_time', 'secret_key'], 'safe'],
            [['dob'], 'date', 'format' => 'yyyy-MM-dd'],
            [['first_name', 'email', 'phone', 'role'], 'string', 'max' => 255],
            [['email', 'first_name'], 'required'],
            [['first_name'], function ($value) {
                    return trim(htmlentities(strip_tags($value), ENT_QUOTES, 'UTF-8'));
                }],
            [['password'], 'string', 'max' => 128],
            [['password', 'password_repeat'], 'required', 'on' => ['create']],
            ['password_repeat', 'compare', 'compareAttribute' => 'password', 'on' => ['create'], 'message' => 'Mật khẩu không trùng nhau! Vui lòng nhập lại'],
            [['password', 'new_pass'], 'string', 'min' => 6, 'message' => 'Mật khẩu ít nhất 6 ký tự'],
            [['email'], 'email', 'message' => 'Email không đúng định dạng'],
            [['email'], 'unique', 'message' => 'Email đã tồn tại'],
            [['current_pass', 'new_pass', 'retype_pass'], 'required', 'on' => ['changepwd']],
            [['new_pass', 'retype_pass'], 'validatePasswordAdmin', 'on' => ['changepwd', 'editpwd']],
            ['retype_pass', 'compare', 'compareAttribute' => 'new_pass', 'message' => 'Mật khẩu nhập lại ko trùng nhau'],
            [['new_pass', 'retype_pass'], 'required', 'on' => 'forgotpwd'],
            [['new_pass', 'retype_pass'], 'required', 'on' => 'editpwd'],
            [['emailphone'], 'string', 'max' => 255],
        ];
    }

    public function validatePasswordAdmin($attribute, $params) {
        if (!$this->hasErrors()) {
            if (!$this->checkvalidatePassword($this->$attribute)) {
                $this->addError($attribute, 'Mật khẩu không đúng quy định.');
            }
        }
    }

    public function validatePasswordCustomer($attribute, $params) {
        if (!$this->hasErrors()) {
            if (!$this->checkvalidatePasswordCustomer($this->$attribute)) {
                $this->addError($attribute, 'Mật khẩu không đúng quy định.');
            }
        }
    }

    public function checkvalidatePasswordCustomer($password) {
        $reVal = false;
        if (preg_match("#.*^(?=.{8,})(?=.*[a-zA-Z])(?=.*[0-9]).*$#", $password)) {
            $reVal = true;
        }
        return $reVal;
    }

    public function checkvalidatePassword($password) {
        $reVal = false;
        if (preg_match("#.*^(?=.{8,})(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[\@\#\$\%\^\&\+\=]).*$#", $password)) {
            $reVal = true;
        }
        return $reVal;
    }

    public function validatePhone($attribute, $params) {
        if (!$this->hasErrors()) {
            if (!$this->checkvalidatePhone($this->phone)) {
                $this->addError($attribute, 'Số điện thoại không hợp lệ');
            }
        }
    }

    public function checkvalidatePhone($phone) {
        $reVal = false;
        $arr_3dauso = ['090', '091', '092', '093', '094', '095', '096', '097', '098', '099', '089', '088', '086', '032', '033', '034', '035', '036', '037', '038', '039', '070', '079', '077', '076', '078', '083', '084', '085', '081', '082', '056', '059', '058'];
        $arr_4dauso = ['0162', '0163', '0164', '0165', '0166', '0167', '0168', '0169', '0123', '0125', '0127', '0129', '0120', '0121', '0122', '0124', '0126', '0128', '0188', '0199'];
        //0904999174 +840904999174 +8490999174  01664999174 +841664999174 +8401664999174   09x 01xx 849x 8409x 8401xx 841xx +849x +8409x +8401xx +841xx
        $phone = preg_replace('/\s+/', '', $phone);
        if (strlen($phone) >= 10 && strlen($phone) <= 14) {
            $phone_new = preg_replace('/[^0-9]/', '', $phone);
            $sub2 = substr($phone, 0, 2);
            if ($sub2 === '09' || $sub2 === '08' || $sub2 === '07' || $sub2 === '03' || $sub2 === '05') {
                if ((strlen($phone) == strlen($phone_new)) && (strlen($phone_new) == 10)) {
                    $reVal = true;
                }
            } elseif ($sub2 == '84') {
                $sub_3 = substr($phone, 2, 1);
                $start = 2;
                switch ($sub_3) {
                    case'0':
                        $s3 = substr($phone, $start, 3);
                        if (in_array($s3, $arr_3dauso)) {
                            if ((strlen($phone) == strlen($phone_new)) && (strlen($phone_new) == 12)) {
                                $reVal = true;
                            }
                        } else {
                            $s4 = substr($phone, $start, 4);
                            if (in_array($s4, $arr_4dauso)) {
                                if ((strlen($phone) == strlen($phone_new)) && (strlen($phone_new) == 13)) {
                                    $reVal = true;
                                }
                            }
                        }
                        break;
                    case'9':
                    case'7':
                    case'5':
                    case'3':
                    case'8':
                        $s2 = '0' . substr($phone, $start, 2);
                        if (in_array($s2, $arr_3dauso)) {
                            if ((strlen($phone) == strlen($phone_new)) && (strlen($phone_new) == 11)) {
                                $reVal = true;
                            }
                        }
                        break;
                    case'1':
                        $s3 = '0' . substr($phone, $start, 3);
                        if (in_array($s3, $arr_4dauso)) {
                            if ((strlen($phone) == strlen($phone_new)) && (strlen($phone_new) == 12)) {
                                $reVal = true;
                            }
                        }
                        break;
                }
            } else {
                $sub3 = substr($phone, 0, 3);
                if ($sub3 == '+84') {
                    $start = 3;
                    $sub_3 = substr($phone, $start, 1);
                    switch ($sub_3) {
                        case'0':
                            $s3 = substr($phone, $start, 3);
                            if (in_array($s3, $arr_3dauso)) {
                                if ((strlen($phone) == strlen($phone_new) + 1) && (strlen($phone_new) == 12)) {
                                    $reVal = true;
                                }
                            } else {
                                $s4 = substr($phone, $start, 4);
                                if (in_array($s4, $arr_4dauso)) {
                                    if ((strlen($phone) == strlen($phone_new) + 1) && (strlen($phone_new) == 13)) {
                                        $reVal = true;
                                    }
                                }
                            }
                            break;
                        case'9':
                        case'7':
                        case'5':
                        case'3':
                        case'8':
                            $s2 = '0' . substr($phone, $start, 2);
                            if (in_array($s2, $arr_3dauso)) {
                                if ((strlen($phone) == strlen($phone_new) + 1) && (strlen($phone_new) == 11)) {
                                    $reVal = true;
                                }
                            }
                            break;
                        case'1':
                            $s3 = '0' . substr($phone, $start, 3);
                            if (in_array($s3, $arr_4dauso)) {
                                if ((strlen($phone) == strlen($phone_new) + 1) && (strlen($phone_new) == 12)) {
                                    $reVal = true;
                                }
                            }
                            break;
                    }
                } else {
                    $sub4 = substr($phone, 0, 4);
                    if (in_array($sub4, $arr_4dauso)) {
                        if ((strlen($phone) == strlen($phone_new)) && (strlen($phone_new) == 11)) {
                            $reVal = true;
                        }
                    }
                }
            }
            if ($reVal) {
                if (in_array($phone, ['01234567890'])) {
                    $reVal = false;
                }
            }
        }
        return $reVal;
    }

    public function getRelAuthuser() {
        return $this->hasOne(AuthAssignment::className(), ['id' => 'id']);
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'cities_id' => 'Tỉnh / Thành Phố',
            'cities_district_id' => 'Quận / Huyện',
            'first_name' => 'Họ tên',
            'password' => 'Mật khẩu',
            'email' => 'Email',
            'phone' => 'Số điện thoại',
            'avatar' => 'Avatar',
            'gender' => 'Giới tính',
            'dob' => 'Ngày sinh',
            'address' => 'Địa chỉ',
            'created_at' => 'Ngày tạo',
            'updated_at' => 'Ngày cập nhật',
            'last_signined_time' => 'Last login',
            'is_admin' => 'Tài khoản',
            'status' => 'Trạng thái',
            'password_repeat' => 'Nhập lại Mật khẩu',
            'current_pass' => 'Mật khẩu hiện tại',
            'new_pass' => 'Mật khẩu mới',
            'retype_pass' => 'Nhập lại Mật khẩu mới',
            'city_name' => 'Tỉnh / Thành Phố',
            'district_name' => 'Quận / Huyện',
            'captcha' => 'Mã xác thực',
            'emailphone' => 'Email/Số điện thoại',
            'secret_key' => 'Secret key',
            'role' => 'Nhóm quyền',
        ];
    }

    public static function findIdentity($id) {
        return static::findOne($id);
    }

    public function checkOldPassword($attribute, $params) {
        if (!Yii::$app->getSecurity()->validatePassword($this->current_pass, $this->password)) {
            $this->addError($attribute, 'Mật khẩu không đúng vui lòng kiểm tra lại');
        }
    }

    /**
     * @inheritdoc
     */
    public static function findIdentityByAccessToken($token, $type = null) {
        return static::findOne(['access_token' => $token]);
        /*
          foreach (self::$users as $user) {
          if ($user['accessToken'] === $token) {
          return new static($user);
          }
          }

          return null;
         */
    }

    public static function findByEmail($email) {
        return static::findOne(['email' => $email, 'status' => 1]);
    }

    public static function findByEmailPhone($email_phone) {
        return static::find()->where('(email = :email OR phone=:phone)  AND status=:status')->addParams([':email' => $email_phone, ':phone' => $email_phone, ':status' => 1])->one();
    }

    /**
     * Finds user by password reset token
     *
     * @param  string $token password reset token
     * @return static|null
     */
    public static function findByPasswordResetToken($token) {
        $expire = \Yii::$app->params['user.passwordResetTokenExpire'];
        $parts = explode('_', $token);
        $timestamp = (int) end($parts);
        if ($timestamp + $expire < time()) {
            // token expired
            return null;
        }
        return static::findOne([
                    'password_reset_token' => $token
        ]);
    }

    /**
     * @inheritdoc
     */
    public function getId() {
        return $this->getPrimaryKey();
    }

    /**
     * @inheritdoc
     */
    public function getAuthKey() {
        return $this->authKey;
    }

    /**
     * @inheritdoc
     */
    public function validateAuthKey($authKey) {
        return $this->authKey === $authKey;
    }

    public function generatePassword($password) {
        return Yii::$app->getSecurity()->generatePasswordHash($password);
    }

    /**
     * Validates password
     *
     * @param  string $password password to validate
     * @return boolean if password provided is valid for current user
     */
    public function validatePassword($password) {
        return Yii::$app->getSecurity()->validatePassword($password, $this->password);
    }

    // Generates "remember me" authentication key
    public function generateAuthKey() {
        $this->auth_key = Yii::$app->getSecurity()->generateRandomKey();
    }

    // Generates new password reset token
    public function generatePasswordResetToken() {
        $this->password_reset_token = Yii::$app->getSecurity()->generateRandomKey() . '_' . time();
    }

    // Removes password reset token
    public function removePasswordResetToken() {
        $this->password_reset_token = null;
    }

    public function beforeSave($insert) {
        if (parent::beforeSave($insert)) {
            if ($this->isNewRecord) {
                $this->created_at = date('Y-m-d H:i:s');
            }
            $this->updated_at = date('Y-m-d H:i:s');
            $this->first_name = strip_tags($this->first_name);
        }
        return true;
    }

    public function afterSave($insert, $changedAttributes) {
        parent::afterSave($insert, $changedAttributes);
    }

    public static function is_adminsupper() {
        return Yii::$app->user->can('/*');
    }

}
