<?php
namespace app\api\controller;

use think\facade\Db;
use crmeb\basic\BaseController;

class Help extends BaseController{

    /**
     * @return 提包创建配置
     */
    public function create_app(){
        $package      = 'com.win3377.amzingAD';  //包名com.win3377.sharewin
        $package_end  = 'amzingAD';  //包名后缀
        $package_name = 'amzingAD线上包'; //括号后面就是游戏名

        $apppackage = Db::name('apppackage')->where('appname','like','%'.$package_end)->find();
        if($apppackage){
            return json(['code' => 201,'msg'=>'包名后缀已使用','data' => []]);
        }

        //增加包名
        $package_id = Db::name('apppackage')->insertGetId(['bagname' => $package_name,'appname' => $package]);
        if(!$package_id){
            return json(['code' => 201,'msg'=>'包名已使用','data' => []]);
        }

        $apppackage_config = [
            'package_id' => $package_id,
            'appname' => $package,
            'updatetime' => time(),
        ];

        $res = Db::name('apppackage_config')->insert($apppackage_config);
        if(!$res){
            return json(['code' => 201,'msg'=>'包配置失败','data' => []]);
        }

        //获取上个包的主渠道
        $olecid =Db::name('chanel')->where(['type' => 1,'level' => 1])->order('channel','desc')->value('channel');
        $cid = $olecid + 10000;

        $chanel = [
            'channel' => $cid,
            'cname' => $package_name.'自然量默认渠道',
            'appname' => $package,
            'package_id' => $package_id,
            'ppackage_id' => $package_id,
            'updatetime' => time(),
            'remark' => '提包系统生成',
            'type' => 1,
        ];
        $res = Db::name('chanel')->insert($chanel);
        if(!$res){
            return json(['code' => 201,'msg'=>'默认主渠道生成失败','data' => []]);
        }

        $cid = $cid + 10;

        $chanel = [
            'channel' => $cid,
            'cname' => $package_name.'广告默认渠道',
            'appname' => $package,
            'package_id' => $package_id,
            'ppackage_id' => $package_id,
            'updatetime' => time(),
            'remark' => '提包系统生成',
            'type' => 2,
        ];
        $res = Db::name('chanel')->insert($chanel);
        if(!$res){
            return json(['code' => 201,'msg'=>'默认主渠道生成失败','data' => []]);
        }



        return json(['code' => 200,'msg'=>'包配置成功','data' => []]);
    }

}
