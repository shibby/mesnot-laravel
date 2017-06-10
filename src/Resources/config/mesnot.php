<?php

return [
    'appId' => config('MESNOT_APPID'),
    'appKey' => config('MESNOT_APPKEY'),
    'user' => [
        'class' => \App\Model\User::class,
        'fields' => [
            'email' => 'email',
            'username' => '',
            'phone' => '',
            'name' => 'name',
        ],
    ],
    'isSandbox' => 0,
];
