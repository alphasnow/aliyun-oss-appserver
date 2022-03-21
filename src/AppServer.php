<?php

namespace AlphaSnow\OSS\AppServer;

class AppServer
{
    /**
     * @param array $config
     * @return array
     */
    public function token(array $config)
    {
        return $this->makeToken($config)->response();
    }

    /**
     * @param array $config
     * @return Token
     */
    public function makeToken(array $config)
    {
        $accessKey = $this->makeAccessKey($config);
        $policy = $this->makePolicy($config);
        $callback = $this->makeCallback($config);
        return new Token($accessKey, $policy, $callback);
    }

    /**
     * @param array $config
     * @return AccessKey
     */
    public function makeAccessKey(array $config)
    {
        return (new AccessKey())->setAccessKeyId($config['access_key_id'])
            ->setAccessKeySecret($config['access_key_secret'])
            ->setOssBucket($config['bucket'])
            ->setOssEndpoint($config['endpoint']);
    }

    /**
     * @param array $config
     * @return Policy
     */
    public function makePolicy(array $config)
    {
        return (new Policy())->setExpireTime($config['expire_time'])
            ->setMaxSize($config['max_size'])
            ->setUserDir($config['user_dir']);
    }

    /**
     * @param array $config
     * @return CallbackParam
     */
    public function makeCallback(array $config)
    {
        return (new CallbackParam())->setCallbackUrl($config['callback_url']);
    }

    /**
     * @return bool
     */
    public function verify()
    {
        return (new Callback())->verify($_SERVER['HTTP_AUTHORIZATION'], $_SERVER['HTTP_X_OSS_PUB_KEY_URL'], $_SERVER['REQUEST_URI'], file_get_contents('php://input'));
    }
}
