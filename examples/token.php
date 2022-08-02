<?php
require "./vendor/autoload.php";

use AlphaSnow\OSS\AppServer\Factory;

function getCallbackURL(){
    $cb_host = "{$_SERVER["REQUEST_SCHEME"]}://{$_SERVER["HTTP_HOST"]}:{$_SERVER["SERVER_PORT"]}";
    $cb_path = substr($_SERVER["REQUEST_URI"],0,strpos($_SERVER["REQUEST_URI"],"token.php"));
    return $cb_host.$cb_path.'callback.php';
}

$cfg = require "./config.php";
// $cfg["callback_url"] = getCallbackURL();

$token = (new Factory($cfg))->makeToken();
header("Content-Type: application/json; charset=utf-8");
echo json_encode($token->response());