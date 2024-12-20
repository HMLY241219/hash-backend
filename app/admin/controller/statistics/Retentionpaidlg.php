<?php

namespace app\admin\controller\statistics;
use app\admin\controller\AuthController;
use crmeb\services\{FormBuilder as Form, JsonService as Json, UtilService as Util};
use think\facade\Db;
use app\admin\controller\Model;
use app\admin\common\Retention;
use think\facade\Session;

/**
 *  付费留存-再登陆
 */
class Retentionpaidlg extends AuthController
{

    private $table = 'statistics_retentionpaidlg';

    public function index()
    {
        return $this->fetch();
    }


    public function getlist(){
        $data =  request()->param();

        //平台与渠道
        $channel_where = [];
        if (!Session::get('chanel')) {
            if ($this->adminInfo['type'] == 0) {
                //$this->sqlwhere[] = ['a.channel', '<', 100000000];
            } else {
                $this->sqlwhere[] = ['a.channel', '>=', 100000000];
            }
        }

        [$list,$count] = Retention::getlist($this->table,$data,$this->sqlWhere());
        return json(['code' => 0, 'count' => $count, 'data' => $list]);
    }


    public function ReCount(){
        $f[] = Form::date('day', '处理的时间');
        $form = Form::make_post_form('重新统计', $f, url('ReCountData'));
        $this->assign(compact('form'));
        return $this->fetch('public/form-builder');
    }


    /**
     * 统计哪天的数据
     * https://inrtakeoff.3377win.com/api/Text/statisticsRetained?day=2024-09-11
     * @param $day 哪天的数据 2024-08-29
     * @param $start 开始的天数
     * @return void 用户、付费留存
     */
    public static function ReCountData($day)
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
        return Json::successful('重新统计成功');
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



    public function userList(){
        $data = $this->request->param();
        $time = strtotime($data['time']);
        $type = $data['type'];

        //平台与渠道
        $channel_where = [];
        if (!Session::get('chanel')) {
            if ($this->adminInfo['type'] == 0) {
                //$channel_where = [['channel', '<', 100000000]];
            } else {
                $channel_where = [['channel', '>=', 100000000]];
            }
        }
        $NewWhere = [];
        if (!empty($this->sqlNewWhere)){
            $NewWhere = [$this->sqlNewWhere];
        }

        $all_users = Db::name('statistics_retainedpaiduser')
            ->where('time', $time)
            ->where($channel_where)
            ->where($NewWhere)
            ->column('uids');
        $all_users = implode(",", $all_users);
        $user_day_table = 'login_'.date('Ymd',$time + ($type*86400));
        $users = Db::name($user_day_table)->whereIn('uid',$all_users)->column('uid');
        $users = implode(",",$users);

        $this->assign('users',$users);
        return $this->fetch();
    }

    public function getUserinfoList(){
        $data = $this->request->param();
//dd($data);
        $page = $data['page'] ?: 1;
        $limit = $data['limit'] ?: 30;

        $users = $data['users'] ? $data['users'] : '';
        $users_arr = explode(",",$users);
        $users_arr = array_unique($users_arr);
        if(!empty($users)){
            $list = Db::name('userinfo')
                ->field('uid,total_pay_score,total_exchange')
                ->whereIn('uid',$users_arr)
                ->order('total_pay_score','desc')
                ->order('regist_time','desc')
                ->page($page, $limit)
                ->select()
                ->toArray();
            $count = Db::name('userinfo')
                ->whereIn('uid',$users_arr)
                ->count();
            return json(['code' => 0, 'count' => $count, 'data' => $list]);
        }
        return json(['code' => 0, 'count' => 0, 'data' => []]);
    }


}



