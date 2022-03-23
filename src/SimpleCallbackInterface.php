<?php

namespace AlphaSnow\OSS\AppServer;

interface SimpleCallbackInterface
{
    /**
     * @return bool
     */
    public function verifyByRequest();
}
