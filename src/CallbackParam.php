<?php

namespace AlphaSnow\OSS\AppServer;

class CallbackParam implements ArrayEntity
{
    /**
     * @var string
     */
    protected $callbackUrl;

    /**
     * @var string
     */
    protected $callbackBody = "filename=\${object}&size=\${size}&mimeType=\${mimeType}&height=\${imageInfo.height}&width=\${imageInfo.width}";

    /**
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
     * @return CallbackParam
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
     * @return CallbackParam
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
     * @return CallbackParam
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
