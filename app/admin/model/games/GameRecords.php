<?php

namespace app\admin\model\games;

use crmeb\basic\BaseModel;
use think\facade\Db;

class GameRecords extends BaseModel
{
    protected $name = 'game_records_';

    public function getTimeAttr($value, $data)
    {
        return date('m-d H:i:s', $data['time_stamp']);
    }

    public function getDateAttr($value, $data)
    {
        return date('F d,Y H:i:s', $data['time_stamp']);
    }

    public function tables()
    {
        return $this->belongsTo(GameTable::class, 'game_id', 'game_id');
    }

    private function parseWhere($maps = [], $suffix = '', $field = '*')
    {
        $model = $suffix ? (new self())->setSuffix($suffix) : new self();

        $field = $field !== '*' ? $field : 'uid,game_type,game_id,final_score,bet_score,total_score,service_score,time_stamp';
        $model = $model->field($field);

        if (empty($maps)) return $model;

        $uid = $maps['uid'] ?? '';
        if (is_numeric($uid)) {
            $model = $model->where('uid', '=', $uid);
        }

        $uids = $maps['uids'] ?? '';
        if ($uids) {
            $model = $model->where('uid', 'in', $uids);
        }

        $game_id = $maps['game_id'] ?? '';
        if ($game_id) {
            $game  = strlen($game_id) > 16 ? substr($game_id, 0, 16) : $game_id;
            $model = $model->where('game_id', 'like', strval($game) . '%');
        }

        $game_type = $maps['game_type'] ?? '';
        if ($game_type) {
            $model = $model->where('game_type', '=', $game_type);
        }

        $table_level = $maps['table_level'] ?? '';
        if ($table_level) {
            $model = $model->where('table_level', '=', $table_level);
        }

        $op = $maps['score'] ?? '';
        if ($op) {
            $model = $model->where('final_score', $op, 0);
        }

        return $model;
    }

    public function getDataSet($param, $suffix = '', $field = '')
    {
        $count = $this->parseWhere($param, $suffix, $field)->count();
        $data  = $this->parseWhere($param, $suffix, $field)->order('id', 'desc');

        if (isset($param['page']) && isset($param['limit'])) {
            $data = $data->page($param['page'], $param['limit'])->select()->toArray();
            return compact('count', 'data');
        }

        //return $data->select()->toArray();
        return $data->select();
    }

    public function getInfo($id, $suffix = '', $field = '*')
    {
        return $this->parseWhere([], $suffix, $field)
            ->with([
                'tables' => function ($query) use ($suffix) {
                    $field = 'game_id,seed,issue,value_1 as result,value_2 as result2,
                    value_3 as result3,value_4 as result4,value_5 as result5,value_6 as result6,
                    cards_0,cards_1,cards_2,cards_3,cards_4,cards_5';

                    $query->name('game_table_' . $suffix)->field($field);
                }
            ])->findOrEmpty($id)->toArray();
    }

    public function getDataBy15day($param)
    {
        $now = time() + (3600 * 2.5);

        $today = date('Ymd', strtotime('-1 day', $now));
        $start = date('Ymd', strtotime('-14 day', $now));

        $date = \customlibrary\Common::createDateRange($start, $today, 'Ymd');

        krsort($date);

        $sql = [];
        foreach ($date as $vo) {
            $res = Db::query("SHOW TABLES LIKE 'lzmj_game_records_{$vo}'");
            if ($res) {
                //$sql[] = Db::name('game_records_' . $vo)->field('COUNT(*)')->select(false);
                $sql[] = $this->parseWhere($param, $vo)->buildSql();
            }
        }

        $build = $this->parseWhere($param, date('Ymd', $now))->union($sql, true)->buildSql();

        $count = Db::table($build . ' a')->count();
        $data  = Db::table($build . ' a')->order('time_stamp', 'desc')
            ->page($param['page'], $param['limit'])->select()->toArray();

        return compact('count', 'data');
    }

    public function getDataByMultiDay($param, $field = '*')
    {
        if (isset($param['dates'])) {
            [$start, $end] = explode(' ~ ', $param['dates']);
        }
        elseif (isset($param['start']) && isset($param['end'])) {
            $start = $param['start'];
            $end   = $param['end'];
        }
        else {
            $start = strtotime('-29 day');
            $end   = time();
        }

        $build = $this->builtUnionSql($start, $end, $param, $field);

        $count = Db::table($build->buildSql() . ' a')->count();
        $data  = $build->order('time_stamp', 'desc');

        if (isset($param['page']) && isset($param['limit'])) {
            $data = $data->page($param['page'], $param['limit'])->select()->toArray();
            return compact('count', 'data');
        }

        //return $data->select()->toArray();
        return $data->select();
    }

    public function getDataByMultiDay2($param, $field = '*')
    {
        if (isset($param['date']) && !empty($param['date'])) {
            [$start, $end] = explode(' - ', $param['date']);
        }
        elseif (isset($param['start']) && isset($param['end'])) {
            $start = $param['start'];
            $end   = $param['end'];
        }
        else {
            $start = strtotime('-1 day');
            $end   = time();
        }

        $build = $this->builtUnionSql($start, $end, $param, $field);

        $count = Db::table($build->buildSql() . ' a')->count();
        $data  = $build;//->order('time_stamp', 'desc');

        /*if (isset($param['page']) && isset($param['limit'])) {
            $data = $data->page($param['page'], $param['limit'])->select()->toArray();
            return compact('count', 'data');
        }*/

        return $data->select()->toArray();
//        return $data->find();
    }

    private function builtUnionSql($start, $end, $param = [], $field = '*')
    {
        $date = get_date_range($start, $end, 'Ymd');
        $last = array_pop($date);
        krsort($date);
        $sql = [];
        foreach ($date as $vo) {
            if (Db::query("SHOW TABLES LIKE 'lzmj_game_records_{$vo}'")) {
                $sql[] = $this->parseWhere($param, $vo, $field)->buildSql();
            }
        }

        $model = $this->parseWhere($param, $last, $field);
        //return $sql ? $model->unionAll($sql)->buildSql() : $model->buildSql();
        return $sql ? $model->unionAll($sql) : $model;
    }


}