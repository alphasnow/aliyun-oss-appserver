<?php

namespace AlphaSnow\OSS\AppServer\Tests\Laravel;

use AlphaSnow\OSS\AppServer\Laravel\ServiceProvider;
use Orchestra\Testbench\TestCase as BaseTestCase;

class TestCase extends BaseTestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        config([
            "oss-appserver" => [
                "access_key_id" => "access_key_id",
                "access_key_secret" => "access_key_secret",
                "bucket" => "bucket",
                "endpoint" => "endpoint.com",
                "max_size" => 1048576000,
                "expire_time" => 60,
                "user_dir" => "upload/",
                "callback_url" => "http://domain.com/callback"
            ]
        ]);
    }

    protected function getPackageProviders($app)
    {
        return [ServiceProvider::class];
    }

    protected function getPackageAliases($app)
    {
        return [];
    }
}
