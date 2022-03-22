<?php

namespace AlphaSnow\OSS\AppServer\Tests;

use AlphaSnow\OSS\AppServer\AppServer;
use AlphaSnow\OSS\AppServer\Token;

class TokenTest extends TestCase
{
    public function testMake()
    {
        /**
         * @var Token $token
         */
        $token = $this->app->make(Token::class);
        $token->policy()->setExpireAt(1647851236);
        $response = $token->response();

        $this->assertSame("P2qcKX8/CKiCzEiDh6CE02HoTRk=", $response['signature']);
    }

    public function testServer()
    {
        /**
         * @var Token $token
         */
        $token = (new AppServer())->makeToken(config("oss-appserver"));
        $token->policy()->setExpireAt(1647851236);
        $response = $token->response();

        $this->assertSame("P2qcKX8/CKiCzEiDh6CE02HoTRk=", $response['signature']);
    }

    public function testSet()
    {
        /**
         * @var Token $token
         */
        $token = $this->app->make(Token::class);

        $token->callback()->setCallbackUrl("http://domain.com/notify");
        $this->assertSame("http://domain.com/notify", $token->callback()->getCallbackUrl());

        $token->policy()->setExpireAt(1647851000)->setUserDir("users/")->setMaxSize(500 * 1024 * 1024);
        $this->assertSame(1647851000, $token->policy()->getExpireAt());
        $this->assertSame("users/", $token->policy()->getUserDir());
        $this->assertSame(500 * 1024 * 1024, $token->policy()->getMaxSize());

        $token->access()->setOssHost("https://wx-static.oss-cn-hangzhou.aliyuncs.com");
        $this->assertSame("https://wx-static.oss-cn-hangzhou.aliyuncs.com", $token->access()->getOssHost());
    }
}
