<?php
namespace dateTime;

use app\api\controller\Vip;
use service\NewjsonService;
use think\facade\Config;
use think\facade\Db;
use think\facade\Log;

class dateTime{
    /**
     * @param $time 获取最近的7天日期
     */
    public static function get7day($time = '', $format='Y-m-d'){
        $time = $time != '' ? $time : time();
        //组合数据
        $date = [];
        for ($i=0; $i<=6; $i++){
            $date[$i] = date($format ,strtotime( '+' . ($i-6) .' days', $time));
        }
        return $date;
    }


    /**
     * @param $mydate 获取年龄 2019-10-12
     */
    public static function age($mydate){
        $birth=$mydate;
        list($by,$bm,$bd)=explode('-',$birth);
        $cm=date('n');
        $cd=date('j');
        $age=date('Y')-$by-1;
        if ($cm>$bm || $cm==$bm && $cd>=$bd) $age++;
        return $age;

    }


    /**
     *  $person_age_min 最小年龄
     *  $person_age_max 最大年龄
     * @return string 根据输入年龄计算最早和最晚的出生年月
     */
    public static function Age_calculation_birthday($person_age_min = '',$person_age_max = ''){

        $year = date('Y');
        $month = date('m');
        $day = date('d');
        $max_birth = '';
        $min_birth = '';
// 用户输入了最小年龄和最大年龄
        if(isset($person_age_min) && isset($person_age_max)){

            $min = min($person_age_min, $person_age_max);
            $max = max($person_age_min, $person_age_max);
            # 计算最大年龄的最早出生日期
            $max_year = $year - $max - 1;
            $max_birth = date('Y-m-d', strtotime("+1 day", strtotime($max_year.'-'.$month.'-'.$day)));
            # 计算最小年龄的最后出生日期
            $min_year = $year-$min;
            $min_birth = $min_year.'-'.$month.'-'.$day;
        }elseif(isset($person_age_min)  && !isset($person_age_max)){ //用户只输入了最小年龄

            # 计算最大年龄的最早出生日期
            $max_year = $year - $person_age_min - 1;
            $max_birth = date('Y-m-d', strtotime("+1 day", strtotime($max_year.'-'.$month.'-'.$day)));
            # 计算最小年龄的最后出生日期
            $min_year = $year-$person_age_min;
            $min_birth = $min_year.'-'.$month.'-'.$day;
        }elseif(!isset($person_age_min)  && isset($person_age_max)) { // 用户只输入了最大年龄

            # 计算最大年龄的最早出生日期
            $max_year = $year - $person_age_max - 1;
            $max_birth = date('Y-m-d', strtotime("+1 day", strtotime($max_year.'-'.$month.'-'.$day)));
            # 计算最小年龄的最后出生日期
            $min_year = $year-$person_age_min;
            $min_birth = $min_year.'-'.$month.'-'.$day;
        }

        return ['min_birth' => $min_birth , 'max_birth' =>$max_birth]; //年龄越小时间戳越大
//        return $min_birth.' ==== '.$max_birth;
//        if(!empty($min_birth) && !empty($max_birth)){
//            // sql语句
//            $sql = "select * from user where birth between $max_birth and $min_birth";
//
//        }

    }


    /**	获取指定时间后几个月的今天
     * @param $date 开始时间 '2018-1-30 15:54:20'
     * @param $number  后面几个月 '6'
     * @param $type  'ymdhis' =  'Y-m-d H:i:s' ,  'ymd' = ‘Y-m-d’
     * @return string
     */

    public static function getNextMonthDays($date,$number,$type = 'ymdhis'){
        $firstday = date('Y-m-01', strtotime($date));
        $lastday = strtotime("$firstday +".($number + 1)." month -1 day");
        $day_lastday = date('d', $lastday); //获取下个月份的最后一天
//        $day_benlastday = date('d', strtotime("$firstday +1 month -1 day")); //获取本月份的最后一天
        //获取当天日期
        $Same_day = date('d', strtotime($date));

        //判断当天是否是最后一天   或 下月最后一天 等于 本月的最后一天
        if($Same_day > $day_lastday){
            $day = $day_lastday;

        }else{
            $day = $Same_day;

        }
        if($type == 'ymdhis'){
            $day = date('Y',$lastday).'-'.date('m',$lastday).'-'.$day.' '.date('H:i:s',strtotime($date));
        }else{
            $day = date('Y',$lastday).'-'.date('m',$lastday).'-'.$day;
        }

        return $day;

    }


