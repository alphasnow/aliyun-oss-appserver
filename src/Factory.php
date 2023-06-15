<?php

namespace AlphaSnow\OSS\AppServer;

use AlphaSnow\OSS\AppServer\Entities\AccessKey;
use AlphaSnow\OSS\AppServer\Entities\Policy;
use AlphaSnow\OSS\AppServer\Entities\Callback;
use AlphaSnow\OSS\AppServer\Contracts\Factory as FactoryContract;

class Factory implements FactoryContract
{
    /**
     * @var array
     */
    protected $config;

    /**
     * @param array $config
     */
    public function __construct(array $config)
    {
        $this->config = $config;
    }

    /**
     * @return Token
     */
    public function makeToken()
    {
        $accessKey = $this->makeAccessKey();
        $policy = $this->makePolicy();
        $callback = $this->makeCallback();
        return new Token($accessKey, $policy, $callback);
    }

    /**
     * @return AccessKey
     */
    public function makeAccessKey()
    {
        return new AccessKey($this->config["access_key_id"], $this->config["access_key_secret"], $this->config["bucket"], $this->config["endpoint"], $this->config["domain"] ?? "", $this->config["use_ssl"] ?? true);
    }

    /**
     * @return Policy
     */
    public function makePolicy()
    {
        $policy = new Policy();
        if ($this->config["bucket"]) {
            $policy->setBucket($this->config["bucket"]);
        }
        if (isset($this->config["expire_time"])) {
            $policy->setExpireTime($this->config["expire_time"]);
        }
        if (isset($this->config["max_size"])) {
            $policy->setMaxSize($this->config["max_size"]);
        }
        if (isset($this->config["user_dir"])) {
            $policy->setUserDir($this->config["user_dir"]);
        }
        return $policy;
    }

    /**
     * @return Callback
     */
    public function makeCallback()
    {
        return new Callback($this->config["callback_url"], $this->config["callback_body"] ?? null, $this->config["callback_body_type"] ?? null);
    }
}
