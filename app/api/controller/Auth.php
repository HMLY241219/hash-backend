<?php
namespace app\api\controller;

use app\admin\model\system\SystemConfig;
use think\facade\Db;
use think\facade\Log;
use crmeb\basic\BaseController;
use customlibrary\Common;
class Auth extends BaseController {

    //Fb打点的包
    private $FbLoginPackageId = [37,39,41,35,42,43,44];
    //Adjust打点的包
    private $AdjustPackageId = [41,35,42,43,44];
    //AF打点的包
    private $AfLoginPackageId = [39,33];

    private $googleClientId = '262294838288-srsnim6tq5e06c45vfjh3kn1v0t53567.apps.googleusercontent.com';

    public function login(){
        $logintype = input('logintype');  //1=手机,2=谷歌,3=账号
        $device_id = str_replace('-','',input('deviceid')); //把-替换为空字符串设备号
        $packname = request()->packname;
        $param = $this->param;
//        $afid = input('afid');
//        $param['afid'] = $afid;
        $adid = $param['adid'] ?? '';  //	adjust的设备ID
        $gpsid = $param['gps_adid'] ?? ''; //	原始谷歌的广告ID
        $package_id = Db::name('apppackage')->where('appname',$packname)->value('id');
        if(!$package_id){
            Log::error('包ID获取失败:'.$packname);
            return ReturnJson::failFul(206);
        }

        if($logintype == 1){ //手机登录
            $phone = input('phone');
            $password = input('password');
            $type = input('type') ?? 1; //1=登录,2=注册


            //检查手机号是否正确
            if (!Common::PregMatch($phone,'phone'))return ReturnJson::failFul(206);


            if($type == 1){  //登录先检查账号密码是否正确
                $userData = Db::name('share_strlog')
                    ->field('uid,code,phone,email,nickname,avatar,package_id,channel')
                    ->where(['phone' => $phone,'password' => md5($password),'package_id' => $package_id,'status' => 1])
                    ->find();
                if(!$userData) return ReturnJson::failFul(210);
            }else{
                $res = Db::name('share_strlog')->field('uid')->where(['phone' => $phone,'package_id' => $package_id])->find();
                if($res)return ReturnJson::failFul(220);//抱歉!手机号已被注册

                $res = $this->get_channel($param,$phone,$package_id,$logintype,$packname,$device_id,$password);
                if($res['code'] != 200)return ReturnJson::failFul($res['code']);
                $userData = $res['data'];
            }


        }elseif($logintype == 2){ //谷歌登录
            $credential =input('credential');
            $sub =input('sub');
            if($sub){
                $userData = Db::name('share_strlog')
                    ->field('uid,code,phone,email,nickname,avatar,googlesub as sub,package_id,channel,1 as status')
                    ->where(['googlesub' => $sub,'status' => 1,'package_id' => $package_id])
                    ->find();
                if(!$userData)return ReturnJson::failFul(214);
            }else{
                //正式服代码
//            $client = new \Google_Client(['client_id' => $this->googleClientId]);  // Specify the CLIENT_ID of the app that accesses the backend
//            $googleInfo = $client->verifyIdToken($credential);
                //测试服代码
                $response = \curl\Curl::get("http://googlelogin.teenpatticlub.shop/api/Auth/login?credential=".$credential);
                $googleInfo = json_decode($response,true);
                if(!$googleInfo || !isset($googleInfo['sub']))return ReturnJson::failFul(214);
                $userinfo = [
                    'sub' => $googleInfo['sub'],
                    'name' => $googleInfo['name'] ?? '',
                    'avatar' => $googleInfo['picture'] ?? '',
                ];

                $userData = Db::name('share_strlog')
                    ->field('uid,code,phone,email,nickname,avatar,googlesub as sub,package_id,channel,1 as status')
                    ->where(['googlesub' => $userinfo['sub'],'status' => 1,'package_id' => $package_id])
                    ->find();
                if(!$userData){
                    $res = $this->get_channel($param,$googleInfo['sub'],$package_id,$logintype,$packname,$device_id,'',$userinfo['name'],$userinfo['avatar'],$googleInfo['email']);
                    if($res['code'] != 200)return ReturnJson::failFul($res['code']);
                    $userData = $res['data'];
                    $userData['sub'] = $userinfo['sub'];
                    $userData['status'] = 2;
                }
            }


        }elseif ($logintype == 3){  //账号登录
            $account = input('account');
            $password = input('password');
            $userData = Db::name('share_strlog')
                ->field('uid,code,phone,email,nickname,avatar,package_id,channel')
                ->where(['account' => $account,'password' => md5($password),'package_id' => $package_id,'status' => 1])
                ->find();
            if(!$userData) return ReturnJson::failFul(210);
        }else{
            Log::error('暂不支持其它登录');
            return ReturnJson::failFul(211);
        }

        //修改用户登录时间
        Db::name('userinfo')->where('uid',$userData['uid'])->update(['login_time' => time()]);

        //处理每日登录
        $this->setLogin($userData['uid'],$userData['channel'],$userData['package_id']);

        $userData['token'] = $this->setUserToken($userData['uid']);

        return ReturnJson::successFul(200,$userData);
    }


