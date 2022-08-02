<?php
require "./vendor/autoload.php";

use AlphaSnow\OSS\AppServer\Callback;
use AlphaSnow\OSS\AppServer\Callbacks\ServerCallback;

$status = (new ServerCallback(new Callback))->verify();
if ($status == false) {
    header("HTTP/1.1 403 Forbidden");
    header("Content-Type: application/json; charset=utf-8");
    echo json_encode(["status" => "fail"]);
    exit;
}
// $filename = $_POST["filename"] ?? "";
header("Content-Type: application/json; charset=utf-8");
echo json_encode(["status" => "ok"]);