<?php

namespace AlphaSnow\OSS\AppServer;

interface SimpleCallback
{
    /**
     * @return bool
     */
    public function verifyByRequest();
}