    /**
     * 用户修改密码
     * @return void
     */
    public function BindingPhone(){
        $uid = input('uid');
        $phone = input('phone'); //手机号
        $packname = request()->packname;
        $package_id = Db::name('apppackage')->where('appname',$packname)->value('id');
        if(!$package_id)return ReturnJson::failFul(206);

        //检查手机号是否正确
        if (!Common::PregMatch($phone,'phone'))return ReturnJson::failFul(206);

//
//        $res = Db::name('share_strlog')->where('uid',$uid)->value('phone');
//        if($res)return ReturnJson::failFul(222);//抱歉!该用户已经绑定了手机;

        $share_strlog = Db::name('share_strlog')->field('uid')->where(['phone' => $phone,'package_id' => $package_id])->find();
        if($share_strlog)return ReturnJson::failFul(221);//抱歉!手机号已被占用;


//        $redis = new \Redis();
//        $redis->connect(config('redis.ip'), config('redis.port0'));
//        $redisCode = $redis->hGet("PHONE_ACCOUNT_CODE", $phone);
//        if($redisCode != $code)return ReturnJson::failFul(209);


//        Db::name('share_strlog')->where('uid',$uid)->update(['phone' => $phone,'password' => md5($password)]);
        Db::name('share_strlog')->where('uid',$uid)->update(['phone' => $phone]);
        return ReturnJson::successFul();
    }


    /**
     * 用户修改密码
     * @return void
     */
    public function editPassword(){
        $uid = request()->uid;
        $password = input('password'); //新密码
        $oldpassword = input('oldpassword'); //老密码
        $phone = input('phone'); //新密码
        $smstype = input('smstype'); //验证码

        $packname = request()->packname;
        $package_id = Db::name('apppackage')->where('appname',$packname)->value('id');
        if(!$package_id)return ReturnJson::failFul(206);

        if(!$password)return ReturnJson::failFul(218);

        if($smstype == 2){
            $share_strlog = Db::name('share_strlog')->field('uid')->where(['phone' => $phone,'package_id' => $package_id])->find();
            if(!$share_strlog)return ReturnJson::failFul(216);//手机号用户不存在!请先注册
        }else{
            $share_strlog = Db::name('share_strlog')->field('uid')->where(['uid' => $uid,'password' => md5($oldpassword)])->find();
            if(!$share_strlog)return ReturnJson::failFul(217);//抱歉!老密码输入错误!
        }
        Db::name('share_strlog')->where('uid',$share_strlog['uid'])->update(['password' => md5($password)]);
        return ReturnJson::successFul(200);
    }

