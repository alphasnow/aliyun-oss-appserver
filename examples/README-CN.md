[English](README.md) | 简体中文

# 单文件服务与客户端的示例

```bash
# 克隆项目
git clone git@github.com:alphasnow/aliyun-oss-appserver.git

# 初始化自动加载
cd aliyun-oss-appserver/examples
composer install

# 修改配置
cp config.php.example config.php
vi config.php

# 部署代码
cp -R ../examples/ /data/wwwroot/appserver/
cd /data/wwwroot/appserver
```

访问 [http://localhost/appserver/index.html](http://localhost/appserver/index.html)