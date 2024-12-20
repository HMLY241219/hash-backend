<?php

namespace app\admin\model\games;

use crmeb\basic\BaseModel;
use think\facade\Db;

class GameTable extends BaseModel
{
    protected $name = 'game_table_';

    protected $hidden = ['table_log'];

    protected $table = 'lzmj_game_table_';

    protected $prefix = 'lzmj_';

    public function getTimeAttr($value, $data)
    {
        return date('H:i:s', $data['begin_time']);
    }

    public function records()
    {
        return $this->hasMany(GameRecords::class, 'game_id', 'game_id');
    }

    private function parseWhere($maps = [], $suffix = '', $field = '*')
    {
        $model = $suffix ? (new self())->setSuffix($suffix) : new self();
        $model = $model->field($field);

        if (empty($maps)) return $model;

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
            $model = $model->where('server_score', $op, 0);
        }

        return $model;
    }

    public function getDataSet($param, $suffix = '', $field = '*')
    {
        $count = $this->parseWhere($param, $suffix, $field)->count();
        $data  = $this->parseWhere($param, $suffix, $field)->order('id', 'desc');

        if (isset($param['page']) && isset($param['limit'])) {
            $data = $data->page($param['page'], $param['limit'])->select()->toArray();
            return compact('count', 'data');
        }

        return $data->limit(50)->select()->toArray();
    }

    public function getVerify($id, $suffix = '', $field = '*')
    {
        return $this->parseWhere([], $suffix, $field)->findOrEmpty($id)->toArray();
    }

    public function getInfo($id, $date = '')
    {
        $suffix = is_numeric($date)
                ? date('Ymd', $date)
                : str_replace('-', '', $date);

        return $this->parseWhere([], $suffix)
            ->where(function ($query) use ($id) {
                if (strlen($id) > 13) {
//                    $game_id = substr($id, -15);
                    $query->where('game_id', '=', $id);

                }
                else {
                    $query->where('id', '=', $id);
                }
            })->with([
                'records' => function ($query) use ($suffix) {
                    $query->table('lzmj_game_records_' . $suffix)->field('*,(final_score+add_bet_15) as sy');
                }
//            ])->buildSql();
            ])->findOrEmpty();
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

        $count = Db::table($build . ' a')->count();
        $data  = $build->order('begin_time', 'desc');

        if (isset($param['page']) && isset($param['limit'])) {
            $data = $data->page($param['page'], $param['limit'])->select()->toArray();
            return compact('count', 'data');
        }

        return $data->select();
    }

    private function builtUnionSql($start, $end, $param = [], $field = '*')
    {
        $date = get_date_range($start, $end, 'Ymd');
        $last = array_pop($date);
        krsort($date);
        $sql = [];
        foreach ($date as $vo) {
            if (Db::query("SHOW TABLES LIKE 'lzmj_game_table_{$vo}'")) {
                $sql[] = $this->parseWhere($param, $vo, $field)->buildSql();
            }
        }

        $model = $this->parseWhere($param, $last, $field);
        //return $sql ? $model->unionAll($sql)->buildSql() : $model->buildSql();
        return $sql ? $model->unionAll($sql) : $model;
    }


}