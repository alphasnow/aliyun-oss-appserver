<?php

namespace AlphaSnow\OSS\AppServer\Tests;

use AlphaSnow\OSS\AppServer\Factory;
use AlphaSnow\OSS\AppServer\Token;

class TokenTest extends TestCase
{
    public function testAppTokenResponse()
    {
        /**
         * @var Token $token
         */
        $token = $this->app->make(Token::class);
        $token->policy()->setExpireAt(1647851236);
        $response = $token->response();

        $this->assertSame("P2qcKX8/CKiCzEiDh6CE02HoTRk=", $response["signature"]);
    }

    public function testFactoryTokenResponse()
    {
        /**
         * @var Token $token
         */
        $token = (new Factory())->makeToken(config("oss-appserver"));
        $token->policy()->setExpireAt(1647851236);
        $response = $token->response();

        $this->assertSame("P2qcKX8/CKiCzEiDh6CE02HoTRk=", $response["signature"]);
    }

    public function testTokenSetter()
    {
        /**
         * @var Token $token
         */
        $token = (new Factory())->makeToken(config("oss-appserver"));

        $token->access()->setOssHost("https://wx-static.oss-cn-hangzhou.aliyuncs.com");
        $this->assertSame("https://wx-static.oss-cn-hangzhou.aliyuncs.com", $token->access()->getOssHost());

        $token->callback()->setCallbackUrl("http://domain.com/notify")
            ->setCallbackBody("{\"filename\":\"\${object}\",\"size\":\${size},\"mimeType\":\"\${mimeType}\"}")
            ->setCallbackBodyType("application/json");
        $this->assertSame("http://domain.com/notify", $token->callback()->getCallbackUrl());
        $this->assertSame("{\"filename\":\"\${object}\",\"size\":\${size},\"mimeType\":\"\${mimeType}\"}", $token->callback()->getCallbackBody());
        $this->assertSame("application/json", $token->callback()->getCallbackBodyType());

        $token->policy()->setExpireAt(1647851000)
            ->setUserDir("users/")
            ->setMaxSize(500 * 1024 * 1024);
        $this->assertSame(1647851000, $token->policy()->getExpireAt());
        $this->assertSame("users/", $token->policy()->getUserDir());
        $this->assertSame(500 * 1024 * 1024, $token->policy()->getMaxSize());
    }
}
