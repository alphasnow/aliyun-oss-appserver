<?php
require "./vendor/autoload.php";

use AlphaSnow\OSS\AppServer\Factory;

$cfg = require "./config.php";

$token = (new Factory($cfg))->makeToken();
$token->policy()->setConditions("eq", "\$success_action_status", "200");
$token->policy()->setConditions("in", "\$content-type", ["text/plain"]);
$tokenArr = $token->response()->toArray();

$formData = [
    'name'=>'readme.txt',
    'key'=>'${filename}', // original name or random string name
    'policy'=>$tokenArr['policy'],
    'OSSAccessKeyId'=>$tokenArr['accessid'],
    'success_action_status'=>200,
    'callback'=>$tokenArr['callback'],
    'signature'=>$tokenArr['signature'],
    'file' => new CURLFile(__DIR__.'/lib/plupload-2.1.2/readme.md', 'text/plain', 'readme.md')
];

function postForm($url,$data){
    $ch = curl_init();
    curl_setopt_array($ch, [
        CURLOPT_URL => $url,
        CURLOPT_POST => true,
        CURLOPT_POSTFIELDS => $data,
        CURLOPT_RETURNTRANSFER => true
    ]);
    $result = curl_exec($ch);
    curl_close($ch);
    return $result;
}
$result = postForm($tokenArr['host'],$formData);
print_r($result);