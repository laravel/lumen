<?php
/**
 * Descript:
 * Class ${NAME}
 * @author: shao.haizhou
 * @email: shaohaizhou@ksm
 * @Time: 2023/6/19   11:58
 */

return [
    "default" => env("FILESYSTEM_DRIVER", "oss"),
    "disks"=>[
        "oss" => [
            "driver" => "oss",
            "access_key_id" => env("OSS_ACCESS_KEY_ID"),           // Required, YourAccessKeyId
            "access_key_secret" => env("OSS_ACCESS_KEY_SECRET"),       // Required, YourAccessKeySecret
            "bucket" => env("OSS_BUCKET"),                  // Required, For example: my-bucket
            "endpoint" => env("OSS_ENDPOINT"),                // Required, For example: oss-cn-shanghai.aliyuncs.com
            "internal" => env("OSS_INTERNAL", null),          // Optional, For example: oss-cn-shanghai-internal.aliyuncs.com
            "domain" => env("OSS_DOMAIN", null),            // Optional, For example: oss.my-domain.com
            "prefix" => env("OSS_PREFIX", ""),              // Optional, The prefix of the store path
            "use_ssl"  => env("OSS_SSL", false),              // Optional, Whether to use HTTPS
            "reverse_proxy" => env("OSS_REVERSE_PROXY", false),    // Optional, Whether to use the Reverse proxy, such as nginx
            "throw" => env("OSS_THROW", false),            // Optional, Whether to throw an exception that causes an error
            "options"  => [],                                 // Optional, Add global configuration parameters, For example: [\OSS\OssClient::OSS_CHECK_MD5 => false]
            "macros"  => []                                  // Optional, Add custom Macro, For example: [\App\Macros\ListBuckets::class, \App\Macros\CreateBucket::class]
        ],
    ]
];
