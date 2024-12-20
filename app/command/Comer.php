<?php
declare (strict_types = 1);

namespace app\command;

use crmeb\services\MqConsumer;
use think\console\Command;
use think\console\Input;
use think\console\input\Argument;
use think\console\input\Option;
use think\console\Output;

class Comer extends Command
{
    protected function configure()
    {
        // 指令配置
        $this->setName('Comer')
            ->addArgument('status', Argument::REQUIRED, 'start/stop/reload/status/connections')
            ->addArgument('server',  Argument::OPTIONAL, 'admin/chat/channel')
            ->addOption('d', null, Option::VALUE_NONE, 'daemon（守护进程）方式启动')
            ->setDescription('the Comer command');
    }

    protected function init(Input $input, Output $output)
    {
        global $argv;
        $argv[1] = $input->getArgument('status') ?: 'start';
        $server = $input->getArgument('server');
        if ($input->hasOption('d')) {
            $argv[2] = '-d';
        } else {
            unset($argv[2]);
        }

        //$this->config = config('workerman');

        return $server;
    }

    protected function execute(Input $input, Output $output)
    {
        $server = $this->init($input, $output);
        if (!$server || $server == 'slots'){
            var_dump($server);
            $amqpDetail = config('rabbitmq.slots_queue');
            $consumer = new MqConsumer(); //消费者
            $consumer->start($amqpDetail);
        }
        // 指令输出
        //$output->writeln('Comer');
        /*$amqpDetail = config('rabbitmq.direct_queue');
        $consumer = new MqConsumer(); //消费者
        $consumer->start($amqpDetail);  //启动*/
    }
}
