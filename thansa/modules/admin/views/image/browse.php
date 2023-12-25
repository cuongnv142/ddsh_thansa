<?php
use yii\widgets\ListView;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\Pjax;
app\modules\admin\AdminAsset::register($this);
$request = Yii::$app->request;
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8"/>
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <?= Html::csrfMetaTags() ?>
        <title>File browser</title>
        <?php $this->head() ?>
        <style type="text/css">
            .cellimg {
                width: 154px;
                height: 180px
            }
        </style>
    </head>
    <?php $this->beginBody() ?>
    <body>
        <input type="hidden" id="form-key-csrf" data-key-name="<?=Yii::$app->request->csrfParam?>" data-key-value="<?=Yii::$app->request->getCsrfToken()?>" />
        <div class="container">
            <div class="col-sm-3">
                <h4>Danh sách thư mục</h4>
<?php
global $glob_id_dir;
$glob_id_dir = $id_dir;

Pjax::begin(['id' => 'image_filter']);
echo '<a style="display:none" id="fake-url" href="'. Url::current(['id_dir' => 'ID_DIR']) .'">Fake</a>';
?>
<div id="jstree"></div>
<?php
$ckName = $request->get('CKEditor');
$urlReferrer = $request->getReferrer();
$idRoot = 0;
$keyState = 'jstree2015';
if ($urlReferrer !== null) {
    $configCKEditor = require(Yii::getAlias('@app') . DIRECTORY_SEPARATOR . 'modules/admin/config/ckeditor.php');
    $controllerName = '';
    if (strpos($urlReferrer, '/project/') !== false) {
        $controllerName = 'project';
        $keyState = 'jstreeproject';
    } elseif (strpos($urlReferrer, '/deal/') !== false) {
        $controllerName = 'deal';
        $keyState = 'jstreedeal';
    } elseif (strpos($urlReferrer, '/design/') !== false) {
        $controllerName = 'design';
        $keyState = 'jstreedesign';
    }
    if ($controllerName != '' && isset($configCKEditor['tree']) && isset($configCKEditor['tree'][$controllerName])) {
        $idRoot = $configCKEditor['tree'][$controllerName];
    }
}

echo '<script>
    var keySateJsTree = "' . $keyState . '",
uMkDir = "' . Url::toRoute('image/mkdir') . '",
uRenameDir = "' . Url::toRoute('image/renamedir') . '",    
uRemoveDir = "' . Url::toRoute('image/removedir') . '",    
uFetchRoot = "' . Url::toRoute(['image/getroot', 'rid' => $idRoot]) . '", uFetchChildren = "' . Url::toRoute('image/getchildren') . '";';
echo '</script>';

$this->registerJsFile('@web/js/tree/image.js', ['depends' => 'yii\bootstrap\BootstrapAsset']);

