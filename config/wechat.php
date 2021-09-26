<?php

    /*
     * This file is part of the overtrue/laravel-wechat.
     *
     * (c) overtrue <i@overtrue.me>
     *
     * This source file is subject to the MIT license that is bundled
     * with this source code in the file LICENSE.
     */

    return [
        /*
         * 小程序
         */
        'mini_program' => [
            'default' => [
                'app_id'  => env('WECHAT_MINI_PROGRAM_APPID', ''),
                'secret'  => env('WECHAT_MINI_PROGRAM_SECRET', ''),
                'response_type' => 'array',
                'log' => [
                    'level' => env('WECHAT_LOG_LEVEL', 'debug'),
                    'file' => env('WECHAT_LOG_FILE', storage_path('logs/wechat.log')),
                ],
            ],
        ],
    ];
