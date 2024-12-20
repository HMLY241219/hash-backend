<?php

namespace app\admin\model;

use crmeb\basic\BaseModel;
use think\facade\Db;
use think\model\concern\SoftDelete;

abstract class GcModel extends BaseModel
{

    use SoftDelete;

    protected $connection = 'gc';

    protected $pk = 'id';

    protected $autoWriteTimestamp = true;

    protected $deleteTime = 'delete_time';

    protected $defaultSoftDelete = 0;

    final static function setField($id, $name, $value)
    {
        return static::update([$name => $value], ['id' => $id]);
    }

    public static function parseWhere(array $maps = [], string $suffix = '')
    {
        $model = $suffix ? (new static())->setSuffix($suffix) : new static();

        $like = $maps['like'] ?? 0;
        unset($maps['page'], $maps['limit'], $maps['like']);

        if (!empty($maps['date'])) {
            [$start, $ended] = explode(' ~ ', $maps['date']);

            $model = $model->whereBetweenTime('date', $start, $ended);
        }
        unset($maps['date']);

        if (!empty($maps['create_time'])) {
            [$start, $ended] = explode(' ~ ', $maps['create_time']);

            $model = $model->whereBetweenTime('create_time', $start, $ended);
        }
        unset($maps['create_time']);

        if (!empty($maps['reg_time'])) {
            [$start, $ended] = explode(' ~ ', $maps['reg_time']);

            $model = $model->whereBetweenTime('reg_time', $start, $ended);
        }
        unset($maps['reg_time']);

        foreach ($maps as $field => $value) {
            if ($value === '') continue;

            $model = $model
                ->when($field != 'select' && ($value || $value >= 0), function ($query) use ($field, $value) {
                    $query->where($field, '=', $value);
                })
                ->when($value && $like, function ($query) use ($field, $value) {
                    $query->whereLike($field, '%' . $value . '%', 'OR');
                })
                ->when($field == 'select', function ($query) use ($field, $value) {
                    $query->whereIn($field, $value);
                });

        }

        return $model;
    }

    final static function getDataSet($param, $suffix = '')
    {
        $count = self::parseWhere($param, $suffix)->count();
        $data  = self::parseWhere($param, $suffix)->order('id', 'desc')
            ->page($param['page'], $param['limit'])->select()->toArray();

        return compact('count', 'data');
    }

    final static function getDataMulti($param)
    {
        $built = self::builtUnionSql($param);

        $count = Db::connect('gc')->table($built . ' a')->count();
        $data  = Db::connect('gc')->table($built . ' a')->order('create_time', 'desc')
            ->withAttr('create_time', function ($value) {
                return date('Y-m-d H:i:s', $value);
            })
            ->page($param['page'], $param['limit'])->select()->toArray();

        return compact('count', 'data');
    }

    private static function builtUnionSql($param = [])
    {
        $dates = get_year_week($param['dates']);
        unset($param['dates']);

        $last = array_pop($dates);

        krsort($dates);

        $sql = [];
        foreach ($dates as $k => $vo) {
            $query = Db::connect('gc')->query("SHOW TABLES LIKE 't_wallet_log_{$vo}'");
            if ($query) {
                $sql[] = self::parseWhere($param, $vo)->buildSql();
            }
        }

        $model = self::parseWhere($param, $last);

        return $sql ? $model->unionAll($sql)->buildSql() : $model->buildSql();
    }

    /**
     * @param $tablename 主表名
     * @param $field 字段
     * @param $data 后台传入的data数据
     * @param $orderfield 排序字段
     * @param $sort 排序方式
     * @param $page page
     * @param $limit limit
     * @param $join 关联
     * @param $alias 主表别名
     * @param $date 如果有时间区间插叙的话，带上这个数据表时间字段
     * @param $zdywhere 自定义条件
     * @return array
     */
    public static function joinGetdata($tablename,$field,$data,$orderfield,$sort = 'desc',$page,$limit,$join,$alias = 'a',$date = 'createtime',$jointype = 'inner',$zdywhere = []){

        $where = self::getNewWhere($data,$date);
        if($jointype == 'inner'){
            $list['data'] = Db::connect('gc')->name($tablename)
                ->alias($alias)
                ->field($field)
                ->join($join[0],$join[1])
                ->where($where)
                ->where($zdywhere)
                ->order($orderfield,$sort)
                ->page($page,$limit)
                ->select()
                ->toArray();
            $list['count'] = Db::connect('gc')->name($tablename)
                ->alias($alias)
                ->join($join[0],$join[1])
                ->where($where)
                ->where($zdywhere)
                ->count();
        }elseif ($jointype == 'left'){
            $list['data'] = Db::connect('gc')->name($tablename)
                ->alias($alias)
                ->field($field)
                ->leftJoin($join[0],$join[1])
                ->where($where)
                ->where($zdywhere)
                ->order($orderfield,$sort)
                ->page($page,$limit)
                ->select()
                ->toArray();
            $list['count'] = Db::connect('gc')->name($tablename)
                ->alias($alias)
                ->leftJoin($join[0],$join[1])
                ->where($where)
                ->where($zdywhere)
                ->count();
        }else{
            $list['data'] = Db::name($tablename)
                ->alias($alias)
                ->field($field)
                ->rightJoin($join[0],$join[1])
                ->where($where)
                ->where($zdywhere)
                ->order($orderfield,$sort)
                ->page($page,$limit)
                ->select()
                ->toArray();
            $list['count'] = Db::name($tablename)
                ->alias($alias)
                ->rightJoin($join[0],$join[1])
                ->where($where)
                ->where($zdywhere)
                ->count();
        }
        return $list;
    }

    /**
     * @param $data  所以的筛选数据
     * @param $date  时间字段单独传入
     * @return void
     */
    public static function getNewWhere($data,$date='create_time'){

        $where = [];
        if($data){

            foreach ($data as $k => $v){
                if(isset(explode('__',$k)[1]) && explode('__',$k)[1] != 'id'){  //如果是active_id这种就直接保留
                    $k = str_replace('__','.',$k);
                }

                if(strpos($k, '/')){
                    $k = str_replace('/','_',$k);
                }
                $filed  = explode('@',$k)[0];
                $type = isset(explode('@',$k)[1]) ? explode('@',$k)[1] : '';

                if($filed == 'page' || $filed == 'limit' ||  $v == '' || $filed == 'datetable'){
                    continue; //datetable这种类型代表分表，时间筛选用于分表
                }

                if($filed == 'date'){

                    [$start,$end] = explode(' - ',$v);
                    $start = strtotime($start);
                    $end = strtotime($end.' 23:59:59');
                    $where[] = [$date,'between',"{$start},{$end}"];
                }elseif ($filed == 'create_time' || $filed == 'succ_time' || $filed == 'reg_time'){
                    [$start, $end] = explode(' ~ ', $v);
                    $start = strtotime($start);// - 60*60*11;
                    $end = strtotime($end);// - 60*60*11;
                    $where[] = [$filed,'between',"{$start},{$end}"];
                    //dd($where);
                }elseif($type){
                    switch ($type){
                        case 'like' :
                            $where[] = [$filed,$type,'%'.$v.'%'];

                            break;
                        case 'in' :
                            $where[] = [$filed,'in',$v];
                            break;
                        default:
                            $where[] = [$filed,'=',$v];
                            break;
                    }
                }elseif ($filed == 'coin'){
                    $where[] = [$filed,'=',$v*100];
                }else{
                    $where[] = [$filed,'=',$v];
                }
            }
        }

        return $where;
    }

}