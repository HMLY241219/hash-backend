<?php
// 示例配置文件
return [

    # 连接信息
    'AMQP' => [
        'host' => '127.0.0.1',   //连接rabbitmq,此为安装rabbitmq服务器
        'port'=>'5672',
        'login'=>'admin',
        'password'=>'123456',
        'vhost'=>'/'
    ],
    # 队列
    'direct_queue' => [
        'exchange_name' => 'direct_exchange',
        'exchange_type'=>'direct',#直连模式
        'queue_name' => 'direct_queue',
        'route_key' => 'direct_roteking',
        'consumer_tag' => 'direct'
    ],

    # 玩三方游戏记录队列
    'slots_queue' => [
        'exchange_name' => 'slots_exchange',
        'exchange_type'=>'direct',#直连模式
        'queue_name' => 'slots_queue',
        'route_key' => 'slots_roteking',
        'consumer_tag' => 'slots'
    ]
];