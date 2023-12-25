<?php

namespace app\helpers;

use Yii;

class StringHelper
{

    public static function formatUrlKey($str)
    {
        $str = self::stripUnicode($str);
        $urlKey = preg_replace('#[^0-9a-z]+#i', '-', $str);
        $urlKey = strtolower($urlKey);
        $urlKey = trim($urlKey, '-');

        return $urlKey;
    }

    public static function stripUnicode($str)
    {
        if (!$str)
            return false;
        $marTViet = array("à", "á", "ạ", "ả", "ã", "â", "ầ", "ấ", "ậ", "ẩ", "ẫ", "ă",
            "ằ", "ắ", "ặ", "ẳ", "ẵ", "è", "é", "ẹ", "ẻ", "ẽ", "ê", "ề"
        , "ế", "ệ", "ể", "ễ",
            "ì", "í", "ị", "ỉ", "ĩ",
            "ò", "ó", "ọ", "ỏ", "õ", "ô", "ồ", "ố", "ộ", "ổ", "ỗ", "ơ"
        , "ờ", "ớ", "ợ", "ở", "ỡ",
            "ù", "ú", "ụ", "ủ", "ũ", "ư", "ừ", "ứ", "ự", "ử", "ữ",
            "ỳ", "ý", "ỵ", "ỷ", "ỹ",
            "đ",
            "À", "Á", "Ạ", "Ả", "Ã", "Â", "Ầ", "Ấ", "Ậ", "Ẩ", "Ẫ", "Ă"
        , "Ằ", "Ắ", "Ặ", "Ẳ", "Ẵ",
            "È", "É", "Ẹ", "Ẻ", "Ẽ", "Ê", "Ề", "Ế", "Ệ", "Ể", "Ễ",
            "Ì", "Í", "Ị", "Ỉ", "Ĩ",
            "Ò", "Ó", "Ọ", "Ỏ", "Õ", "Ô", "Ồ", "Ố", "Ộ", "Ổ", "Ỗ", "Ơ"
        , "Ờ", "Ớ", "Ợ", "Ở", "Ỡ",
            "Ù", "Ú", "Ụ", "Ủ", "Ũ", "Ư", "Ừ", "Ứ", "Ự", "Ử", "Ữ",
            "Ỳ", "Ý", "Ỵ", "Ỷ", "Ỹ",
            "Đ");

        $marKoDau = array("a", "a", "a", "a", "a", "a", "a", "a", "a", "a", "a"
        , "a", "a", "a", "a", "a", "a",
            "e", "e", "e", "e", "e", "e", "e", "e", "e", "e", "e",
            "i", "i", "i", "i", "i",
            "o", "o", "o", "o", "o", "o", "o", "o", "o", "o", "o", "o"
        , "o", "o", "o", "o", "o",
            "u", "u", "u", "u", "u", "u", "u", "u", "u", "u", "u",
            "y", "y", "y", "y", "y",
            "d",
            "A", "A", "A", "A", "A", "A", "A", "A", "A", "A", "A", "A"
        , "A", "A", "A", "A", "A",
            "E", "E", "E", "E", "E", "E", "E", "E", "E", "E", "E",
            "I", "I", "I", "I", "I",
            "O", "O", "O", "O", "O", "O", "O", "O", "O", "O", "O", "O"
        , "O", "O", "O", "O", "O",
            "U", "U", "U", "U", "U", "U", "U", "U", "U", "U", "U",
            "Y", "Y", "Y", "Y", "Y",
            "D");

        $str = str_replace($marTViet, $marKoDau, $str);
        return $str;
    }

    public static function fomat_price($price)
    {
        return Yii::$app->formatter->asInteger((float)$price) . ' ' . Yii::$app->params['currency'];
    }

    public static function replatePrice($price)
    {
        return str_replace('.', ',', $price);
    }

    public static function fomat_price_short($price, $unit = '')
    {
        if ($unit == 'm2') {
            $unit = '/m<sub>2</sub>';
        }
        if ((float)$price > 999999999) {
            return self::replatePrice(round(($price / 1000000000), 1)) . 'tỷ' . $unit;
        } elseif ((float)$price > 999999) {
            return self::replatePrice(round(($price / 1000000), 1)) . 'triệu' . $unit;
        } else {
            return Yii::$app->formatter->asInteger((float)$price) . Yii::$app->params['currency'] . $unit;
        }
    }

