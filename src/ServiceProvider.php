<?php

namespace AlphaSnow\OSS\AppServer;

use Illuminate\Support\ServiceProvider as BaseServiceProvider;

class ServiceProvider extends BaseServiceProvider
{
    public function register()
    {
        $source = realpath(__DIR__.'/../config/config.php');
        if ($this->app->runningInConsole()) {
            $this->publishes([$source => \config_path('oss-appserver.php')], 'oss-appserver');
        }
        $this->mergeConfigFrom($source, 'oss-appserver');

        $appServer = new Factory();
        $this->app->bind(AccessKey::class, function ($app) use ($appServer) {
            $config = $app->make('config')->get('oss-appserver');
            return $appServer->makeAccessKey($config);
        });
        $this->app->bind(Policy::class, function ($app) use ($appServer) {
            $config = $app->make('config')->get('oss-appserver');
            return $appServer->makePolicy($config);
        });
        $this->app->bind(CallbackParam::class, function ($app) use ($appServer) {
            $config = $app->make('config')->get('oss-appserver');
            return $appServer->makeCallbackParam($config);
        });
    }
}