    /**
     *
     * 获取归因
     * @param $param  归因参数
     * @param $key 用户的唯一标识
     * @param $package_id 包名
     * @param $logintype  登录方式  注册 1=手机,2=谷歌,3=账号
     * @param $packname 包名
     * @param $device_id 设备ID
     * @param $password 登录密码
     * @param $nickname 昵称
     * @param $password 密码
     * @param $email 邮箱
     * @return int[]
     */
    private function get_channel($param, $key, $package_id, $logintype, $packname,$device_id,$password = '',$nickname = '',$avatar = '',$email = '')
    {

        $apppackage = Db::name('apppackage')->field('hide,is_genuine_gold')->where('id',$package_id)->find();
        $chanel = Db::name('chanel')->where(['package_id' => $package_id,'type' => 1])->value('channel');
        $chanelid = $chanel ?: 10000;
        $phone = $logintype == 1 ? $key : '';
        $pchanelid = 0;
        $puid = 0;
        $isgold = 1;
        $ip = request()->ip();  //获取ip
        $nickname = $nickname ?: substr($key,0,6).'***';
        $googlesub = $logintype == 2 ? $key : '';
        $afid = $param['afid'] ?? '';  //	appsflyer_id的设备ID
        $adid = $param['adid'] ?? '';  //	adjust的设备ID
        $gpsid = $param['gps_adid'] ?? ''; //	原始谷歌的广告ID
        $af_status = 0;


        //获取UID同时处理shrlog
        $uid = $this->GetUid();

        if($logintype == 4){ //黑名单处理
            $filed_array = ['phone' =>$phone,'ip' => $ip];
        }else{
            $filed_array = ['ip' => $ip];
        }



        $getIpLoginStatus = $this->getIpLoginStatus($package_id,$ip);
        $ip_login_status = $getIpLoginStatus['ip_login_status'];//0 = A面  ， 1 = B面  ,-1 = 不允许登录
        $city = $getIpLoginStatus['city'];

        //不管是不是真金包都不允许拉贾拾坦邦进入
        if($ip_login_status === -1){
            Log::error('非巴西地区无法进入系统:'.$key);
            return ['code' => 212,'msg' => 'Sorry! The service is temporarily unavailable','data' => []];
        }

        if(!$apppackage['hide']){  //闪退或者不投放，直接A
            $chanelid = 0;
        }else{
            if($apppackage['is_genuine_gold'] == 1){
                $isgold = 0;
                $ip_login_status = 1;
                $af_status = isset($param['af_status']) && !isset($param['bindData']) && $param['af_status'] == 'Non-organic' ? 1 : 0;
                $chanelid = $this->getGgChanelid($param,$chanelid,$package_id,$af_status);
            }elseif ((isset($param['af_status']) && $param['af_status'] != 'share-link' &&  !isset($param['bindData'])) || isset($param['trackerName'])) {  //不是分享来的
                $trackerName = $param['af_status'] ?? $param['trackerName'];
                if ($trackerName) {
                    $isgold = $trackerName == 'Organic' ? 1 : 0;
                    //是否开启自然量进入B面
                    if($this->isNatureStatus()){
                        if ($isgold == 1 && $ip_login_status !== 1) {  //金币玩家同时设备ip等检测不能通过就为金币
                            $chanelid = 0;
                        }elseif ($isgold == 1 && $ip_login_status === 1) {  //金币玩家同时设备ip等检测能通过就转为真金
                            $isgold = 0;
                        }else {  //真金玩家且有有归因参数
                            //广告渠道
                            $chanelid = $this->getGgChanelid($param,$chanelid,$package_id,1);
                            $af_status = 1;
                            if (strpos($trackerName, "Youmi") !== false) $af_status = 0;

                        }
                    }else{
                        if($isgold == 1){
                            $chanelid = 0;
                        }else {  //真金玩家且有有归因参数
                            //广告渠道
                            $chanelid = $this->getGgChanelid($param,$chanelid,$package_id,1);
                            $af_status = 1;
                            if (strpos($trackerName, "Youmi") !== false) $af_status = 0;
                        }
                    }


                }
            }elseif (((isset($param['bindData']) && $param['bindData']) || (isset($param['af_status']) && $param['af_status'] == 'share-link')) && !isset($param['h5uid']) ){

                $bindData = isset($param['bindData']) ? json_decode($param['bindData'],true) : $param;
//                $bindData = json_decode($param['bindData'],true);
                if(isset($bindData['af_status']) && $bindData['af_status']){

                    $isgold = $bindData['af_status'] == 'share-link' ? 0 : 1;

                    if(isset($bindData['agent']) && $bindData['agent']){
                        $agent_cid = Db::name('chanel')->where('package_id',$package_id)->where('ctag',$bindData['agent'])->value('channel');
                        $chanelid = $agent_cid ?: $chanelid;
                    }

                    $bindData['clickLabel'] = isset($bindData['clickLabel']) ? base64_decode($bindData['clickLabel']) : 0;

                    $chanelinfo = Db::name('share_strlog')->where('uid',$bindData['clickLabel'])->find();

                    if ($chanelinfo && $bindData['clickLabel'] != $uid) {
                        $puid = $bindData['clickLabel'];  //上级用户uid
                        $pchanelid = $chanelinfo['channel'];  //上级用户渠道id
                        $pchan =  Db::name('chanel')->where('channel',$pchanelid)->find();//获取上级渠道的等级
                        $agentstatus = true;
                        //本次修改
                        if($pchanelid > 100000000 || in_array($pchanelid,[380020,9160]))$agentstatus = false;  //所以用户都给代理 理
                        if($pchan && $pchan['level'] <= 2 && $agentstatus) {
                            $chanelinfo = Db::name('chanel')->where('channel',$pchanelid + 1)->find();  //获取分享用户理想状态的渠道 上级渠道 + 1
                            if (!$chanelinfo || !$pchan['channel']) {
                                $leave = $pchan['level'] + 1; //用户等级等级
                                $chanelid = $pchanelid + 1; //下级渠道id
                                //添加
                                $chanel_data = [
                                    'channel' => $chanelid,
                                    'pchannel' => $pchanelid,
                                    'cname' => $pchan['cname'] . $leave . '级',
                                    'appname' => $packname,
                                    'level' => $leave,
                                    'package_id' => $package_id,
                                    'ppackage_id' => $pchan['ppackage_id'],
                                ];
                                Db::name('chanel')->insert($chanel_data);
                            } else {
                                $chanelid = $chanelinfo['channel'];
                            }
                        } elseif ($pchan) {
                            //本次修改
                            if($pchanelid == 40012 && $chanelinfo['agent'] != 1){
                                $chanelid = 9000;
                            }else{
                                $chanelid = in_array($chanelid,[40012,9160]) ? $chanelid : $chanelinfo['channel']; //落地页包的分享包用户单独区分渠道
                            }

                        }

                    }


                }
            } else { //parm为空的时候
                if($this->isNatureStatus() && $ip_login_status === 1) $isgold = 0;
            }
        }


        if(!$ip_login_status && !$af_status){
            $isgold = 1;
            $chanelid = 0;
        }

        //没有A面的包禁止登录
        if($isgold == 1){
            Log::error('金币玩家无法登陆包id:'.$package_id.'登录信息：'.$key);
            return ['code' => 212,'msg' => 'Sorry! The service is temporarily unavailable','data' => []];
        }

        //如果有设备号，检查设备是否唯一，如果不唯一，则把上级用户uid变为0
        if($puid > 0 && $device_id != '00000000000000000000000000000000'){
            $puid_status = Db::name('share_strlog')->field('uid')->where('device_id',$device_id)->find();
            if($puid_status)$puid = 0;
        }

        $fb_login_status = false;

        //ip与设备号检测
        if($apppackage['is_genuine_gold'] != 1 && $device_id != '00000000000000000000000000000000'){ //不是真金包检测ip 13为支付包不检查这个,000为未获取到设备号用户
            $device_count = Db::name('share_strlog')->where('device_id',$device_id)->where('package_id',$package_id)->count(); //获取注册用户的设备号数量
            if(!$device_count && in_array($package_id,$this->FbLoginPackageId))$fb_login_status = true;
//            if($device_count >= 5){ //如果ip已经注册了3个直接进A面
//                Log::error('设备号注册了超过了5个禁止注册'.$device_id.'包id:'.$package_id.'登录信息：'.$key);
//                return ['code' => 201,'msg' => 'Sorry! A device can only register up to 5 accounts.','data' => []];
//            }
        }



        //黑名单处理
        $res = \app\common\xsex\Common::is_block($filed_array);
        if($res){
            Log::error('黑名单用户禁止注册===登录信息:'.$key.'ip:'.$ip);
            return ['code' => 201,'msg' => 'Sorry! The service is temporarily unavailable','data' => []];
        }



        Db::startTrans();
        $code = $this->code();
        $share_strlog_data = [
            'uid' => $uid,
            'puid' => $puid,
            'password' => md5($password),
            'nickname' => $nickname,
            'googlesub' => $googlesub,
            'avatar' => $avatar,
            'ip' =>$ip,
            'strlog' => json_encode($param),
            'isgold' => $isgold,
            'pchannel' => $pchanelid,
            'channel' => $chanelid,
            'appname' => $packname,
            'device_id' => $device_id,
            'last_login_time' => time(),
            'createtime' => time(),
            'gpsadid' => $gpsid,
            'adid' => $adid,
            'code' => $code,
            'phone' => $phone,
            'package_id' => $package_id,
            'login_ip' => $ip,
            'afid' => $afid,
            'jiaemail' => $this->getEmail(),
            'jiaphone' => $this->getPhone(),
            'af_status' => $af_status,
            'city' => $city,
        ];

        $res = Db::name('share_strlog')->insert($share_strlog_data);
        if(!$res){
            Db::rollback();
            Log::error('注册用户信息:'.$key.'数据表share_strlog添加失败');
            return ['code' => 213 ,'msg'=>'注册用户失败','data' => []];
        }

        $userinfo = [
            'uid' => $uid,
            'puid' => $puid,
            'channel' => $chanelid,
            'vip' => $this->getVip(),
            'ip' => $ip,
            'regist_time' => time(),
            'acc_type' => $logintype,
            'package_id' => $package_id,
        ];

        $userinfo = Db::name('userinfo')->insert($userinfo);
        if(!$userinfo){
            Db::rollback();
            Log::error('注册用户信息:'.$key.'数据表userinfo添加失败');
            return ['code' => 213 ,'msg'=>'注册用户失败','data' => []];
        }


        $this->setTeamLevel($uid,$puid,$nickname,$avatar,$chanelid,$package_id,0,$param); //团队数据处理


        if($isgold == 0){
            $this->statisticsRetainedUser($uid,$package_id,$chanelid);
        }

        //处理每日注册
        $this->setRegist($uid,$chanelid,$package_id);


        Db::commit();


        //fb注册打点
        if($fb_login_status && in_array($package_id,$this->FbLoginPackageId))Adjust::fbUploadEvent($packname,0,false,'','',$uid,2);
        //AF注册打点
        if($fb_login_status && in_array($package_id,$this->AfLoginPackageId) && $afid)Adjust::afUploadEvent($packname,'',$afid,0,false,'',$share_strlog_data,2);
        //Adjust注册打点
        if($fb_login_status && in_array($package_id,$this->AdjustPackageId))Adjust::adjustUploadEvent($packname,$gpsid,$adid,0,false,'',$share_strlog_data,2);




        return ['code' => 200,'msg' => '成功','data' => ['uid' => $uid,'code'=>$code,'phone' => $phone,'email' => $email,'nickname' => $nickname,'avatar' => $avatar,'package_id' => $package_id,'channel' => $chanelid]];

    }

