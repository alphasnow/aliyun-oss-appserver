English | [简体中文](README-CN.md)  

# AliYun OSS AppServer
Upload data to OSS through Web applications.
Add signatures on the server, configure upload callback, and directly transfer data.

[![Latest Stable Version](https://poser.pugx.org/alphasnow/aliyun-oss-appserver/v/stable)](https://packagist.org/packages/alphasnow/aliyun-oss-appserver)
[![Total Downloads](https://poser.pugx.org/alphasnow/aliyun-oss-appserver/downloads)](https://packagist.org/packages/alphasnow/aliyun-oss-appserver)
[![License](https://poser.pugx.org/alphasnow/aliyun-oss-appserver/license)](https://packagist.org/packages/alphasnow/aliyun-oss-appserver)
[![Build Status](https://github.com/alphasnow/aliyun-oss-appserver/workflows/CI/badge.svg)](https://github.com/alphasnow/aliyun-oss-appserver/actions)
[![Code Coverage](https://scrutinizer-ci.com/g/alphasnow/aliyun-oss-appserver/badges/coverage.png?b=main)](https://scrutinizer-ci.com/g/alphasnow/aliyun-oss-appserver/?branch=main)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/alphasnow/aliyun-oss-appserver/badges/quality-score.png?b=main)](https://scrutinizer-ci.com/g/alphasnow/aliyun-oss-appserver/?branch=main)

## Installation
```bash
composer require alphasnow/aliyun-oss-appserver
```

## Configuration
Modify the environment file `.env`
```env
OSS_ACCESS_KEY_ID=<Your aliyun accessKeyId, Required, Example: LT************Hz>
OSS_ACCESS_KEY_SECRET=<Your aliyun accessKeySecret, Required, Example: Q5**************************PD>
OSS_BUCKET=<Your oss bucket name, Required, Example: my-files>
OSS_ENDPOINT=<Your oss endpoint domain, Required, Example: oss-cn-hangzhou.aliyuncs.com>
OSS_CALLBACK_URL=<Default callback address, Optional, Example: https://my-domain.com/callback>
OSS_POLICY_MAX_SIZE=<Default maximum file size 1000MB, Optional, Example: 1048576000>
OSS_POLICY_EXPIRE_TIME=<Default expiration time 3600s, Optional, Example: 3600>
OSS_POLICY_USER_DIR=<Default Upload Directory upload/, Optional, Example: upload/>
```

(Optional) Modify the config file `config/oss-appserver.php`
```bash
php artisan vendor:publish --provider=AlphaSnow\OSS\AppServer\ServiceProvider
```

## Usage
### Laravel server
Add route `routes/api.php`
```php
Route::get("app-server/token","AppSeverController@token");
Route::post("app-server/callback","AppSeverController@callback")->name("app-server.callback");
```
Add controller `app/Http/controllers/AppSeverController.php`
```php
namespace App\Http\Controllers;

use AlphaSnow\OSS\AppServer\Token;
use AlphaSnow\OSS\AppServer\LaravelCacheCallback;

class AppSeverController
{
    public function token(){
        $token = app(Token::class);
        // Dynamic configuration based on requirements
        // $token->callback()->setCallbackUrl(route("app-server.callback"));
        return response()->json($token->response());
    }

    public function callback(){
        $status = app(LaravelCacheCallback::class)->verifyByRequest();
        if ($status == false) {
            return response()->json(["status" => "fail"],403);
        }
        // Default callback parameters: filename, size, mimeType, height, width
        // $filename = request()->post("filename");
        return response()->json(["status" => "ok"]);
    }
}
```

#### Dynamic configuration
```php
// Change the address of the direct transmission server
$token->access()->setOssHost("https://bucket.endpoint.com");

// Change the upload directory/timeout period to 60 seconds/maximum file limit to 500 MB
$token->policy()->setUserDir("upload/")->setExpireTime(60)->setMaxSize(500*1024*1024);

// Change the callback address/callback body/callback header
$token->callback()->setCallbackUrl("http://domain.com/callback")
    ->setCallbackBody("filename=\${object}&size=\${size}&mimeType=\${mimeType}&height=\${imageInfo.height}&width=\${imageInfo.width}")
    ->setCallbackBodyType("application/x-www-form-urlencoded");
```

### Web client
1. Download [https://help.aliyun.com/document_detail/31927.html#section-kx3-tsk-gfb](https://help.aliyun.com/document_detail/31927.html#section-kx3-tsk-gfb)
2. Find line 30 of `upload.js` and change it to the actual server address
    ```js
    // serverUrl = 'http://88.88.88.88:8888'
    serverUrl = 'http://laravel.local/api/app-server/token'
    ```
3. Set the bucket of the OSS object storage to Cors(Check Post)

## Example data
### Token response 
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

### Callback request
```json
{
    "filename": "upload/894a60bb3ce807d5f39f9b11bfb94f3d.png",
    "size": "256270",
    "mimeType": "image/png",
    "height": "529",
    "width": "353"
}
```

## Example of single-file services with clients
[https://github.com/alphasnow/aliyun-oss-appserver/tree/main/examples](https://github.com/alphasnow/aliyun-oss-appserver/tree/main/examples)


## Ali document
> https://www.alibabacloud.com/help/en/object-storage-service/latest/obtain-signature-information-from-the-server-and-upload-data-to-oss
