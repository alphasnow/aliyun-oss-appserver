<?php

namespace AlphaSnow\OSS\AppServer\Entities;

use AlphaSnow\OSS\AppServer\Contracts\Parameter;

/**
 * @link https://help.aliyun.com/document_detail/31989.html
 */
class Callback implements Parameter
{
    /**
     * It can be a combination of multiple domain names
     * Limit up to five domain names
     * Each domain name is separated by `;`
     * Examples:
     * http://api.domain1.com/storage;http://ai.domain2.com/upload?disk=oss;https://open.domain3.com/oss/callback?bucket=xstorage
     *
     * @var string
     */
    protected $callbackUrl;

    /**
     * Examples:
     * bucket=\${bucket}&etag=\${etag}&format=\${imageInfo.format}&filename=\${object}&size=\${size}&mimeType=\${mimeType}&height=\${imageInfo.height}&width=\${imageInfo.width}
     * {\"bucket\":\${bucket},\"etag\":\${etag},\"format\":\${imageInfo.format},\"filename\":\${object},\"size\":\${size},\"mimeType\":\${mimeType},\"height\":\${imageInfo.height},\"width\":\${imageInfo.width}}
     *
     * @var string
     */
    protected $callbackBody = "bucket=\${bucket}&etag=\${etag}&format=\${imageInfo.format}&filename=\${object}&size=\${size}&mimeType=\${mimeType}&height=\${imageInfo.height}&width=\${imageInfo.width}";

    /**
     * Examples:
     * application/x-www-form-urlencoded
     * application/json
     *
     * @var string
     */
    protected $callbackBodyType = "application/x-www-form-urlencoded";

    /**
     * @param string $callbackUrl
     * @param string $callbackBody
     * @param string $callbackBodyType
     */
    public function __construct($callbackUrl, $callbackBody = null, $callbackBodyType = null)
    {
        $this->callbackUrl = $callbackUrl;
        if (!is_null($callbackBody)) {
            $this->callbackBody = $callbackBody;
        }
        if (!is_null($callbackBodyType)) {
            $this->callbackBodyType = $callbackBodyType;
        }
    }

    /**
     * @return mixed
     */
    public function getCallbackUrl()
    {
        return $this->callbackUrl;
    }

    /**
     * @param string $callbackUrl
     * @return Callback
     */
    public function setCallbackUrl($callbackUrl)
    {
        $this->callbackUrl = $callbackUrl;
        return $this;
    }

    /**
     * @return string
     */
    public function getCallbackBody()
    {
        return $this->callbackBody;
    }

    /**
     * @param string $callbackBody
     * @return Callback
     */
    public function setCallbackBody(string $callbackBody)
    {
        $this->callbackBody = $callbackBody;
        return $this;
    }

    /**
     * @return string
     */
    public function getCallbackBodyType()
    {
        return $this->callbackBodyType;
    }

    /**
     * @param string $callbackBodyType
     * @return Callback
     */
    public function setCallbackBodyType(string $callbackBodyType)
    {
        $this->callbackBodyType = $callbackBodyType;
        return $this;
    }

    /**
     * @return array
     */
    public function toArray()
    {
        return [
            "callbackUrl" => $this->callbackUrl,
            "callbackBody" => $this->callbackBody,
            "callbackBodyType" => $this->callbackBodyType
        ];
    }
}
