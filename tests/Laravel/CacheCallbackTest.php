<?php

namespace AlphaSnow\OSS\AppServer\Tests\Laravel;

use AlphaSnow\OSS\AppServer\Callback;
use AlphaSnow\OSS\AppServer\Contracts\Callback as CallbackContract;
use AlphaSnow\OSS\AppServer\Laravel\CacheCallback;
use AlphaSnow\OSS\AppServer\Laravel\RequestCallback;
use Illuminate\Http\Request;
use Mockery\MockInterface;

class CacheCallbackTest extends TestCase
{
    public function callbackProvider()
    {
        $pub = realpath(__DIR__."/../stubs/public.pem");
        $pri = realpath(__DIR__."/../stubs/private.pem");

        $callback = \Mockery::mock(Callback::class)
            ->makePartial()
            ->shouldAllowMockingProtectedMethods();
        $callback->shouldReceive("downloadPublicKey")
            ->andReturn(file_get_contents($pub));
        return [
            [$callback]
        ];
    }

    /**
     * @dataProvider callbackProvider
     * @param Callback|MockInterface $callback
     */
    public function testVerify($callback)
    {
        $this->app->when(RequestCallback::class)
            ->needs(CallbackContract::class)
            ->give(function () use ($callback) {
                return $callback;
            });
        $body = "filename=upload%2Ffile.zip&size=157&mimeType=application%2Fx-zip-compressed&height=&width=";
        $request = new Request([], [], [], [], [], [
            "HTTP_AUTHORIZATION" => "adK5wEx8Xko1k+PLK7X9AdNeBrERezJc+dIDs/cbI7a1Qj6T79maIO1VsSRmgiIH3LY+MG/N62lfaDSBq3ylN+yJyyXeletN/j/o+lg/j/m/6ghAUzbTBPniuxByWGvCE9pYgn5hKYDV6JhqF/y+8p87JsndAZULK9jdgjloOEw=",
            "HTTP_X_OSS_PUB_KEY_URL" => "aHR0cHM6Ly9nb3NzcHVibGljLmFsaWNkbi5jb20vY2FsbGJhY2tfcHViX2tleV92MS5wZW0=",
            "REQUEST_URI" => "/tests/callback.php",
        ], $body);
        $this->app->instance(Request::class, $request);

        $callback = $this->app->make(CacheCallback::class);

        $status = $callback->verify();
        $this->assertTrue($status);
    }
}
