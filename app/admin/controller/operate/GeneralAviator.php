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
 *  飞机普通配置
 */
class GeneralAviator extends AuthController
{

    private $redis;

    private $other = ['ControlWin' => 'ControlWin','ControlLost' => 'ControlLost','AnKou' => 'AnKou'];


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
        $data =  request()->param();
        $rotary = $this->redis->hGetAll('crash2_config');
        $config = config('game.new_crash_config');
        $data = [];
        for ($i=3; $i<=5; $i++){
            for ($j=1; $j<=16; $j++){
                $name = $config['CrashRatio'.$j] ?? '';
                $key =$i.'_'.$j;
                $data[] = [
                    'key' => 'CrashRatio'.$key,
                    'value' => $rotary['CrashRatio'.$key] ?? '',
                    'name' => in_array($i,[0,1,2]) ? '收_'.$i.'_'.$name : $i.'_'.$name,
                ];
            }
        }

        $other = $this->other;
        foreach ($other as $k => $v){
            $data[] = [
                'key' => $k,
                'value' => $rotary[$k] ?? '',
                'name' => $v,
            ];
        }

        /*$last_names = array_column($data,'value');
        array_multisort($last_names,SORT_DESC,$data);*/

        return json(['code' => 0, 'count' => count($rotary), 'data' => $data]);
    }


    public function edit($key){
        $other = $this->other;
        $value = $this->redis->hGet('crash2_config', $key);
        if(isset($other[$key])){
            $name = $other[$key];
        }else{
            $keyArray = explode('_',$key);
            $name = isset(config('game.crash_config')['CrashRatio'.$keyArray[1]]) ? config('game.crash_config')['CrashRatio'.$keyArray[1]] : '';
        }

        $f = [];
        $f[] = Form::input('key', '键名',$key)->disabled(true);
        $f[] = Form::input('name', '名称',$name)->disabled(true);
        $f[] = Form::input('value', '值',$value)->required();

        $form = Form::make_post_form('修改数据', $f, url('save',['key' => $key]));
        $this->assign(compact('form'));
        return $this->fetch('public/form-builder');
    }


    /**
     * @return void 修改数据
     */
    public function save($key){
        $data = request()->post();

        $this->redis->hSet('crash2_config', $key, $data['value']);
        return Json::successful( '修改成功!');
    }




}


