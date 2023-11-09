English | [简体中文](README-CN.md)  

# AliYun OSS AppServer
![aliyun-oss-appserver](https://socialify.git.ci/alphasnow/aliyun-oss-appserver/image?description=1&language=1&name=1&owner=1&pattern=Plus&theme=Auto)

Upload data to OSS through Web applications.
Add signatures on the server, configure upload callback, and directly transfer data.

[![Latest Stable Version](https://poser.pugx.org/alphasnow/aliyun-oss-appserver/v/stable)](https://packagist.org/packages/alphasnow/aliyun-oss-appserver)
[![Total Downloads](https://poser.pugx.org/alphasnow/aliyun-oss-appserver/downloads)](https://packagist.org/packages/alphasnow/aliyun-oss-appserver)
[![License](https://poser.pugx.org/alphasnow/aliyun-oss-appserver/license)](https://packagist.org/packages/alphasnow/aliyun-oss-appserver)
[![Tests](https://github.com/alphasnow/aliyun-oss-appserver/actions/workflows/tests.yml/badge.svg?branch=1.x)](https://github.com/alphasnow/aliyun-oss-appserver/actions/workflows/tests.yml)

## Installation
```bash
composer require alphasnow/aliyun-oss-appserver
```

## Configuration
Modify the environment file `.env`
```env
OSS_ACCESS_KEY_ID=<Your aliyun accessKeyId, Required, Example: LT************Hz>
OSS_ACCESS_KEY_SECRET=<Your aliyun accessKeySecret, Required, Example: Q5**************************PD>
OSS_BUCKET=<Your oss bucket name, Required, Example: x-storage>
OSS_ENDPOINT=<Your oss endpoint domain, Required, Example: oss-cn-hangzhou.aliyuncs.com>
OSS_SSL=<Whether to use ssl, Optional, Example: true>
OSS_DOMAIN=<Domain name addresses, Optional, Example: x-storage.domain.com>
OSS_CALLBACK_URL=<Default callback address, Optional, Example: https://api.domain.com/callback>
OSS_POLICY_MAX_SIZE=<Default maximum file size 1GB, Optional, Example: 1048576000>
OSS_POLICY_EXPIRE_TIME=<Default expiration time 1 hour, Optional, Example: 3600>
OSS_POLICY_USER_DIR=<Default Upload Directory upload/, Optional, Example: upload/>
```

(Optional) Modify the config file `config/oss-appserver.php`
```bash
php artisan vendor:publish --provider=AlphaSnow\OSS\AppServer\Laravel\ServiceProvider
```

## Usage
### OSS configuration
- CORS configuration / Create rule / Example: `Soucre: *, Allow Methods: POST`


### Laravel server
Add route `routes/api.php`, Use the default controller.
```php
Route::get("app-server/oss-token", "\AlphaSnow\OSS\AppServer\Laravel\ServerController@token");
Route::post("app-server/oss-callback", "\AlphaSnow\OSS\AppServer\Laravel\ServerController@callback");
```

### Web client
1. Download [https://www.alibabacloud.com/help/en/object-storage-service/latest/add-signatures-on-the-client-by-using-javascript-and-upload-data-to-oss#title-l7m-nho-uap](https://www.alibabacloud.com/help/en/object-storage-service/latest/add-signatures-on-the-client-by-using-javascript-and-upload-data-to-oss#title-l7m-nho-uap)
2. Find line 30 of `upload.js` and change it to the actual server address, example: `http://laravel.local`
    ```js
    // serverUrl = "http://88.88.88.88:8888"
    serverUrl = "http://laravel.local/api/app-server/oss-token"
    ```

## Examples
[Example of single-file services with clients](examples)

### Dynamic configuration
```php
use AlphaSnow\OSS\AppServer\Factory;

$token = (new Factory($config))->makeToken();

// Change the address of the direct transmission server
$token->access()->setOssHost("https://bucket.endpoint.com");

// Change the upload directory/timeout period to 60 seconds/maximum file limit to 500 MB
$token->policy()->setUserDir("upload/")->setExpireTime(60)->setMaxSize(500*1024*1024);

// Change the callback address/callback body/callback header
$token->callback()->setCallbackUrl("http://domain.com/oss-callback")
    ->setCallbackBody("filename=\${object}&size=\${size}&mimeType=\${mimeType}&height=\${imageInfo.height}&width=\${imageInfo.width}")
    ->setCallbackBodyType("application/x-www-form-urlencoded");
```

## Ali document
> https://www.alibabacloud.com/help/en/object-storage-service/latest/obtain-signature-information-from-the-server-and-upload-data-to-oss