    public static function fomat_price_long($price, $unit = '')
    {
        if ($unit == 'm2') {
            $unit = '/m<sub>2</sub>';
        }
        if ((float)$price > 999999999) {
            $text = '';
            $ty = floor($price / 1000000000);
            $text = Yii::$app->formatter->asInteger($ty) . 'tỷ';
            $du = $price - (1000000000 * $ty);
            if ($du > 999999) {
                $text .= ' ' . (float)round($du / 1000000) . 'triệu';
            }
            return $text . $unit;
        } elseif ((float)$price > 999999) {
            return self::replatePrice(round(($price / 1000000), 1)) . 'triệu' . $unit;
        } else {
            return Yii::$app->formatter->asInteger((float)$price) . Yii::$app->params['currency'] . $unit;
        }
    }

    public static function encode($originalStr)
    {
        $encodedStr = $originalStr;
        $num = mt_rand(0, 5);
        for ($i = 1; $i <= $num; $i++) {
            $encodedStr = base64_encode($encodedStr);
        }
        $seed_array = array('S', 'H', 'A', 'F', 'I', 'Q');
        $encodedStr = $encodedStr . "+" . $seed_array[$num];
        $encodedStr = base64_encode($encodedStr);
        return $encodedStr;
    }

    public static function decode($decodedStr)
    {
        $seed_array = array('S', 'H', 'A', 'F', 'I', 'Q');
        $decoded = base64_decode($decodedStr);
        list($decoded, $letter) = explode("+", $decoded);
        for ($i = 0; $i < count($seed_array); $i++) {
            if ($seed_array[$i] == $letter)
                break;
        }
        for ($j = 1; $j <= $i; $j++) {
            $decoded = base64_decode($decoded);
        }
        return $decoded;
    }

    public static function generateRandomChar($length = 10)
    {
        return substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyz"), 0, $length);
    }

    public static function generateRandomString($length = 10)
    {
        return substr(str_shuffle("0123456789"), 0, $length);
    }

    public static function generateRandomStringInt($length = 10)
    {
        return substr(str_shuffle("123456789"), 0, $length);
    }

    public static function getImageThumbnailYoutube($url = null)
    {
        $linkimg = array();
        if ($url) {
            $urls = parse_url($url);
            if ($urls['host'] == 'youtu.be') :
                $imgPath = ltrim($urls['path'], '/');
            elseif (strpos($urls['path'], 'embed') == 1) :

                $imgPath = (explode('/', $urls['path']));
                $imgPath = end($imgPath);
            elseif (strpos($url, '/') === false):

                $imgPath = $url;
            else :
                parse_str($urls['query']);
                $imgPath = $v;
            endif;
            if ($imgPath) {
                $linkimg['img'] = 'https://img.youtube.com/vi/' . $imgPath . '/0.jpg';
                $linkimg['play'] = 'https://www.youtube.com/embed/' . $imgPath;
            }
        }
        return $linkimg;
    }

    public static function cutHTML($string, $length, $patternsReplace = false)
    {
        $i = 0;
        $count = 0;
        $isParagraphCut = false;
        $htmlOpen = false;
        $openTag = false;
        $tagsStack = array();

        while ($i < strlen($string)) {
            $char = substr($string, $i, 1);
            if ($count >= $length) {
                $isParagraphCut = true;
                break;
            }

            if ($htmlOpen) {
                if ($char === ">") {
                    $htmlOpen = false;
                }
            } else {
                if ($char === "<") {
                    $j = $i;
                    $char = substr($string, $j, 1);

                    while ($j < strlen($string)) {
                        if ($char === '/') {
                            $i++;
                            break;
                        } elseif ($char === ' ') {
                            $tagsStack[] = substr($string, $i, $j);
                        }
                        $j++;
                    }
                    $htmlOpen = true;
                }
            }

            if (!$htmlOpen && $char != ">") {
                $count++;
            }

            $i++;
        }

        if ($isParagraphCut) {
            $j = $i;
            while ($j > 0) {
                $char = substr($string, $j, 1);
                if ($char === " " || $char === ";" || $char === "." || $char === "," || $char === "<" || $char === "(" || $char === "[") {
                    break;
                } else if ($char === ">") {
                    $j++;
                    break;
                }
                $j--;
            }
            $string = substr($string, 0, $j);
            foreach ($tagsStack as $tag) {
                $tag = strtolower($tag);
                if ($tag !== "img" && $tag !== "br") {
                    $string .= "</$tag>";
                }
            }
            $string .= "...";
        }

        if ($patternsReplace) {
            foreach ($patternsReplace as $value) {
                if (isset($value['pattern']) && isset($value["replace"])) {
                    $string = preg_replace($value["pattern"], $value["replace"], $string);
                }
            }
        }
        return $string;
    }

