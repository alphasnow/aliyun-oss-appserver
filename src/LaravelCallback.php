<?php

namespace AlphaSnow\OSS\AppServer;

use Illuminate\Http\Request;

class LaravelCallback implements SimpleCallbackInterface
{
    /**
     * @var Request
     */
    protected $request;

    /**
     * @var Callback
     */
    protected $callback;

    /**
     * @param Callback $callback
     * @param Request $request
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

    /**
     * @return Callback
     */
    public function getCallback()
    {
        return $this->callback;
    }

    /**
     * @return Request
     */
    public function getRequest()
    {
        return $this->request;
    }
}
