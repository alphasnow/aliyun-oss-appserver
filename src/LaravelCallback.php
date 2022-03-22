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
     * @param Callback $callback
     */
    public function __construct(Callback $callback)
    {
        $this->callback = $callback;
    }

    /**
     * @param Request $request
     * @return bool
     */
    public function verifyByRequest(Request $request)
    {
        return $this->callback->verify(
            $request->server(Callback::KEY_AUTH),
            $request->server(Callback::KEY_PUB),
            $request->server(Callback::KEY_URI),
            $request->getContent()
        );
    }
}
