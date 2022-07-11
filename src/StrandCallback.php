<?php

namespace AlphaSnow\OSS\AppServer;

class StrandCallback implements SimpleCallback
{
    /**
     * @var Callback
     */
    protected $callback;

    /**
     * @param Callback $callback
     */
    public function __construct(Callback $callback)
    {
        $this->callback = $callback;
    }

    /**
     * @return bool
     */
    public function verifyByRequest()
    {
        return $this->callback->verify(
            $_SERVER["HTTP_AUTHORIZATION"],
            $_SERVER["HTTP_X_OSS_PUB_KEY_URL"],
            $_SERVER["REQUEST_URI"],
            file_get_contents("php://input")
        );
    }
}
