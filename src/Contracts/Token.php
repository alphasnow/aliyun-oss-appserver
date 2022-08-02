<?php

namespace AlphaSnow\OSS\AppServer\Contracts;

interface Token
{
    /**
     * @return Parameter
     */
    public function policy();

    /**
     * @return Parameter
     */
    public function callback();

    /**
     * @return Parameter
     */
    public function access();

    /**
     * @return Parameter
     */
    public function response();
}
