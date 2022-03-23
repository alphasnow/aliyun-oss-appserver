[English](README.md) | 简体中文  

# AliYun OSS AppServer
阿里云服务端签名直传并设置上传回调

[![Latest Stable Version](https://poser.pugx.org/alphasnow/aliyun-oss-appserver/v/stable)](https://packagist.org/packages/alphasnow/aliyun-oss-appserver)
[![Total Downloads](https://poser.pugx.org/alphasnow/aliyun-oss-appserver/downloads)](https://packagist.org/packages/alphasnow/aliyun-oss-appserver)
[![License](https://poser.pugx.org/alphasnow/aliyun-oss-appserver/license)](https://packagist.org/packages/alphasnow/aliyun-oss-appserver)
[![Build Status](https://github.com/alphasnow/aliyun-oss-appserver/workflows/CI/badge.svg)](https://github.com/alphasnow/aliyun-oss-appserver/actions)

## 安装依赖
```bash
composer require alphasnow/aliyun-oss-appserver
```

## 服务配置
修改环境配置 `.env`
```
OSS_ACCESS_KEY_ID=<必填, 阿里云的AccessKeyId>
OSS_ACCESS_KEY_SECRET=<必填, 阿里云的AccessKeySecret>
OSS_BUCKET=<必填, 对象存储的Bucket>
OSS_ENDPOINT=<必填, 对象存储的Endpoint>
OSS_CALLBACK_URL=<必填, 默认回调地址>
OSS_POLICY_MAX_SIZE=<选填, 默认最大文件大小1G>
OSS_POLICY_EXPIRE_TIME=<选填, 默认过期时间60秒>
OSS_POLICY_USER_DIR=<选填, 默认上传目录upload/>
```

(可选) 修改配置文件 `config/oss-appserver.php`
```bash
php artisan vendor:publish --provider=AlphaSnow\OSS\AppServer\ServiceProvider
```

## 快速使用
### Laravel项目
获取授权
```php
use AlphaSnow\OSS\AppServer\Token;

$data = app(Token::class)->response();
return response()->json($data);
```
处理回调
```php
use AlphaSnow\OSS\AppServer\LaravelCallback;

$status = app(LaravelCallback::class)->verifyByRequest();
```

### 其他框架项目
获取授权
```php
use AlphaSnow\OSS\AppServer\Factory;

$data = (new Factory())->makeToken($config)->response();
echo json_encode($data);
```
处理回调
```php
use AlphaSnow\OSS\AppServer\Callback;
use AlphaSnow\OSS\AppServer\StrandCallback;

$status = (new StrandCallback(new Callback))->verifyByRequest();
```

### 动态配置
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