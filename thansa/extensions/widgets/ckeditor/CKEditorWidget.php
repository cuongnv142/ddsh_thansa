<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 17/01/19
 * Time: 13:47
 */

namespace app\extensions\widgets\ckeditor;

use app\assets\CkeditorAsset;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Json;
use yii\web\View;
use yii\widgets\InputWidget;

class CKEditorWidget extends InputWidget
{
    use CKEditorTrait;

    /**
     * @params:
     *['clientOptions' => [
            'toolbar' = [
            { name: 'document', groups: [ 'mode', 'document', 'doctools' ], items: [ 'Source', 'Preview' ] },
            { name: 'clipboard', groups: [ 'clipboard', 'undo' ], items: [ 'Cut', 'Copy', 'Paste', 'PasteText', 'PasteFromWord', '-', 'Undo', 'Redo' ] },
            //{ name: 'editing', groups: [ 'find', 'selection', 'spellchecker' ], items: [ 'Find', 'Replace', '-', 'SelectAll', '-', 'Scayt' ] },
            //{ name: 'forms', items: [ 'Form', 'Checkbox', 'Radio', 'TextField', 'Textarea', 'Select', 'Button', 'ImageButton', 'HiddenField' ] },
            { name: 'insert', items: [ 'Youtube', 'Bdsimage', 'Image', 'Flash', 'Table', 'HorizontalRule', 'Smiley', 'SpecialChar', 'PageBreak', 'Iframe' ] },
            '/',
            { name: 'basicstyles', groups: [ 'basicstyles', 'cleanup' ], items: [ 'Bold', 'Italic', 'Underline', 'Strike', 'Subscript', 'Superscript', '-', 'RemoveFormat' ] },
            { name: 'paragraph', groups: [ 'list', 'indent', 'blocks', 'align', 'bidi' ], items: [ 'NumberedList', 'BulletedList', '-', 'Outdent', 'Indent', '-', 'Blockquote', 'CreateDiv', '-', 'JustifyLeft', 'JustifyCenter', 'JustifyRight', 'JustifyBlock', '-', 'BidiLtr', 'BidiRtl', 'Language' ] },
            { name: 'links', items: [ 'Link', 'Unlink', 'Anchor' ] },
            '/',
            { name: 'styles', items: [ 'Styles', 'Format', 'Font', 'FontSize' ] },
            { name: 'colors', items: [ 'TextColor', 'BGColor' ] },
            //{ name: 'tools', items: [ 'Maximize', 'ShowBlocks' ] },
            //{ name: 'others', items: [ '-' ] },
            //{ name: 'about', items: [ 'About' ] }
            ];
     */
    public function init()
    {
        parent::init();
        $this->initOptions();
        $this->registerAsset();
    }

    public function run()
    {
        $view = $this->getView();
        $id = $this->options['id'];

        $strClientOptions = Json::encode($this->clientOptions);

        $script = <<<JAVASCRIPT
            CKEDITOR.replace('{$id}', {$strClientOptions});
JAVASCRIPT;
        $view->registerJs($script, View::POS_READY);

        Html::addCssClass($this->options, 'form-control');
        $content = '';
        if ($this->hasModel()) {
            $content .= Html::activeTextarea($this->model, $this->attribute, $this->options);
        } else {
            $content .= Html::textarea($this->name, $this->value, $this->options);
        }

        return $content;
    }

    public function registerAsset()
    {
        $baseUrl = \Yii::$app->request->BaseUrl;
        $view = $this->getView();
        $script = <<<JS
    var ckEditor_baseUrl = '{$baseUrl}';
JS;

        $view->registerJs($script, View::POS_HEAD);
        CkeditorAsset::register($view);
//        $js = <<<JS
//            CKEDITOR.config.extraPlugins = 'justify';
//            CKEDITOR.config.extraPlugins = 'font';
//            CKEDITOR.config.extraPlugins = 'colorbutton';
//
//            CKEDITOR.config.width = 'auto';
//JS;
//        $view->registerJs($js);

    }

}

?>

