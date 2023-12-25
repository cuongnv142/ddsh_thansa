<?php
/**
 * Created by PhpStorm.
 * User: Tony
 * Date: 11/5/2021
 * Time: 8:29 AM
 */

namespace app\exception;

use yii\base\InvalidValueException;

class NullFileException extends InvalidValueException
{
    public function getName()
    {
        return 'Invalid File Is Null';
    }

}