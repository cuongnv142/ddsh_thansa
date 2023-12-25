<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "dtv_loai".
 *
 * @property int $id
 * @property string|null $name
 * @property string|null $name_latinh
 * @property int|null $loai Phân loại: 0: thực vât, 1: động vật
 * @property int|null $id_dtv_ho
 * @property string|null $ten_khac
 * @property string|null $dac_diem
 * @property string|null $phan_bo
 * @property string|null $file_dinh_kem
 * @property string|null $nguon_tai_lieu
 * @property int|null $muc_do_bao_ton_iucn
 * @property int|null $muc_do_bao_ton_sdvn
 * @property int|null $muc_do_bao_ton_ndcp
 * @property int|null $status
 * @property string|null $created_at
 * @property int|null $created_by
 * @property string|null $updated_at
 * @property int|null $updated_by
 */
class DtvLoai extends ActiveRecord {

    public static $arrMucDoBaoTonIUCN = [
        1 => 'EX- Tuyệt chủng',
        2 => 'EW-Tuyệt chủng ngoài thiên nhiên',
        3 => 'CR-Rất nguy cấp',
        4 => 'EN-Nguy cấp',
        5 => 'VU-Sẽ nguy cấp',
        6 => 'LR-Ít nguy cấp',
        7 => 'DD-Thiếu dẫn liệu',
        8 => 'NE-Không đánh giá',
    ];
    public static $arrMucDoBaoTonSDVN = [
        21 => 'EX- Tuyệt chủng',
        22 => 'EW-Tuyệt chủng ngoài thiên nhiên',
        23 => 'CR-Rất nguy cấp',
        24 => 'EN-Nguy cấp',
        25 => 'VU-Sẽ nguy cấp',
        26 => 'LR-Ít nguy cấp',
        27 => 'DD-Thiếu dẫn liệu',
        28 => 'NE-Không đánh giá',
    ];
    public static $arrMucDoBaoTonNDCP = [
        0 => [
            31 => 'Nhóm IA',
            32 => 'Nhóm IIA',
        ],
        1 => [
            41 => 'Nhóm IB',
            42 => 'Nhóm IIB',
        ]
    ];

    /**
     * {@inheritdoc}
     */
    public static function tableName() {
        return 'dtv_loai';
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['name', 'loai', 'id_dtv_ho'], 'required'],
            [['loai', 'id_dtv_ho', 'muc_do_bao_ton_iucn', 'muc_do_bao_ton_sdvn', 'muc_do_bao_ton_ndcp','muc_do_bao_ton_nd64cp', 'status', 'created_by', 'updated_by'], 'integer'],
            [['dac_diem', 'file_dinh_kem','gia_tri_su_dung'], 'string'],
            [['created_at', 'updated_at'], 'safe'],
            [['name', 'name_latinh', 'ten_khac', 'phan_bo', 'nguon_tai_lieu'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'name' => 'Tên tiếng việt',
            'name_latinh' => 'Tên Latinh',
            'loai' => 'Phân loại',
            'status' => 'Trạng thái',
            'id_dtv_ho' => 'Họ',
            'ten_khac' => 'Tên khác',
            'dac_diem' => 'Đặc điểm hình thái, sinh thái',
            'phan_bo' => 'Vùng phân bố',
            'file_dinh_kem' => 'Ảnh đính kèm',
            'nguon_tai_lieu' => 'Nguồn tài liệu',
            'muc_do_bao_ton_iucn' => 'Mức độ bảo tồn IUCN',
            'muc_do_bao_ton_sdvn' => 'Mức độ bảo tồn Sách đỏ Việt Nam',
            'muc_do_bao_ton_ndcp' => 'Mức độ bảo tồn Nghị định 84-CP',
            'muc_do_bao_ton_nd64cp' => 'Mức độ bảo tồn Nghị định 64-CP',
            'created_at' => 'Created At',
            'created_by' => 'Created By',
            'updated_at' => 'Updated At',
            'updated_by' => 'Updated By',
            'gia_tri_su_dung'=>'Công dụng/Giá trị sử dụng',
        ];
    }

    public function beforeSave($insert) {
        if (parent::beforeSave($insert)) {
            if ($this->isNewRecord) {
                $this->created_at = date('Y-m-d H:i:s');
                $this->created_by = (int) Yii::$app->getUser()->getId();
            }

            $this->updated_at = date('Y-m-d H:i:s');
            $this->updated_by = (int) Yii::$app->getUser()->getId();
        }
        return true;
    }

}
