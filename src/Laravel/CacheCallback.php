<?php

namespace AlphaSnow\OSS\AppServer\Laravel;

use AlphaSnow\OSS\AppServer\Contracts\Callback;
use AlphaSnow\OSS\AppServer\Contracts\SimpleCallback;
use Illuminate\Contracts\Cache\Factory as Cache;
use Carbon\Carbon;

class CacheCallback implements SimpleCallback
{
    const KEY_PUBLIC = "oss-server:public-key";

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
            $publicKeyUrl = base64_decode($pubKey);
            $publicKey = $this->laravelCallback->getCallback()->parsePublicKey($publicKeyUrl);
            if (!$publicKey) {
                return false;
            }
            $this->cache->store()->put($cacheKey, $publicKey, Carbon::now()->addHour());
        }
        $this->laravelCallback->getCallback()->setPublicKey($publicKey);

        return $this->laravelCallback->verify();
    }
}
