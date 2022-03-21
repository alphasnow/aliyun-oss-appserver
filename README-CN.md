[English](README.md) | 简体中文  

# AliYun OSS AppServer
阿里云服务端签名直传并设置上传回调

## 安装依赖

```bash
composer require "alphasnow/aliyun-oss-appserver"
```

## 快速使用
### Laravel
```
use AlphaSnow\OSS\AppServer\Token;

$data = app(Token::class)->response();
return response()->json($data);
```
```
namespace AlphaSnow\OSS\AppServer;

$status = app(Callback::class)->verify($_SERVER['HTTP_AUTHORIZATION'],$_SERVER['HTTP_X_OSS_PUB_KEY_URL'],$_SERVER['REQUEST_URI'],file_get_contents('php://input'));
```

### Others
```
use AlphaSnow\OSS\AppServer;

$data = (new AppServer())->token($config);
echo json_encode($data);
```
```
use AlphaSnow\OSS\AppServer;

$status = (new AppServer())->verify();
```

## 阿里云文档
> https://help.aliyun.com/document_detail/31927.html