<?php

namespace app\admin\controller;

use app\admin\model\member\Users;
use app\admin\model\order\StoreOrder as StoreOrderModel;
use app\admin\model\statistics\Indicator;
use app\admin\model\system\{SystemConfig, SystemMenus, SystemRole};
use think\facade\Db;

class Index extends AuthController
{
    public function index()
    {
        //获取当前登录后台的管理员信息
        $admin = $this->adminInfo->toArray();
        $roles = explode(',', $admin['roles']);

        //$site_logo = SystemConfig::getOneConfig('menu_name', 'site_logo')->toArray();

        $this->assign([
            'site_name' => SystemConfig::getOne('site_name'),
            'menu_list' => SystemMenus::menuList(),
            'role_name' => SystemRole::where('id', $roles[0])->value('role_name'),

            //'site_logo' => json_decode($site_logo['value'], true),
            //'new_order_audio_link' => sys_config('new_order_audio_link'),
            //'workermanPort'        => Config::get('workerman.admin.port'),
        ]);

        return $this->fetch();
    }

    //后台首页内容
    public function main()
    {
        $date = date('Y-m-d');

        $day_data = Db::name('day_data')->where('date', $date)->find();

        $this->assign([
            'day_data' => $day_data,
        ]);
        return $this->fetch();
    }

