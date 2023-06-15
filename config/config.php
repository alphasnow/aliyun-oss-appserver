<?php

return [
    "access_key_id" => env("OSS_ACCESS_KEY_ID"), // Required, YourAccessKeyId
    "access_key_secret" => env("OSS_ACCESS_KEY_SECRET"), // Required, YourAccessKeySecret
    "bucket" => env("OSS_BUCKET"), // Required, Bucket
    "endpoint" => env("OSS_ENDPOINT"), // Required, Endpoint
    "use_ssl" => env("OSS_SSL", true),
    "domain" => env("OSS_DOMAIN", ""),
    "callback_url" => env("OSS_CALLBACK_URL", ""),
    "max_size" => env("OSS_POLICY_MAX_SIZE", 1048576000),
    "expire_time" => env("OSS_POLICY_EXPIRE_TIME", 3600),
    "user_dir" => env("OSS_POLICY_USER_DIR", "upload/"),
];
