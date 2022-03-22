[English](README.md) | 简体中文  

# AliYun OSS AppServer
阿里云服务端签名直传并设置上传回调

[![Latest Stable Version](https://poser.pugx.org/alphasnow/aliyun-oss-appserver/v/stable)](https://packagist.org/packages/alphasnow/aliyun-oss-appserver)
[![Total Downloads](https://poser.pugx.org/alphasnow/aliyun-oss-appserver/downloads)](https://packagist.org/packages/alphasnow/aliyun-oss-appserver)
[![License](https://poser.pugx.org/alphasnow/aliyun-oss-appserver/license)](https://packagist.org/packages/alphasnow/aliyun-oss-appserver)
[![Build Status](https://github.com/alphasnow/aliyun-oss-appserver/workflows/CI/badge.svg)](https://github.com/alphasnow/aliyun-oss-appserver/actions)

## 安装依赖
```bash
composer require "alphasnow/aliyun-oss-appserver"
```

## 快速使用
### Laravel项目
```php
use AlphaSnow\OSS\AppServer\Token;

$data = app(Token::class)->response();
return response()->json($data);
```
```php
use AlphaSnow\OSS\AppServer\LaravelCallback;

$status = app(LaravelCallback::class)->verifyByRequest(request());
```

### 其他项目
```php
use AlphaSnow\OSS\AppServer\AppServer;

$data = (new AppServer())->token($config)->response();
echo json_encode($data);
```
```php
use AlphaSnow\OSS\AppServer\Callback;
use AlphaSnow\OSS\AppServer\StrandCallback;

$status = (new StrandCallback(new Callback))->verifyByRequest();
```

## 配置参数
```php
// 修改直传服务器地址
$token->access()->setOssHost("https://wx-static.oss-cn-hangzhou.aliyuncs.com");

// 修改上传目录/超时时间60秒/最大文件限制500M
$token->policy()->setUserDir("users/")->setExpireTime(60)->setMaxSize(500*1024*1024);

// 修改回调地址
$token->callback()->setCallbackUrl("http://domain.com/notify");
```

## 阿里云文档
> https://help.aliyun.com/document_detail/31927.html