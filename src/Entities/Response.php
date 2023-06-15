<?php

namespace AlphaSnow\OSS\AppServer\Entities;

use AlphaSnow\OSS\AppServer\Contracts\Parameter;

class Response implements Parameter
{
    /**
     * @required
     * @var string
     */
    protected $accessId;
    /**
     * @var string
     */
    protected $host;
    /**
     * @required
     * @var string
     */
    protected $policy;
    /**
     * @required
     * @var string
     */
    protected $signature;
    /**
     * @var int
     */
    protected $expire;
    /**
     * @var string
     */
    protected $callback = "";
    /**
     * @var string
     */
    protected $dir = "";

    /**
     * @return string
     */
    public function getAccessId()
    {
        return $this->accessId;
    }

    /**
     * @param string $accessId
     * @return Response
     */
    public function setAccessId($accessId)
    {
        $this->accessId = $accessId;
        return $this;
    }

    /**
     * @return string
     */
    public function getHost()
    {
        return $this->host;
    }

    /**
     * @param string $host
     * @return Response
     */
    public function setHost($host)
    {
        $this->host = $host;
        return $this;
    }

    /**
     * @return string
     */
    public function getPolicy()
    {
        return $this->policy;
    }

    /**
     * @param string $policy
     * @return Response
     */
    public function setPolicy($policy)
    {
        $this->policy = $policy;
        return $this;
    }

    /**
     * @return string
     */
    public function getSignature()
    {
        return $this->signature;
    }

    /**
     * @param string $signature
     * @return Response
     */
    public function setSignature($signature)
    {
        $this->signature = $signature;
        return $this;
    }

    /**
     * @return int
     */
    public function getExpire()
    {
        return $this->expire;
    }

    /**
     * @param int $expire
     * @return Response
     */
    public function setExpire($expire)
    {
        $this->expire = $expire;
        return $this;
    }

    /**
     * @return string
     */
    public function getCallback()
    {
        return $this->callback;
    }

    /**
     * @param string $callback
     * @return Response
     */
    public function setCallback($callback)
    {
        $this->callback = $callback;
        return $this;
    }

    /**
     * @return string
     */
    public function getDir()
    {
        return $this->dir;
    }

    /**
     * @param string $dir
     * @return Response
     */
    public function setDir($dir)
    {
        $this->dir = $dir;
        return $this;
    }

    public function toArray()
    {
        return [
            "accessid" => $this->accessId,
            "host" => $this->host,
            "policy" => $this->policy,
            "signature" => $this->signature,
            "expire" => $this->expire,
            "callback" => $this->callback,
            "dir" => $this->dir,
        ];
    }
}
