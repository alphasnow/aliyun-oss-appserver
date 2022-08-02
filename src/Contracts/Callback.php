<?php

namespace AlphaSnow\OSS\AppServer\Contracts;

interface Callback
{
    const KEY_AUTH = "HTTP_AUTHORIZATION";
    const KEY_PUB = "HTTP_X_OSS_PUB_KEY_URL";
    const KEY_URI = "REQUEST_URI";

    /**
     * @param string $authorization $_SERVER["HTTP_AUTHORIZATION"]
     * @param string $pubKeyUrl $_SERVER["HTTP_X_OSS_PUB_KEY_URL"]
     * @param string $requestUri $_SERVER["REQUEST_URI"]
     * @param string $requestBody file_get_contents("php://input")
     * @return bool
     */
    public function verify($authorization, $pubKeyUrl, $requestUri, $requestBody);

    /**
     * @param string $pubKeyUrl
     * @return string
     */
    public function parsePublicKey($pubKeyUrl);

    /**
     * @param string $pubKey
     * @return Callback
     */
    public function setPublicKey($pubKey);
}