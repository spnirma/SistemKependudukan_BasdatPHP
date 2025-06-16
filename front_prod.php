<?php

$whitelist = array(
    //'/api/',
    //'/cron/',
    //'/search/',
);

$redirect = true;
$forceHost = 'cipika.co.id';
$forceScheme = 'https';

foreach ($whitelist as $route) {
    if (strstr($_SERVER['REQUEST_URI'], $route)) {
        $redirect = false;
        break;
    }
}

$requestScheme = $_SERVER['REQUEST_SCHEME'];

if (!empty($_SERVER['HTTP_X_REAL_REQUEST_SCHEME'])
    && ($_SERVER['REMOTE_ADDR'] == '54.169.15.16' || $_SERVER['REMOTE_ADDR'] == '52.76.31.120' || $_SERVER['REMOTE_ADDR'] == '104.31.81.113')) {
    $requestScheme = $_SERVER['HTTP_X_REAL_REQUEST_SCHEME'];
}

if ($redirect && ($_SERVER['SERVER_NAME'] != $forceHost || $requestScheme != $forceScheme)) {
    header('Location: ' . 'https://' . $forceHost . $_SERVER['REQUEST_URI'], true, 302);
    exit;
}
