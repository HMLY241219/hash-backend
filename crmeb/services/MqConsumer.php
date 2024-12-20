<?php

namespace crmeb\services;

use PhpAmqpLib\Connection\AMQPStreamConnection;
use think\facade\Log;

class MqConsumer
{
    protected $queue_name;

    /**
     * 消费端 消费端需要保持运行状态实现方式
     * 1 linux上写定时任务每隔5分钟运行下该脚本，保证访问服务器的ip比较平缓，不至于崩溃
     * 2 nohup php index.php index/Message_Consume/start &  用nohup命令后台运行该脚本
     * 3
     **/
    function shutdown($channel, $connection)
    {
        $channel->close();
        $connection->close();
        //Log::write("closed",3);
        Log::write("closed");
    }

    //消息处理
    function process_message($message)
    {

        //休眠两秒
        //sleep(2);
        echo  $message->body."\n";
        //echo $this->queue_name;
        $queue_name = $this->queue_name;
        //自定义日志为rabbitmq-consumer
        //Log::write($message->body,'rabbitmq-consumer');
        Log::write($message->body);

        if ($queue_name == 'slots_queue'){ //三方游戏记录后续操作
            $res = MqDealWith::SlotsLogDealWith($message->body);
            if(!$res){ //失败以后重新推送，之后的代码不再执行
                $message->delivery_info['channel']->basic_reject($message->delivery_info['delivery_tag'], true);
                return;
            }
        }

        if ($this->queue_name == 'test'){

        }

        //手动发送ack
        $message->delivery_info['channel']->basic_ack($message->delivery_info['delivery_tag']);
        // Send a message with the string "quit" to cancel the consumer.
        if ($message->body === 'quit') {
            $message->delivery_info['channel']->basic_cancel($message->delivery_info['consumer_tag']);
        }
    }

    /**
     * 启动
     * @return \think\Response
     */
    public function start($amqpDetail)
    {
        Log::write('start111');
        $param = config('rabbitmq.AMQP');
        //$amqpDetail = config('rabbitmq.direct_queue');
        $connection = new AMQPStreamConnection(
            $param['host'],
            $param['port'],
            $param['login'],
            $param['password'],
            $param['vhost']
        );

        /*
         * 创建通道
         */
        $channel = $connection->channel();
        /*
         * 设置消费者（Consumer）客户端同时只处理一条队列
         * 这样是告诉RabbitMQ，再同一时刻，不要发送超过1条消息给一个消费者（Consumer），
         * 直到它已经处理了上一条消息并且作出了响应。这样，RabbitMQ就会把消息分发给下一个空闲的消费者（Consumer）。
         */
        $channel->basic_qos(0, 1, false);
        /*
         * 同样是创建路由和队列，以及绑定路由队列，注意要跟publisher的一致
         * 这里其实可以不用，但是为了防止队列没有被创建所以做的容错处理
         */
        $channel->queue_declare($amqpDetail['queue_name'], false, true, false, false);

        $channel->exchange_declare($amqpDetail['exchange_name'], $amqpDetail['exchange_type'], false, true, false);

        $channel->queue_bind($amqpDetail['queue_name'], $amqpDetail['exchange_name'],$amqpDetail['route_key']);

        /*
            queue: 从哪里获取消息的队列
            consumer_tag: 消费者标识符,用于区分多个客户端
            no_local: 不接收此使用者发布的消息
            no_ack: 设置为true，则使用者将使用自动确认模式。详情请参见.
                        自动ACK：消息一旦被接收，消费者自动发送ACK
                        手动ACK：消息接收后，不会发送ACK，需要手动调用
            exclusive:是否排他，即这个队列只能由一个消费者消费。适用于任务不允许进行并发处理的情况下
            nowait: 不返回执行结果，但是如果排他开启的话，则必须需要等待结果的，如果两个一起开就会报错
            callback: :回调逻辑处理函数,PHP回调 array($this, 'process_message') 调用本对象的process_message方法
        */
        $this->queue_name = $amqpDetail['queue_name'];
        $channel->basic_consume($amqpDetail['queue_name'], $amqpDetail['consumer_tag'], false, false, false, false, array($this, 'process_message'));

        register_shutdown_function(array($this, 'shutdown'), $channel, $connection);
        // 阻塞队列监听事件
        while (count($channel->callbacks)) {
            $channel->wait();
        }
        Log::write('end333');
    }
}