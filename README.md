English | [简体中文](README-CN.md)  

# AliYun OSS AppServer
Ali cloud server signature direct transmission and set up the call back

## Installation
```bash
composer require "alphasnow/aliyun-oss-appserver"
```

## Usage
### Laravel
```php
use AlphaSnow\OSS\AppServer\Token;

$data = app(Token::class)->response();
return response()->json($data);
```
```php
namespace AlphaSnow\OSS\AppServer;

$status = app(Callback::class)->verify($_SERVER['HTTP_AUTHORIZATION'],$_SERVER['HTTP_X_OSS_PUB_KEY_URL'],$_SERVER['REQUEST_URI'],file_get_contents('php://input'));
```

### Others
```php
use AlphaSnow\OSS\AppServer;

$data = (new AppServer())->token($config);
echo json_encode($data);
```
```php
use AlphaSnow\OSS\AppServer;

$status = (new AppServer())->verify();
```

## aliyun document
> https://help.aliyun.com/document_detail/31927.html