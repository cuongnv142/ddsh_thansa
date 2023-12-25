<?php

define("DS", DIRECTORY_SEPARATOR);
require_once("LFunc.php");

class CDir {

    public $dir = ""; // Đường dẫn chứa file upload:
    public $url = ""; // Đường dẫn được trả về của file upload:

    public function __construct($dir = null, $path = null, $url = null) {
        $this->dir = ($dir === null) ? dirname(__FILE__) : $dir;
        $this->url = ($url === null) ? LFunc::getFullUrl() : $url;
        $this->create($path);
    }

    /**
     * Tạo thư mục để Upload:
     */
    private function create($path) {
        if (!empty($path)) {
            if (count($path) > 0) {
                foreach ($path as $d) { // Tạo thư mục chứa ảnh mặc định:
                    $this->dir .= DS . $d;
                    $this->url .= '/' . $d;
                    if (!is_dir($this->dir))
                        mkdir($this->dir, 0755);
                }
            }
        }
    }

    public function add($dir_name) {
        if (!is_dir($this->dir . DS . $dir_name))
            mkdir($this->dir . DS . $dir_name, 0755);
    }

}

?>