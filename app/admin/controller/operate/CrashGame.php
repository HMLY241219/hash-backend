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
 *  火箭配置
 */
class CrashGame extends AuthController
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
        $data =  request()->param();
        $rotary = $this->redis->hGetAll('crash_config');
        $data = [];
        foreach ($rotary as $k => $v){
            /*$index = explode('_',$k)[0];
            $filed = explode('_',$k)[1];
            $filed .= isset(explode('_',$k)[2]) ? "_".explode('_',$k)[2] : '';*/
            $data[] = [
                'key' => $k,
                'value' => $v,
                'name' => isset(config('game.crash_config')[$k]) ? config('game.crash_config')[$k] : '',
            ];
        }
        /*$last_names = array_column($data,'value');
        array_multisort($last_names,SORT_DESC,$data);*/

        return json(['code' => 0, 'count' => count($rotary), 'data' => $data]);
    }


    public function edit($key){

        $value = $this->redis->hGet('crash_config', $key);

        $name = isset(config('game.crash_config')[$key]) ? config('game.crash_config')[$key] : '';
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

        $this->redis->hSet('crash_config', $key, $data['value']);
        return Json::successful( '修改成功!');
    }




}

