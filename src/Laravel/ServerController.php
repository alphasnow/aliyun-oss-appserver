<?php

namespace AlphaSnow\OSS\AppServer\Laravel;

use AlphaSnow\OSS\AppServer\Token;

/**
 * Directly transfer data
 */
class ServerController
{
    /**
     * Request authorization
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function token()
    {
        $token = app(Token::class);
        // Dynamic configuration based on requirements
        // $token->callback()->setCallbackUrl(url("api/app-server/callback"));
        return response()->json($token->response()->toArray());
    }

    /**
     * Deal with the callback
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function callback()
    {
        $status = app(CacheCallback::class)->verify();
        if ($status == false) {
            return response()->json(["status" => "fail"], 403);
        }
        // Default callback parameters: filename, size, mimeType, height, width
        // $filename = request()->post("filename");
        return response()->json(["status" => "ok"]);
    }
}
