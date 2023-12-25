
<?php
$arrKey = array('post_max_size', 'upload_max_filesize', 'max_execution_time', 'memory_limit');
foreach ($arrKey as $key) {
    echo '<strong>' . $key . '</strong>: ' . ini_get($key) . '<br />';
}
?>
<form action="" method="post" enctype="multipart/form-data">
    <input type="file" name="ftest" />
    <input type="submit" value="Upload" />
</form> 


