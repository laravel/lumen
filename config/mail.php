<?php
/**
 * Descript:
 * Class ${NAME}
 * @author: shao.haizhou
 * @email: shaohaizhou@ksm
 * @Time: 2023/6/18   15:53
 */

return [
    'driver' => env('MAIL_DRIVER'),
    'host' => env('MAIL_HOST'), // 根据你的邮件服务提供商来填
    'port' => env('MAIL_PORT'), // 同上
    'encryption' => env('MAIL_ENCRYPTION'), // 同上 一般是tls或ssl
    'username' => env('MAIL_USERNAME'),
    'password' => env('MAIL_PASSWORD'),
    'from' => [
        'address' => env('MAIL_FROM_ADDRESS', env('MAIL_USERNAME')),
        'name' => env('MAIL_FROM_NAME', env('MAIL_USERNAME')),
    ],
];