    /**
     * 获取用户的默认VIP等级
     * @return
     */
    private function getVip(){
        $vip = Db::name('vip')->where('need_water',0)->order('vip','desc')->value('vip');
        return $vip ?: 0;
    }

    /**
     * 设置用户token
     * @param $uid
     * @return void
     */
    private function setUserToken($uid){
        $token = setToken($uid);

        Db::name('user_token')->replace()->insert([
            'uid' => $uid,
            'token' => $token,
        ]);
        return $token;
    }

    /**
     * 设置用户团队层级数据
     * @param $uid 用户UID
     * @param $chanelid 渠道ID
     * @param $package_id   包名
     * @return void
     */
    private function setLogin($uid,$chanelid,$package_id){
        //处理每日登录数据表检查数据表是否存在，不存在就创建
        Db::name('login_'.date('Ymd'))->replace()->insert([
            'uid' => $uid,
            'channel' => $chanelid,
            'package_id' => $package_id,
            'createtime' => time(),
        ]);
    }


    /**
     * 设置用户团队层级数据
     * 设置用户团队层级数据
     * @param $uid 用户UID
     * @param $chanelid 渠道ID
     * @param $package_id   包名
     * @return void
     */
    private function setRegist($uid,$chanelid,$package_id){
        //处理每日注册数据表检查数据表是否存在，不存在就创建
        Db::name('regist_'.date('Ymd'))->replace()->insert([
            'uid' => $uid,
            'channel' => $chanelid,
            'package_id' => $package_id,
            'createtime' => time(),
        ]);
    }


