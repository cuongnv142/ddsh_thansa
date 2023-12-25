<?php

namespace app\components;

use CURLFile;
use linslin\yii2\curl;
use yii\validators\FileValidator;

class FileUpload {

    const name_space = 'root';
    //const domain_post_upload = 'http://csdldongthucvat.local/uploads/irouter.php';
    //const domain_get = 'http://csdldongthucvat.local/uploads/up/';
    const domain_post_upload = 'http://ddshthansa.vnuforest.com/uploads/irouter.php';
    const domain_get = 'http://ddshthansa.vnuforest.com/uploads/up/';
    const type_image = 1;
    const type_video = 2;
    const type_pdf = 3;
    const type_video_youtube = 4;
    const type_doc = 5;

    public static function createPathImageUpload($project) {
        $path = self::name_space;
        if ($project) {
            $path .= '/' . $project;
        }
        $time = time() + 3600 * 6;
        $links_dir = array(// Danh sách các thư mục được tạo ra theo nguyên tắc
            'year' => date('Y', $time),
            'month' => date('m', $time),
            'day' => date('d', $time),
            'hour' => date('H', $time),
            'minute' => date('i', $time),
        );

        if (count($links_dir) > 0) {
            foreach ($links_dir as $d) { // Tạo thư mục chứa ảnh mặc định:
                $path .= '/' . $d;
            }
        }
        $path = str_replace('//', '/', $path);
        return $path;
    }

