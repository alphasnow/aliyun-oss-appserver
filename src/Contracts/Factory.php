<?php

namespace AlphaSnow\OSS\AppServer\Contracts;

interface Factory
{
    /**
     * @return Token
     */
    public function makeToken();

    /**
     * @return Parameter
     */
    public function makeAccessKey();

    /**
     * @return Parameter
     */
    public function makePolicy();

    /**
     * @return Parameter
     */
    public function makeCallback();
}