    /**
     * 设置用户团队层级数据
     * @param $uid 用户UID
     * @param $puid 上级代理用户UID
     * @param $level 上级用户层级 默认是自己 0
     * @return void
     */
    private function setTeamLevel($uid,$puid,$nickname,$avatar,$channel,$package_id,$level = 0,$param=[]){

        //第一次进来，如果有团队详细数据就直接返回。
        if(!$level){
            $this->installTeamLevel($uid,$uid,0);
            //存储团队信息
            if($puid > 0){
                //转盘邀请用户处理
                $turntable_id = 0;
                $money = 0;
                if (isset($param['turntable_id']) && $param['turntable_id'] > 0){
                    $turntable_id = $param['turntable_id'];
                    $turntable_user_count = Db::name('user_team')->where('turntable_id',$turntable_id)->count();
                    if ($turntable_user_count <= 5){
                        $money = mt_rand(5, 15) / 100;
                    }else{
                        $probability = 0.2;  // 控制概率，范围为 0 到 1 之间
                        $randomNumber = mt_rand(1, 100) / 100;  // 生成一个介于 0.01 和 1 之间的随机数
                        if ($randomNumber < $probability) {
                            $money = 0.01;
                        } else {
                            $money = 0;
                        }
                    }
                    Db::name('turntable')->where('id',$turntable_id)->inc('money',$money)->update();
                }

                Db::name('user_team')->insert([
                    'uid' => $uid,
                    'nickname' => $nickname,
                    'avatar' => $avatar,
                    'puid' => $puid,
                    'createtime' => time(),
                    'channel' => $channel,
                    'package_id' => $package_id,
                    'turntable_id' => $turntable_id,
                    'money' => $money,
                ]);
            }else{
                return 1;
            }
        }

        //防止层级过多出问题，这里最多设置10级
        if($level >= 10)return 1;

        $this->installTeamLevel($uid,$puid,$level + 1);

        //获取上级用户是否还有上级用户
        $user_team = Db::name('user_team')->field('puid')->where('uid',$puid)->find();
        if(!$user_team)return 1;

        //如果推荐代理有上级用户，同时上级用户不是代理自己
        if($user_team['puid'] > 0 && $user_team['puid'] != $puid) self::setTeamLevel($uid,$user_team['puid'],$nickname,$avatar,$channel,$package_id,$level + 1);
        return 1;
    }


