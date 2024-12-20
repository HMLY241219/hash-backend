<?php
namespace app\api\controller\user;

use think\facade\Db;

use crmeb\basic\BaseController;
use customlibrary\Common;
use app\api\controller\ReturnJson;
/**
 *  用户提现信息
 */
class Withinfo extends BaseController{


    public function delete(){
        $uid = input('uid');
        $account = input('account');
        $res = Db::name('user_withinfo')->where(['uid' => $uid],['account' => $account])->delete();
        if(!$res){
            return ReturnJson::failFul();
        }
        return ReturnJson::successFul();
    }

    /**
     * @return void 用户提现银行卡UIP列表
     */
    public function index(){
        $type = input('type') ?: 1;//类型:1=CPF,2=CNPJ,3=EMAIL,4=PHONE,5=EVP
        $uid = input('uid');
        $user_withinfo = Db::name('user_withinfo')->where([['uid' ,'=', $uid],['type' ,'=',$type]])->find();
//        return json(['code' => 200 ,'msg'=>'','data' =>$user_withinfo ]);
        return ReturnJson::successFul(200, $user_withinfo);
    }


    /**
     * 用户提现银行卡UIP添加与修改
     * @return void
     */
    public function add(){
        $type = input('type') ?: 1; //类型:1=CPF,2=CNPJ,3=EMAIL,4=PHONE,5=EVP
        $uid = input('uid');
        $account = trim(base64_decode(input('account')));  //账户信息
        $cpf = input('cpf') ?  trim(base64_decode(input('cpf'))) : '';  //CPF/CNPJ

        //效验数据格式是否正确
        [$code,$cpf] = self::verify($type,$account,$cpf);
        if($code != 200) return ReturnJson::failFul($code);

        $user_withinfo = Db::name('user_withinfo')->where([['uid' ,'=', $uid],['type' ,'=',$type]])->find();

        if($user_withinfo){  //修改
            $data = [
                'account' => $account,
                'cpf' => $cpf,
                'updatetime' => time(),
            ];
            $res = Db::name('user_withinfo')->where('id',$user_withinfo['id'])->update($data);
            if(!$res) return ReturnJson::failFul(237);
            $user_withinfo_id = $user_withinfo['id'];
        }else{  //添加
            if($type != 1 && $type != 2 && $type != 3 && $type != 4 && $type != 5 ) return ReturnJson::failFul(232);
            [$code,$cpf] = self::verify($type,$account,$cpf);
            if($code != 200) return ReturnJson::failFul($code);
            $data = [
                'uid' => $uid,
                'account' => $account,
                'cpf' => $cpf,
                'type' => $type,
                'status' => 1,
                'createtime' => time(),
            ];

            $user_withinfo_id = Db::name('user_withinfo')->insertGetId($data);
            if(!$user_withinfo_id) return ReturnJson::failFul(238);

        }


        self::editstatus($user_withinfo_id,$uid);
//        return json(['code' => 200 ,'msg'=>'success','data' =>$data ]);
        return ReturnJson::successFul();
    }


    private static function verify($type,$account,$cpf){

        if($type == 3 && $account && !Common::PregMatch($account,'email')){
            return [232,$cpf];
        }elseif ($type == 4 && $account && !Common::PregMatch($account,'phone')){
            return [203,$cpf];
        }elseif ($type == 1 &&$account){
            if(!Common::PregMatch($account,'cpf'))return [233,$cpf];
            $cpf = $account;
        }elseif ($type == 2 && $account){
            if(!Common::PregMatch($account,'cnpj'))return [234,$cpf];
            $cpf = $account;
        }elseif ($cpf){
            if(!Common::PregMatch($cpf,'cpf') && !Common::PregMatch($cpf,'cnpj'))return [235,$cpf];
        }
        return [200,$cpf];
    }


    /**
     * 修改用户提现信息默认值
     * @return void
     */
    public static function editstatus($id,$uid){

        //判断前端提交的数据是否正确
        $user_withinfo = Db::name('user_withinfo')->where([['id' ,'=', $id],['uid' ,'=',$uid]])->find();
        if(!$user_withinfo){
            return true;
        }

        Db::startTrans();
        $res = Db::name('user_withinfo')->where([['uid' ,'=' , $uid],['id' ,'<>',$id]])->find();
        if($res){
            $res = Db::name('user_withinfo')->where([['uid' ,'=' , $uid],['id' ,'<>',$id]])->update(['status'=> '-1','updatetime'=>time()]);
            if(!$res){
                Db::rollback();
                return false;
            }
        }
        $res = Db::name('user_withinfo')->where('id','=',$id)->update(['status' => 1,'updatetime'=>time()]);
        if(!$res){
            Db::rollback();
            return false;
        }

        Db::commit();
//        return json(['code' => 200 ,'msg'=>'success','data' =>[] ]);
        return true;
    }


}
