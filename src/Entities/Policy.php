<?php

namespace AlphaSnow\OSS\AppServer\Entities;

use AlphaSnow\OSS\AppServer\Contracts\Parameter;

/**
 * @link https://help.aliyun.com/document_detail/31988.htm#section-d5z-1ww-wdb
 */
class Policy implements Parameter
{
    /**
     * @var array
     */
    protected $policy = [];

    /**
     * policy: conditions.starts-with
     *
     * @var string
     */
    protected $userDir;

    /**
     * Either expireTime or expireAt must be used
     * policy: expiration
     *
     * @var int
     */
    protected $expireTime;

    /**
     * Either expireTime or expireAt must be used
     * policy: expiration
     *
     * @var int
     */
    protected $expireAt;

    /**
     * policy: conditions.content-length-range
     *
     * @var int
     */
    protected $maxSize;

    /**
     * policy: conditions.bucket
     *
     * @var string
     */
    protected $bucket;

    /**
     * @param array $conditions
     * @param string $expiration
     */
    public function __construct($conditions = [], $expiration = null)
    {
        if (!empty($conditions)) {
            $this->policy["conditions"] = $conditions;
        }
        if (!is_null($expiration)) {
            $this->policy["expiration"] = $expiration;
        }
    }

    /**
     * Examples:
     * ["eq", "$success_action_status", "201"]
     * ["in", "$content-type", ["image/jpg", "image/png"]]
     * ["not-in", "$cache-control", ["no-cache"]]
     *
     * @param string $rule
     * @param string $field
     * @param mixed $value
     * @return $this
     */
    public function setConditions($rule, $field, $value)
    {
        $this->policy["conditions"][] = [$rule,$field,$value];
        return $this;
    }

    /**
     * @return array
     */
    public function getConditions()
    {
        return $this->policy["conditions"] ?? [];
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
    public function setExpireAt($expireAt)
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
     * @return string
     */
    public function getBucket()
    {
        return $this->bucket;
    }

    /**
     * @param string $bucket
     * @return Policy
     */
    public function setBucket($bucket)
    {
        $this->bucket = $bucket;
        return $this;
    }

    /**
     * @param int $time
     * @return string
     */
    protected function gmtIso8601($time)
    {
        return str_replace("+00:00", ".000Z", gmdate("c", $time));
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
            $this->policy["expiration"] = $this->gmtIso8601($this->expireAt);
        }
        if ($this->bucket) {
            $this->policy["conditions"][] = ["bucket" => $this->bucket];
        }
        if ($this->maxSize) {
            $this->policy["conditions"][] = ["content-length-range", 0, intval($this->maxSize)];
        }
        if ($this->userDir) {
            $this->policy["conditions"][] = ["starts-with", "\$key", $this->userDir];
        }
        return $this->policy;
    }
}