    /**
     * 储存用户团队层级数据
     * @return void 存储
     */
    private function installTeamLevel($uid,$puid,$level = 0){
        Db::name('teamlevel')->insert([
            'uid' => $uid,
            'puid' => $puid,
            'level' => $level,
            'createtime' => time(),
        ]);
    }




    /**
     * @return bool|mixed 自然量是否开启进入B面,1=是,0=否
     */
    private function isNatureStatus(){
        return SystemConfig::getConfigValue('is_nature_status');
    }

    /**
     * 设置首次登录用户的uid
     * @param $package_id 包名
     * @param $logintype 登录类型
     * @param $key  key
     * @return void
     */
    private function GetUid()
    {
        $Reids = new \Redis();
        $Reids->connect(config('redis.ip'), config('redis.port1'));

        $olduid = $Reids->hGet("D_TEXAS_INDEX", 'UID');
        $randnum = rand(2, 9); //取随机数
        $uid = $olduid + $randnum;
        $Reids->hSet("D_TEXAS_INDEX", 'UID', $olduid + $randnum);

        return $uid;
    }

    /**
     * @return void 生成邀请码
     */
    private function code(){
        $english = substr(str_shuffle("ABCDEFGHIJKLMNOPQRSTUVWXYZ"),0,4);
        $num = rand(1000,9999);
        $code = str_shuffle($num.$english);
        $user_team = Db::name('share_strlog')->field('uid')->where('code','=',$code)->find();
        if($user_team){
            $this->code();
        }
        return $code;
    }



