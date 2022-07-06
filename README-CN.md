[English](README.md) | 简体中文  

# AliYun OSS AppServer
Web端直接上传数据至OSS, 服务端签名直传并设置上传回调.

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
```env
OSS_ACCESS_KEY_ID=<必填, 阿里云的AccessKeyId, 示例: LT************Hz>
OSS_ACCESS_KEY_SECRET=<必填, 阿里云的AccessKeySecret, 示例: Q5**************************PD>
OSS_BUCKET=<必填, 对象存储的Bucket, 示例: my-files>
OSS_ENDPOINT=<必填, 对象存储的Endpoint, 示例: oss-cn-hangzhou.aliyuncs.com>
OSS_CALLBACK_URL=<选填, 默认回调地址, 示例: https://my-domain.com/callback>
OSS_POLICY_MAX_SIZE=<选填, 默认最大文件大小1000MB, 示例: 1048576000>
OSS_POLICY_EXPIRE_TIME=<选填, 默认过期时间3600秒, 示例: 3600>
OSS_POLICY_USER_DIR=<选填, 默认上传目录upload/, 示例: upload/>
```

(可选) 修改配置文件 `config/oss-appserver.php`
```bash
php artisan vendor:publish --provider=AlphaSnow\OSS\AppServer\ServiceProvider
```

## 快速使用
### Laravel服务端
添加路由`routes/api.php`
```php
Route::get("app-server/token","AppSeverController@token");
Route::post("app-server/callback","AppSeverController@callback")->name("app-server.callback");
```
添加控制器`app/Http/controllers/AppSeverController.php`
```php
namespace App\Http\Controllers;

use AlphaSnow\OSS\AppServer\Token;
use AlphaSnow\OSS\AppServer\LaravelCacheCallback;

class AppSeverController
{
    public function token(){
        $token = app(Token::class);
        // 根据需求动态配置
        // $token->callback()->setCallbackUrl(route("app-server.callback"));
        return response()->json($token->response());
    }

    public function callback(){
        $status = app(LaravelCacheCallback::class)->verifyByRequest();
        if ($status == false) {
            return response()->json(["status" => "fail"],403);
        }
        // 默认回调参数: filename, size, mimeType, height, width
        // $filename = request()->post("filename");
        return response()->json(["status" => "ok"]);
    }
}
```

#### 动态配置
```php
// 修改直传服务器地址
$token->access()->setOssHost("https://bucket.endpoint.com");

// 修改上传目录/超时时间60秒/最大文件限制500M
$token->policy()->setUserDir("upload/")->setExpireTime(60)->setMaxSize(500*1024*1024);

// 修改回调地址/回调数据/回调请求头
$token->callback()->setCallbackUrl("http://domain.com/callback")
    ->setCallbackBody("filename=\${object}&size=\${size}&mimeType=\${mimeType}&height=\${imageInfo.height}&width=\${imageInfo.width}")
    ->setCallbackBodyType("application/x-www-form-urlencoded");
```

### Web客户端
1. 下载 [https://help.aliyun.com/document_detail/31927.html#section-kx3-tsk-gfb](https://help.aliyun.com/document_detail/31927.html#section-kx3-tsk-gfb)
2. 找到`upload.js`的第30行代码,修改为实际服务器地址
    ```js
    // serverUrl = 'http://88.88.88.88:8888'
    serverUrl = 'http://laravel.local/api/app-server/token'
    ```
3. OSS对象存储的对应bucket设置Cors(Post打勾）

## 数据示例
### 授权响应示例
```json
{
    "accessid": "access_key_id",
    "host": "https://bucket.endpoint.com",
    "policy": "eyJleHBpcmF0aW9uIjoiMjAyMi0wMy0yMVQwODoyNzoxNi4wMDBaIiwiY29uZGl0aW9ucyI6W1siY29udGVudC1sZW5ndGgtcmFuZ2UiLDAsMTA0ODU3NjAwMF0sWyJzdGFydHMtd2l0aCIsIiRrZXkiLCJ1cGxvYWRcLyJdXX0=",
    "signature": "P2qcKX8/CKiCzEiDh6CE02HoTRk=",
    "expire": 1647851236,
    "callback": "eyJjYWxsYmFja1VybCI6Imh0dHA6XC9cL2RvbWFpbi5jb21cL2NhbGxiYWNrIiwiY2FsbGJhY2tCb2R5IjoiZmlsZW5hbWU9JHtvYmplY3R9JnNpemU9JHtzaXplfSZtaW1lVHlwZT0ke21pbWVUeXBlfSZoZWlnaHQ9JHtpbWFnZUluZm8uaGVpZ2h0fSZ3aWR0aD0ke2ltYWdlSW5mby53aWR0aH0iLCJjYWxsYmFja0JvZHlUeXBlIjoiYXBwbGljYXRpb25cL3gtd3d3LWZvcm0tdXJsZW5jb2RlZCJ9",
    "dir": "upload/"
}
```

### 回调请求示例
```json
{
    "filename": "upload/894a60bb3ce807d5f39f9b11bfb94f3d.png",
    "size": "256270",
    "mimeType": "image/png",
    "height": "529",
    "width": "353"
}
```

## 单文件服务与客户端的示例
[https://github.com/alphasnow/aliyun-oss-appserver/tree/main/examples](https://github.com/alphasnow/aliyun-oss-appserver/tree/main/examples)

## 阿里云文档
> https://help.aliyun.com/document_detail/31927.html