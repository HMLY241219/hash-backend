<?php

namespace app\admin\controller;

use customlibrary\Common;
use think\facade\Db;
use app\admin\controller\AuthController;

class Model extends  AuthController
{

    /** is_show 开关开启或者关闭
     * 前端会传入 $param value id field  这里的id的值根据自己情况选择数据表字段
     * @param $table 数据表
     * @param $param  前端会传入 $param 中包含value id field  这里的id的值根据自己情况选择数据表字段
     * @param $wherefiled  where条件的字段
     * @param  $admin_id 管理员id
     * @return void
     */
    public static function is_show($table,array $param,$wherefiled,$admin_id){

        $res = Db::name($table)->where($wherefiled,$param['id'])->update([$param['field'] => $param['value'],'admin_id' => $admin_id,'updatetime' => time()]);$data['updatetime'] = time();
        if(!$res){
            return ['code' => 201,'msg' => '修改失败','data' => []];
        }
        return ['code' => 200,'msg' => '修改成功','data' => []];
    }


    /** lauyiedit 后台页面修改
     *
     * 前端会传入 $param value id field  这里的id的值根据自己情况选择数据表字段
     * @param $table 数据表
     * @param $param  前端会传入 $param 中包含value id field  这里的id的值根据自己情况选择数据表字段
     * @param $wherefiled  where条件的字段
     * @return void
     */
    public static function layuiedit($table,array $param,$wherefiled){
        $vaule = $param['value'];
        $where_value = $param['id'];
        $field = $param['field'];
        $res = Db::name($table)->where($wherefiled,$where_value)->update([$field => $vaule,'updatetime' => time()]);
        if(!$res){
            return ['code' => 201,'msg' => '修改失败','data' => []];
        }
        return ['code' => 200,'msg' => '修改成功','data' => []];
    }
    /**
     * @param $data  所以的筛选数据
     * @param $date  时间字段单独传入
     * @return void
     */
    public static function getWhere($data,$date='createtime'){

        $where = [];
        if($data){

            foreach ($data as $k => $v){
                if(isset(explode('_',$k)[1]) && explode('_',$k)[1] != 'id'){  //如果是active_id这种就直接保留
                    $k = str_replace('_','.',$k);
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
                }elseif($type){
                    switch ($type){
                        case 'like' :
                            $where[] = [$filed,$type,'%'.$v.'%'];

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

    public static function getWhere2($data,$date='createtime'){

        $where = [];
        if($data){

            foreach ($data as $k => $v){
                if(isset(explode('_',$k)[1]) && explode('_',$k)[1] != 'id'){  //如果是active_id这种就直接保留
                    $k = str_replace('_','.',$k);
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
                    $where[] = [$date,'between',"{$start},{$end}"];
                }elseif($type){
                    switch ($type){
                        case 'like' :
                            $where[] = [$filed,$type,'%'.$v.'%'];

                            break;
                        default:
                            $where[] = [$filed,'=',$v];
                            break;
                    }
                }else{
                    $where[] = [$filed,'=',$v];
                }
            }
        }

        return $where;
    }

    /**
     * @param $data  所以的筛选数据
     * @param $date  时间字段单独传入
     * @param $date2  时间字段单独传入
     * @return void
     */
    public static function getWhere3($data,$date='createtime',$date2='createtime'){

        $where = [];
        if($data){

            foreach ($data as $k => $v){
                if(isset(explode('_',$k)[1]) && explode('_',$k)[1] != 'id'){  //如果是active_id这种就直接保留
                    $k = str_replace('_','.',$k);
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
                }elseif ($filed == 'date2'){

                    [$start,$end] = explode(' - ',$v);
                    $start = strtotime($start);
                    $end = strtotime($end.' 23:59:59');
                    $where[] = [$date2,'between',"{$start},{$end}"];
                }elseif($type){
                    switch ($type){
                        case 'like' :
                            $where[] = [$filed,$type,'%'.$v.'%'];

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

        $where = self::getWhere($data,$date);
        if($jointype == 'inner'){
            $list['data'] = Db::name($tablename)
                ->alias($alias)
                ->field($field)
                ->join($join[0],$join[1])
                ->where($where)
                ->where($zdywhere)
                ->order($orderfield,$sort)
                ->page($page,$limit)
                ->select()
                ->toArray();
            $list['count'] = Db::name($tablename)
                ->alias($alias)
                ->join($join[0],$join[1])
                ->where($where)
                ->where($zdywhere)
                ->count();
        }elseif ($jointype == 'left'){
            $list['data'] = Db::name($tablename)
                ->alias($alias)
                ->field($field)
                ->leftJoin($join[0],$join[1])
                ->where($where)
                ->where($zdywhere)
                ->order($orderfield,$sort)
                ->page($page,$limit)
                ->select()
                ->toArray();
            $list['count'] = Db::name($tablename)
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
     * @param $tablename 主表名
     * @param $field 字段
     * @param $data 后台传入的data数据
     * @param $orderfield 排序字段
     * @param $sort 排序方式
     * @param $page page
     * @param $limit limit
     * @param $join1 关联
     * @param $join2 关联
     * @param $alias 主表别名
     * @param $date 如果有时间区间插叙的话，带上这个数据表时间字段
     * @param $zdywhere 自定义条件
     * @return array
     */
    public static function joinGetdata2($tablename,$field,$data,$orderfield,$sort = 'desc',$page,$limit,$join1,$join2,$alias = 'a',$date = 'createtime', $date2='createtime', $jointype = 'inner',$zdywhere = []){

        $where = self::getWhere3($data,$date,$date2);
        if($jointype == 'inner'){
            $list['data'] = Db::name($tablename)
                ->alias($alias)
                ->field($field)
                ->join($join1[0],$join1[1])
                ->join($join2[0],$join2[1])
                ->where($where)
                ->where($zdywhere)
                ->order($orderfield,$sort)
                ->page($page,$limit)
                ->select()
                ->toArray();
            $list['count'] = Db::name($tablename)
                ->alias($alias)
                ->join($join1[0],$join1[1])
                ->join($join2[0],$join2[1])
                ->where($where)
                ->where($zdywhere)
                ->count();
        }elseif ($jointype == 'left'){
            $list['data'] = Db::name($tablename)
                ->alias($alias)
                ->field($field)
                ->leftJoin($join1[0],$join1[1])
                ->leftJoin($join2[0],$join2[1])
                ->where($where)
                ->where($zdywhere)
                ->order($orderfield,$sort)
                ->page($page,$limit)
                ->select()
                ->toArray();
            $list['count'] = Db::name($tablename)
                ->alias($alias)
                ->leftJoin($join1[0],$join1[1])
                ->leftJoin($join2[0],$join2[1])
                ->where($where)
                ->where($zdywhere)
                ->count();
        }else{
            $list['data'] = Db::name($tablename)
                ->alias($alias)
                ->field($field)
                ->rightJoin($join1[0],$join1[1])
                ->rightJoin($join2[0],$join2[1])
                ->where($where)
                ->where($zdywhere)
                ->order($orderfield,$sort)
                ->page($page,$limit)
                ->select()
                ->toArray();
            $list['count'] = Db::name($tablename)
                ->alias($alias)
                ->rightJoin($join1[0],$join1[1])
                ->rightJoin($join2[0],$join2[1])
                ->where($where)
                ->where($zdywhere)
                ->count();
        }
        return $list;
    }

    /**
     * layui数据
     * @param $tablename
     * @param $field
     * @param $data  //前端传过来的parms参数
     * @param $orderfield
     * @param $sort
     * @param $page
     * @param $limit
     *  @param $zdywhere 自定义条件
     * @return void
     */
    public static function Getdata($tablename,$field,$data,$orderfield,$sort = 'desc',$page,$limit,$date='createtime',$zdywhere = [])
    {

        $where = self::getWhere($data,$date);

        $list['data'] = Db::name($tablename)
            ->field($field)
            ->where($where)
            ->where($zdywhere)
            ->order($orderfield,$sort)
            ->page($page,$limit)
            ->select()
            ->toArray();

        $list['count'] = Db::name($tablename)
            ->where($where)
            ->where($zdywhere)
            ->count();

        return $list;
    }

    /**
     * layui数据
     * @param $tablename
     * @param $field
     * @param $where
     * @param $orderfield
     * @param $sort
     * @param $page
     * @param $limit
     * @return void
     */
    public static function Getlist($tablename,$field,$where,$orderfield,$sort = 'desc',$page,$limit,$zdywhere= [])
    {
        $data['data'] = Db::name($tablename)
            ->field($field)
            ->where($where)
            ->where($zdywhere)
            ->order($orderfield,$sort)
            ->page($page,$limit)
            ->select()
            ->toArray();

        $data['count'] = Db::name($tablename)
            ->field("id")
            ->where($where)
            ->where($zdywhere)
            ->count();

        return $data;
    }


    /**
     * 分表查询
     *
     * @return void
     * @param $dateList [20231127,20231126] 数据表示查询这2张表
     * @param $table 数据表，要加前缀,结尾加_  'br_game_'
     * @param $filed  查询的字段
     * @param $where  查询条件
     * @param $orderField 排序的字段
     * @param $orderField 排序的字段
     * @param $sort 排序方式
     */
    public static function SubTablequery($dateList,$table,$filed,$where,$orderField,$sort = 'desc',$page = 1,$limit = 200){
        $sql = Db::table("$table" . $dateList[0])->field($filed)->where($where);

        for ($i = 1; $i < count($dateList); $i++) {
            $tables = $table.$dateList[$i];
            $res = Db::query("SHOW TABLES LIKE '$tables'");
            if(!$res){
                continue;
            }
            $sql->union(function ($query) use ($dateList, $i,$filed,$where,$table) {
                $query->table($table. $dateList[$i])->field($filed)->where($where);
            })->bind([]);
        }
        $countSql = "SELECT COUNT(*) AS count FROM (" . $sql->buildSql() . ") AS temp";
        $count = Db::query($countSql)[0]['count'];

        $dataList = $sql->limit($limit * ($page - 1), $limit)->order($orderField,$sort)->select()->toArray();
        return [$count,$dataList];
    }



    /**
     * 分表查询直接返回所有数据
     *
     * @return void
     * @param $dateList [20231127,20231126] 数据表示查询这2张表
     * @param $table 数据表，要加前缀,结尾加_  'br_game_'
     * @param $filed  查询的字段
     * @param $where  查询条件
     * @param $orderField 排序的字段
     * @param $orderField 排序的字段
     * @param $sort 排序方式
     */
    public static function SubTableQueryList($dateList,$table,$filed,$where = [],$orderField = '',$sort = 'desc'){
        $sql = Db::table("$table" . $dateList[0])->field($filed)->where($where);

        for ($i = 1; $i < count($dateList); $i++) {
            $tables = $table.$dateList[$i];
            $res = Db::query("SHOW TABLES LIKE '$tables'");
            if(!$res){
                continue;
            }
            $sql->unionAll(function ($query) use ($dateList, $i,$filed,$where,$table) {
                $query->table($table. $dateList[$i])->field($filed)->where($where);
            })->bind([]);
        }
        if($orderField){
            $list = $sql->order($orderField,$sort)->select()->toArray();
        }else{
            $list = $sql->select()->toArray();
        }
        return $list;
    }



    /**
     * 分表查询直接返回分页数据
     *
     * @return void
     * @param $dateList [20231127,20231126] 数据表示查询这2张表
     * @param $table 数据表，要加前缀,结尾加_  'br_game_'
     * @param $filed  查询的字段
     * @param $where  查询条件
     * @param $orderField 排序的字段
     * @param $orderField 排序的字段
     * @param $sort 排序方式
     */
    public static function SubTableQueryPage($dateList,$table,$filed,$where = [],$orderField = '',$page = 1,$limit = 20,$sort = 'desc'){
        $sql = Db::table("$table" . $dateList[0])->field($filed)->where($where);

        for ($i = 1; $i < count($dateList); $i++) {
            $tables = $table.$dateList[$i];
            $res = Db::query("SHOW TABLES LIKE '$tables'");
            if(!$res){
                continue;
            }
            $sql->unionAll(function ($query) use ($dateList, $i,$filed,$where,$table) {
                $query->table($table. $dateList[$i])->field($filed)->where($where);
            })->bind([]);
        }

        return $sql->page($page, $limit)->order($orderField,$sort)->select()->toArray();
    }

}