    /**
     * 随机生产几位字母
     * @param $length
     * @return string
     */
    private static function generateRandomString($uid,$length = 6){

        $characters = 'abcdefghijklmnopqrstuvwxyz';
        $randomString = '';

        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, strlen($characters) - 1)];
        }

        return $randomString.$uid;

    }


    /**
     * 给充值用户随机生产email
     * @param $length
     * @return string
     */
    private function getEmail(){
        $num = rand(1,2);
        $shuff = $num == 1 ? '@gmail.com' : '@outlook.com';
        $RandomString = self::generateRandomString(rand(1000,9999),6);
        return $RandomString.$shuff;
    }



    /**
     * 给充值用户随机生产生成手机号
     * @param $length
     * @return string
     */
    private function getPhone(){
        return rand(7777777777,9999999999);
    }

    /**
     * 获取自然用户的登录状态
     * @param $device_id 设备号
     * @param $device 设备
     * @param $package_id 分享包
     * @param $isApp 是否是APP  'true' 是 ， 'false' 否
     * 返回值代表 0 = A面  ， 1 = B面  ,-1 = 不允许登录
     */
    private function getIpLoginStatus($package_id,$ip){
        //获取用户城市
        $response = $this->getUserCity($ip,2,$package_id);
        $city = $response['regionName'].'/'.$response['city'];

        // 帮 regionName/城市 city/国家编码 countryCode  例子 Rajasthan/Jodhpur/IN
//        if($response['countryCode'] != 'BR')return ['city' => $city,'ip_login_status' => -1]; //如果不在印度就直接A面

        return ['city' => $city,'ip_login_status' => 1];
    }

    /**
     * @param $type 类型: 1= 直接返回帮和城市的字符串 ， 2 = 获取所有数据
     * @return mixed 获取用户城市
     * @param $ip  用户ip
     */
    private function getUserCity($ip,$type = 1,$package_id){
        $response = \curl\Curl::get("https://pro.ip-api.com/json/".$ip."?key=IKEH1fFMW5o1qKY");
        $response = json_decode($response,true);

        return  $type == 1 ? $response['regionName'].'/'.$response['city'] : $response;

    }





    /**
     * 获取广告渠道id
     * @param $param param 参数
     * @param $chanelid 渠道号
     * @param $package_id 包名
     * @return string
     */
    private function getGgChanelid($param,$chanelid,$package_id,$af_status){

        if((isset($param['bindData'])  && $param['bindData'])  || (isset($param['af_status']) && $param['af_status'] == 'share-link')){  //如果是特殊的话就单独处理
            $bindData = isset($param['bindData']) ? json_decode($param['bindData'],true) : $param;
            if(isset($bindData['agent']) && $bindData['agent']){
                $agent_cid = Db::name('chanel')->where('package_id',$package_id)->where('ctag',$bindData['agent'])->value('channel');
                return $agent_cid ?: $chanelid;
            }

        }
        //修改广告用户的默认渠道
        if($af_status == 1){
            $ggchanelid = Db::name('chanel')->where(['package_id' => $package_id,'type' => 2])->value('channel');
            $chanelid = $ggchanelid ?: $chanelid;
        };

        $fb_tage = $param['campaign'] ?? ''; //fb的广告标记
        if($fb_tage){
            $fb_tage = explode('_',$fb_tage)[0];
            $chanelinfo = Db::name('chanel')->where('package_id',$package_id)->where('ctag','like',$fb_tage.'%')->find();
            if($chanelinfo){
                return $chanelinfo['channel'];
            }
        }

        $adjust_tage = $param['trackerName'] ?? ''; //adjust的广告标记
        if($adjust_tage){
            $adjust_tage = explode('::',$adjust_tage)[0];
            $chanelinfo = Db::name('chanel')->where('package_id',$package_id)->where('ctag','like',$adjust_tage.'%')->find();
            if($chanelinfo){
                $chanelid = $chanelinfo['channel'];
            }
        }
        return $chanelid;
    }



    /**处理当日注册用户与当日注册统计
     * @param $uid 用户uid
     * @param $package_id 包id
     * @param $channel 渠道号
     * @param $af_status  是否是广告
     * @return void
     */
    private function statisticsRetainedUser($uid,$package_id,$channel){

        //获取当日包和渠道下的首充用户
        $day_user = Db::name('statistics_retaineduser')->where(['time'=> strtotime('00:00:00'), 'package_id' => $package_id, 'channel' => $channel])
            ->update([
                'uids' => Db::raw("concat(uids,',', '$uid')")
            ]);
        if(!$day_user){
            Db::name('statistics_retaineduser')
                ->insert([
                    'time' => strtotime('00:00:00'),
                    'package_id' => $package_id,
                    'channel' => $channel,
                    'uids' => $uid,
                ]);
        }
        $res = Db::name('statistics_retained')->where(['time'=> strtotime('00:00:00'), 'package_id' => $package_id, 'channel' => $channel])
            ->update([
                'num' => Db::raw('num + 1')
            ]);

        if(!$res){
            Db::name('statistics_retained')
                ->insert([
                    'time' => strtotime('00:00:00'),
                    'package_id' => $package_id,
                    'channel' => $channel,
                    'num' => 1,
                ]);
        }
    }

}