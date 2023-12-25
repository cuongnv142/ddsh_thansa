<?php
/**
 * Created by PhpStorm.
 * User: Tony
 * Date: 11/5/2021
 * Time: 8:37 AM
 */

namespace app\exception;

use yii\base\ErrorException;

class UploadFileException extends ErrorException
{
    public function getName()
    {
        return 'Error Upload File To Server';
    }

}