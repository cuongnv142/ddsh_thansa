<?php

switch ($_SERVER['HTTP_HOST']) {
    case "csdldongthucvat.local":
        defined('YII_DEBUG') or define('YII_DEBUG', true);
        defined('YII_ENV') or define('YII_ENV', 'dev');
        defined('URL_DOMAIN') or define('URL_DOMAIN', 'http://csdldongthucvat.local');
        require(__DIR__ . '/../vendor/autoload.php');
        require(__DIR__ . '/../vendor/yiisoft/yii2/Yii.php');
        $config = require(__DIR__ . '/../config/local/local.php');
        break;
    case "csdldongthucvat.todo.vn":
        require_once('auth.php');
        defined('YII_DEBUG') or define('YII_DEBUG', true);
        defined('YII_ENV') or define('YII_ENV', 'dev');
        defined('URL_DOMAIN') or define('URL_DOMAIN', 'https://csdldongthucvat.todo.vn');
        require(__DIR__ . '/../vendor/autoload.php');
        require(__DIR__ . '/../vendor/yiisoft/yii2/Yii.php');
        $config = require(__DIR__ . '/../config/dev/dev.php');
        break;
    case "ddshnamxuanlac.vnuforest.com":
            //require_once('auth.php');
            defined('YII_DEBUG') or define('YII_DEBUG', true);
            defined('YII_ENV') or define('YII_ENV', 'dev');
            defined('URL_DOMAIN') or define('URL_DOMAIN', 'http://ddshnamxuanlac.vnuforest.com');
            require(__DIR__ . '/../vendor/autoload.php');
            require(__DIR__ . '/../vendor/yiisoft/yii2/Yii.php');
            $config = require(__DIR__ . '/../config/dev/dev.php');
            break;
    case "ddshthansa.vnuforest.com":
                //require_once('auth.php');
                defined('YII_DEBUG') or define('YII_DEBUG', true);
                defined('YII_ENV') or define('YII_ENV', 'dev');
                defined('URL_DOMAIN') or define('URL_DOMAIN', 'http://ddshthansa.vnuforest.com');
                require(__DIR__ . '/../vendor/autoload.php');
                require(__DIR__ . '/../vendor/yiisoft/yii2/Yii.php');
                $config = require(__DIR__ . '/../config/dev/dev.php');
                break;
    default:
        echo 1;
        echo "He thong dang nang cap! Vui long tro lai sau it phut.";
        exit();
}
(new yii\web\Application($config))->run();