    /**
     * 订单图表
     */
    public function orderchart()
    {
        header('Content-type:text/json');

        $cycle = $this->request->param('cycle') ?: 'thirtyday';//默认30天
        $datalist = [];
        $where = ['is_del' => 0, 'paid' => 1, 'refund_status' => 0];
        switch ($cycle) {
            case 'thirtyday':
                $datebefor = date('Y-m-d 00:00:00', strtotime('-30 day'));
                $dateafter = date('Y-m-d 23:59:59');
                //上期
                $pre_datebefor = date('Y-m-d', strtotime('-60 day'));
                $pre_dateafter = date('Y-m-d', strtotime('-30 day'));
                for ($i = -30; $i < 1; $i++) {
                    $datalist[date('m-d', strtotime($i . ' day'))] = date('m-d', strtotime($i . ' day'));
                }
                $order_list = StoreOrderModel::where('add_time', 'between time', [$datebefor, $dateafter])
                    ->where($where)
                    ->field("FROM_UNIXTIME(add_time,'%m-%d') as day,count(*) as count,sum(pay_price) as price")
                    ->group("FROM_UNIXTIME(add_time, '%Y%m%d')")
                    ->order('add_time asc')
                    ->select()->toArray();
                if (empty($order_list)) return app('json')->fail('无数据');
                foreach ($order_list as $k => &$v) {
                    $order_list[$v['day']] = $v;
                }
                $cycle_list = [];
                foreach ($datalist as $dk => $dd) {
                    if (!empty($order_list[$dd])) {
                        $cycle_list[$dd] = $order_list[$dd];
                    } else {
                        $cycle_list[$dd] = ['count' => 0, 'day' => $dd, 'price' => ''];
                    }
                }
                $chartdata = [];
                $data = [];//临时
                $chartdata['yAxis']['maxnum'] = 0;//最大值数量
                $chartdata['yAxis']['maxprice'] = 0;//最大值金额
                foreach ($cycle_list as $k => $v) {
                    $data['day'][] = $v['day'];
                    $data['count'][] = $v['count'];
                    $data['price'][] = round($v['price'], 2);
                    if ($chartdata['yAxis']['maxnum'] < $v['count'])
                        $chartdata['yAxis']['maxnum'] = $v['count'];//日最大订单数
                    if ($chartdata['yAxis']['maxprice'] < $v['price'])
                        $chartdata['yAxis']['maxprice'] = $v['price'];//日最大金额
                }
                $chartdata['legend'] = ['订单金额', '订单数'];//分类
                $chartdata['xAxis'] = $data['day'];//X轴值
                //,'itemStyle'=>$series
                $series = ['normal' => ['label' => ['show' => true, 'position' => 'top']]];
                $chartdata['series'][] = ['name' => $chartdata['legend'][0], 'type' => 'bar', 'itemStyle' => $series, 'data' => $data['price']];//分类1值
                $chartdata['series'][] = ['name' => $chartdata['legend'][1], 'type' => 'bar', 'itemStyle' => $series, 'data' => $data['count']];//分类2值
                //统计总数上期
                $pre_total = StoreOrderModel::where('add_time', 'between time', [$pre_datebefor, $pre_dateafter])
                    ->where($where)
                    ->field("count(*) as count,sum(pay_price) as price")
                    ->find();
                if ($pre_total) {
                    $chartdata['pre_cycle']['count'] = [
                        'data' => $pre_total['count'] ?: 0
                    ];
                    $chartdata['pre_cycle']['price'] = [
                        'data' => $pre_total['price'] ?: 0
                    ];
                }
                //统计总数
                $total = StoreOrderModel::where('add_time', 'between time', [$datebefor, $dateafter])
                    ->where($where)
                    ->field("count(*) as count,sum(pay_price) as price")
                    ->find();
                if ($total) {
                    $cha_count = intval($pre_total['count']) - intval($total['count']);
                    //$pre_total['count'] = $pre_total['count'] == 0 ? 1 : $pre_total['count'];
                    $chartdata['cycle']['count'] = [
                        'data' => $total['count'] ?: 0,
                        'percent' => intval($pre_total['count']) == 0 ? 100 : round((abs($cha_count) / intval($pre_total['count']) * 100), 2),
                        'is_plus' => $cha_count > 0 ? -1 : ($cha_count == 0 ? 0 : 1)
                    ];
                    $cha_price = round($pre_total['price'], 2) - round($total['price'], 2);
                    //$pre_total['price'] = $pre_total['price'] == 0 ? 1 : $pre_total['price'];
                    $chartdata['cycle']['price'] = [
                        'data' => $total['price'] ?: 0,
                        'percent' => (intval($pre_total['price']) == 0 || !$pre_total['price'] || $pre_total['price'] == 0.00) ? 100 : round(abs($cha_price) / $pre_total['price'] * 100, 2),
                        'is_plus' => $cha_price > 0 ? -1 : ($cha_price == 0 ? 0 : 1)
                    ];
                }
                return app('json')->success('ok', $chartdata);
                break;
            case 'week':
                $weekarray = array(['周日'], ['周一'], ['周二'], ['周三'], ['周四'], ['周五'], ['周六']);
                $datebefor = date('Y-m-d 00:00:00)', strtotime('-1 week Monday'));
                $dateafter = date('Y-m-d 23:59:59', strtotime('-1 week Sunday'));
                $order_list = StoreOrderModel::where('add_time', 'between time', [$datebefor, $dateafter])
                    ->where($where)
                    ->field("FROM_UNIXTIME(add_time,'%w') as day,count(*) as count,sum(pay_price) as price")
                    ->group("FROM_UNIXTIME(add_time, '%Y%m%e')")
                    ->order('add_time asc')
                    ->select()->toArray();
                //数据查询重新处理
                $new_order_list = [];
                foreach ($order_list as $k => $v) {
                    $new_order_list[$v['day']] = $v;
                }
                $now_datebefor = date('Y-m-d 00:00:00', (time() - ((date('w') == 0 ? 7 : date('w')) - 1) * 24 * 3600));
                $now_dateafter = date('Y-m-d 23:59:59', strtotime("+1 day"));
                $now_order_list = StoreOrderModel::where('add_time', 'between time', [$now_datebefor, $now_dateafter])
                    ->where($where)
                    ->field("FROM_UNIXTIME(add_time,'%w') as day,count(*) as count,sum(pay_price) as price")
                    ->group("FROM_UNIXTIME(add_time, '%Y%m%e')")
                    ->order('add_time asc')
                    ->select()->toArray();
                //数据查询重新处理 key 变为当前值
                $new_now_order_list = [];
                foreach ($now_order_list as $k => $v) {
                    $new_now_order_list[$v['day']] = $v;
                }
                foreach ($weekarray as $dk => $dd) {
                    if (!empty($new_order_list[$dk])) {
                        $weekarray[$dk]['pre'] = $new_order_list[$dk];
                    } else {
                        $weekarray[$dk]['pre'] = ['count' => 0, 'day' => $weekarray[$dk][0], 'price' => '0'];
                    }
                    if (!empty($new_now_order_list[$dk])) {
                        $weekarray[$dk]['now'] = $new_now_order_list[$dk];
                    } else {
                        $weekarray[$dk]['now'] = ['count' => 0, 'day' => $weekarray[$dk][0], 'price' => '0'];
                    }
                }
                $chartdata = [];
                $data = [];//临时
                $chartdata['yAxis']['maxnum'] = 0;//最大值数量
                $chartdata['yAxis']['maxprice'] = 0;//最大值金额
                foreach ($weekarray as $k => $v) {
                    $data['day'][] = $v[0];
                    $data['pre']['count'][] = $v['pre']['count'];
                    $data['pre']['price'][] = round($v['pre']['price'], 2);
                    $data['now']['count'][] = $v['now']['count'];
                    $data['now']['price'][] = round($v['now']['price'], 2);
                    if ($chartdata['yAxis']['maxnum'] < $v['pre']['count'] || $chartdata['yAxis']['maxnum'] < $v['now']['count']) {
                        $chartdata['yAxis']['maxnum'] = $v['pre']['count'] > $v['now']['count'] ? $v['pre']['count'] : $v['now']['count'];//日最大订单数
                    }
                    if ($chartdata['yAxis']['maxprice'] < $v['pre']['price'] || $chartdata['yAxis']['maxprice'] < $v['now']['price']) {
                        $chartdata['yAxis']['maxprice'] = $v['pre']['price'] > $v['now']['price'] ? $v['pre']['price'] : $v['now']['price'];//日最大金额
                    }
                }
                $chartdata['legend'] = ['上周金额', '本周金额', '上周订单数', '本周订单数'];//分类
                $chartdata['xAxis'] = $data['day'];//X轴值
                //,'itemStyle'=>$series
                $series = ['normal' => ['label' => ['show' => true, 'position' => 'top']]];
                $chartdata['series'][] = ['name' => $chartdata['legend'][0], 'type' => 'bar', 'itemStyle' => $series, 'data' => $data['pre']['price']];//分类1值
                $chartdata['series'][] = ['name' => $chartdata['legend'][1], 'type' => 'bar', 'itemStyle' => $series, 'data' => $data['now']['price']];//分类1值
                $chartdata['series'][] = ['name' => $chartdata['legend'][2], 'type' => 'line', 'itemStyle' => $series, 'data' => $data['pre']['count']];//分类2值
                $chartdata['series'][] = ['name' => $chartdata['legend'][3], 'type' => 'line', 'itemStyle' => $series, 'data' => $data['now']['count']];//分类2值

                //统计总数上期
                $pre_total = StoreOrderModel::where('add_time', 'between time', [$datebefor, $dateafter])
                    ->where($where)
                    ->field("count(*) as count,sum(pay_price) as price")
                    ->find();
                if ($pre_total) {
                    $chartdata['pre_cycle']['count'] = [
                        'data' => $pre_total['count'] ?: 0
                    ];
                    $chartdata['pre_cycle']['price'] = [
                        'data' => $pre_total['price'] ?: 0
                    ];
                }
                //统计总数
                $total = StoreOrderModel::where('add_time', 'between time', [$now_datebefor, $now_dateafter])
                    ->where($where)
                    ->field("count(*) as count,sum(pay_price) as price")
                    ->find();
                if ($total) {
                    $cha_count = intval($pre_total['count']) - intval($total['count']);
                    //$pre_total['count'] = $pre_total['count'] == 0 ? 1 : $pre_total['count'];
                    $chartdata['cycle']['count'] = [
                        'data' => $total['count'] ?: 0,
                        'percent' => intval($pre_total['count']) == 0 ? 100 : round((abs($cha_count) / intval($pre_total['count']) * 100), 2),
                        'is_plus' => $cha_count > 0 ? -1 : ($cha_count == 0 ? 0 : 1)
                    ];
                    $cha_price = round($pre_total['price'], 2) - round($total['price'], 2);
                    //$pre_total['price'] = $pre_total['price'] == 0 ? 1 : $pre_total['price'];
                    $chartdata['cycle']['price'] = [
                        'data' => $total['price'] ?: 0,
                        'percent' => (intval($pre_total['price']) == 0 || !$pre_total['price'] || $pre_total['price'] == 0.00) ? 100 : round(abs($cha_price) / $pre_total['price'] * 100, 2),
                        'is_plus' => $cha_price > 0 ? -1 : ($cha_price == 0 ? 0 : 1)
                    ];
                }
                return app('json')->success('ok', $chartdata);
                break;
            case 'month':
                $weekarray = array('01' => ['1'], '02' => ['2'], '03' => ['3'], '04' => ['4'], '05' => ['5'], '06' => ['6'], '07' => ['7'], '08' => ['8'], '09' => ['9'], '10' => ['10'], '11' => ['11'], '12' => ['12'], '13' => ['13'], '14' => ['14'], '15' => ['15'], '16' => ['16'], '17' => ['17'], '18' => ['18'], '19' => ['19'], '20' => ['20'], '21' => ['21'], '22' => ['22'], '23' => ['23'], '24' => ['24'], '25' => ['25'], '26' => ['26'], '27' => ['27'], '28' => ['28'], '29' => ['29'], '30' => ['30'], '31' => ['31']);

                $datebefor = date('Y-m-01 00:00:00', strtotime('-1 month'));
                $dateafter = date('Y-m-d 23:59:59', strtotime(date('Y-m-01')));
                $order_list = StoreOrderModel::where('add_time', 'between time', [$datebefor, $dateafter])
                    ->where($where)
                    ->field("FROM_UNIXTIME(add_time,'%d') as day,count(*) as count,sum(pay_price) as price")
                    ->group("FROM_UNIXTIME(add_time, '%Y%m%e')")
                    ->order('add_time asc')
                    ->select()->toArray();
                //数据查询重新处理
                $new_order_list = [];
                foreach ($order_list as $k => $v) {
                    $new_order_list[$v['day']] = $v;
                }
                $now_datebefor = date('Y-m-01 00:00:00');
                $now_dateafter = date('Y-m-d 23:59:59', strtotime("+1 day"));
                $now_order_list = StoreOrderModel::where('add_time', 'between time', [$now_datebefor, $now_dateafter])
                    ->where($where)
                    ->field("FROM_UNIXTIME(add_time,'%d') as day,count(*) as count,sum(pay_price) as price")
                    ->group("FROM_UNIXTIME(add_time, '%Y%m%e')")
                    ->order('add_time asc')
                    ->select()->toArray();
                //数据查询重新处理 key 变为当前值
                $new_now_order_list = [];
                foreach ($now_order_list as $k => $v) {
                    $new_now_order_list[$v['day']] = $v;
                }
                foreach ($weekarray as $dk => $dd) {
                    if (!empty($new_order_list[$dk])) {
                        $weekarray[$dk]['pre'] = $new_order_list[$dk];
                    } else {
                        $weekarray[$dk]['pre'] = ['count' => 0, 'day' => $weekarray[$dk][0], 'price' => '0'];
                    }
                    if (!empty($new_now_order_list[$dk])) {
                        $weekarray[$dk]['now'] = $new_now_order_list[$dk];
                    } else {
                        $weekarray[$dk]['now'] = ['count' => 0, 'day' => $weekarray[$dk][0], 'price' => '0'];
                    }
                }
                $chartdata = [];
                $data = [];//临时
                $chartdata['yAxis']['maxnum'] = 0;//最大值数量
                $chartdata['yAxis']['maxprice'] = 0;//最大值金额
                foreach ($weekarray as $k => $v) {
                    $data['day'][] = $v[0];
                    $data['pre']['count'][] = $v['pre']['count'];
                    $data['pre']['price'][] = round($v['pre']['price'], 2);
                    $data['now']['count'][] = $v['now']['count'];
                    $data['now']['price'][] = round($v['now']['price'], 2);
                    if ($chartdata['yAxis']['maxnum'] < $v['pre']['count'] || $chartdata['yAxis']['maxnum'] < $v['now']['count']) {
                        $chartdata['yAxis']['maxnum'] = $v['pre']['count'] > $v['now']['count'] ? $v['pre']['count'] : $v['now']['count'];//日最大订单数
                    }
                    if ($chartdata['yAxis']['maxprice'] < $v['pre']['price'] || $chartdata['yAxis']['maxprice'] < $v['now']['price']) {
                        $chartdata['yAxis']['maxprice'] = $v['pre']['price'] > $v['now']['price'] ? $v['pre']['price'] : $v['now']['price'];//日最大金额
                    }

                }
                $chartdata['legend'] = ['上月金额', '本月金额', '上月订单数', '本月订单数'];//分类
                $chartdata['xAxis'] = $data['day'];//X轴值
                //,'itemStyle'=>$series
                $series = ['normal' => ['label' => ['show' => true, 'position' => 'top']]];
                $chartdata['series'][] = ['name' => $chartdata['legend'][0], 'type' => 'bar', 'itemStyle' => $series, 'data' => $data['pre']['price']];//分类1值
                $chartdata['series'][] = ['name' => $chartdata['legend'][1], 'type' => 'bar', 'itemStyle' => $series, 'data' => $data['now']['price']];//分类1值
                $chartdata['series'][] = ['name' => $chartdata['legend'][2], 'type' => 'line', 'itemStyle' => $series, 'data' => $data['pre']['count']];//分类2值
                $chartdata['series'][] = ['name' => $chartdata['legend'][3], 'type' => 'line', 'itemStyle' => $series, 'data' => $data['now']['count']];//分类2值

                //统计总数上期
                $pre_total = StoreOrderModel::where('add_time', 'between time', [$datebefor, $dateafter])
                    ->where($where)
                    ->field("count(*) as count,sum(pay_price) as price")
                    ->find();
                if ($pre_total) {
                    $chartdata['pre_cycle']['count'] = [
                        'data' => $pre_total['count'] ?: 0
                    ];
                    $chartdata['pre_cycle']['price'] = [
                        'data' => $pre_total['price'] ?: 0
                    ];
                }
                //统计总数
                $total = StoreOrderModel::where('add_time', 'between time', [$now_datebefor, $now_dateafter])
                    ->where($where)
                    ->field("count(*) as count,sum(pay_price) as price")
                    ->find();
                if ($total) {
                    $cha_count = intval($pre_total['count']) - intval($total['count']);
                    //$pre_total['count'] = $pre_total['count'] == 0 ? 1 : $pre_total['count'];
                    $chartdata['cycle']['count'] = [
                        'data' => $total['count'] ?: 0,
                        'percent' => intval($pre_total['count']) == 0 ? 100 : round((abs($cha_count) / intval($pre_total['count']) * 100), 2),
                        'is_plus' => $cha_count > 0 ? -1 : ($cha_count == 0 ? 0 : 1)
                    ];
                    $cha_price = round($pre_total['price'], 2) - round($total['price'], 2);
                    //$pre_total['price'] = $pre_total['price'] == 0 ? 1 : $pre_total['price'];
                    $chartdata['cycle']['price'] = [
                        'data' => $total['price'] ?: 0,
                        'percent' => (intval($pre_total['price']) == 0 || !$pre_total['price'] || $pre_total['price'] == 0.00) ? 100 : round(abs($cha_price) / $pre_total['price'] * 100, 2),
                        'is_plus' => $cha_price > 0 ? -1 : ($cha_price == 0 ? 0 : 1)
                    ];
                }
                return app('json')->success('ok', $chartdata);
                break;
            case 'year':
                $weekarray = array('01' => ['一月'], '02' => ['二月'], '03' => ['三月'], '04' => ['四月'], '05' => ['五月'], '06' => ['六月'], '07' => ['七月'], '08' => ['八月'], '09' => ['九月'], '10' => ['十月'], '11' => ['十一月'], '12' => ['十二月']);
                $datebefor = date('Y-01-01 00:00:00', strtotime('-1 year'));
                $dateafter = date('Y-12-31 23:59:59', strtotime('-1 year'));
                $order_list = StoreOrderModel::where('add_time', 'between time', [$datebefor, $dateafter])
                    ->where($where)
                    ->field("FROM_UNIXTIME(add_time,'%m') as day,count(*) as count,sum(pay_price) as price")
                    ->group("FROM_UNIXTIME(add_time, '%Y%m')")
                    ->order('add_time asc')
                    ->select()->toArray();
                //数据查询重新处理
                $new_order_list = [];
                foreach ($order_list as $k => $v) {
                    $new_order_list[$v['day']] = $v;
                }
                $now_datebefor = date('Y-01-01 00:00:00');
                $now_dateafter = date('Y-m-d 23:59:59');
                $now_order_list = StoreOrderModel::where('add_time', 'between time', [$now_datebefor, $now_dateafter])
                    ->where($where)
                    ->field("FROM_UNIXTIME(add_time,'%m') as day,count(*) as count,sum(pay_price) as price")
                    ->group("FROM_UNIXTIME(add_time, '%Y%m')")
                    ->order('add_time asc')
                    ->select()->toArray();
                //数据查询重新处理 key 变为当前值
                $new_now_order_list = [];
                foreach ($now_order_list as $k => $v) {
                    $new_now_order_list[$v['day']] = $v;
                }
                foreach ($weekarray as $dk => $dd) {
                    if (!empty($new_order_list[$dk])) {
                        $weekarray[$dk]['pre'] = $new_order_list[$dk];
                    } else {
                        $weekarray[$dk]['pre'] = ['count' => 0, 'day' => $weekarray[$dk][0], 'price' => '0'];
                    }
                    if (!empty($new_now_order_list[$dk])) {
                        $weekarray[$dk]['now'] = $new_now_order_list[$dk];
                    } else {
                        $weekarray[$dk]['now'] = ['count' => 0, 'day' => $weekarray[$dk][0], 'price' => '0'];
                    }
                }
                $chartdata = [];
                $data = [];//临时
                $chartdata['yAxis']['maxnum'] = 0;//最大值数量
                $chartdata['yAxis']['maxprice'] = 0;//最大值金额
                foreach ($weekarray as $k => $v) {
                    $data['day'][] = $v[0];
                    $data['pre']['count'][] = $v['pre']['count'];
                    $data['pre']['price'][] = round($v['pre']['price'], 2);
                    $data['now']['count'][] = $v['now']['count'];
                    $data['now']['price'][] = round($v['now']['price'], 2);
                    if ($chartdata['yAxis']['maxnum'] < $v['pre']['count'] || $chartdata['yAxis']['maxnum'] < $v['now']['count']) {
                        $chartdata['yAxis']['maxnum'] = $v['pre']['count'] > $v['now']['count'] ? $v['pre']['count'] : $v['now']['count'];//日最大订单数
                    }
                    if ($chartdata['yAxis']['maxprice'] < $v['pre']['price'] || $chartdata['yAxis']['maxprice'] < $v['now']['price']) {
                        $chartdata['yAxis']['maxprice'] = $v['pre']['price'] > $v['now']['price'] ? $v['pre']['price'] : $v['now']['price'];//日最大金额
                    }
                }
                $chartdata['legend'] = ['去年金额', '今年金额', '去年订单数', '今年订单数'];//分类
                $chartdata['xAxis'] = $data['day'];//X轴值
                //,'itemStyle'=>$series
                $series = ['normal' => ['label' => ['show' => true, 'position' => 'top']]];
                $chartdata['series'][] = ['name' => $chartdata['legend'][0], 'type' => 'bar', 'itemStyle' => $series, 'data' => $data['pre']['price']];//分类1值
                $chartdata['series'][] = ['name' => $chartdata['legend'][1], 'type' => 'bar', 'itemStyle' => $series, 'data' => $data['now']['price']];//分类1值
                $chartdata['series'][] = ['name' => $chartdata['legend'][2], 'type' => 'line', 'itemStyle' => $series, 'data' => $data['pre']['count']];//分类2值
                $chartdata['series'][] = ['name' => $chartdata['legend'][3], 'type' => 'line', 'itemStyle' => $series, 'data' => $data['now']['count']];//分类2值

                //统计总数上期
                $pre_total = StoreOrderModel::where('add_time', 'between time', [$datebefor, $dateafter])
                    ->where($where)
                    ->field("count(*) as count,sum(pay_price) as price")
                    ->find();
                if ($pre_total) {
                    $chartdata['pre_cycle']['count'] = [
                        'data' => $pre_total['count'] ?: 0
                    ];
                    $chartdata['pre_cycle']['price'] = [
                        'data' => $pre_total['price'] ?: 0
                    ];
                }
                //统计总数
                $total = StoreOrderModel::where('add_time', 'between time', [$now_datebefor, $now_dateafter])
                    ->where($where)
                    ->field("count(*) as count,sum(pay_price) as price")
                    ->find();
                if ($total) {
                    $cha_count = intval($pre_total['count']) - intval($total['count']);
                    //$pre_total['count'] = $pre_total['count'] == 0 ? 1 : $pre_total['count'];
                    $chartdata['cycle']['count'] = [
                        'data' => $total['count'] ?: 0,
                        'percent' => intval($pre_total['count']) == 0 ? 100 : round((abs($cha_count) / intval($pre_total['count']) * 100), 2),
                        'is_plus' => $cha_count > 0 ? -1 : ($cha_count == 0 ? 0 : 1)
                    ];
                    $cha_price = round($pre_total['price'], 2) - round($total['price'], 2);
                    //$pre_total['price'] = $pre_total['price'] == 0 ? 1 : $pre_total['price'];
                    $chartdata['cycle']['price'] = [
                        'data' => $total['price'] ?: 0,
                        'percent' => (intval($pre_total['price']) == 0 || !$pre_total['price'] || $pre_total['price'] == 0.00) ? 100 : round(abs($cha_price) / $pre_total['price'] * 100, 2),
                        'is_plus' => $cha_price > 0 ? -1 : ($cha_price == 0 ? 0 : 1)
                    ];
                }
                return app('json')->success('ok', $chartdata);
                break;
            default:
                break;
        }


    }

