[English](README.md) | 简体中文

# 单文件服务与客户端的示例

```bash
# 克隆项目
git clone https://github.com/alphasnow/aliyun-oss-appserver.git

# 初始化自动加载
cd aliyun-oss-appserver/examples
composer install

# 修改配置
cp config.php.example config.php
vi config.php

# 启动服务
php -S 127.0.0.1:8080
```

访问 [http://127.0.0.1:8080](http://127.0.0.1:8080)

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