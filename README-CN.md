[English](README.md) | 简体中文  

# AliYun OSS AppServer
![aliyun-oss-appserver](https://socialify.git.ci/alphasnow/aliyun-oss-appserver/image?description=1&language=1&name=1&owner=1&pattern=Plus&theme=Auto)

Web端直接上传数据至OSS, 服务端签名直传并设置上传回调.

[![Latest Stable Version](https://poser.pugx.org/alphasnow/aliyun-oss-appserver/v/stable)](https://packagist.org/packages/alphasnow/aliyun-oss-appserver)
[![Total Downloads](https://poser.pugx.org/alphasnow/aliyun-oss-appserver/downloads)](https://packagist.org/packages/alphasnow/aliyun-oss-appserver)
[![License](https://poser.pugx.org/alphasnow/aliyun-oss-appserver/license)](https://packagist.org/packages/alphasnow/aliyun-oss-appserver)
[![Test](https://github.com/alphasnow/aliyun-oss-appserver/workflows/Test/badge.svg?branch=1.x)](https://github.com/alphasnow/aliyun-oss-appserver/actions?query=branch:1.x)

## 安装依赖
```bash
composer require alphasnow/aliyun-oss-appserver
```

## 服务配置
修改环境配置 `.env`
```env
OSS_ACCESS_KEY_ID=<必填, 阿里云的AccessKeyId, 示例: LT************Hz>
OSS_ACCESS_KEY_SECRET=<必填, 阿里云的AccessKeySecret, 示例: Q5**************************PD>
OSS_BUCKET=<必填, 对象存储的Bucket, 示例: x-storage>
OSS_ENDPOINT=<必填, 对象存储的Endpoint, 示例: oss-cn-hangzhou.aliyuncs.com>
OSS_SSL=<选填, 是否使用SSL, 示例: true>
OSS_DOMAIN=<选填, 域名地址, 示例: x-storage.domain.com>
OSS_CALLBACK_URL=<选填, 默认回调地址, 示例: https://api.domain.com/callback>
OSS_POLICY_MAX_SIZE=<选填, 默认最大文件大小1GB, 示例: 1048576000>
OSS_POLICY_EXPIRE_TIME=<选填, 默认过期时间1小时, 示例: 3600>
OSS_POLICY_USER_DIR=<选填, 默认上传目录upload/, 示例: upload/>
```

(可选) 修改配置文件 `config/oss-appserver.php`
```bash
php artisan vendor:publish --provider=AlphaSnow\OSS\AppServer\ServiceProvider
```

## 快速使用
### OSS 配置
- 跨域设置 / 创建规则 / 示例: `来源:*, 允许 Methods:POST`

### Laravel服务端
添加路由`routes/api.php`, 使用默认控制器.
```php
Route::get("app-server/oss-token", "\AlphaSnow\OSS\AppServer\Laravel\ServerController@token");
Route::post("app-server/oss-callback", "\AlphaSnow\OSS\AppServer\Laravel\ServerController@callback");
```

### Web客户端
1. 下载 [https://help.aliyun.com/document_detail/31927.html#section-kx3-tsk-gfb](https://help.aliyun.com/document_detail/31927.html#section-kx3-tsk-gfb)
2. 找到`upload.js`的第30行代码,修改为实际服务器地址, 示例: `http://laravel.local`
    ```js
    // serverUrl = "http://88.88.88.88:8888"
    serverUrl = "http://laravel.local/api/app-server/oss-token"
    ```

## 示例
[单文件服务与客户端的示例](examples)

### 动态配置
```php
use AlphaSnow\OSS\AppServer\Factory;

$token = (new Factory($config))->makeToken();

// 修改直传服务器地址
$token->access()->setOssHost("https://bucket.endpoint.com");

// 修改上传目录/超时时间60秒/最大文件限制500M
$token->policy()->setUserDir("upload/")->setExpireTime(60)->setMaxSize(500*1024*1024);

// 修改回调地址/回调数据/回调请求头
$token->callback()->setCallbackUrl("http://domain.com/callback")
    ->setCallbackBody("filename=\${object}&size=\${size}&mimeType=\${mimeType}&height=\${imageInfo.height}&width=\${imageInfo.width}")
    ->setCallbackBodyType("application/x-www-form-urlencoded");
```

## 阿里云文档
> https://help.aliyun.com/document_detail/31927.html