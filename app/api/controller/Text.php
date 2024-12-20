<?php
namespace app\api\controller;

use app\admin\controller\Common;
use dateTime\dateTime;
use think\facade\Config;
use think\facade\Db;
use think\facade\Log;
use crmeb\basic\BaseController;
use app\api\controller\ReturnJson;
use curl\Curl;

class Text extends BaseController
{


    public function mySqlTiHuan(){
        Db::name('app_package')->where('file_url', 'like', 'http://1.13.81.132:5009%')->update(['file_url' => Db::raw("REPLACE(file_url, 'http://1.13.81.132:5009', 'http://1.136.81.132:5009')")]);
    }

    public function testDaoChu(){

        $black_user = Db::name('black_user')
            ->alias('a')
            ->join('share_strlog b','a.uid = b.uid')
            ->field('b.login_ip,a.uid')
            ->select()
            ->toArray();
        foreach ($black_user as $v){



            $list[] = [$v['uid'],$v['login_ip']];

        }


        Common::daoChuExcel($list,['用户UID','IP'],'黑名单用户数据');
        dd(111);
    }


    public function testWithLog()
    {
        $withdraw_log1 = Db::name('withdraw_log')->field('createtime,finishtime,really_money')->where('status',0)->select()->toArray();
        $withdraw_log2 = Db::name('withdraw_log')->field('createtime,finishtime,really_money')->whereNotNull('finishtime')->where('status','<>',0)->where('status','<>',-1)->select()->toArray();

        $count7 = 0;
        $money7 = 0;
        $count3 = 0;
        $money3 = 0;
        foreach ($withdraw_log1 as $v){
            if(bcadd($v['createtime'],604800,0) <= time()){ //7天订单
                $count7 = $count7 + 1;
                $money7 = bcadd(bcdiv($v['really_money'],100,0),$money7,0);
            }elseif (bcadd($v['createtime'],259200,0) <= time()){//3天订单
                $count3 = $count3 + 1;
                $money3 = bcadd(bcdiv($v['really_money'],100,0),$money3,0);
            }
        }

        foreach ($withdraw_log2 as $value){
            if(bcadd($value['finishtime'],$value['createtime'],0) >= 604800){
                $count7 = $count7 + 1;
                $money7 = bcadd(bcdiv($value['really_money'],100,0),$money7,0);
            }elseif (bcadd($value['finishtime'],$value['createtime'],0) >= 259200){//3天订单
                $count3 = $count3 + 1;
                $money3 = bcadd(bcdiv($value['really_money'],100,0),$money3,0);
            }

        }
        dd($count7,$money7,$count3,$money3);
    }



    public function slotsLogSql()
    {
// Adjust API 凭证
        $apiToken = 'YOUR_API_TOKEN';
        $baseUrl = 'https://dash.adjust.com/api/v1/';

// 创建 Guzzle 客户端
        $client = new Client([
            'base_uri' => $baseUrl,
            'headers' => [
                'Authorization' => 'Bearer ' . $apiToken,
                'Content-Type' => 'application/json',
            ],
        ]);

// 定义请求参数
        $params = [
            'query' => [
                'start_date' => '2023-01-01', // 起始日期
                'end_date' => '2023-01-31',   // 结束日期
                'kpis' => 'installs,clicks,revenue', // 关键指标
                'grouping' => 'source',       // 分组方式
            ],
        ];

        try {
            // 发送 GET 请求
            $response = $client->request('GET', 'kpi', $params);

            // 解析响应
            $data = json_decode($response->getBody(), true);

            // 处理数据
            if (isset($data['result'])) {
                echo "Data retrieved successfully:\n";
                print_r($data['result']);
            } else {
                echo "No data found.\n";
            }
        } catch (RequestException $e) {
            // 处理请求异常
            echo "Error: " . $e->getMessage() . "\n";
            echo "Response: " . $e->getResponse()->getBody() . "\n";
        }
    }

    public function daochu()
    {
        $redis = new \Redis();
        $redis->connect('127.0.0.1', 6379);
        $redis->hSet('aaa', 'bbb', 'aaa');
//        $userinfo = Db::name('userinfo')
//            ->alias('a')
//            ->join('share_strlog b','a.uid = b.uid')
//            ->field('a.uid,a.total_pay_score,a.total_give_score,a.bonus_cash,(a.total_cash_water_score + a.total_bonus_water_score) as total_water_score,b.device_id,b.createtime')
//            ->where('a.package_id',8)
//            ->where('(a.total_cash_water_score + a.total_bonus_water_score)','>',0)
//            ->order('b.createtime','desc')
//            ->select()
//            ->toArray();
//        $list = [];
//        foreach ($userinfo as $v){
//            $money = bcadd(bcadd($v['total_pay_score'],$v['total_give_score'],0),$v['bonus_cash'],0);
//
//
//            $list[] = [$v['uid'],bcdiv($v['total_pay_score'],100,2),bcdiv($v['total_water_score'],100,2),bcdiv($v['total_water_score'],$money,2),$v['device_id'],date('Y-m-d H:i:s',$v['createtime'])];
//
//        }
//
//
//        Common::daoChuExcel($list,['用户UID','总充值','总流水','流水倍数','设备ID'],'用户游戏数据');
//        dd(111);
    }


