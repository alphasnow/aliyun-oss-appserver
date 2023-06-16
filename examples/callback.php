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
if($_SERVER["HTTP_CONTENT_TYPE"] == "application/json"){
    $data = json_decode(file_get_contents("php://input"),true);
}else{
    $data = $_POST;
}
// $filename = $data["filename"] ?? "";
header("Content-Type: application/json; charset=utf-8");
echo json_encode(["status" => "ok","data"=>$data]);