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