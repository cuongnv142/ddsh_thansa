<?php

namespace app\models;

use yii\db\ActiveRecord;

/**
 * This is the model class for table "site_contact".
 *
 * @property string $id
 * @property string $name
 * @property string $email
 * @property string $phone
 * @property string $hotline
 * @property string $fax
 * @property string $address
 * @property string $link_face
 * @property string $link_insta
 * @property string $link_youtube
 * @property string $link_twitter
 * @property string $link_twitter
 * @property string $link_zalo
 * @property string $link_messenger
 * @property string $link_map
 * @property string $embed_script_head
 * @property string $embed_script_body_begin
 * @property string $embed_script_body_end
 * @property string $link_favicon
 * @property string $link_logo
 * @property string $link_logo_footer
 * @property string $language
 */
class SiteContact extends ActiveRecord {

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return 'site_contact';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['name'], 'required'],
            [['multitext', 'embed_script_head', 'embed_script_body_begin', 'embed_script_body_end', 'link_map'], 'string'],
            [['name', 'email', 'phone', 'hotline', 'fax', 'address', 'link_face', 'link_insta', 'link_youtube', 'link_messenger', 'link_favicon', 'link_twitter', 'link_zalo', 'link_logo', 'link_logo_footer'], 'string', 'max' => 255],
            [['language'], 'default', 'value' => 'vi'],
            [['language'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'name' => 'Tiêu đề',
            'email' => 'Email',
            'phone' => 'Điện thoại',
            'hotline' => 'Hotline',
            'fax' => 'Sologan',
            'address' => 'Địa chỉ',
            'link_face' => 'Link Face',
            'link_youtube' => 'Link Youtube',
            'link_twitter' => 'Link Twitter',
            'link_insta' => 'Link Instagram',
            'link_zalo' => 'Link Zalo',
            'multitext' => 'Multitext',
            'link_messenger' => 'Link Messenger',
            'link_map' => 'Link bản đồ',
            'link_favicon' => 'Favicon',
            'embed_script_head' => 'Nhúng mã Script ở Head',
            'embed_script_body_begin' => 'Nhúng mã Script ở đầu Body',
            'embed_script_body_end' => 'Nhúng mã Script ở cuối Body',
            'link_logo' => 'Logo',
            'link_logo_footer' => 'Logo Footer',
            'language' => 'Ngôn ngữ',
        ];
    }

}
