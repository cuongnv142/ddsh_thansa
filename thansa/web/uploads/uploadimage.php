<?php

//$allowIps = array('118.70.74.161');
//if (!in_array($_SERVER["REMOTE_ADDR"], $allowIps) && !empty($allowIps)) {
//    header('HTTP/1.1 401 Unauthorized', true, 401);
//    exit('Not authorized' . $_SERVER["REMOTE_ADDR"]);
//}


define("DT", "tmp");
require_once("Config.php");
require_once("CDir.php");
require_once("IResize.php");
require_once("LFunc.php");

if (isset($_GET['action']) && $_GET['action'] == "createThumb") {
    $urlRoot = LFunc::getFullUrl();
    $url = '';
    $typeMethod = 0; // 0 : resize, 1:crop
    if (isset($_GET['url'])) {
        $url = $_GET['url'];
        if (strpos($url, '/uploads/') === 0) {
            $url = str_replace('/uploads/', '', $url);
        }
    }
    $config = new Config($url);
    $pathRoot = dirname(__FILE__);
    $filename = $pathRoot . DS . $config->baseurl . $config->nameimage;
    if (is_file($filename) && file_exists($filename) && $config->validate()) {
        $newpath = $config->baseurl;
        $forderName = '';
        $iresize = new IResize();
        $iresize->load($filename);
        if (strpos($config->thumb, "c") !== false) {
            $typeMethod = 1; //crop
        } elseif (strpos($config->thumb, "wm") !== false) {
            $typeMethod = 2; //watermark
        }
        if ($typeMethod == 1) {
            $arrthumb = explode('_', $config->thumb);
            $width = (isset($arrthumb[1])) ? (int)$arrthumb[1] : '';
            $height = (isset($arrthumb[2])) ? (int)$arrthumb[2] : '';
            $x = (isset($arrthumb[3])) ? (int)$arrthumb[3] : '';
            $y = (isset($arrthumb[4])) ? (int)$arrthumb[4] : '';
            if ($width && $height) {
                $forderName = $config->thumb;
                if (!is_dir($newpath . $forderName)) {
                    mkdir($newpath . $forderName, 0755);
                }
                if (!file_exists($newpath . $forderName . DS . $config->nameimage)) {
                    $iresize->crop($width, $height, $x, $y);
                }
            } else {
                header("HTTP/1.0 404 Not Found");
                exit();
            }
        } elseif ($typeMethod == 2) {
            $arrthumb = explode('_', $config->thumb);
            $pos = (isset($arrthumb[1])) ? $arrthumb[1] : 'tl';
            $forderName = $config->thumb;
            if (!is_dir($newpath . $forderName)) {
                mkdir($newpath . $forderName, 0755);
            }
            $iresize->overlay($pos);
        } else {
            $preFolder = '';
            $ext = false;
            if (strpos($config->thumb, "exh") !== false) {
                $arrthumb = explode('exh', $config->thumb);
                $width = '';
                $height = (int)$arrthumb[1];
                $preFolder = "exh";
                $ext = true;
            } elseif (strpos($config->thumb, "exw") !== false) {
                $arrthumb = explode('exw', $config->thumb);
                $width = (int)$arrthumb[1];
                $height = '';
                $preFolder = "exw";
                $ext = true;
            } elseif (strpos($config->thumb, "h") !== false) {
                $arrthumb = explode('h', $config->thumb);
                $width = '';
                $height = (int)$arrthumb[1];
                $preFolder = "h";
            } elseif (strpos($config->thumb, "w") !== false) {
                $arrthumb = explode('w', $config->thumb);
                $width = (int)$arrthumb[1];
                $height = '';
                $preFolder = "w";
            } else {
                $arrthumb = explode('_', $config->thumb);
                $width = (isset($arrthumb[0])) ? (int)$arrthumb[0] : '';
                $height = (isset($arrthumb[1])) ? (int)$arrthumb[1] : '';
            }

            if ($width && $height) {
                $forderName = $config->thumb;
                if (!is_dir($newpath . $forderName)) {
                    mkdir($newpath . $forderName, 0755);
                }
                if (!file_exists($newpath . $forderName . DS . $config->nameimage)) {
                    $iresize->resize($width, $height);
                }
            } elseif ($width && !$height) {
                $forderName = $preFolder . $width;
                if (!is_dir($newpath . $forderName)) {
                    mkdir($newpath . $forderName, 0755);
                }
                if (!file_exists($newpath . $forderName . DS . $config->nameimage)) {
                    $iresize->resizeToWidth($width, $ext); // Chỉ resize theo chiều rộng
                }
            } elseif (!$width && $height) {
                $forderName = $preFolder . $height;
                if (!is_dir($newpath . $forderName)) {
                    mkdir($newpath . $forderName, 0755);
                }
                if (!file_exists($newpath . $forderName . DS . $config->nameimage)) {
                    $iresize->resizeToHeight($height, $ext); // Chỉ resize theo chiều cao
                }
            } else {
                header("HTTP/1.0 404 Not Found");
                exit();
            }
        }

        if (!file_exists($pathRoot . DS . $newpath . $forderName . DS . $config->nameimage)) {
            $iresize->output();
            $iresize->save($pathRoot . DS . $newpath . $forderName . DS . $config->nameimage);
        }

        if ($config->nameimage == 'test.jpg') {

        }

        exit();
    }

    $iresize = new IResize();
    $iresize->load($urlRoot . '/no-photo.png');
    $iresize->output();
    exit();
}
exit();
?>