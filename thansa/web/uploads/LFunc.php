<?php

class LFunc {

    // $n = 0;
    // get_create_name($dir, $file_name, $n);
    // echo $n;
    public static function get_create_name($dir, $file, &$n) {
        if ($n == 0)
            $file_name = $dir . DIRECTORY_SEPARATOR . $file;
        else {
            $_info = pathinfo($file);
            $file_name = $dir . DIRECTORY_SEPARATOR . $_info['filename'] . '_' . $n . '.' . $_info['extension'];
        }
        if (file_exists($file_name)) {
            ++$n;
            LFunc::get_create_name($dir, $file, $n);
        }
    }

    public static function del_files($dir, $file_name, $sub_dir = false) {
        try {
            $mydir = opendir($dir);
            while (false !== ($file = readdir($mydir))) {
                if ($file != "." && $file != "..") {
                    if (is_dir($dir . '/' . $file)) {
                        if ($sub_dir == true)
                            del_files($dir . DIRECTORY_SEPARATOR . $file, $file_name);
                    }else if ($file_name == $file)
                        unlink($dir . DIRECTORY_SEPARATOR . $file);
                }
            }
            closedir($mydir);
        } catch (Exception $e) {
            
        }
    }

    public static function getFullUrl() {
        return
                (isset($_SERVER['HTTPS']) ? 'https://' : 'http://') .
                (isset($_SERVER['REMOTE_USER']) ? $_SERVER['REMOTE_USER'] . '@' : '') .
                (isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : ($_SERVER['SERVER_NAME'] .
                        (isset($_SERVER['HTTPS']) && $_SERVER['SERVER_PORT'] === 443 ||
                        $_SERVER['SERVER_PORT'] === 80 ? '' : ':' . $_SERVER['SERVER_PORT']))) .
                substr($_SERVER['SCRIPT_NAME'], 0, strrpos($_SERVER['SCRIPT_NAME'], '/'));
    }

    public static function getServerUrl() {
        return
                (isset($_SERVER['HTTPS']) ? 'https://' : 'http://') .
                (isset($_SERVER['REMOTE_USER']) ? $_SERVER['REMOTE_USER'] . '@' : '') .
                (isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : ($_SERVER['SERVER_NAME'] .
                        (isset($_SERVER['HTTPS']) && $_SERVER['SERVER_PORT'] === 443 ||
                        $_SERVER['SERVER_PORT'] === 80 ? '' : ':' . $_SERVER['SERVER_PORT'])));
    }

    public static function stripUnicode($str) {
        if (!$str)
            return false;
        $unicode = array(
            'a' => 'á|à|ả|ã|ạ|ă|ắ|ằ|ẳ|ẵ|ặ|â|ấ|ầ|ẩ|ẫ|ậ',
            'A' => 'Á|À|Ả|Ã|Ạ|Ă|Ắ|Ằ|Ẳ|Ẵ|Ặ|Â|Ấ|Ầ|Ẩ|Ẫ|Ậ',
            'd' => 'đ',
            'D' => 'Đ',
            'e' => 'é|è|ẻ|ẽ|ẹ|ê|ế|ề|ể|ễ|ệ',
            'E' => 'É|È|Ẻ|Ẽ|Ẹ|Ê|Ế|Ề|Ể|Ễ|Ệ',
            'i' => 'í|ì|ỉ|ĩ|ị',
            'I' => 'Í|Ì|Ỉ|Ĩ|Ị',
            'o' => 'ó|ò|ỏ|õ|ọ|ô|ố|ồ|ổ|ỗ|ộ|ơ|ớ|ờ|ở|ỡ|ợ',
            'O' => 'Ó|Ò|Ỏ|Õ|Ọ|Ô|Ố|Ồ|Ổ|Ỗ|Ộ|Ơ|Ớ|Ờ|Ở|Ỡ|Ợ',
            'u' => 'ú|ù|ủ|ũ|ụ|ư|ứ|ừ|ử|ữ|ự',
            'U' => 'Ú|Ù|Ủ|Ũ|Ụ|Ư|Ứ|Ừ|Ử|Ữ|Ự',
            'y' => 'ý|ỳ|ỷ|ỹ|ỵ',
            'Y' => 'Ý|Ỳ|Ỷ|Ỹ|Ỵ'
        );
        foreach ($unicode as $khongdau => $codau) {
            $arr = explode("|", $codau);
            $str = str_replace($arr, $khongdau, $str);
        }
        return $str;
    }

    public static function scaleImage($x, $y, $cx, $cy) {
        //Set the default NEW values to be the old, in case it doesn't even need scaling
        list($nx, $ny) = array($x, $y);

        //If image is generally smaller, don't even bother
        if ($x >= $cx || $y >= $cx) {

            //Work out ratios
            if ($x > 0)
                $rx = $cx / $x;
            if ($y > 0)
                $ry = $cy / $y;

            //Use the lowest ratio, to ensure we don't go over the wanted image size
            if ($rx > $ry) {
                $r = $ry;
            } else {
                $r = $rx;
            }

            //Calculate the new size based on the chosen ratio
            $nx = intval($x * $r);
            $ny = intval($y * $r);
        }

        //Return the results
        return array($nx, $ny);
    }

}

?>
