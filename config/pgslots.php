<?php
// PGSlots

return [
    'Name'             => 'SweetBonanzaSlots-EU',//测试
//    'Name'             => 'WINNERRUMMY',//正式
    'OperatorToken'    => 'b1d90cf590f16cf7500f4658610e5a7d', // 运营商独有的身份识别
//    'OperatorToken'    => '1E4FC7BC-FF5A-2388-DD2F-9839C677A949', // 运营商独有的身份识别
    'SecretKey'        => '3a2600c44566655c9eea40d8c53a4ef9', // 密码
//    'SecretKey'        => 'EB179419ACFC9FE1855445D4765513E6', // 密码
    'Salt'             => '6924e18f0510f939c9205b1b6002bafb',//测试
//    'Salt'             => 'D81517939AE89C1E2150466C7CB5D30D',//正式
    'BackOfficeURL'    => 'https://www.pg-bo.me/#/login?code=winnerrummy',//测试
//    'BackOfficeURL'    => 'https://www.pg-bo.net/#/login?code=WINNERRUMMY',//正式

    'Username'         => 'winnerrummy',//测试
    'Password'         => 'g1{Jb1>M',

//    'Username'         => 'winnerrummy',//正式
//    'Password'         => 'RW3@g2t}',
    // 币种
    'currency'         => 'BRL',

    // 交易类型
    'cash_type'        => [
        'in'  => ['value' => 1, 'title' => '充值'],
        'out' => ['value' => 2, 'title' => '转出'],
    ],

    //请求头
    'herder' => ["Content-Type: application/x-www-form-urlencoded"],

    // 验证ip地址
    'check_ip'         => false,
    'check_ip_address' => '127.0.0.1', // TODO::正式环境需要更换地址

    // 进入PG游戏地址 TODO::正式环境需要更换地址 第一个%s=game_id ot = OperatorToken; ops = 用户标识;
    'entry_address' =>'https://m.pg-redirect.net/%s/index.html?ot=%s&ops=%s&btt=1&l=pt&f=closewebview' ,
//    'entry_address' => 'https://m.pgr-nmga.com/%s/index.html?ot=%s&ops=%s&btt=1&l=pt&f=closewebview',
    // 接口请求地址 TODO::正式环境需要更换地址
    'api_url' => 'https://api.pg-bo.me/external',
//    'api_url' => 'https://api.pg-bo.co/external',



    'history_url' => "https://api.pg-bo.me/external-datagrabber",  //测试
//    'history_url' => "https://api.pg-bo.co/external-datagrabber",  //正式
];



