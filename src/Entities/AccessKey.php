<?php

namespace AlphaSnow\OSS\AppServer\Entities;

use AlphaSnow\OSS\AppServer\Contracts\Parameter;

class AccessKey implements Parameter
{
    /**
     * @var string
     */
    protected $accessKeyId;

    /**
     * @var string
     */
    protected $accessKeySecret;

    /**
     * @var string
     */
    protected $ossBucket;

    /**
     * @var string
     */
    protected $ossEndpoint;

    /**
     * @var string
     */
    protected $ossHost;

    /**
     * @var bool
     */
    protected $useSSL;

    /**
     * @param string $accessKeyId
     * @param string $accessKeySecret
     * @param string $ossBucket
     * @param string $ossEndpoint
     * @param string $ossHost
     * @param boolean $useSSL
     */
    public function __construct($accessKeyId, $accessKeySecret, $ossBucket, $ossEndpoint, $ossHost = null, $useSSL = true)
    {
        $this->accessKeyId = $accessKeyId;
        $this->accessKeySecret = $accessKeySecret;
        $this->ossBucket = $ossBucket;
        $this->ossEndpoint = $ossEndpoint;
        $this->ossHost = $ossHost;
        $this->useSSL = $useSSL;
    }

    /**
     * @return string
     */
    public function getAccessKeyId()
    {
        return $this->accessKeyId;
    }

    /**
     * @param string $accessKeyId
     * @return $this
     */
    public function setAccessKeyId($accessKeyId)
    {
        $this->accessKeyId = $accessKeyId;

        return $this;
    }

    /**
     * @return string
     */
    public function getAccessKeySecret()
    {
        return $this->accessKeySecret;
    }

    /**
     * @param string $accessKeySecret
     * @return $this
     */
    public function setAccessKeySecret($accessKeySecret)
    {
        $this->accessKeySecret = $accessKeySecret;

        return $this;
    }

    /**
     * @return string
     */
    public function getOssBucket()
    {
        return $this->ossBucket;
    }

    /**
     * @param string $ossBucket
     * @return $this
     */
    public function setOssBucket($ossBucket)
    {
        $this->ossBucket = $ossBucket;

        return $this;
    }

    /**
     * @return string
     */
    public function getOssEndpoint()
    {
        return $this->ossEndpoint;
    }

    /**
     * @param string $ossEndpoint
     * @return $this
     */
    public function setOssEndpoint($ossEndpoint)
    {
        $this->ossEndpoint = $ossEndpoint;

        return $this;
    }

    /**
     * @return string
     */
    public function getOssHost()
    {
        $protocol = $this->useSSL ? "https" : "http";

        if ($this->ossHost) {
            if (substr($this->ossHost, 0, 4) === "http") {
                return $this->ossHost;
            }

            return $protocol."://".$this->ossHost;
        }

        return $protocol."://".$this->ossBucket.".".$this->ossEndpoint;
    }

    /**
     * @param string $ossHost
     * @return $this
     */
    public function setOssHost(string $ossHost)
    {
        $this->ossHost = $ossHost;

        return $this;
    }

    /**
     * @return array
     */
    public function toArray()
    {
        return [
            "accessid" => $this->accessKeyId,
            "host" => $this->getOssHost(),
        ];
    }
}
