<?php

namespace AlphaSnow\OSS\AppServer;

class Callback
{
    const KEY_AUTH = "HTTP_AUTHORIZATION";
    const KEY_PUB = "HTTP_X_OSS_PUB_KEY_URL";
    const KEY_URI = "REQUEST_URI";

    /**
     * @param string $authorizationBase64 $_SERVER['HTTP_AUTHORIZATION']
     * @param string $pubKeyUrlBase64 $_SERVER['HTTP_X_OSS_PUB_KEY_URL']
     * @param string $requestUri $_SERVER['REQUEST_URI']
     * @param string $requestBody file_get_contents('php://input')
     * @return bool
     */
    public function verify($authorizationBase64, $pubKeyUrlBase64, $requestUri, $requestBody)
    {
        $authorization = base64_decode($authorizationBase64);
        $pubKeyUrl = base64_decode($pubKeyUrlBase64);
        if (!$authorization || !$pubKeyUrl) {
            return false;
        }

        // cache key ?
        $pubKey = $this->getPublicKey($pubKeyUrl);
        if (!$pubKey) {
            return false;
        }

        $authStr = $this->buildAuthStr($requestUri, $requestBody);
        $ok = openssl_verify($authStr, $authorization, $pubKey, OPENSSL_ALGO_MD5);
        return $ok == 1;
    }

    /**
     * @param string $pubKeyUrl
     * @return bool|string
     */
    protected function getPublicKey($pubKeyUrl)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $pubKeyUrl);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
        $pubKey = curl_exec($ch);
        return $pubKey;
    }

    /**
     * @param string $requestUri
     * @param string $requestBody
     * @return string
     */
    protected function buildAuthStr($requestUri, $requestBody)
    {
        $authStr = '';
        $pos = strpos($requestUri, '?');
        if ($pos === false) {
            $authStr .= urldecode($requestUri)."\n".$requestBody;
        } else {
            $authStr .= urldecode(substr($requestUri, 0, $pos)).substr($requestUri, $pos, strlen($requestUri) - $pos)."\n".$requestBody;
        }
        return $authStr;
    }
}
