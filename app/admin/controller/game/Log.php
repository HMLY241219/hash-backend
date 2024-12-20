<?php

namespace app\admin\controller\game;

use app\admin\controller\AuthController;
use app\admin\controller\Model;
use app\admin\model\games\GameRecords;
use app\admin\model\games\GameTable;
use crmeb\services\{FormBuilder as Form, JsonService as Json, UtilService as Util};
use think\Config;
use think\facade\Db;

class Log extends AuthController
{

    public function index()
    {
        //$game_name_type = config('game.gamename');
        $game_name_type = Db::name('slots_game')->where('terrace_id',8)->column('englishname','slotsgameid');
        $this->assign('game_name_type', $game_name_type);

        return $this->fetch();
    }

    public function get_list()
    {
        $data =  request()->param();

        $page = $data['page'] ?: 1;
        $limit = $data['limit'] ?: 30;

        $where = Model::getWhere($data);

        $filed = "id,game_type,game_id,seat_num,ai_players,user_num,bet_all,server_score,service_score,begin_time,end_time,table_level,control_win_or_loser,cards_0";
        $date = isset($data['datetable']) && $data['datetable']? $data['datetable'] : date('Y-m-d').' - '.date('Y-m-d');

        [$start,$end] = explode(' - ',$date);
        $datearray = \customlibrary\Common::createDateRange($start,$end,'Ymd');
        $dateList = array_reverse($datearray);
        [$count,$dataList] = Model::SubTablequery($dateList,'lzmj_game_table_',$filed,$where,'begin_time','desc',$page,$limit);
        if (!empty($dataList)){
            foreach ($dataList as $k=>&$v){
                if ($v['game_type'] == 1514){
                    $v['cards_0'] = bcdiv($v['cards_0'],100,2).'倍';
                }else{
                    $v['cards_0'] = '';
                }
            }
        }

        return json(['code' => 0, 'count' => $count, 'data' => $dataList]);
    }


    /**
     * 返回分页数据表的后缀，以及page和limit
     * @param $page 当前第几页
     * @param $limit 分页的数量
     * @param $DBData ['20230315' => 10 ,'20230316' => 20]  分表的后缀加上条数
     * @return array
     */
    public function pageSelectDBData($page,$limit,$DBData){

        $retData = [];
        $pushIdx = 0;
        $breaked = false;
        $endIdx = $page * $limit;
        $startIdx = ($page - 1) * $limit;

        foreach ($DBData as $k => $v){
            for ($j=0;$j<$v;$j++){
                $pushIdx += 1;
                if($pushIdx >= $startIdx && $pushIdx < $endIdx){
                    array_push($retData,[$k,$j]);
                }
                if($pushIdx > $endIdx){
                    $breaked = true;
                    break;
                }
            }
            if($breaked){
                break;
            }
        }
        $statusarray= [];
        $tablearray = [];

        foreach ($retData as $value){
            if(in_array($value[0],$statusarray)){
                $tablearray[$value[0]]['limit'] += 1;
            }else{
                $tablearray[$value[0]]['page'] = $value[1];
                $tablearray[$value[0]]['limit'] = 1;
                array_push($statusarray,$value[0]);
            }
        }

        return $tablearray;
    }

    public function details($id, $date = '')
    {


        $info = (new GameTable())->getInfo($id, $date);

        !$info && exit("Data not found, game_id [{$id}] too long!");

        $this->assign('info', $info->toArray());
        $userList = $info->records->toArray();
        /*foreach ($userList as &$v){
            $v['user_type'] = Db::name('userinfo')->where('uid',$v['uid'])->value('user_type');
        }*/


        $this->assign('dataList',$userList );

        return $this->fetch();
    }


    /**
     * @return void 牌局日志
     */
    public function view($id, $date = ''){
        $date  = $date ?: strtotime('00:00:00');
        $sql = "SHOW TABLES LIKE 'lzmj_game_table_".date('Ymd',$date)."'";
        if(!Db::query($sql)){
            return json(['code' => 101,'msg' => '数据表不存在']);
        }
        $table_log = Db::name('game_table_'.date('Ymd',$date))->where('game_id|id',$id)->value('table_log');
        $this->assign('table_log', $table_log);
        return $this->fetch();
    }

}