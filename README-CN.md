[English](README.md) | 简体中文  

# AliYun OSS AppServer
Web端直接上传数据至OSS, 服务端签名直传并设置上传回调.

[![Latest Stable Version](https://poser.pugx.org/alphasnow/aliyun-oss-appserver/v/stable)](https://packagist.org/packages/alphasnow/aliyun-oss-appserver)
[![Total Downloads](https://poser.pugx.org/alphasnow/aliyun-oss-appserver/downloads)](https://packagist.org/packages/alphasnow/aliyun-oss-appserver)
[![License](https://poser.pugx.org/alphasnow/aliyun-oss-appserver/license)](https://packagist.org/packages/alphasnow/aliyun-oss-appserver)
[![Build Status](https://github.com/alphasnow/aliyun-oss-appserver/workflows/CI/badge.svg)](https://github.com/alphasnow/aliyun-oss-appserver/actions)
[![Code Coverage](https://scrutinizer-ci.com/g/alphasnow/aliyun-oss-appserver/badges/coverage.png?b=main)](https://scrutinizer-ci.com/g/alphasnow/aliyun-oss-appserver/?branch=main)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/alphasnow/aliyun-oss-appserver/badges/quality-score.png?b=main)](https://scrutinizer-ci.com/g/alphasnow/aliyun-oss-appserver/?branch=main)

## 安装依赖
```bash
composer require alphasnow/aliyun-oss-appserver
```

## 服务配置
修改环境配置 `.env`
```env
OSS_ACCESS_KEY_ID=<必填, 阿里云的AccessKeyId, 示例: LT************Hz>
OSS_ACCESS_KEY_SECRET=<必填, 阿里云的AccessKeySecret, 示例: Q5**************************PD>
OSS_BUCKET=<必填, 对象存储的Bucket, 示例: my-files>
OSS_ENDPOINT=<必填, 对象存储的Endpoint, 示例: oss-cn-hangzhou.aliyuncs.com>
OSS_CALLBACK_URL=<必填, 默认回调地址, 示例: https://my-domain.com/callback>
OSS_POLICY_MAX_SIZE=<选填, 默认最大文件大小1G, 示例: 5242880>
OSS_POLICY_EXPIRE_TIME=<选填, 默认过期时间60秒, 示例: 15>
OSS_POLICY_USER_DIR=<选填, 默认上传目录upload/, 示例: attachments/>
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

$token = app(Token::class);
return response()->json($token->reponse());
// {"accessid":"access_key_id","host":"https://bucket.endpoint.com","policy":"eyJleHBpcmF0aW9uIjoiMjAyMi0wMy0yMVQwODoyNzoxNi4wMDBaIiwiY29uZGl0aW9ucyI6W1siY29udGVudC1sZW5ndGgtcmFuZ2UiLDAsMTA0ODU3NjAwMF0sWyJzdGFydHMtd2l0aCIsIiRrZXkiLCJ1cGxvYWRcLyJdXX0=","signature":"P2qcKX8/CKiCzEiDh6CE02HoTRk=","expire":1647851236,"callback":"eyJjYWxsYmFja1VybCI6Imh0dHA6XC9cL2RvbWFpbi5jb21cL2NhbGxiYWNrIiwiY2FsbGJhY2tCb2R5IjoiZmlsZW5hbWU9JHtvYmplY3R9JnNpemU9JHtzaXplfSZtaW1lVHlwZT0ke21pbWVUeXBlfSZoZWlnaHQ9JHtpbWFnZUluZm8uaGVpZ2h0fSZ3aWR0aD0ke2ltYWdlSW5mby53aWR0aH0iLCJjYWxsYmFja0JvZHlUeXBlIjoiYXBwbGljYXRpb25cL3gtd3d3LWZvcm0tdXJsZW5jb2RlZCJ9","dir":"upload/"}
```
处理回调
```php
use AlphaSnow\OSS\AppServer\LaravelCallback;

$status = app(LaravelCallback::class)->verifyByRequest();
// true or false
```

### 其他框架项目
获取授权
```php
use AlphaSnow\OSS\AppServer\Factory;

$token = (new Factory)->makeToken($config);
echo json_encode($token->response());
// {"accessid":"access_key_id","host":"https://bucket.endpoint.com","policy":"eyJleHBpcmF0aW9uIjoiMjAyMi0wMy0yMVQwODoyNzoxNi4wMDBaIiwiY29uZGl0aW9ucyI6W1siY29udGVudC1sZW5ndGgtcmFuZ2UiLDAsMTA0ODU3NjAwMF0sWyJzdGFydHMtd2l0aCIsIiRrZXkiLCJ1cGxvYWRcLyJdXX0=","signature":"P2qcKX8/CKiCzEiDh6CE02HoTRk=","expire":1647851236,"callback":"eyJjYWxsYmFja1VybCI6Imh0dHA6XC9cL2RvbWFpbi5jb21cL2NhbGxiYWNrIiwiY2FsbGJhY2tCb2R5IjoiZmlsZW5hbWU9JHtvYmplY3R9JnNpemU9JHtzaXplfSZtaW1lVHlwZT0ke21pbWVUeXBlfSZoZWlnaHQ9JHtpbWFnZUluZm8uaGVpZ2h0fSZ3aWR0aD0ke2ltYWdlSW5mby53aWR0aH0iLCJjYWxsYmFja0JvZHlUeXBlIjoiYXBwbGljYXRpb25cL3gtd3d3LWZvcm0tdXJsZW5jb2RlZCJ9","dir":"upload/"}
```
处理回调
```php
use AlphaSnow\OSS\AppServer\Callback;
use AlphaSnow\OSS\AppServer\StrandCallback;

$status = (new StrandCallback(new Callback))->verifyByRequest();
// true or false
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