$this->registerJs(
'$("document").ready(function(){ 
    $("#image_filter").on("pjax:success", function() {
        $.pjax.reload({container:"#image_result",async:false});
    });
});');
Pjax::end();
?>            
            
            <div class='form-group'>
                <input type='text' id='dirname_new' class='form-control' placeholder="Tên thư mục mới" />
            </div>
            <button class='btn btn-primary' onclick='createNewImageDir();'>Tạo thư mục mới</button>
            
            </div>
            <div class="col-sm-9">
            <div class="row">
                <iframe name="up_iframe" src="" style="display:none" border="0"></iframe>
                <form onsubmit="$('#id_dir').val($('#id_dir_pjax').val());return true;" method="post" action="<?=Url::toRoute('image/uploadfiles')?>" enctype="multipart/form-data" target="up_iframe">
                <div class="widget-main">
                    <input multiple="multiple" type="file" name="inputfiles[]" class="file-input" />
                </div>
                <input type="hidden" id="id_dir" name="id_dir" value="<?=$id_dir?>" />
                    <div class="center">
                        <div id="uploadSatus"></div>
                <button id="btnUploadNow" class="btn btn-primary" type="submit" onclick="uploadNow();"><i class="icon-save bigger-110"></i> Upload</button>
                    </div>
                </form>
            </div>
            
            <?php Pjax::begin(['id' => 'image_result']); ?>
            <input type="hidden" id="id_dir_pjax" value="<?=$id_dir?>" />
            <div class="row" style="margin-top: 10px">
                <?=
                ListView::widget([
                    'dataProvider' => $dataProvider,
                    'itemView' => '_item',
                    'summary' => '', // Khong hien thi co bao nhieu anh
                    'itemOptions' => [
                        'tag' => 'li',
                        'class' => 'cellimg'
                    ],
                    'options' => [
                        'tag' => 'ul',
                        'class' => 'ace-thumbnails',
                    ],
                    'layout' => "{summary}\n{items}\n<div class='clearfix'></div>{pager}"
                ]);
                ?>
            </div>
            <?php Pjax::end(); ?>
            
            </div>
        </div>
     
    <script type="text/javascript">
      function appendToCKEditor(imgTag) {
        //return appendToCKEditorQuick(imgTag);
        if (!window.opener) return;

        var url = imgTag.getAttribute('data-use-src');
        window.opener.CKEDITOR.tools.callFunction(<?php echo isset($_GET['CKEditorFuncNum']) ? intval($_GET['CKEditorFuncNum']) : 0; ?>, url, function() {
            // Get the reference to a dialog window.
            var element,
                dialog = this.getDialog();
            // Check if this is the Image dialog window.
            if ( dialog.getName() == 'image' ) {
                /*
                // Get the reference to a text field that holds the "alt" attribute.
                element = dialog.getContentElement( 'info', 'txtAlt' );
                // Assign the new value.
                if ( element )
                    element.setValue( 'alt text' );
                */
                element = dialog.getContentElement('info', 'txtWidth');
                if (element) {
                    
                }
            }
            //return false;
        });
        window.close();
      }
      
    function appendToCKEditorQuick(imgTagId, closeMe) {
        var imgTag = document.getElementById(imgTagId);
        if (!window.opener) return;
        var url = imgTag.getAttribute('data-use-src');
        var altText = '';
        var text = "<p style='text-align: center;'><img src='"+url+"' alt=\"" + altText + "\"/></p>";
        window.opener.CKEDITOR.instances['<?=isset($_GET['CKEditor']) ? $_GET['CKEditor']:'noid'?>'].insertHtml(text);
        if (typeof closeMe !== 'undefined') {
            window.close();
        }
    }
      
    function delete_file(id, element) {
        if (id && element) {
            if (confirm("Bạn muốn xóa ảnh này?")) {
                var csrfParam = $('#form-key-csrf').attr('data-key-name');
                var csrfToken = $('#form-key-csrf').attr('data-key-value');
                //alert('Like comment co id =' + id);
                var dataPost = {id: id};
                dataPost[csrfParam] = csrfToken;

                jQuery.ajax({
                    url: '<?php echo Url::to(['image/delete']) ?>',
                    type: "POST",
                    data: dataPost,
                    dataType: "json",
                    success: function (obj) {
                        if (obj.err === 0) {
                            $(element).parents('li').remove();
                        } else {
                            alert('Có lỗi xảy ra khi xóa ảnh');
                        }
                    }
                });
            }
        }
        return false;
    }
    
    function createNewImageDir() {
        var name = $('#dirname_new').val();
        var id_parent = $('#id_dir_pjax').val();
        var csrfParam = $('#form-key-csrf').attr('data-key-name');
        var csrfToken = $('#form-key-csrf').attr('data-key-value');
        var dataPost = {name: name, id_parent: id_parent};
        $('#dirname_new').val('');
        dataPost[csrfParam] = csrfToken;
        jQuery.ajax({
            url: '<?php echo Url::to(['image/mkdir']) ?>',
            type: "POST",
            data: dataPost,
            dataType: "json",
            success: function (obj) {
                if (obj.err === 0) {
                    var ref = $('#jstree').jstree(true),
                    sel = ref.get_selected();
                    if(!sel.length) {
                        ref.create_node('#', {id: obj.id, text: obj.name});
                    } else {
                        sel = sel[0];
                        sel = ref.create_node(sel, {id: obj.id, text: obj.name});
                    }
                } else {
                    if (obj.err == 1) {
                        alert('Tên thư mục không được để trống');
                    } else if (obj.err == 2) {
                        alert('Tên thư mục không được quá dài');
                    } else if (obj.err == 3) {
                        alert('Tên thư mục chỉ được có các ký tự a-z 0-9 CÁCH và _ -');
                    } else {
                        alert('Có lỗi xảy ra khi tạo thư mục');
                    }
                }
            }
        });
    }
    
    function uploadNow() {
        $('#uploadSatus').html('Đang upload...').addClass('text-sucess');
        $('#btnUploadNow').hide();
    }
    
    function uploadComplete() {
        // Reset upload form
        $("div.ace-file-input a.remove").trigger("click");
        // Co the goi code goc thay vi trigger click o tren: $("input.file-input").data("ace_file_input").reset_input();

        $.pjax.reload({container:"#image_result",async:false});
        
        $('#uploadSatus').html('').removeClass('text-sucess');
        $('#btnUploadNow').show();
    }
    </script>
  </body>
   <?php $this->endBody() ?>
</html>
<?php $this->endPage() ?>