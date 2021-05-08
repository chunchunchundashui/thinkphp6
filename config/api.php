<?php

return [
    //token 过期时间    0 表示永久不过期
    'token_expire' => 0,
    // 阿里云短信
    'aliSMS' => [
        'isopen' => false,  // 开启阿里云 短信
        'accessKeyId' => '',
        'accessSecret' => '',
        'regionId' => 'cn-hangzhou',
        'product' => 'Dysmsapi',
        'version' => '2017-05-25',
        'SignName' => '注册登录',
        'TemplateCode' => 'SMS_214527565',
        // 过期时间
        'expire' => 60
    ],
    // 腾讯短信
    'txSMS' => [
        'secretId' => '',
        'secretKey' => '',
        'TemplateID' =>  '625562',   // 模板id
        'Sign'  =>  '学习测试',   // 签名内容
        'SmsSdkAppid' => '1400379804'   // 应用id
    ]
];
