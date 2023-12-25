<?php

define("DT", "tmp");

require_once("CDir.php");
require_once("IResize.php");
require_once("LFunc.php");

switch ($_POST['action']) {
    case 'upload':
        if (!empty($_FILES['filedata']) && $_FILES['filedata']['error'] <= 0) {
            $filename = (isset($_POST["filename"])) ? $_POST["filename"] : false;
            $dirUpload = dirname(__FILE__) . DIRECTORY_SEPARATOR . "up";
            if ($filename) {
                $arrpath = explode('/', $filename);
                $name = end($arrpath);
                array_pop($arrpath);
                $cdir = new Cdir($dirUpload, $arrpath);
                $image_upload = $cdir->dir . DS . $name;
                if (move_uploaded_file($_FILES['filedata']['tmp_name'], $image_upload)) {
                    var_dump(http_response_code(200));
                    die();
                } else {
                    var_dump(http_response_code(404));
                    die("File not upload.");
                }
            }
        } else {
            var_dump(http_response_code(404));
            die("File not upload.");
        }
        break;
    case 'uploadWithUrl':
        if (!empty($_POST['source']) && $_POST['source']) {
            $url = $_POST['source'];
            $url = preg_replace("/ /", "%20", $url);
            $filename = (isset($_POST["filename"])) ? $_POST["filename"] : false;
            $dirUpload = dirname(__FILE__) . DIRECTORY_SEPARATOR . "up";
            if ($filename) {
                $arrpath = explode('/', $filename);
                $name = end($arrpath);
                array_pop($arrpath);
                $cdir = new Cdir($dirUpload, $arrpath);
                $image_upload = $cdir->dir . DS . $name;
                if (copy($url, $image_upload)) {
                    var_dump(http_response_code(200));
                    die();
                } else {
                    var_dump(http_response_code(404));
                    die("File not upload.");
                }
            }
        } else {
            var_dump(http_response_code(404));
            die("File not upload.");
        }
        break;
    case 'delete':
        if (!empty($_POST['filename']) && $_POST['filename']) {
            $filename = (isset($_POST["filename"])) ? $_POST["filename"] : false;
            $dir = realpath(__DIR__ . DIRECTORY_SEPARATOR . 'u');
            if (!is_dir($dir)) {
                var_dump(http_response_code(404));
                echo 'Is not dir';
                die();
            }
            if ($filename) {
                $path = $dir . DIRECTORY_SEPARATOR . $filename;
                if (is_dir($path)) {
                    rmdir($path);
                } else {
                    unlink($path);
                }
                var_dump(http_response_code(200));
            }
        } else {
            var_dump(http_response_code(404));
            die("File not upload.");
        }
        break;
    case 'createThumb':
        if (!empty($_POST['filename']) && $_POST['filename']) {
            $filename = (isset($_POST["filename"])) ? $_POST["filename"] : false;
            $width = (int) ((isset($_POST["width"])) ? $_POST["width"] : 0);
            $height = (int) ((isset($_POST["height"])) ? $_POST["height"] : 0);
            $dirUpload = dirname(__FILE__) . DIRECTORY_SEPARATOR . "up";
            if ($filename) {
                $arrpath = explode('/', $filename);
                $name = end($arrpath);
                array_pop($arrpath);
                $cdir = new Cdir($dirUpload, $arrpath);
                if ($width && $height) {
                    $forderName = $width . '_' . $height;
                } elseif ($width && !$height) {
                    $forderName = 'w' . $width;
                    $height = null;
                } elseif (!$width && $height) {
                    $forderName = 'h' . $height;
                    $width = null;
                }
                if (!file_exists($cdir->dir . DS . $forderName . DS . $name)) {
                    $cdir->add($forderName);
//                    try {
//                        $image = $filename;
//                        $im = new Imagick();
//                        $im->pingImage($image);
//
//                        /*                         * * read the image into the object ** */
////                        $im->readImage($image);
//                        echo '<pre>';
//                        var_dump($im->pingImage($image));
//                        die();
//
//                        $thumb = new Imagick();
//
//                        list($newX, $newY) = LFunc::scaleImage(
//                                        $thumb->getImageWidth(), $thumb->getImageHeight(), $newMaximumWidth, $newMaximumHeight);
//
//                        $thumb->thumbnailImage($newX, $newY);
//
//                        $thumb->writeImage($cdir->dir . DS . $forderName . DS . $name);
//                    } catch (Exception $e) {
//                        echo '<pre>';
//                        var_dump( $e->getMessage());
//                        die();
//                    }
                    $source_image_path = $cdir->dir . DS . $name;
                    $thumbnail_image_path = $cdir->dir . DS . $forderName . DS . $name;

                    list($source_image_width, $source_image_height, $source_image_type) = getimagesize($source_image_path);
                    switch ($source_image_type) {
                        case IMAGETYPE_GIF:
                            $source_gd_image = imagecreatefromgif($source_image_path);
                            break;
                        case IMAGETYPE_JPEG:
                            $source_gd_image = imagecreatefromjpeg($source_image_path);
                            break;
                        case IMAGETYPE_PNG:
                            $source_gd_image = imagecreatefrompng($source_image_path);
                            break;
                    }
                    if ($source_gd_image === false) {
                        return false;
                    }
                    $source_aspect_ratio = $source_image_width / $source_image_height;
                    $thumbnail_aspect_ratio = $width / $height;
                    if ($source_image_width <= $width && $source_image_height <= $height) {
                        $thumbnail_image_width = $source_image_width;
                        $thumbnail_image_height = $source_image_height;
                    } elseif ($thumbnail_aspect_ratio > $source_aspect_ratio) {
                        $thumbnail_image_width = (int) ($height * $source_aspect_ratio);
                        $thumbnail_image_height = $height;
                    } else {
                        $thumbnail_image_width = $width;
                        $thumbnail_image_height = (int) ($width / $source_aspect_ratio);
                    }
                    $thumbnail_gd_image = imagecreatetruecolor($thumbnail_image_width, $thumbnail_image_height);
                    imagecopyresampled($thumbnail_gd_image, $source_gd_image, 0, 0, 0, 0, $thumbnail_image_width, $thumbnail_image_height, $source_image_width, $source_image_height);

                    $img_disp = imagecreatetruecolor($width, $width);
                    $backcolor = imagecolorallocate($img_disp, 0, 0, 0);
                    imagefill($img_disp, 0, 0, $backcolor);

                    imagecopy($img_disp, $thumbnail_gd_image, (imagesx($img_disp) / 2) - (imagesx($thumbnail_gd_image) / 2), (imagesy($img_disp) / 2) - (imagesy($thumbnail_gd_image) / 2), 0, 0, imagesx($thumbnail_gd_image), imagesy($thumbnail_gd_image));

                    imagejpeg($img_disp, $thumbnail_image_path, 90);
                    imagedestroy($source_gd_image);
                    imagedestroy($thumbnail_gd_image);
                    imagedestroy($img_disp);
                }
                echo $cdir->url . '/' . $forderName . '/' . $name;
                var_dump(http_response_code(200));
            }
        } else {
            var_dump(http_response_code(404));
            die("File not upload.");
        }
        break;
    default :
        var_dump(http_response_code(404));
        die("File not upload.");
        break;
}
?>