<?php

class Config {
    public $firstFolder = 'up';
    public $project = array(
        'doisong' => array(
            "news" => array(),
        ),
    );
    private $url = '';
    public $baseurl = '';
    public $thumb = '';
    public $nameimage = '';
    private $firstPath = '';
    private $validate = null;

    public function __construct($url = null) {
        $this->url = ($url === null) ? '' : $url;
        $this->parseUrl();
    }

    private function parseUrl() {
        $arrurl = explode('/', $this->url);
        if (count($arrurl) > 4) {
            $this->firstPath = $arrurl[0];
            $this->nameimage = array_pop($arrurl);
            $this->thumb = array_pop($arrurl);
            $this->baseurl = implode('/', $arrurl);
            $this->baseurl.='/';
        }
    }

    public function validate() {
        if (is_null($this->validate)) {
            if ($this->isImage() && $this->firstPath == $this->firstFolder) {
                $this->validate = true;
            }else{
                $this->validate = false;
            }
        }
        return $this->validate;
    }

    protected function isImage() {
        if ($this->nameimage) {
            $pos = strrpos($this->nameimage, ".");
            if ($pos === false)
                return false;
            $ext = strtolower(trim(substr($this->nameimage, $pos)));
            $imgExts = array(".gif", ".jpg", ".jpeg", ".png"); // this is far from complete but that's always going to be the case...
            if (in_array($ext, $imgExts))
                return true;
        }
        return false;
    }

}

?>