    /**
     * 用户图表
     */
    public function userchart()
    {
        header('Content-type:text/json');

        $starday = date('Y-m-d', strtotime('-30 day'));
        $yesterday = date('Y-m-d');

        /*$user_list = UserModel::where('add_time', 'between time', [$starday, $yesterday])
            ->field("FROM_UNIXTIME(add_time,'%m-%e') as day,count(*) as count")
            ->group("FROM_UNIXTIME(add_time, '%Y%m%e')")
            ->order('add_time asc')
            ->select()->toArray();*/

        $user_list = Users::where('last_login_time', '>', $starday)
            ->field("FROM_UNIXTIME(last_login_time,'%m-%d') as day,count(*) as count")
            ->group("FROM_UNIXTIME(last_login_time, '%Y%m%d')")
            ->order('last_login_time')
            ->select()->toArray();

        $chartdata = [];
        $chartdata['legend'] = ['用户数'];//分类
        $chartdata['yAxis']['maxnum'] = 0;//最大值数量
        $chartdata['xAxis'] = [date('m-d')];//X轴值
        $chartdata['series'] = [0];//分类1值
        if (!empty($user_list)) {
            $data = [];
            foreach ($user_list as $k => $v) {
                $data['day'][]   = $v['day'];
                $data['count'][] = $v['count'];
                if ($chartdata['yAxis']['maxnum'] < $v['count'])
                    $chartdata['yAxis']['maxnum'] = $v['count'];
            }
            $chartdata['xAxis']  = $data['day'];  //X轴值
            $chartdata['series'] = $data['count'];//分类1值
        }
        return app('json')->success('ok', $chartdata);
    }

