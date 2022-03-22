<?php

namespace AlphaSnow\OSS\AppServer;

use Illuminate\Http\Request;

class LaravelCallback
{
    /**
     * @var Callback
     */
    protected $callback;

    /**
     * @var Request
     */
    protected $request;

    /**
     * @param Callback $callback
     */
    public function __construct(Callback $callback, Request $request)
    {
        $this->callback = $callback;
        $this->request = $request;
    }

    /**
     * @return bool
     */
    public function verifyByRequest()
    {
        return $this->callback->verify(
            $this->request->server(Callback::KEY_AUTH),
            $this->request->server(Callback::KEY_PUB),
            $this->request->server(Callback::KEY_URI),
            $this->request->getContent()
        );
    }
}
