<?php
/*
 * @Description:
 * @Author: LMG
 * @Date: 2019-12-28 22:17:29
 * @LastEditors  : LMG
 * @LastEditTime : 2019-12-28 22:25:42
 */

return [
    'allow-credentials'  => env('CORS_ALLOW_CREDENTIAILS', false), // set "Access-Control-Allow-Credentials" 👉 string "false" or "true".
    'allow-headers'      => ['*'], // ex: Content-Type, Accept, X-Requested-With
    'expose-headers'     => ['Authorization'], //列出了哪些首部可以作为响应的一部分暴露给外部。默认为 [] 。
    'origins'            => ['*'], // ex: http://localhost
    'methods'            => ['*'], // ex: GET, POST, PUT, PATCH, DELETE
    'max-age'            => env('CORS_ACCESS_CONTROL_MAX_AGE', 0),
    'laravel'            => [
        'allow-route-prefix' => env('CORS_LARAVEL_ALLOW_ROUTE_PREFIX', '*'), // The prefix is using \Illumante\Http\Request::is method. 👉
        'route-group-mode'   => env('CORS_LARAVEL_ROUTE_GROUP_MODE', false),
    ],
];