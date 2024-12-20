<?php

namespace app\api\controller;

use app\Request;
use crmeb\basic\BaseController;
use customlibrary\Common;
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;
use service\NewjsonService;
use think\facade\Db;
use think\facade\Env;
use think\facade\Log;
use think\facade\Validate;
use crmeb\services\MqProducer;
use crmeb\services\MqConsumer;


/**
 * 首页
 */
class Home extends BaseController
{

    /**
     * 用户信息
     * @param Request $request
     * @return null
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function userinfo(Request $request){
        $uid = $request->uid;

        $userinfo = Db::name('userinfo')->where('uid',$uid)->field('coin,bonus')->find();
        return ReturnJson::successFul(200,$userinfo);
    }

    /**
     * 轮播
     * @param Request $request
     * @return null
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function banner(Request $request){
        //$packname = $request->header('packname');
        //$param = $this->param;

        $list = Db::name('banner')->where(['type'=>1,'status'=>1])->field('title,image,url_type,url')->select()->toArray();
        if (!empty($list)){
            foreach ($list as $key=>$value){
                $list[$key]['image'] = Common::domain_name_path($value['image']);
            }
        }
        return ReturnJson::successFul(200,$list,1);
    }

    /**
     * 公告
     * @return null
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function notice(Request $request){
        $param = $request->param();
        $validate = Validate::rule([
            'type' => 'require|in:1,2', //1移动端  2-pc端
        ]);
        if (!$validate->check($param)) {
            Log::record("公共接口数据验证失败===>".$validate->getError());
            return ReturnJson::failFul(219);
        }

        $list = Db::name('notice')->where(['status'=>1,'type'=>$param['type'],'delete_time'=>0])->field('title,content')->select()->toArray();
        $data = [];
        $data['notice'] = $list;
        $data['marquee'] = [
            '1*****09 acabou de retirar 10000.0 BRL',
            '5*****07 acabou de retirar 8000.0 BRL',
            '6*****88 acabou de retirar 9000.0 BRL',
            '3*****56 acabou de retirar 10000.0 BRL',
            '9*****33 acabou de retirar 80000.0 BRL',
        ];
        /*if ($param['type'] == 2){
            $data['marquee'] = [
                '1*****09 acabou de retirar 10000.0 BRL'
            ];
        }*/
        return ReturnJson::successFul(200,$data,1);
    }

    /**
     * 首页游戏列表
     * @return null
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function gameList(Request $request){
        $param = $request->param();
        $validate = Validate::rule([
            'type' => 'require|in:1,2,3,4,5,6,7,8,9', //1-Quente  2-PG SOFT 3-Originais 4-TADA 5-Pragmatic Play 6-Recomendados 7-Live Casino 8-Todos Os(slots) 9-spin
        ]);
        if (!$validate->check($param)) {
            Log::record("游戏列表接口数据验证失败===>".$validate->getError());
            return ReturnJson::failFul(219);
        }
        $page = isset($param['page']) ? $param['page'] : 1;
        $limit = isset($param['page_size']) ? $param['page_size'] : 18;
        $page = ($page - 1) * $limit;

        $type = $param['type'];
        $where = [];
        $where['status'] = 1;
        switch ($type){
            case 1:
                $where['hot'] = 1;
                break;
            case 2:
                $where['terrace_id'] = 1;
                break;
            case 3:
                $where['type'] = 4;
                break;
            case 4:
                $where['terrace_id'] = 3;
                break;
            case 5:
                $where['terrace_id'] = 2;
                break;
            case 6:
                $where['recommend'] = 1;
                break;
            case 7:
                $where['type'] = 2;
                break;
            case 8:
                $where['type'] = 1;
                break;
            case 9:
                $where['type'] = 3;
                break;
            default:
                break;
        }

        //厂商分类使用
        if (isset($param['terrace_id']) && $param['terrace_id'] > 0){
            $where = [];
            $where['status'] = 1;
            $where['terrace_id'] = $param['terrace_id'];
        }

        $list = Db::name('slots_game')->where($where)
            ->field("englishname,slotsgameid,maintain_status,image,id as game_id,free") //IFNULL(CONCAT('https://', image),'') as
            ->order('weight','desc')
            ->order('id','desc')
            ->limit($page,$limit)
            ->select()->toArray();
        $count = Db::name('slots_game')->where($where)->count();
        if (!empty($list)){
            foreach ($list as $key=>$value){
                $list[$key]['image'] = Common::domain_name_path($value['image']);
            }
        }

        $data = [];
        $data['games'] = $list;
        $data['totalNum'] = $count;

        return ReturnJson::successFul(200,$data);

    }


    /**
     * 关键词搜索游戏
     * @return null
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function look(Request $request){
        $param = $request->param();
        $validate = Validate::rule([
            'keyword' => 'require',
        ]);
        if (!$validate->check($param)) {
            Log::record("游戏检索接口数据验证失败===>".$validate->getError());
            return ReturnJson::failFul(219);
        }
        $keyword = $param['keyword'];
        $page = isset($param['page']) ? $param['page'] : 1;
        $limit = isset($param['page_size']) ? $param['page_size'] : 18;
        $page = ($page - 1) * $limit;

        $list = Db::name('slots_game')
            ->where('englishname','like',"%$keyword%")
            ->where('status',1)
            ->field("englishname,slotsgameid,maintain_status,image")
            ->order('weight','desc')
            ->order('id','desc')
            ->limit($page,$limit)
            ->select()->toArray();

        $count = Db::name('slots_game')->where('englishname','like',"%$keyword%")->where('status',1)->count();
        if (!empty($list)){
            foreach ($list as $key=>$value){
                $list[$key]['image'] = Common::domain_name_path($value['image']);
            }
        }

        $data = [];
        $data['games'] = $list;
        $data['totalNum'] = $count;

        return ReturnJson::successFul(200,$data);
    }

    /**
     * 游戏厂商
     * @return null
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function terrace(){
        $list = Db::name('slots_terrace')
            ->where('status',1)
            ->field('id as terrace_id,name,image,type')
            ->order('weight','desc')
            ->order('id','desc')
            ->select()->toArray();
        if (!empty($list)){
            foreach ($list as $key=>$value){
                $list[$key]['image'] = Common::domain_name_path($value['image']);
            }
        }

        return ReturnJson::successFul(200,$list);
    }

    /**
     * 社区联系账号
     * @return void
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function contact(){
        $list = Db::name('contact')
            ->where('status',1)
            ->field('name,icon,contact,url')
            ->order('sort','desc')
            ->order('id','desc')
            ->select()->toArray();
        if (!empty($list)){
            foreach ($list as $key=>$value){
                $list[$key]['icon'] = Common::domain_name_path($value['icon']);
            }
        }

        return ReturnJson::successFul(200,$list);
    }

    /**
     * 消息列表
     * @param Request $request
     * @return null
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function message(Request $request){
        $param = $request->param();
        $validate = Validate::rule([
            'uid' => 'require',
        ]);
        if (!$validate->check($param)) {
            Log::record("消息接口数据验证失败===>".$validate->getError());
            return ReturnJson::failFul(219);
        }
        $uid = $param['uid'];
        $page = isset($param['page']) ? $param['page'] : 1;
        $limit = isset($param['page_size']) ? $param['page_size'] : 18;
        $page = ($page - 1) * $limit;

        $list = Db::name('notice')
            ->where('status',1)
            ->field('id,title,content,create_time')
            ->order('create_time','desc')
            ->limit($page,$limit)
            ->select()->toArray();
        return ReturnJson::successFul(200,$list);
    }


    public function send()
    {
       /* //队列名  消息队列载体，每个消息都会被投入到一个或多个队列。
        $queue = 'hello';

        //建立连接
        $connection = new AMQPStreamConnection('127.0.0.1', 5672, 'admin', '123456', '/');
        //获取信道
        $channel = $connection->channel();

        //声明创建队列
        $channel->queue_declare($queue, false, false, false, false);

        for ($i=0; $i < 5; ++$i) {
            sleep(1);//休眠1秒
            //消息内容
            //$messageBody = "Hello,Zq Now Time:".date("h:i:s");
            $data = ['id'=>rand(1,100), 'msg'=>'lalala'];
            //将我们需要的消息标记为持久化 - 通过设置AMQPMessage的参数delivery_mode = AMQPMessage::DELIVERY_MODE_PERSISTENT
            $message = new AMQPMessage(json_encode($data), array('content_type' => 'application/json', 'delivery_mode' => AMQPMessage::DELIVERY_MODE_PERSISTENT));
            //发送消息
            $channel->basic_publish($message, 'test','egg');
            echo "Send Message:". $i."\n";
        }

        //关闭信道
        $channel->close();
        //关闭连接
        $connection->close();
        return 'Send Success';*/

        $data = ['id'=>rand(1,100), 'msg'=>'lalala2'];
        //self::pushMessage($data);
        $amqpDetail = config('rabbitmq.direct_queue');
        MqProducer::pushMessage($data, $amqpDetail);
//        $ss = new MqConsumer();
//        $ss->start($amqpDetail);
    }

}