    public static function FileSizeConvert($bytes)
    {
        $bytes = floatval($bytes);
        $arBytes = array(
            0 => array(
                "UNIT" => "TB",
                "VALUE" => pow(1024, 4)
            ),
            1 => array(
                "UNIT" => "GB",
                "VALUE" => pow(1024, 3)
            ),
            2 => array(
                "UNIT" => "MB",
                "VALUE" => pow(1024, 2)
            ),
            3 => array(
                "UNIT" => "KB",
                "VALUE" => 1024
            ),
            4 => array(
                "UNIT" => "B",
                "VALUE" => 1
            ),
        );

        foreach ($arBytes as $arItem) {
            if ($bytes >= $arItem["VALUE"]) {
                $result = $bytes / $arItem["VALUE"];
                $result = str_replace(".", ",", strval(round($result, 2))) . " " . $arItem["UNIT"];
                break;
            }
        }
        return $result;
    }

    public static function getIPAddress()
    {
        $ip = $_SERVER['REMOTE_ADDR'];
        if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
            $ip = $_SERVER['HTTP_CLIENT_IP'];
        } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
        }

        return $ip;
    }

    static function clean_key($key)
    {
        if ($key != "") {
            $key = htmlspecialchars(urldecode($key));
            $key = preg_replace("/\.\./", "", $key);
            $key = preg_replace("/\_\_(.+?)\_\_/", "", $key);
            $key = preg_replace("/^([\w\.\-\_]+)$/", "$1", $key);
        }
        return $key;
    }

    public static function clean_value($val)
    {
        if ($val != "") {
            $val = trim($val);
            $val = strip_tags($val);
            $val = str_replace("&#032;", " ", $val);
            $val = str_replace(chr(0xCA), "", $val);  //Remove sneaky spaces
            $val = str_replace(array("<!--", "-->", "/<script/i", ">", "<", '"', "/\\\$/", "/\r/", "!", "'"), array("", "", "&#60;script", "&gt;", "&lt;", "&quot;", "&#036;", "", "&#33;", "&#39;"), $val);
            $get_magic_quotes = @get_magic_quotes_gpc();
            if ($get_magic_quotes) {
                $val = stripslashes($val);
            }
            $val = preg_replace("/\\\(?!&amp;#|\?#)/", "&#092;", $val);
        }
        return $val;
    }

    /**
     * Giu 3 so cuoi dien thoai ex: ******618
     * @return string phone
     */
    static function substringPhone($phone)
    {
        $countString = strlen($phone);
        if ($countString > 3) {
            $phone = substr($phone, -3);
        } else {
            $phone = substr($phone, -2);
        }
        return '*******' . $phone;
    }

    /**
     * Bo 4 ki tu trong Email truoc @
     * @return string email
     */
    static function substringEmail($email)
    {
        $subfi = '';
        $arremail = explode('@', $email);
        if (isset($arremail[0]) && isset($arremail[1])) {
            $countString = strlen($arremail[0]);
            if ($countString >= 4) {
                $subfi = substr($arremail[0], 0, $countString - 4);
            } else {
                $subfi = substr($arremail[0], $countString);
            }
            $subfi = '';
            $email = $subfi . '****@' . $arremail[1];
        }
        return $email;
    }

    /**
     * Chuyển chuỗi input thành chuỗi phù hợp cho SEO
     * @param type $string
     */
    public static function rewrite($string)
    {
        $string = self::stripUnicode(trim($string)); // Xoá trọng âm
        $string = strtolower($string);
        // Chuyển các ký tự đặc biệt thành khoảng trắng
        $string = preg_replace('/([^a-z0-9\s])/i', '', $string);
        $string = preg_replace('/\s+/', '-', $string); // Xoá các khoảng trắng lặp lại
//		$string = preg_replace('/([^a-z0-9\s])/i', '-', $string);

        return $string;
    }

}
