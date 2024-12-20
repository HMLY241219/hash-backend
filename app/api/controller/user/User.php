<?php
namespace app\api\controller\user;

use app\api\controller\ReturnJson;
use think\facade\Db;
use crmeb\basic\BaseController;
/**
 *  用户信息
 */
class User extends BaseController{
    /**
     * @return void 上传用户头像
     */
    public function uploadImage(){
        $image = input('file');
        $path= root_path() .'public/uploads/useravatar';
        if(!file_exists($path)){
            //检查是否有该文件夹，如果没有就创建，并给予最高权限
            mkdir($path,0777,true);
        }
        $file = file_get_contents($image);
        $fileName = '/'.rand(0000,1111).time().".png";
        $res = file_put_contents($path .$fileName,$file);
        if(!$res) return json(['code' => 201,'data' => []]);
        return json(['code' => 200,'data' => '/public/uploads/useravatar'.$fileName]);
    }

    /**
     * @return void 获取用户的一些详情
     */
    public function view(){
        $uid = input('uid');
        $userinfo = Db::name('userinfo')
            ->field('coin,bonus')
            ->where('uid',$uid)
            ->find();
        return ReturnJson::successFul(200,$userinfo);
    }

    /**
     * 用户Cash和Bonus流水记录
     * @return void
     */
    public function UserWaterLog(){
        $uid = input('uid');
        $type = input('type') ?? 1;//类型1=Cash,2=Bonus
        $page = input('page') ?? 1; //当前页数
        $table = $type == 1 ? 'br_coin_' : 'br_bonus_';
        $field = "FROM_UNIXTIME(createtime,'%d/%m/%Y %H:%i') as createtime,num,reason";
        $where = [['uid','=',$uid],['type','=',1],['reason','<>',3]];
        $dateArray = \dateTime\dateTime::createDateRange(strtotime('-30 day'),time(),'Ymd');
        $dayDescArray = array_reverse($dateArray);
        $list = \app\admin\controller\Model::SubTableQueryPage($dayDescArray,$table,$field,$where,'createtime',$page);

        return ReturnJson::successFul(200,$list);
    }


    /**
     * @return void 获取用户类型
     * @param $uid 用户uid
     */
    public static function getUserType($uid){
        $share_strlog = Db::name('share_strlog')->field('puid,channel,af_status,package_id')->where('uid',$uid)->find();
        if(!$share_strlog)  return 2;
        if($share_strlog['af_status'] == 1){  //广告量
            return 1;
        }elseif (in_array($share_strlog['package_id'],[1,31])){ //分享量
            return 3;
        }else{ //自然量
            return 2;
        }

    }

    /**
     * 判断用户是否首次提现并返回金额
     * @param $uid
     * @return mixed
     */
    public static function getUserWithStatus($uid){
        $money = Db::name('withdraw_log')->where([['uid','=',$uid],['status','in',[0,1,3]]])->value('money');
        return $money ?: 0;
    }
}