    /**
     * 给网红加钱
     * @return void
     */
    public function setWhCoin($uid, $money)
    {
        //打标签
        $struser = Db::name('share_strlog')->where('uid', $uid)->find();
        if (empty($struser)) return '用户异常';
        $old_tagarr = explode(",", $struser['tag']);
        if (empty($struser['tag'])) {
            $tag = 1;
        } elseif (!in_array(1, $old_tagarr)) {
            $tag = $struser['tag'] . ',1';
        } else {
            $tag = $struser['tag'];
        }
        Db::name('share_strlog')->where('uid', $uid)->update(['tag' => $tag]);


        //标记为网红
        Db::name('share_strlog')->where('uid', $uid)->update(['is_red' => 1]);

        $res = Db::name('userinfo')->where('uid', $uid)
            ->update([
                'updatetime' => time(),
                'coin' => Db::raw('coin + ' . $money),
                'withdraw_money_other' => Db::raw('withdraw_money_other + ' . $money),
                'total_pay_score' => Db::raw('total_pay_score + ' . $money),
            ]);

        return '成功';

    }

    public function setPayUserWT()
    {

    }

    public function setBonusCash()
    {
        $userinfo = Db::name('userinfo')
            ->alias('a')
            ->join('share_strlog b', 'b.uid = a.uid')
            ->field('b.account')
            ->group('b.account')
            ->having('COUNT(*) > 1') // 使用 Db::raw() 来构建 HAVING 子句
            ->select()
            ->toArray();

        foreach ($userinfo as $v) {
            if (!$v['account']) continue;
            $userinfoNew = Db::name('userinfo')
                ->alias('a')
                ->join('share_strlog b', 'b.uid = a.uid')
                ->field('b.uid')
                ->order('a.coin', 'desc')
                ->order('a.bonus', 'desc')
                ->where('b.account', $v['account'])
                ->select()
                ->toArray();
            if (!$userinfoNew) continue;
            $uidArray = [];
            foreach ($userinfoNew as $key => $value) {
                if ($key == 0) continue;
                $uidArray[] = $value['uid'];
            }
            Db::name('share_strlog')->where('uid', 'in', $uidArray)->update(['account' => '99999999' . $v['account']]);
        }
        dd(111);
    }


