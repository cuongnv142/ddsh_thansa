<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 17/01/19
 * Time: 14:57
 */

namespace app\extensions\widgets\ckeditor;

use yii\helpers\ArrayHelper;

trait CKEditorTrait
{

    public $clientOptions = [];

    protected function initOptions()
    {
        $options = [
            'height' => '200px',
            'allowedContent' => true,
            'toolbar' => [
                [
                    'name' => 'styles',
                    'items' => ['Format', 'FontSize']
                ],
                [
                    'name' => 'basicstyles',
                    'groups' => ['basicstyles', 'cleanup'],
                    'items' => ['Bold', 'Italic', 'Underline']
                ],
                [
                    'name' => 'paragraph',
                    'groups' => ['list', 'indent', 'blocks', 'align', 'bidi'],
                    'items' => ['NumberedList', 'BulletedList', '-', 'Outdent', 'Indent', '-', 'JustifyLeft', 'JustifyCenter', 'JustifyRight', 'JustifyBlock']
                ],
                [
                    'name' => 'links',
                    'items' => ['Link', 'Unlink']
                ],
                [
                    'name' => 'insert',
                    'items' => ['Youtube', 'Image', 'Table']
                ],
//                [
//                    "name" => "links",
//                    "groups" => ["links"]
//                ],
//                [
//                    "name" => "paragraph",
//                    "groups" => ["list", "blocks"]
//                ],
//                [
//                    "name" => "document",
//                    "groups" => ["mode"]
//                ],
//                [
//                    "name" => "insert",
//                    "groups" => ["insert"]
//                ],
//                [
//                    "name" => "styles",
//                    "groups" => ["styles"]
//                ],
//                [
//                    "name" => "about",
//                    "groups" => ["about"]
//                ]
            ],
            'removeDialogTabs' => 'image:Upload;image:advance',
            'removeButtons' => 'ImageButton',
            'filebrowserBrowseUrl' => '',
            'filebrowserUploadUrl' => '',
        ];


        $this->clientOptions = ArrayHelper::merge($options, $this->clientOptions);
    }
}