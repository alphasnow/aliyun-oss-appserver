<?php

namespace AlphaSnow\OSS\AppServer;

class Factory
{
    /**
     * @param array $config
     * @return Token
     */
    public function makeToken(array $config)
    {
        $accessKey = $this->makeAccessKey($config);
        $policy = $this->makePolicy($config);
        $callback = $this->makeCallbackParam($config);
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
    public function makeCallbackParam(array $config)
    {
        return (new CallbackParam())->setCallbackUrl($config['callback_url']);
    }
}
