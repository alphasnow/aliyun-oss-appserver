[English](README.md) | 简体中文

# 单文件服务与客户端的示例

```bash
# 克隆
git clone git@github.com:alphasnow/aliyun-oss-appserver.git

# 创建 autoload.php
cd aliyun-oss-appserver/examples
composer install

# 修改 $config
vi token.php
# "access_key_id" => "",
# "access_key_secret" => "",
# "bucket" => "",
# "endpoint" => "",

# 部署代码
cp -R ../examples/ /data/wwwroot/appserver/
cd /data/wwwroot/appserver
```

访问 [http://localhost/appserver/index.html](http://localhost/appserver/index.html)