    /**
     * 计算2个时间相差的,天数，时分秒， 倒计时时间
     * @param $starttime 开始时间时间戳
     * @param $endtime 结束时间时间戳
     * @return void
     */
    public static function CountDown($starttime,$endtime){
        if($starttime >= $endtime){
            $maxtime = $starttime;
            $mintime = $endtime;
        }else{
            $maxtime = $endtime;
            $mintime = $starttime;
        }

        $activity['day'] = floor(($maxtime-$mintime)/86400);

        $activity['hour'] = floor(($maxtime-$mintime)%86400/3600);

        $activity['minute'] = floor(($maxtime-$mintime)%86400%3600/60);

        $activity['second'] = floor(($maxtime-$mintime)%86400%3600%60);

        return $activity;
    }


    /** 判断当前时间是否在每天的某一时间区域内
     * @param $startdate  9:00
     * @param $enddate 18:00
     * @return int
     */
    public static function get_curr_time_section($startdate,$enddate){
        $checkDayStr = date('Y-m-d ',time());
        $timeBegin1 = strtotime($checkDayStr.$startdate.":00");
        $timeEnd1 = strtotime($checkDayStr.$enddate.":00");

        $curr_time = time();

        if($curr_time >= $timeBegin1 && $curr_time <= $timeEnd1)
        {
            return true;
        }

        return false;

    }

    /**
     * 返回开始时间和结束时间的所有天数
     * Returns every date between two dates as an array
     * @param string $startDate the start of the date range  2022-12-12
     * @param string $endDate the end of the date range   2023-02-16
     * @param string $format DateTime format, default is Y-m-d
     * @return array returns every date between $startDate and $endDate, formatted as "Y-m-d"
     */
    public static function createDateRange($startDate, $endDate, $format = "Y-m-d")
    {

        $startDate = is_numeric($startDate) ? date('Y-m-d',$startDate) : $startDate;
        $endDate = is_numeric($endDate) ? date('Y-m-d',$endDate) : $endDate;
        $begin = new \DateTime($startDate);
        $end = new \DateTime(date('Y-m-d',strtotime($endDate .' +1 day')));

        $interval = new \DateInterval('P1D'); // 1 Day

        $dateRange = new \DatePeriod($begin, $interval, $end);

        $range = [];

        foreach ($dateRange as $date) {
            $range[] = $date->format($format);
        }

        return $range;
    }


    /**
     * @param $time 时间戳
     * @return false|string 获取上个月的今天
     */
    public static function preMonthDay($time)
    {
        $preMonth = mktime(0, 0, 0,
            date("n", $time), 0, date("Y", $time)); //上个月最后一天的时间戳

        $preMonthMaxDay =  date("t", $preMonth);  //上个月的最大天数

        //如果当前月的最大天数大于上个月的最大天数，则以上个月的最大天数为准 比如3月31的上个月今天就是2月28或29
        if ($preMonthMaxDay < date("j", $time)) {
            return date("Y-m-d", $preMonth);
        }

        return date(date("Y-m", $preMonth) . "-d", $time);
    }


    /**
     * 返回指定天数的开始日期
     * @param $days 天数
     * @param $type 类型:1=时间戳 2=日期
     * @param $status 是否包含今天  true 是  false 否
     * @return array
     */
    public static function getStartTimes($days,$type = 1,$status = true){
        $startTimes = array();
        $now = time();
        $start = $status ? 0 : 1;
        if($type == 1){
            for ($i = $start; $i < $days; $i++) {
                $startTimes[] = strtotime(date('Y-m-d 00:00:00', $now - 86400 * $i));
            }
        }else{
            for ($i = $start; $i < $days; $i++) {
                $startTimes[] = date('Y-m-d 00:00:00', $now - 86400 * $i);
            }
        }

        return $startTimes;
    }


    /**
     * 获取指定时间戳的当周的开始时间和结束时间
     * @param $time
     * @return void
     */
    public static function startEndWeekTime($time){
        $sdefaultDate = date("Y-m-d", $time);
        //获取当前周的第几天 周日是 0 周一到周六是 1 - 6
        $w = date('w', strtotime($sdefaultDate));
        //获取本周开始日期，如果$w是0，则表示周日，减去 6 天
        $week_start = strtotime("$sdefaultDate -" . ($w ? $w - 1 : 6) . ' days');
        //本周结束日期
        $week_end = strtotime(date('Y-m-d',$week_start)." +6 days") + 86399;

        return [$week_start,$week_end];
    }
}