    /**
     * 待办事统计
     * @param int $newTime
     * @return false|string
     */
    public function Jnotice($newTime = 30)
    {
        header('Content-type:text/json');

        $data = [];
        $data['ordernum'] = StoreOrderModel::statusByWhere(1)->count();//待发货
        $replenishment_num = sys_config('store_stock') > 0 ? sys_config('store_stock') : 2;//库存预警界限
        //$data['inventory'] = ProductModel::where('stock', '<=', $replenishment_num)->where('is_show', 1)->where('is_del', 0)->count();//库存
        //$data['commentnum'] = StoreProductReplyModel::where('is_reply', 0)->count();//评论
        //$data['reflectnum'] = UserExtractModel::where('status', 0)->count();//提现
        $data['msgcount'] = intval($data['ordernum']) + intval($data['inventory']) + intval($data['commentnum']) + intval($data['reflectnum']);
        //新订单提醒
        $data['newOrderId'] = StoreOrderModel::statusByWhere(1)->where('is_remind', 0)->column('order_id', 'id');
        if (count($data['newOrderId'])) StoreOrderModel::where('order_id', 'in', $data['newOrderId'])->update(['is_remind' => 1]);
        return app('json')->success('ok', $data);
    }

    public function visitChart(){
        $data = [];
        $data['visit_count'] = [900, 850, 950, 1000, 1100, 1050, 1000, 1150, 1250, 1370, 1250, 1100];
        $data['regist_count'] = [850, 850, 800, 950, 1000, 950, 950, 1150, 1100, 1240, 1000, 950];
        $data['ave_visit_count'] = [870, 850, 850, 950, 1050, 1000, 980, 1150, 1000, 1300, 1150, 1000];
        return app('json')->success('ok', $data);
    }
}


