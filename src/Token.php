<?php

namespace AlphaSnow\OSS\AppServer;

use AlphaSnow\OSS\AppServer\Entities\AccessKey;
use AlphaSnow\OSS\AppServer\Entities\Policy;
use AlphaSnow\OSS\AppServer\Entities\Callback;
use AlphaSnow\OSS\AppServer\Contracts\Token as TokenContract;

class Token implements TokenContract
{
    /**
     * @var Policy
     */
    protected $policy;

    /**
     * @var Callback
     */
    protected $callback;

    /**
     * @var AccessKey
     */
    protected $access;

    /**
     * @param AccessKey $accessKey
     * @param Policy $policy
     * @param Callback $callback
     */
    public function __construct(AccessKey $accessKey, Policy $policy, Callback $callback)
    {
        $this->policy = $policy;
        $this->callback = $callback;
        $this->access = $accessKey;
    }

    /**
     * @return Policy
     */
    public function policy()
    {
        return $this->policy;
    }

    /**
     * @return Callback
     */
    public function callback()
    {
        return $this->callback;
    }

    /**
     * @return AccessKey
     */
    public function access()
    {
        return $this->access;
    }

    /**
     * @return array
     */
    public function response()
    {
        $response = [];
        $response["accessid"] = $this->access->getAccessKeyId();
        $response["host"] = $this->access->getOssHost();
        $response["policy"] = $this->encodePolicy($this->policy->toArray());
        $response["signature"] = $this->generateSignature($response["policy"], $this->access->getAccessKeySecret());
        $response["expire"] = $this->policy->getExpireAt();
        $response["callback"] = $this->encodeCallback($this->callback->toArray());
        $response["dir"] = $this->policy->getUserDir();
        return $response;
    }

    /**
     * @param array $policy
     * @return string
     */
    protected function encodePolicy($policy)
    {
        if ($json = json_encode($policy)) {
            return base64_encode($json);
        }
        return "";
    }

    /**
     * @param string $encodePolicy
     * @param string $key
     * @return string
     */
    protected function generateSignature($encodePolicy, $key)
    {
        return base64_encode(hash_hmac("sha1", $encodePolicy, $key, true));
    }

    /**
     * @param array $callback
     * @return string
     */
    protected function encodeCallback($callback)
    {
        if ($json = json_encode($callback)) {
            return base64_encode($json);
        }
        return "";
    }
}
