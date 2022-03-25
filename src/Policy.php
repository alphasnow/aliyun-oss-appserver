<?php

namespace AlphaSnow\OSS\AppServer;

/**
 * @link https://help.aliyun.com/document_detail/31988.htm#section-d5z-1ww-wdb
 */
class Policy implements ArrayEntity
{
    /**
     * @var array
     */
    protected $policy = [];

    /**
     * @var string
     */
    protected $userDir;

    /**
     * @var int
     */
    protected $expireTime;

    /**
     * @var int
     */
    protected $expireAt;

    /**
     * @var int
     */
    protected $maxSize;

    /**
     * @param array $conditions
     * @param string $expiration
     */
    public function __construct($conditions = [], $expiration = null)
    {
        if (!empty($conditions)) {
            $this->policy['conditions'] = $conditions;
        }
        if (!is_null($expiration)) {
            $this->policy['expiration'] = $expiration;
        }
    }

    /**
     * @param array $policy
     * @return $this
     */
    public function setPolicy(array $policy)
    {
        $this->policy = $policy;
        return $this;
    }

    /**
     * @return string
     */
    public function getUserDir()
    {
        return $this->userDir;
    }

    /**
     * @param string $userDir
     * @return Policy
     */
    public function setUserDir($userDir)
    {
        $this->userDir = $userDir;
        return $this;
    }

    /**
     * @return int
     */
    public function getExpireTime()
    {
        return $this->expireTime;
    }

    /**
     * @param int $expireTime
     * @return Policy
     */
    public function setExpireTime($expireTime)
    {
        $this->expireTime = $expireTime;
        return $this;
    }

    /**
     * @return int
     */
    public function getExpireAt()
    {
        return $this->expireAt;
    }

    /**
     * @param int $expireAt
     * @return Policy
     */
    public function setExpireAt(int $expireAt)
    {
        $this->expireAt = $expireAt;
        return $this;
    }

    /**
     * @return int
     */
    public function getMaxSize()
    {
        return $this->maxSize;
    }

    /**
     * @param int $maxSize
     * @return Policy
     */
    public function setMaxSize($maxSize)
    {
        $this->maxSize = $maxSize;
        return $this;
    }

    /**
     * @param int $time
     * @return string
     */
    protected function gmtIso8601($time)
    {
        return str_replace('+00:00', '.000Z', gmdate('c', $time));
    }

    /**
     * @return array
     */
    public function toArray()
    {
        if (!$this->expireAt && $this->expireTime) {
            $this->expireAt = time() + $this->expireTime;
        }
        if ($this->expireAt) {
            $this->policy['expiration'] = $this->gmtIso8601($this->expireAt);
        }
        if ($this->maxSize) {
            $this->policy['conditions'][] = ['content-length-range', 0, $this->maxSize];
        }
        if ($this->userDir) {
            $this->policy['conditions'][] = ['starts-with', '$key', $this->userDir];
        }
        return $this->policy;
    }
}
