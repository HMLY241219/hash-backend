<?php

namespace app\admin\common;

use app\api\controller\My;
use customlibrary\Common;
use think\facade\Db;

class Retention{

    private static $type = [
        'statistics_retained' => 1,
        'statistics_retentionpaid' => 2,
        'statistics_retentionpaidlg' => 3,
        'statistics_retainedwithlg' => 4,
    ];

    /**
     *
     * @return void 获取一个区间的时间
     * @param $data 查询数据
     * @param $filed 字段
     */
    public static function getIntervalTime($data = [],$filed = 'date'){
        if(isset($data[$filed]) && $data[$filed]){
            [$start,$end] = explode(' - ',$data[$filed]);
            $date = Common::createDateRange($start,$end);
            $list = [];
            foreach ($date as $v){
                $list[] = strtotime($v);
            }
            return array_reverse($list);
        }
        return Common::getStartTimes(62); //返回30日开始时间戳;

    }

    /**
     * 获取留存数据
     * @param $table  数据表
     * @param $data 网页的条件
     * @param $zdy_where 自定义条件
     * @param $filed 字段
     * @return void
     */
    public static function getlist($table,$data = [],$zdy_where = [],$filed = 'date'){
        //统计当日数据

//        My::statisticsRetained(self::$type[$table],1,strtotime('00:00:00'));
        $dateArray = self::getIntervalTime($data,$filed);
        $minTime = min($dateArray);
        $tableList = Db::name($table)
            ->where($zdy_where)
            ->where('time','>=',$minTime)
            ->group('time')
            ->column("time,sum(num) as num,sum(day2) as day2,sum(day3) as day3,sum(day4) as day4,sum(day5) as day5,
            sum(day6) as day6,sum(day7) as day7,sum(day8) as day8,sum(day9) as day9,sum(day10) as day10,sum(day11) as day11,
            sum(day12) as day12,sum(day13) as day13,sum(day14) as day14,sum(day15) as day15,sum(day16) as day16,
            sum(day17) as day17,sum(day18) as day18,sum(day19) as day19,sum(day20) as day20,sum(day21) as day21,
            sum(day22) as day22,sum(day23) as day23,sum(day24) as day24,sum(day25) as day25,sum(day26) as day26,
            sum(day27) as day27,sum(day28) as day28,sum(day29) as day29,sum(day30) as day30,sum(day45) as day45",'time');
        $oldList = [];

        foreach ($dateArray as $v){
            $oldList[] = $tableList[$v] ?? self::tableNullData($v);
        }
//dd($dateArray);
        $list = [];
        foreach ($oldList as $value){
            if(date('Y-m-d',$value['time']) == date('Y-m-d'))continue;
            $list[] = self::getValue($value);
        }

        $count = count($list);
        //计算平均
        $num = 0;
        $js_num2 = 0;
        $js_num3 = 0;
        $js_num4 = 0;
        $js_num5 = 0;
        $js_num6 = 0;
        $js_num7 = 0;
        $js_num8 = 0;
        $js_num9 = 0;
        $js_num10 = 0;
        $js_num11 = 0;
        $js_num12 = 0;
        $js_num13 = 0;
        $js_num14 = 0;
        $js_num15 = 0;
        $js_num16 = 0;
        $js_num17 = 0;
        $js_num18 = 0;
        $js_num19 = 0;
        $js_num20 = 0;
        $js_num21 = 0;
        $js_num22 = 0;
        $js_num23 = 0;
        $js_num24 = 0;
        $js_num25 = 0;
        $js_num26 = 0;
        $js_num27 = 0;
        $js_num28 = 0;
        $js_num29 = 0;
        $js_num30 = 0;
        $js_num45 = 0;
        $day_count = 0;
        $day2 = 0;
        $day3 = 0;
        $day4 = 0;
        $day5 = 0;
        $day6 = 0;
        $day7 = 0;
        $day8 = 0;
        $day9 = 0;
        $day10 = 0;
        $day11 = 0;
        $day12 = 0;
        $day13 = 0;
        $day14 = 0;
        $day15 = 0;
        $day16 = 0;
        $day17 = 0;
        $day18 = 0;
        $day19 = 0;
        $day20 = 0;
        $day21 = 0;
        $day22 = 0;
        $day23 = 0;
        $day24 = 0;
        $day25 = 0;
        $day26 = 0;
        $day27 = 0;
        $day28 = 0;
        $day29 = 0;
        $day30 = 0;
        $day45 = 0;
        if (!empty($list)){
            foreach ($list as $lk=>$lv){
                if ($lv['num'] > 0) {
                    $num += (int)$lv['num'];
                    $day_count += 1;
                }
                if ($lk >= 2){
                    $js_num2 += (int)$lv['num'];
                    if ($lv['day2']) {
                        $val = preg_replace("#^.*?\((.*?)\).*?$#us", "$1", $lv['day2']);
                        $day2 += (int)$val;
                    }
                }
                if ($lk >= 3){
                    $js_num3 += (int)$lv['num'];
                    if ($lv['day3']) {
                        $val = preg_replace("#^.*?\((.*?)\).*?$#us", "$1", $lv['day3']);
                        $day3 += (int)$val;
                    }
                }
                if ($lk >= 4){
                    $js_num4 += (int)$lv['num'];
                    if ($lv['day4']) {
                        $val = preg_replace("#^.*?\((.*?)\).*?$#us", "$1", $lv['day4']);
                        $day4 += (int)$val;
                    }
                }
                if ($lk >= 5){
                    $js_num5 += (int)$lv['num'];
                    if ($lv['day5']) {
                        $val = preg_replace("#^.*?\((.*?)\).*?$#us", "$1", $lv['day5']);
                        $day5 += (int)$val;
                    }
                }
                if ($lk >= 6){
                    $js_num6 += (int)$lv['num'];
                    if ($lv['day6']) {
                        $val = preg_replace("#^.*?\((.*?)\).*?$#us", "$1", $lv['day6']);
                        $day6 += (int)$val;
                    }
                }
                if ($lk >= 7){
                    $js_num7 += (int)$lv['num'];
                    if ($lv['day7']) {
                        $val = preg_replace("#^.*?\((.*?)\).*?$#us", "$1", $lv['day7']);
                        $day7 += (int)$val;
                    }
                }
                if ($lk >= 8){
                    $js_num8 += (int)$lv['num'];
                    if ($lv['day8']) {
                        $val = preg_replace("#^.*?\((.*?)\).*?$#us", "$1", $lv['day8']);
                        $day8 += (int)$val;
                    }
                }
                if ($lk >= 9){
                    $js_num9 += (int)$lv['num'];
                    if ($lv['day9']) {
                        $val = preg_replace("#^.*?\((.*?)\).*?$#us", "$1", $lv['day9']);
                        $day9 += (int)$val;
                    }
                }
                if ($lk >= 10){
                    $js_num10 += (int)$lv['num'];
                    if ($lv['day10']) {
                        $val = preg_replace("#^.*?\((.*?)\).*?$#us", "$1", $lv['day10']);
                        $day10 += (int)$val;
                    }
                }
                if ($lk >= 11){
                    $js_num11 += (int)$lv['num'];
                    if ($lv['day11']) {
                        $val = preg_replace("#^.*?\((.*?)\).*?$#us", "$1", $lv['day11']);
                        $day11 += (int)$val;
                    }
                }
                if ($lk >= 12){
                    $js_num12 += (int)$lv['num'];
                    if ($lv['day12']) {
                        $val = preg_replace("#^.*?\((.*?)\).*?$#us", "$1", $lv['day12']);
                        $day12 += (int)$val;
                    }
                }
                if ($lk >= 13){
                    $js_num13 += (int)$lv['num'];
                    if ($lv['day13']) {
                        $val = preg_replace("#^.*?\((.*?)\).*?$#us", "$1", $lv['day13']);
                        $day13 += (int)$val;
                    }
                }
                if ($lk >= 14){
                    $js_num14 += (int)$lv['num'];
                    if ($lv['day14']) {
                        $val = preg_replace("#^.*?\((.*?)\).*?$#us", "$1", $lv['day14']);
                        $day14 += (int)$val;
                    }
                }
                if ($lk >= 15){
                    $js_num15 += (int)$lv['num'];
                    if ($lv['day15']) {
                        $val = preg_replace("#^.*?\((.*?)\).*?$#us", "$1", $lv['day15']);
                        $day15 += (int)$val;
                    }
                }
                if ($lk >= 16){
                    $js_num16 += (int)$lv['num'];
                    if ($lv['day16']) {
                        $val = preg_replace("#^.*?\((.*?)\).*?$#us", "$1", $lv['day16']);
                        $day16 += (int)$val;
                    }
                }
                if ($lk >= 17){
                    $js_num17 += (int)$lv['num'];
                    if ($lv['day17']) {
                        $val = preg_replace("#^.*?\((.*?)\).*?$#us", "$1", $lv['day17']);
                        $day17 += (int)$val;
                    }
                }
                if ($lk >= 18){
                    $js_num18 += (int)$lv['num'];
                    if ($lv['day18']) {
                        $val = preg_replace("#^.*?\((.*?)\).*?$#us", "$1", $lv['day18']);
                        $day18 += (int)$val;
                    }
                }
                if ($lk >= 19){
                    $js_num19 += (int)$lv['num'];
                    if ($lv['day19']) {
                        $val = preg_replace("#^.*?\((.*?)\).*?$#us", "$1", $lv['day19']);
                        $day19 += (int)$val;
                    }
                }
                if ($lk >= 20){
                    $js_num20 += (int)$lv['num'];
                    if ($lv['day20']) {
                        $val = preg_replace("#^.*?\((.*?)\).*?$#us", "$1", $lv['day20']);
                        $day20 += (int)$val;
                    }
                }
                if ($lk >= 19){
                    $js_num21 += (int)$lv['num'];
                    if ($lv['day21']) {
                        $val = preg_replace("#^.*?\((.*?)\).*?$#us", "$1", $lv['day21']);
                        $day21 += (int)$val;
                    }
                }
                if ($lk >= 20){
                    $js_num22 += (int)$lv['num'];
                    if ($lv['day22']) {
                        $val = preg_replace("#^.*?\((.*?)\).*?$#us", "$1", $lv['day22']);
                        $day22 += (int)$val;
                    }
                }
                if ($lk >= 21){
                    $js_num23 += (int)$lv['num'];
                    if ($lv['day23']) {
                        $val = preg_replace("#^.*?\((.*?)\).*?$#us", "$1", $lv['day23']);
                        $day23 += (int)$val;
                    }
                }
                if ($lk >= 22){
                    $js_num24 += (int)$lv['num'];
                    if ($lv['day24']) {
                        $val = preg_replace("#^.*?\((.*?)\).*?$#us", "$1", $lv['day24']);
                        $day24 += (int)$val;
                    }
                }
                if ($lk >= 23){
                    $js_num25 += (int)$lv['num'];
                    if ($lv['day25']) {
                        $val = preg_replace("#^.*?\((.*?)\).*?$#us", "$1", $lv['day25']);
                        $day25 += (int)$val;
                    }
                }
                if ($lk >= 24){
                    $js_num26 += (int)$lv['num'];
                    if ($lv['day26']) {
                        $val = preg_replace("#^.*?\((.*?)\).*?$#us", "$1", $lv['day26']);
                        $day26 += (int)$val;
                    }
                }
                if ($lk >= 25){
                    $js_num27 += (int)$lv['num'];
                    if ($lv['day27']) {
                        $val = preg_replace("#^.*?\((.*?)\).*?$#us", "$1", $lv['day27']);
                        $day27 += (int)$val;
                    }
                }
                if ($lk >= 26){
                    $js_num28 += (int)$lv['num'];
                    if ($lv['day28']) {
                        $val = preg_replace("#^.*?\((.*?)\).*?$#us", "$1", $lv['day28']);
                        $day28 += (int)$val;
                    }
                }
                if ($lk >= 27){
                    $js_num29 += (int)$lv['num'];
                    if ($lv['day29']) {
                        $val = preg_replace("#^.*?\((.*?)\).*?$#us", "$1", $lv['day29']);
                        $day29 += (int)$val;
                    }
                }
                if ($lk >= 30){
                    $js_num30 += (int)$lv['num'];
                    if ($lv['day30']) {
                        $val = preg_replace("#^.*?\((.*?)\).*?$#us", "$1", $lv['day30']);
                        $day30 += (int)$val;
                    }
                }
                if ($lk >= 45){
                    $js_num45 += (int)$lv['num'];
                    if ($lv['day45']) {
                        $val = preg_replace("#^.*?\((.*?)\).*?$#us", "$1", $lv['day45']);
                        $day45 += (int)$val;
                    }
                }
            }
        }

        $num_ave = $num && $day_count ? bcdiv($num,$day_count,2) : '';
        $day_count = $day_count - 2;
        $new_data = [
            'time' => '平均',
            'num' => $num_ave,
            'day2' => $day2 && ($day_count-0) && $js_num2 ? bcmul(bcdiv($day2,$js_num2,4),100,2).'%('.bcdiv($day2,$day_count-0,2).')' : '',
            'day3' => $day3 && ($day_count-1) && $js_num3 ? bcmul(bcdiv($day3,$js_num3,4),100,2).'%('.bcdiv($day3,$day_count-1,2).')' : '',
            'day4' => $day4 && ($day_count-2) && $js_num4 ? bcmul(bcdiv($day4,$js_num4,4),100,2).'%('.bcdiv($day4,$day_count-2,2).')' : '',
            'day5' => $day5 && ($day_count-3) && $js_num5 ? bcmul(bcdiv($day5,$js_num5,4),100,2).'%('.bcdiv($day5,$day_count-3,2).')' : '',
            'day6' => $day6 && ($day_count-4) && $js_num6 ? bcmul(bcdiv($day6,$js_num6,4),100,2).'%('.bcdiv($day6,$day_count-4,2).')' : '',
            'day7' => $day7 && ($day_count-5) && $js_num7 ? bcmul(bcdiv($day7,$js_num7,4),100,2).'%('.bcdiv($day7,$day_count-5,2).')' : '',
            'day8' => $day8 && ($day_count-6) && $js_num8 ? bcmul(bcdiv($day8,$js_num8,4),100,2).'%('.bcdiv($day8,$day_count-6,2).')' : '',
            'day9' => $day9 && ($day_count-7) && $js_num9 ? bcmul(bcdiv($day9,$js_num9,4),100,2).'%('.bcdiv($day9,$day_count-7,2).')' : '',
            'day10' => $day10 && ($day_count-8) && $js_num10 ? bcmul(bcdiv($day10,$js_num10,4),100,2).'%('.bcdiv($day10,$day_count-8,2).')' : '',
            'day15' => $day15 && ($day_count-13) && $js_num15 ? bcmul(bcdiv($day15,$js_num15,4),100,2).'%('.bcdiv($day15,$day_count-13,2).')' : '',
            'day20' => $day20 && ($day_count-18) && $js_num20 ? bcmul(bcdiv($day20,$js_num20,4),100,2).'%('.bcdiv($day20,$day_count-18,2).')' : '',
            'day25' => $day25 && ($day_count-23) && $js_num25 ? bcmul(bcdiv($day25,$js_num25,4),100,2).'%('.bcdiv($day25,$day_count-23,2).')' : '',
            'day30' => $day30 && ($day_count-28) && $js_num30 ? bcmul(bcdiv($day30,$js_num30,4),100,2).'%('.bcdiv($day30,$day_count-28,2).')' : '',
            'day45' => $day45 && ($day_count-43) && $js_num45 ? bcmul(bcdiv($day45,$js_num45,4),100,2).'%('.bcdiv($day45,$day_count-43,2).')' : '',
            /*'day3' => $day3 && ($day_count-3) && $num_ave ? bcmul(bcdiv(bcdiv($day3,$day_count-3,2),$num_ave,4),100,2).'%('.bcdiv($day3,$day_count-3,2).')' : '',
            'day4' => $day4 && ($day_count-4) && $num_ave ? bcmul(bcdiv(bcdiv($day4,$day_count-4,2),$num_ave,4),100,2).'%('.bcdiv($day4,$day_count-4,2).')' : '',
            'day5' => $day5 && ($day_count-5) && $num_ave ? bcmul(bcdiv(bcdiv($day5,$day_count-5,2),$num_ave,4),100,2).'%('.bcdiv($day5,$day_count-5,2).')' : '',
            'day6' => $day6 && ($day_count-6) && $num_ave ? bcmul(bcdiv(bcdiv($day6,$day_count-6,2),$num_ave,4),100,2).'%('.bcdiv($day6,$day_count-6,2).')' : '',
            'day7' => $day7 && ($day_count-7) && $num_ave ? bcmul(bcdiv(bcdiv($day7,$day_count-7,2),$num_ave,4),100,2).'%('.bcdiv($day7,$day_count-7,2).')' : '',
            'day8' => $day8 && ($day_count-8) && $num_ave ? bcmul(bcdiv(bcdiv($day8,$day_count-8,2),$num_ave,4),100,2).'%('.bcdiv($day8,$day_count-8,2).')' : '',
            'day9' => $day9 && ($day_count-9) && $num_ave ? bcmul(bcdiv(bcdiv($day9,$day_count-9,2),$num_ave,4),100,2).'%('.bcdiv($day9,$day_count-9,2).')' : '',
            'day10' => $day10 && ($day_count-10) && $num_ave ? bcmul(bcdiv(bcdiv($day10,$day_count-10,2),$num_ave,4),100,2).'%('.bcdiv($day10,$day_count-10,2).')' : '',
            'day15' => $day15 && ($day_count-15) && $num_ave ? bcmul(bcdiv(bcdiv($day15,$day_count-15,2),$num_ave,4),100,2).'%('.bcdiv($day15,$day_count-15,2).')' : '',
            'day20' => $day20 && ($day_count-20) && $num_ave ? bcmul(bcdiv(bcdiv($day20,$day_count-20,2),$num_ave,4),100,2).'%('.bcdiv($day20,$day_count-20,2).')' : '',
            'day25' => $day25 && ($day_count-25) && $num_ave ? bcmul(bcdiv(bcdiv($day25,$day_count-25,2),$num_ave,4),100,2).'%('.bcdiv($day25,$day_count-25,2).')' : '',
            'day30' => $day30 && ($day_count-30) && $num_ave ? bcmul(bcdiv(bcdiv($day30,$day_count-30,2),$num_ave,4),100,2).'%('.bcdiv($day30,$day_count-30,2).')' : '',
            'day45' => $day45 && ($day_count-45) && $num_ave ? bcmul(bcdiv(bcdiv($day45,$day_count-45,2),$num_ave,4),100,2).'%('.bcdiv($day45,$day_count-45,2).')' : '',*/
        ];
        array_unshift($list,$new_data);
        //dd($list);
        //dd(bcdiv($num,$day_count,2));

        return [$list ,$count];

    }




    /**
     * 当某一天的没有数据的情况
     * @param $v 某一天的开始时间
     * @return array
     */
    private static function tableNullData($v){
        return [
            'time' => $v,
            'num' => 0,
            'day2' => 0,
            'day3' => 0,
            'day4' => 0,
            'day5' => 0,
            'day6' => 0,
            'day7' => 0,
            'day8' => 0,
            'day9' => 0,
            'day10' => 0,
            'day11' => 0,
            'day12' => 0,
            'day13' => 0,
            'day14' => 0,
            'day15' => 0,
            'day16' => 0,
            'day17' => 0,
            'day18' => 0,
            'day19' => 0,
            'day20' => 0,
            'day21' => 0,
            'day22' => 0,
            'day23' => 0,
            'day24' => 0,
            'day25' => 0,
            'day26' => 0,
            'day27' => 0,
            'day28' => 0,
            'day29' => 0,
            'day30' => 0,
            'day45' => 0,
        ];
    }

    /**
     * 获取参数的值
     * @param $value
     * @return void
     */
    private static function getValue($value){
        $data['time'] = date('Y-m-d',$value['time']);
        $data['num'] = $value['num'] ?: '';
        $i = [2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25,26,27,28,29,30,45];
        foreach ($i as $val){
            $data['day'.$val] = $data['num'] && $value['day'.$val] ? bcmul(bcdiv($value['day'.$val],$data['num'],4),100,2).'%('.$value['day'.$val].')' :'';
        }

        return $data;
    }
}
