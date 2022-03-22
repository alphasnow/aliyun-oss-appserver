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

### Change Parameters
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