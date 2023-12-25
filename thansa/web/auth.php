<?php

define('ADMIN_USERNAME', $_SERVER['HTTP_HOST']);  // Admin Username
define('ADMIN_PASSWORD', $_SERVER['HTTP_HOST']);
$UriTruth = [
    '/site/auth/'
];

if (in_array($_SERVER['REQUEST_URI'], $UriTruth)) {
    return;
}
if (!isset($_SERVER['PHP_AUTH_USER']) || !isset($_SERVER['PHP_AUTH_PW']) ||
        $_SERVER['PHP_AUTH_USER'] != ADMIN_USERNAME || $_SERVER['PHP_AUTH_PW'] != ADMIN_PASSWORD) {
    Header("WWW-Authenticate: Basic realm=\"Login\"");
    Header("HTTP/1.0 401 Unauthorized");

    echo <<<EOB
				<html><body>
				<h1>Rejected!</h1>
				<big>Wrong Username or Password!</big>
				</body></html>
EOB;
    exit;
}
?>