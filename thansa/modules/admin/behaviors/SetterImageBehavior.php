<?php

/**
 * Created by PhpStorm.
 * User: Tony
 * Date: 07/5/2021
 * Time: 5:57 PM
 */

namespace app\modules\admin\behaviors;

use Yii;
use yii\base\Behavior;
use yii\web\UploadedFile;
use app\components\FileUpload;
use app\exception\NullFileException;
use app\exception\UploadFileException;

class SetterImageBehavior extends Behavior {

    private $_fieldUploadName = 'image';
    private $_isImageDeleteName = 'is_deleteimage';
    private $_fileUploadName;

    public function setFileUploadName($value) {
        $this->_fileUploadName = $value;
        return $this->owner;
    }

    public function getFileUploadName() {
        return ($this->_fileUploadName) ? $this->_fileUploadName : $this->getFieldUploadName();
    }

    public function setFieldUploadName($value) {
        $this->_fieldUploadName = $value;
        return $this->owner;
    }

    public function getFieldUploadName() {
        return $this->_fieldUploadName;
    }

    public function setIsImageDeleteName($value) {
        $this->_isImageDeleteName = $value;
        return $this->owner;
    }

    public function getIsImageDeleteName() {
        return $this->_isImageDeleteName;
    }

    public function getProjectImageUpload() {
        $classExplode = explode("\\", get_parent_class($this->owner));
        return strtolower(array_pop($classExplode));
    }

    public function uploadImage() {
        if (!$this->owner->isAttributeActive($this->getFieldUploadName())) {
            return;
        }
        if ($this->getIsImageDeleteName() && Yii::$app->request->post($this->getIsImageDeleteName()) == 'on') {
            $this->owner->{$this->getFieldUploadName()} = '';
        }

        try {
            $this->owner->{$this->getFieldUploadName()} = $this->upload($this->getFileUploadName());
        } catch (NullFileException $exception) {
            return;
        } catch (UploadFileException $exception) {
            $this->owner->addError($this->getFieldUploadName(), $exception->getMessage());
            return;
        }
    }

    private function upload(string $imageFieldName): string {
        $file = UploadedFile::getInstanceByName($imageFieldName);
        if (is_null($file)) {
            throw new NullFileException('File is null');
        }
        $filename = FileUpload::upload($file, $this->getProjectImageUpload());
        if (!$filename['action']) {
            throw new UploadFileException($filename['mes']);
        }

        return $filename['filename'];
    }

}
