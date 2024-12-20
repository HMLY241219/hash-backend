<?php

namespace app\admin\controller\operate;
use app\admin\controller\AuthController;
use app\admin\model\ump\ExecPhp;
use crmeb\services\{FormBuilder as Form, JsonService as Json, UtilService as Util};
use think\facade\App;
use think\facade\Config;
use think\facade\Db;
use app\admin\controller\Model;
/**
 *  飞机假数据配置
 */
class JiaAviatorConfig extends AuthController
{

    private $redis;
    public function __construct(App $app)
    {
        parent::__construct($app);
        $redis = new \Redis();
        $redis->connect(Config::get('redis.ip'), 5502);
        $this->redis = $redis;
    }


    public function index()
    {

        return $this->fetch();
    }


    public function getlist(){

        $where = $this->request->param();
        $where_game_id = $where['game_id'] ?? '';
        $rotary = $this->redis->hGetAll('RobotNum');

//        $Aviator = config('game.AviatorStock');
//        foreach ($Aviator as  $key =>$v){
//            for ($i = 0; $i <= 24; $i++){
//                $this->redis->hSet('RobotNum', $key.'_'.$i, '100');
//            }
//        }
//        dd(111);
        // 自定义排序函数
        uksort($rotary, function($a, $b) {
            // 提取 _ 前面的部分
            $a_prefix = (int)substr($a, 0, strpos($a, '_'));
            $b_prefix = (int)substr($b, 0, strpos($b, '_'));

            // 如果 _ 前面的部分相同，则比较 _ 后面的部分
            if ($a_prefix === $b_prefix) {
                $a_suffix = (int)substr($a, strpos($a, '_') + 1);
                $b_suffix = (int)substr($b, strpos($b, '_') + 1);
                return $a_suffix - $b_suffix;
            }

            // 否则，比较 _ 前面的部分
            return $a_prefix - $b_prefix;
        });
        $Aviator = config('game.AviatorStock');

        $data = [];
        foreach ($rotary as $k => $v){
            [$game_id,$time] = explode('_',$k);
            if($where_game_id && $game_id != $where_game_id)continue;
            if(!isset($Aviator[$game_id]))continue;
            $data[] = [
                'game_id' => $game_id,
                'game_name' => $Aviator[$game_id] ?? '',
                'time' => $time,
                'value' => $v,
            ];
        }

        return json(['code' => 0, 'count' => count($data), 'data' => $data]);
    }


    public function edit($game_id,$time){

        $RobotNum = $this->redis->hGet('RobotNum', $game_id.'_'.$time);
        $Aviator = config('game.AviatorStock');

        $name = $Aviator[$game_id] ?? '';
        $f = [];
        $f[] = Form::input('game_id', '游戏ID',$game_id)->disabled(true);
        $f[] = Form::input('name', '名称',$name)->disabled(true);
        $f[] = Form::input('time', '时间',$time)->disabled(true);
        $f[] = Form::input('value', '值',$RobotNum)->required();

        $form = Form::make_post_form('修改数据', $f, url('save'));
        $this->assign(compact('form'));
        return $this->fetch('public/form-builder');
    }


    /**
     * @return void 修改数据
     */
    public function save($game_id,$time){
        $data = request()->post();

        $this->redis->hSet('RobotNum', $game_id.'_'.$time, $data['value']);
        return Json::successful( '修改成功!');
    }




}




