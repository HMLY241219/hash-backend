<?php

namespace app\admin\common;

use app\api\controller\My;
use customlibrary\Common;
use think\facade\Db;

class Roi{

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
        return Common::getStartTimes(30); //返回30日开始时间戳;

    }

    /**
     * 获取数据
     * @param $table  数据表
     * @param $data 网页的条件
     * @param $zdy_where 自定义条件
     * @param $filed 字段
     * @return void
     */
    public static function getlist($table,$data = [],$zdy_where = [],$filed = 'date'){
        //统计当日数据

        //My::statisticsRetained(self::$type[$table],1,strtotime('00:00:00'));
        $dateArray = self::getIntervalTime($data,$filed);
        $minTime = min($dateArray);
        $tableList = Db::name($table)
            ->where($zdy_where)
            ->where('time','>=',$minTime)
            ->group('time')
            ->column("time,sum(num) as num,sum(consume) as consume,sum(recharge) as recharge,sum(withdraw) as withdraw,
            sum(day1) as day1,sum(day2) as day2,sum(day3) as day3,sum(day4) as day4,sum(day5) as day5,
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
            $list[] = self::getValue($value);
        }

        $count = count($list);
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
            'consume' => 0,
            'recharge' => 0,
            'withdraw' => 0,
            'day1' => 0,
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
        $amount_reduction_multiple = config('my.amount_reduction_multiple');  //后台金额缩小倍数

        $data = [];
        $data['time'] = date('Y-m-d',$value['time']);
        $data['num'] = $value['num'] ?: '';
        $data['consume'] = bcdiv((string)$value['consume'],100,2) ?: '';
//        $data['consume'] = $value['consume'] ?: '';
        $data['recharge'] = bcdiv((string)$value['recharge'], $amount_reduction_multiple,2) ?: '';
        $data['withdraw'] = bcdiv((string)$value['withdraw'], $amount_reduction_multiple,2) ?: '';

        $data['all_roi'] = $data['consume'] > 0 ? bcmul(bcdiv($data['recharge'],$data['consume'],4),100,2).'%' : 0;
        //$data['ltv'] = $data['num'] > 0 ? bcdiv(bcsub($data['recharge'],$data['withdraw']), $data['num'],2) : 0;
        $data['ltv'] = $data['num'] > 0 ? bcdiv($data['recharge'], $data['num'],2) : 0;

        $i = [1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25,26,27,28,29,30,45];
        $all_val = 0;
        foreach ($i as $val){
            if ($value['day' . $val]){
                $all_val += bcdiv($value['day' . $val], $amount_reduction_multiple, 2);
            }
            //$all_val = bcdiv((string)$all_val, $amount_reduction_multiple, 2);
            $data['day' . $val] = $data['consume']>0 && $value['day' . $val] ? bcmul(bcdiv($all_val, $data['consume'], 4), 100, 2) . '%(' . ($all_val) . ')' : '';
            /*if ($val == 1) {
                $data['day' . $val] = $data['consume'] && $value['day' . $val] ? bcmul(bcdiv($value['day' . $val], $data['consume'] * 100, 4), 100, 2) . '%(' . ($value['day' . $val] / 100) . ')' : '';
            }else{
                $day_val = $value['day' . $val] ? ($value['day' . $val] + $value['day1']) : 0;
                $data['day' . $val] = $data['consume'] && $value['day' . $val] ? bcmul(bcdiv($day_val, $data['consume'] * 100, 4), 100, 2) . '%(' . ($day_val / 100) . ')' : '';
            }*/
        }

        return $data;
    }
}