    public static function stripUnicode($str) {
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

    public static function upload($file, $project, $file_type = 1, $overwrite = 1, $file_name = '') {
        $reVal = [
            'action' => false,
            'filename' => '',
            'mes' => ''
        ];

        if ($file) {
            switch ($file_type) {
                case self::type_video:
                    $config = ['extensions' => 'flv,mp4,ogg,webm,wmv,swf', 'maxSize' => 1024 * 1024 * 1];
                    break;
                case self::type_pdf:
                    $config = ['extensions' => 'pdf', 'maxSize' => 1024 * 1024 * 50];
                    break;
                case self::type_doc:
                    $config = ['extensions' => 'pdf,docx,doc', 'maxSize' => 1024 * 1024 * 10];
                    break;
                default :
                    $config = ['extensions' => 'jpg, png, jpeg, bmp', 'maxSize' => 1024 * 1024 * 5];
                    break;
            }
            $validator = new FileValidator($config);
            if (!$validator->validate($file, $error)) {
                if ($error) {
                    $error = str_replace('MiB', 'MB', $error);
                }

                return $reVal = [
                    'action' => false,
                    'mes' => $error,
                    'filename' => '',
                ];
            }
            $path = self::createPathImageUpload(trim($project));
            $filename = '';
            if ($file_name) {
                $filename = $file_name;
            } else {
                $filename = preg_replace('/[\s\(\)"\'\.]/i', '_', substr(self::stripUnicode(strtolower($file->baseName)), 0, 3) . microtime(true)) . '.' . $file->extension;
            }
            $curl = new curl\Curl();
            $response = $curl->reset()->setOption(
                            CURLOPT_POSTFIELDS, array(
                        'filedata' => class_exists('CurlFile', false) ? new CURLFile($file->tempName, $file->type) : '@' . $file->tempName,
                        'filename' => $path . '/' . $filename,
                        'action' => 'upload',
                        'overwrite' => $overwrite
                            )
                    )
                    ->post(self::domain_post_upload);
            switch ($curl->responseCode) {
                case 200:
                    $path_file = $path . '/' . $filename;
                    $reVal = [
                        'action' => true,
                        'mes' => '',
                        'filename' => $path_file,
                    ];
                    break;
                case 404:
                    $reVal = [
                        'action' => false,
                        'mes' => 'Lỗi server',
                        'filename' => '',
                    ];
                    break;
            }
        }
        return $reVal;
    }

    public static function uploadUrl($url, $project, $overwrite = 0, $file_name = '') {
        $path_file = '';
        if ($url) {
            $path = self::createPathImageUpload(trim($project));
            $filename = '';
            if ($file_name) {
                $filename = $file_name;
            } else {
                $path_parts = pathinfo($url);
                $filename = preg_replace('/[\s\(\)"\'\.]/i', '_', substr(self::stripUnicode(strtolower($path_parts['filename'])), 0, 3) . microtime(true)) . '.' . $path_parts['extension'];
            }

            $curl = new curl\Curl();
            $response = $curl->reset()->setOption(
                            CURLOPT_POSTFIELDS, array(
                        'source' => $url,
                        'filename' => $path . '/' . $filename,
                        'action' => 'uploadWithUrl',
                        'overwrite' => $overwrite
                            )
                    )
                    ->post(self::domain_post_upload);
            switch ($curl->responseCode) {
                case 200:
                    $path_file = $path . '/' . $filename;
                    break;
                case 404:
                    //404 Error logic here
                    break;
            }
        }
        return $path_file;
    }

    public static function deletefile($filename) {
        if ($filename) {
            $curl = new curl\Curl();
            $response = $curl->reset()->setOption(
                            CURLOPT_POSTFIELDS, array(
                        'filename' => $filename,
                        'action' => 'delete',
                            )
                    )
                    ->post(self::domain_post_upload);
            switch ($curl->responseCode) {
                case 200:
                    return true;
                    break;
                case 404:
                    //404 Error logic here
                    break;
            }
        }
        return false;
    }

    public static function originalfile($filename) {
        if ($filename) {
            if (strpos($filename, 'http') === 0) {
                $link = $filename;
            } else {
                $link = self::domain_get . $filename;
            }

            return $link;
        }
        return false;
    }

    public static function thumbfile($width, $height, $filename) {
        if ($filename) {
            return self::thumbimage($width, $height, $filename);
        }
        return false;
    }

    public static function thumb_infile($width, $height, $filename, $quality = null) {
        if ($filename) {
            return self::thumbimage($width, $height, $filename);
        }
        return false;
    }

    public static function thumb_maxfile($filename, $quality = null) {
        if ($filename) {
            return self::thumbimage($width, 0, $filename);
        }
        return false;
    }

    public static function thumb_wlfile($width, $filename, $quality = null) {
        if ($filename) {
            return self::thumbimage($width, 0, $filename);
        }
        return false;
    }

    public static function thumb_wfile($width, $filename, $quality = null) {
        if ($filename) {
            return self::thumbimage($width, 0, $filename);
        }
        return false;
    }

    public static function thumb_wmfile($width, $filename, $quality = null) {
        if ($filename) {
            return self::thumbimage($width, 0, $filename);
        }
        return false;
    }

    public static function thumbimage($width, $height, $filename) {
        if ($filename) {
            if (strpos($filename, 'http') === 0) {
                return $filename;
            } else {
                $link = self::domain_get . $filename;
                return $link;
                $arrpath = explode('/', $filename);
                $name = end($arrpath);
                array_pop($arrpath);
                if ($width && $height) {
                    $forderName = $width . '_' . $height . '/';
                } elseif ($width && !$height) {
                    $forderName = 'w' . $width . '/';
                    $height = null;
                } elseif (!$width && $height) {
                    $forderName = 'h' . $height . '/';
                    $width = null;
                } else {
                    $forderName = '';
                }
                return self::domain_get . implode('/', $arrpath) . '/' . $forderName . $name;
            }
        } else {
            return self::domain_get . 'no-photo.png';
        }
        return false;
    }

    public static function thumb_hfile($height, $filename, $quality = null) {
        if ($filename) {
            return self::thumbimage(0, $height, $filename);
        }
        return false;
    }

    public static function thumb_hlfile($height, $filename, $quality = null) {
        if ($filename) {
            return self::thumbimage(0, $height, $filename);
        }
        return false;
    }

    public static function zoomfile($width, $height, $filename, $quality = null) {
        if ($filename) {
            return self::thumbimage($width, $height, $filename);
        }
        return false;
    }

    public static function staticfile($filename) {
        if ($filename) {
            $link = self::domain_get . $filename;
            return $link;
        }
        return false;
    }

}
