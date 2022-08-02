<?php

namespace AlphaSnow\OSS\AppServer\Laravel;

use AlphaSnow\OSS\AppServer\Entities\Callback;
use AlphaSnow\OSS\AppServer\Entities\AccessKey;
use AlphaSnow\OSS\AppServer\Entities\Policy;
use AlphaSnow\OSS\AppServer\Factory;
use Illuminate\Support\ServiceProvider as BaseServiceProvider;

class ServiceProvider extends BaseServiceProvider
{
    public function register()
    {
        $source = realpath(__DIR__ . "/../../config/config.php");
        if ($this->app->runningInConsole()) {
            $this->publishes([$source => \config_path("oss-appserver.php")], "oss-appserver");
        }
        $this->mergeConfigFrom($source, "oss-appserver");

        $this->app->bind(AccessKey::class, function ($app) {
            $config = $app->make("config")->get("oss-appserver");
            return (new Factory($config))->makeAccessKey();
        });
        $this->app->bind(Policy::class, function ($app) {
            $config = $app->make("config")->get("oss-appserver");
            return (new Factory($config))->makePolicy();
        });
        $this->app->bind(Callback::class, function ($app) {
            $config = $app->make("config")->get("oss-appserver");
            return (new Factory($config))->makeCallback();
        });
    }
}
