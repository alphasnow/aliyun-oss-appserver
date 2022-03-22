<?php

namespace AlphaSnow\OSS\AppServer\Tests;

use AlphaSnow\OSS\AppServer\Callback;

class CallbackTest extends TestCase
{
    public function testFeature()
    {
        $pub = realpath(__DIR__.'/stubs/public.pem');
        $pri = realpath(__DIR__.'/stubs/private.pem');

        $callback = \Mockery::mock(Callback::class)
            ->makePartial()
            ->shouldAllowMockingProtectedMethods();
        $callback->shouldReceive("getPublicKey")
            ->andReturn(file_get_contents($pub));

        $body = "filename=upload%2Ffile.zip&size=157&mimeType=application%2Fx-zip-compressed&height=&width=";
        $uri = "/tests/callback.php";
        $pubKey = "aHR0cHM6Ly9nb3NzcHVibGljLmFsaWNkbi5jb20vY2FsbGJhY2tfcHViX2tleV92MS5wZW0=";
        $auth = "adK5wEx8Xko1k+PLK7X9AdNeBrERezJc+dIDs/cbI7a1Qj6T79maIO1VsSRmgiIH3LY+MG/N62lfaDSBq3ylN+yJyyXeletN/j/o+lg/j/m/6ghAUzbTBPniuxByWGvCE9pYgn5hKYDV6JhqF/y+8p87JsndAZULK9jdgjloOEw=";

        $status = $callback->verify($auth, $pubKey, $uri, $body);
        $this->assertTrue($status);
    }
}
