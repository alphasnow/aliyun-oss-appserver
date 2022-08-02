<?php

namespace AlphaSnow\OSS\AppServer\Laravel;

use AlphaSnow\OSS\AppServer\Contracts\Callback;
use AlphaSnow\OSS\AppServer\Contracts\SimpleCallback;
use Carbon\Carbon;
use Illuminate\Contracts\Cache\Factory as Cache;

class CacheCallback implements SimpleCallback
{
    const KEY_PUBLIC = "oss-app-server:public-key";

    /**
     * @var RequestCallback
     */
    protected $laravelCallback;

    /**
     * @var Cache
     */
    protected $cache;

    /**
     * @param RequestCallback $laravelCallback
     * @param Cache $cache
     */
    public function __construct(RequestCallback $laravelCallback, Cache $cache)
    {
        $this->laravelCallback = $laravelCallback;
        $this->cache = $cache;
    }

    /**
     * @return bool
     */
    public function verify()
    {
        $pubKey = $this->laravelCallback->getRequest()->server(Callback::KEY_PUB);
        $cacheKey = self::KEY_PUBLIC.":".$pubKey;
        $publicKey = $this->cache->store()->get($cacheKey);
        if (!$publicKey) {
            $publicKey = $this->laravelCallback->getCallback()->parsePublicKey(Callback::KEY_PUB);
            if (!$publicKey) {
                return false;
            }
            $this->cache->store()->put($cacheKey, $publicKey, Carbon::now()->addHour());
        }
        $this->laravelCallback->getCallback()->setPublicKey($publicKey);

        return $this->laravelCallback->verify();
    }
}
