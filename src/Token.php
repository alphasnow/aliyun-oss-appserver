<?php

namespace AlphaSnow\OSS\AppServer;

/**
 * @link https://help.aliyun.com/document_detail/31927.html
 */
class Token
{
    /**
     * @var Policy
     */
    protected $policy;

    /**
     * @var CallbackParam
     */
    protected $callback;

    /**
     * @var AccessKey
     */
    protected $access;

    /**
     * @param AccessKey $accessKey
     * @param Policy $policy
     * @param CallbackParam $callback
     */
    public function __construct(AccessKey $accessKey, Policy $policy, CallbackParam $callback)
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
     * @return CallbackParam
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
        $response['accessid'] = $this->access->getAccessKeyId();
        $response['host'] = $this->access->getOssHost();
        $response['policy'] = $this->encodePolicy($this->policy->getPolicy());
        $response['signature'] = $this->generateSignature($response['policy'], $this->access->getAccessKeySecret());
        $response['expire'] = $this->policy->getExpireAt();
        $response['callback'] = $this->encodeCallback($this->callback->getCallbackParam());
        $response['dir'] = $this->policy->getUserDir();
        return $response;
    }

    /**
     * @param array $policy
     * @return string
     */
    protected function encodePolicy($policy)
    {
        return base64_encode(json_encode($policy));
    }

    /**
     * @param string $encodePolicy
     * @param string $key
     * @return string
     */
    protected function generateSignature($encodePolicy, $key)
    {
        return base64_encode(hash_hmac('sha1', $encodePolicy, $key, true));
    }

    /**
     * @param array $callback
     * @return string
     */
    protected function encodeCallback($callback)
    {
        return base64_encode(json_encode($callback));
    }
}
