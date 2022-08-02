English | [简体中文](README-CN.md)

# Example of single-file services with clients

```bash
# clone project
git clone git@github.com:alphasnow/aliyun-oss-appserver.git

# create autoload.php
cd aliyun-oss-appserver/examples
composer install

# modify $config
cp config.php.example config.php
vi config.php

# deploy code
cp -R ../examples/ /data/wwwroot/appserver/
cd /data/wwwroot/appserver
```

Open [http://localhost/appserver/index.html](http://localhost/appserver/index.html)

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