<?php
require "./vendor/autoload.php";

use AlphaSnow\OSS\AppServer\Factory;

$cb_host = "{$_SERVER["REQUEST_SCHEME"]}://{$_SERVER["HTTP_HOST"]}:{$_SERVER["SERVER_PORT"]}";
$cb_path = substr($_SERVER["REQUEST_URI"],0,strpos($_SERVER["REQUEST_URI"],"token.php"));
$cb_url = $cb_host.$cb_path.'callback.php';

$config = [
    "access_key_id" => "",
    "access_key_secret" => "",
    "bucket" => "",
    "endpoint" => "",
    "callback_url"=>$cb_url,
    "max_size"=>1048576000,
    "expire_time"=>60,
    "user_dir"=>"upload/"
];
$token = (new Factory)->makeToken($config);
header("Content-Type: application/json; charset=utf-8");
echo json_encode($token->response());