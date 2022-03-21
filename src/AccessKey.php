<?php

namespace AlphaSnow\OSS\AppServer;

class AccessKey
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
     * @param bool $ssl
     * @return string
     */
    public function getOssHost($ssl = true)
    {
        if ($this->ossHost) {
            return $this->ossHost;
        }

        $protocol = $ssl ? "https" : "http";
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
}
