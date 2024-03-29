<?php

namespace AlphaSnow\OSS\AppServer\Tests\Laravel;

use AlphaSnow\OSS\AppServer\Token;

class TokenTest extends TestCase
{
    public function testResponse()
    {
        /**
         * @var Token $token
         */
        $token = $this->app->make(Token::class);
        $token->policy()->setExpireAt(1647851236);
        $response = $token->response();

        $this->assertSame("yBiYmA7ExfIlWuuqLzbt4rkj24w=", $response->getSignature());
    }
}
