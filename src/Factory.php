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
        return new AccessKey($config["access_key_id"], $config["access_key_secret"], $config["bucket"], $config["endpoint"], $config["host"] ?? null);
    }

    /**
     * @param array $config
     * @return Policy
     */
    public function makePolicy(array $config)
    {
        $policy = new Policy();
        if (isset($config["expire_time"])) {
            $policy->setExpireTime($config["expire_time"]);
        }
        if (isset($config["max_size"])) {
            $policy->setMaxSize($config["max_size"]);
        }
        if (isset($config["user_dir"])) {
            $policy->setUserDir($config["user_dir"]);
        }
        return $policy;
    }

    /**
     * @param array $config
     * @return CallbackParam
     */
    public function makeCallbackParam(array $config)
    {
        return new CallbackParam($config["callback_url"], $config["callback_body"] ?? null, $config["callback_body_type"] ?? null);
    }
}
