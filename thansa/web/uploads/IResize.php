<?php

class IResize
{

    private $image;

    /**
     * Load ảnh:
     */
    function load($filename)
    {
        $this->image = new Imagick($filename);
    }

    /**
     * Lưu ảnh:
     */
    function save($filename)
    {
        //$this->image->setCompressionQuality(100);
        $this->image->writeImage($filename);
        $this->image->clear();
        $this->image->destroy();
    }

    /**
     * Lấy chiều rộng của ảnh:
     */
    function getWidth()
    {
        $d = $this->image->getImageGeometry();
        return $d['width'];
    }

    /**
     * Lấy chiều cao của ảnh:
     */
    function getHeight()
    {
        $d = $this->image->getImageGeometry();
        return $d['height'];
    }

    /**
     * Resize theo chiều cao:
     */
    function resizeToHeight($height, $ext = false)
    {
        if ($height >= $this->getHeight() && !$ext)
            return;
        $ratio = $height / $this->getHeight();
        $width = $this->getWidth() * $ratio;
        $this->resize($width, $height, $ext);
    }

    /**
     * Resize theo chiều rộng:
     */
    function resizeToWidth($width, $ext = false)
    {
        if ($width >= $this->getWidth() && !$ext)
            return;
        $ratio = $width / $this->getWidth();
        $height = $this->getheight() * $ratio;
        $this->resize($width, $height, $ext);
    }

    /**
     * Resize ảnh theo tỉ lệ:
     */
    function scale($scale)
    {
        $width = $this->getWidth() * $scale / 100;
        $height = $this->getheight() * $scale / 100;
        $this->resize($width, $height);
    }

    /**
     * Resize ảnh theo chiều cao và chiều rộng:
     */
    function resize($width, $height, $ext = false)
    {
        $currentWidth = $this->getWidth();
        $currentHeight = $this->getHeight();
        if ($width > $currentWidth && $height > $currentHeight && !$ext) {
            return;
        }
        if (($width == $currentWidth) && ($height == $currentHeight) && !$ext) {
            return;
        }
        $ratio = $currentWidth / $currentHeight;
        $target_ratio = $width / $height;
        if ($ratio > $target_ratio) {
            $new_w = $width;
            $new_h = round($width / $ratio);
        } else {
            $new_h = $height;
            $new_w = round($height * $ratio);
        }
        $this->image->setbackgroundcolor('rgb(255, 255, 255)');

        if ($this->image->getImageFormat() == 'JPEG') {
            $this->image->setImageCompression(Imagick::COMPRESSION_JPEG);
            $this->image->setImageCompressionQuality(0);
        }
        $this->image->thumbnailImage($width, $height, true, true);

//        $this->image->resizeImage($new_w,$new_h,imagick::FILTER_LANCZOS,1);
//        if($new_w <> $new_h){
//            $start_w=($width-$new_w)/2;
//            $start_h=($height-$new_h)/2;
//            $background = new Imagick();
//            $background->newImage($width, $height, new ImagickPixel('white'));
//            $background->compositeimage($this->image, Imagick::COMPOSITE_COPY,$start_w,$start_h);
//            $this->image=$background;
//        }
    }

    function crop($width, $height, $x, $y)
    {
        $this->image->cropImage($width, $height, $x, $y);
    }

    function overlay($position = 'tr')
    {
        // Open the watermark
        $watermark = new Imagick();
        $watermark->readImage("logo_over.png");
        $w_wm = $watermark->getImageWidth();
        $h_wm = $watermark->getImageHeight();
        $w = $this->getWidth();
        $h = $this->getHeight();
        $x = 10;
        $y = 10;
        if ($position == 'tr') {
            $x = (int)$w - $w_wm - 12;
        } elseif ($position == 'bl') {
            $y = (int)$h - $h_wm - 10;
        } elseif ($position == 'br') {
            $x = (int)$w - $w_wm - 10;
            $y = (int)$h - $h_wm - 10;
        }
        // Overlay the watermark on the original image
        $this->image->compositeImage($watermark, imagick::COMPOSITE_OVER, $x, $y);
    }

    function output()
    {
        // Output the image
        $output = $this->image->getImageBlob();
        $outputtype = $this->image->getFormat();
        header("Content-type: $outputtype");
        echo $output;
    }

}

?>
