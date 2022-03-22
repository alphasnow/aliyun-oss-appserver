English | [简体中文](README-CN.md)  

# AliYun OSS AppServer
Ali cloud server signature direct transmission and set up the call back

[![Latest Stable Version](https://poser.pugx.org/alphasnow/aliyun-oss-appserver/v/stable)](https://packagist.org/packages/alphasnow/aliyun-oss-appserver)
[![Total Downloads](https://poser.pugx.org/alphasnow/aliyun-oss-appserver/downloads)](https://packagist.org/packages/alphasnow/aliyun-oss-appserver)
[![License](https://poser.pugx.org/alphasnow/aliyun-oss-appserver/license)](https://packagist.org/packages/alphasnow/aliyun-oss-appserver)
[![Build Status](https://github.com/alphasnow/aliyun-oss-appserver/workflows/CI/badge.svg)](https://github.com/alphasnow/aliyun-oss-appserver/actions)

## Installation
```bash
composer require "alphasnow/aliyun-oss-appserver"
```

## Configuration
Modify the environment file `.env`
```
OSS_ACCESS_KEY_ID=<Your aliyun accessKeyId, Required>
OSS_ACCESS_KEY_SECRET=<Your aliyun accessKeySecret, Required>
OSS_BUCKET=<Your oss bucket name, Required>
OSS_ENDPOINT=<Your oss endpoint domain, Required>
OSS_CALLBACK_URL=<Default callback address, Required>
OSS_POLICY_MAX_SIZE=<Default maximum file size 1 GB, Optional>
OSS_POLICY_EXPIRE_TIME=<Default expiration time 60s, Optional>
OSS_POLICY_USER_DIR=<Default Upload Directory upload/, Optional>
```

(Optional) Modify the config file `config/oss-appserver.php`
```bash
php artisan vendor:publish --provider=AlphaSnow\OSS\AppServer\ServiceProvider
```

## Usage
### Laravel Project
```php
use AlphaSnow\OSS\AppServer\Token;

$token = app(Token::class);
return response()->json($token->reponse());
```
```php
use AlphaSnow\OSS\AppServer\LaravelCallback;

$status = app(LaravelCallback::class)->verifyByRequest();
```

### Other Project
```php
use AlphaSnow\OSS\AppServer\AppServer;

$token = (new AppServer())->token($config);
echo json_encode($token->response());
```
```php
use AlphaSnow\OSS\AppServer\Callback;
use AlphaSnow\OSS\AppServer\StrandCallback;

$status = (new StrandCallback(new Callback))->verifyByRequest();
```

### Dynamic configuration
```php
// Change the address of the direct transmission server
$token->access()->setOssHost("https://wx-static.oss-cn-hangzhou.aliyuncs.com");

// Change the upload directory/timeout period to 60 seconds/maximum file limit to 500 MB
$token->policy()->setUserDir("users/")->setExpireTime(60)->setMaxSize(500*1024*1024);

// Change the callback address
$token->callback()->setCallbackUrl("http://domain.com/notify");
```

## AliYun document
> https://help.aliyun.com/document_detail/31927.html