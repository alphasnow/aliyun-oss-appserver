<?php

namespace AlphaSnow\OSS\AppServer\Tests;

use AlphaSnow\OSS\AppServer\Factory;
use AlphaSnow\OSS\AppServer\Token;
use PHPUnit\Framework\TestCase;

class TokenTest extends TestCase
{
    public function testResponse()
    {
        $config = [
            "access_key_id" => "access_key_id",
            "access_key_secret" => "access_key_secret",
            "bucket" => "bucket",
            "endpoint" => "endpoint.com",
            "max_size" => 1048576000,
            "expire_time" => 60,
            "user_dir" => "upload/",
            "callback_url" => "http://domain.com/callback"
        ];
        /**
         * @var Token $token
         */
        $token = (new Factory($config))->makeToken();
        $token->policy()->setExpireAt(1647851236);
        $response = $token->response();

        $this->assertSame("yBiYmA7ExfIlWuuqLzbt4rkj24w=", $response->getSignature());
    }

    public function testSetter()
    {
        $config = [
            "access_key_id" => "access_key_id",
            "access_key_secret" => "access_key_secret",
            "bucket" => "bucket",
            "endpoint" => "endpoint.com",
            "max_size" => 1048576000,
            "expire_time" => 60,
            "user_dir" => "upload/",
            "callback_url" => "http://domain.com/callback"
        ];
        /**
         * @var Token $token
         */
        $token = (new Factory($config))->makeToken();

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