    public function serpayData()
    {
        dd(111);
        $logFile = root_path() . 'public/serpay.log'; // 替换为你的日志文件路径

        $orderDetails = [];
        $failedOrders = [];
        $failedOrders2 = [];

        // 读取日志文件
        $logLines = file($logFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        if ($logLines === false) {
            dd("无法读取日志文件: " . $logFile);
        }

        // 提取所有 serpay充值: 记录中的 custOrderNo 和 payAmt
        foreach ($logLines as $line) {
            if (strpos($line, 'serpay充值:') !== false) {
                // 使用更灵活的正则表达式
                preg_match('/"custOrderNo":"(\d+)"[^}]*"payAmt":"(\d+)"/', $line, $matches);
                if (!empty($matches[1]) && !empty($matches[2])) {
                    $orderNumber = $matches[1];
                    $payAmt = $matches[2];
                    $orderDetails[$orderNumber] = $payAmt;
                    // echo "提取订单: {$orderNumber}, 金额: {$payAmt}\n";
                } else {
                    echo "无法匹配1: {$line}\n";
                }
            }
        }

        // 查找所有 serpay充值事务处理失败===订单获取失败==ordersn== 记录
        foreach ($logLines as $line) {
            if (strpos($line, 'serpay充值事务处理失败===订单获取失败==ordersn==') !== false) {
                preg_match('/ordersn==(\d+)/', $line, $matches);
                if (!empty($matches[1])) {
                    $orderNumber = $matches[1];
                    if (isset($orderDetails[$orderNumber])) {
                        $failedOrders[] = [
                            'orderNumber' => $orderNumber,
                            'payAmt' => bcdiv($orderDetails[$orderNumber], 100, 2),
                        ];
                        $failedOrders2[] = [$orderNumber, bcdiv($orderDetails[$orderNumber], 100, 2)];
                        // echo "事务处理失败: {$orderNumber}, 金额: {$orderDetails[$orderNumber]}\n";
                    } else {
                        echo "未找到订单2: {$orderNumber}\n";
                    }
                } else {
                    echo "无法匹配2: {$line}\n";
                }
            }
        }
        // dd($failedOrders2);
        Common::daoChuExcel($failedOrders2, ['订单号', '金额'], 'serpay');
        dd(111);

    }


    /**
     * 付费留存-再登录数据
     * @param $fieldnum 修改的字段数字
     * @param $time 数据表time的时间
     * @param $strtotime 查询表的时间戳
     * @return void
     */
    public static function setStatisticsRetainedLg($fieldnum, $date, $statistics_retainedpaiduser,$time)
    {
        $field = 'day'.$fieldnum;
        $table = 'login_' . $date;
        $sql = "SHOW TABLES LIKE 'br_" . $table . "'";
        if (!Db::query($sql)) {
            return ['code' => 201, 'msg' => '数据表不存在', 'data' => $table];
        }

//        $data = [];
//        foreach ($statistics_retainedpaiduser as $v) {  //获取每日不同包不同渠道的用户
//            $count = Db::name($table)->where('uid', 'in', $v['uids'])->count();
//            if ($count > 0) {
//                if(isset($data['filed'])){
//                    $data['count'] = $data['count'] + $count;
//                }else{
//                    $data = [
//                        'table' => $table,
//                        'filed' => $field,
//                        'count' => $count,
//                        'package_id' => $v['package_id'],
//                        'channel' => $v['channel'],
//                    ];
//                }
//
//
//            }
//        }
//
//        return $data;

        foreach ($statistics_retainedpaiduser as $v) {  //获取每日不同包不同渠道的用户

            $count = Db::name($table)->where('uid', 'in', $v['uids'])->count();

            if ($count > 0) {

                Db::name('statistics_retentionpaidlg')->where(['time' => $time, 'package_id' => $v['package_id'], 'channel' => $v['channel']])
                    ->update([
                        $field => $count
                    ]);
            }
        }
    }


    /**
     * 统计哪天的数据
     * https://inrtakeoff.3377win.com/api/Text/statisticsRetained?day=2024-09-11
     * @param $day 哪天的数据 2024-08-29
     * @param $start 开始的天数
     * @return void 用户、付费留存
     */
    public static function statisticsRetained($day)
    {
        $time = strtotime($day);
        $statistics_retainedpaiduser = Db::name('statistics_retainedpaiduser')->field('uids,package_id,channel')->where(['time' => $time])->select()->toArray();
        if (!$statistics_retainedpaiduser) {
            return ['code' => 201, 'msg' => '暂无数据', 'data' => []];
        }

        $day_array15 = self::getStartTimes($time);  //获取近14日的时间戳
        $day45 = date('Ymd',strtotime('00:00:00 +45 day'));
        foreach ($day_array15 as $k => $v) {
            $list[] = self::setStatisticsRetainedLg($k + 1,$v,$statistics_retainedpaiduser,$time);
        }
        $list[] = self::setStatisticsRetainedLg(45, $day45,$statistics_retainedpaiduser,$time);
        dd($list);
    }


    /**
     * 返回指定天数的开始日期
     * @param $days 天数
     * @param $type 类型:1=时间戳 2=日期
     * @param $start 开始的天数  0从今天开始 1表示从昨天开始，2表示从前天开始
     * @return array
     */
    public static function getStartTimes($timestamp)
    {
        // 循环获取接下来 30 天的日期
        for ($i = 0; $i < 30; $i++) {
            // 将时间设置为当天的 00:00:00
            $midnightTimestamp = mktime(0, 0, 0, date('m', $timestamp), date('d', $timestamp), date('Y', $timestamp));

            // 将日期添加到结果数组中
            $result[] = date('Ymd', $midnightTimestamp);

            // 将日期增加一天
            $timestamp = strtotime('+1 day', $timestamp);
        }
        unset($result[0]);
        return $result;
    }

    public function SseStreamTest()
    {
        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
        header("X-Accel-Buffering: no");
        header("Content-Type: text/event-stream");
        header("Cache-Control: no-cache");

        $counter = rand(1, 10); // a random counter
        while (1) {
// 1 is always true, so repeat the while loop forever (aka event-loop)

            $curDate = date(DATE_ISO8601);
            echo "event: ping\n",
                'data: {"time": "' . $curDate . '"}', "\n\n";

            // Send a simple message at random intervals.

            $counter--;

            if (!$counter) {
                echo 'data: This is a message at time ' . $curDate, "\n\n";
                $counter = rand(1, 10); // reset random counter
            }

            // flush the output buffer and send echoed messages to the browser

            while (ob_get_level() > 0) {
                ob_end_flush();
            }
            flush();

            $connectionStatus = connection_status();
            $this->writeLog('connection_status：' . $connectionStatus);
            // break the loop if the client aborted the connection (closed the page)
            $isEnd = connection_aborted();
            $this->writeLog('connection_aborted：' . $isEnd);
            if (connection_aborted()) break;

            // sleep for 1 second before running the loop again

            sleep(1);
        }
    }

    public function writeLog(string $msg)
    {
        $fb = fopen('./aaa.txt', 'a+');
        fwrite($fb, date('Y-m-d H:i:s') . $msg . PHP_EOL);
        fclose($fb);
    }
}
