# Example of single-file services with clients

```bash
git clone git@github.com:alphasnow/aliyun-oss-appserver.git
cd aliyun-oss-appserver
vi examples/token.php
# modify $config
mv examples/ /data/wwwroot/appserver/
cd /data/wwwroot/appserver
composer install
```

Open [http://localhost/appserver/index.html](http://localhost/appserver/index.html)