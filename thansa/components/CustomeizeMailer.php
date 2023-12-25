<?php

/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\components;

use Yii;
use yii\mail\BaseMailer;

class CustomeizeMailer extends BaseMailer {

    const DOMAIN_NAME = 'beto.vn';
    const EMAIL_API_URL = 'https://in-x.bizfly.vn/api/';
    const MAIL_API_KEY = '7pqD5aqdKbZCLebFnM3f';

    public $messageClass = 'yii\swiftmailer\Message';
    public $_message;
    public $_htmlbody = '';

    public function compose($view = null, array $params = []) {
        $message = $this->createMessage();
        if ($view === null) {
            return $message;
        }

        if (!array_key_exists('message', $params)) {
            $params['message'] = $message;
        }

        $this->_message = $message;

        if (is_array($view)) {
            if (isset($view['html'])) {
                $html = $this->render($view['html'], $params, $this->htmlLayout);
            }
            if (isset($view['text'])) {
                $text = $this->render($view['text'], $params, $this->textLayout);
            }
        } else {
            $html = $this->render($view, $params, $this->htmlLayout);
        }
        $this->_message = null;

        if (isset($html)) {
            $message->setHtmlBody($html);
            $this->_htmlbody = $html;
        }
        if (isset($text)) {
            $message->setTextBody($text);
        } elseif (isset($html)) {
            if (preg_match('~<body[^>]*>(.*?)</body>~is', $html, $match)) {
                $html = $match[1];
            }
            // remove style and script
            $html = preg_replace('~<((style|script))[^>]*>(.*?)</\1>~is', '', $html);
            // strip all HTML tags and decoded HTML entities
            $text = html_entity_decode(strip_tags($html), ENT_QUOTES | ENT_HTML5, Yii::$app ? Yii::$app->charset : 'UTF-8');
            // improve whitespace
            $text = preg_replace("~^[ \t]+~m", '', trim($text));
            $text = preg_replace('~\R\R+~mu', "\n\n", $text);
            $message->setTextBody($text);
        }
        return $message;
    }

    protected function sendMessage($message) {
        $from = $message->getFrom();
        $to = $message->getTo();
        $subject = $message->getSubject();
        $htmlbody = $this->_htmlbody;
        $ch = curl_init();
        $postvars = '';
        if (is_array($from)) {
            foreach ($from as $key => $value) {
                if ($postvars) {
                    $postvars .= '&';
                }
                if ($value) {
                    $postvars .= "from=" . curl_escape($ch, $value . '<' . $key . '>');
                } else {
                    $postvars .= "from=" . curl_escape($ch, $key);
                }
            }
        }
        if (is_array($to)) {
            foreach ($to as $key => $value) {
                if ($postvars) {
                    $postvars .= '&';
                }
                if ($value) {
                    $postvars .= "to=" . curl_escape($ch, $value . '<' . $key . '>');
                } else {
                    $postvars .= "to=" . curl_escape($ch, $key);
                }
            }
        }

        if ($subject) {
            if ($postvars) {
                $postvars .= '&';
            }
            $postvars .= "subject=" . curl_escape($ch, $subject);
        }
        if ($htmlbody) {
            if ($postvars) {
                $postvars .= '&';
            }
            $postvars .= "html=" . curl_escape($ch, $htmlbody);
        } else {
            if ($postvars) {
                $postvars .= '&';
            }
            $postvars .= "html=" . curl_escape($ch, $message->getSwiftMessage()->getBody());
        }
        $url = self::EMAIL_API_URL . self::DOMAIN_NAME . '/messages';
        curl_setopt($ch, CURLOPT_USERPWD, "api:" . self::MAIL_API_KEY);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postvars);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);

        $result = curl_exec($ch);
        $result_error = $result;
        curl_close($ch);
        $result = json_decode($result, true);
        return $result;
    }

}
