<?php

namespace app\admin\controller\user;
use app\admin\controller\AuthController;
use app\admin\controller\Common;
use app\admin\model\ump\ExecPhp;
use crmeb\services\{FormBuilder as Form, JsonService as Json, UtilService as Util};
use think\facade\Db;
use app\admin\controller\Model;
/**
 *  召回用户短信发送
 */
class Smssend extends AuthController
{

    private $tablename = 'recallolduser_smssend';

    public function index()
    {
        return $this->fetch();
    }


    public function getlist(){
        $data =  request()->param();
        $page = $data['page'] ?: 1;
        $limit = $data['limit'] ?: 30;
        $tablename = $this->tablename;
        $filed = "a.id,FROM_UNIXTIME(a.updatetime,'%Y-%m-%d %H:%i:%s') as updatetime,a.content,a.phone,b.real_name as admin_id,a.uid,a.email";

        $orderfield = "id";
        $sort = "desc";
        $join = ['system_admin b','b.id = a.admin_id'];
        $alias = 'a';
        $date = 'a.updatetime';

        $data = Model::joinGetdata($tablename,$filed,$data,$orderfield,$sort,$page,$limit,$join,$alias,$date,'left');

        return json(['code' => 0, 'count' => $data['count'], 'data' => $data['data']]);

    }


    public function add(){
        $this->assign('recallOldPackage',$this->recallOldPackage());
        return $this->fetch();
    }




    /**
     * @return void 根据用户条件选择筛选发送对应用户短信
     */
    public function whereSend(){
        $active = $this->recallOldPackage();
        $f = array();
        $f[] = Form::input('pay_money', '用户累计充值金额(分)')->required();
        $f[] = Form::input('last_login_time', '用户多久未登录游戏(天)');
        $f[] = Form::select('package_id','选择包')->setOptions(function () use ($active){
            $menus = [];
            foreach ($active as $menu) {
                $menus[] = ['value' => $menu['package_id'], 'label' => $menu['bagname']];
            }
            return $menus;
        });
        $form = Form::make_post_form('添加数据', $f, url('save'));
        $this->assign(compact('form'));
        return $this->fetch('public/form-builder');
    }


    /**
     * @return void 导入黑名单
     */
    public function upload(){
        if(request()->isPost()) {
            $file = $_FILES['file'];

            //获取Excel数据
            $data = Common::leadingIn($file);
            if(!$data){
                return Json::fail('暂无数据导入');
            }


            if($this->getXlsxKey('uid') === -1){
                return Json::fail('暂无导入用户配置!');
            }
            $uidArray = [];
            foreach ($data as $k => $v){
                if(!$v[$this->getXlsxKey('uid')]){
                    continue;
                }

                $uidArray[] = trim($v[$this->getXlsxKey('uid')]);
            }

            return Json::success('成功',serialize($uidArray));
        }
        return Json::fail("请先上传数据");

    }



    /**
     * @return void 存储数据
     */
    public function save($id=0){
        set_time_limit(0);
        ini_set('memory_limit','1024M');

        $adminId = $this->adminId;
        $package_id = input('package_id');
        $pay_money = input('pay_money');
        $last_login_time = input('last_login_time'); //天数

        if(!$last_login_time) Json::fail('请输入多久未登录游戏的玩家');

        //if(!$pay_money)Json::fail('请输入玩家累计充值金额');

        if(!$package_id)Json::fail('请选择发送的包');

        $recallold_package = Db::name('recallold_package')->field('url')->where('package_id',$package_id)->find();
        if(!$recallold_package)Json::fail('该包暂不支持发送短信');

        //获取所有满足条件的用户，一次只能999个用户一起发送
        $uidArray = Db::name('userinfo')
            ->alias('a')
            ->join('share_strlog b','b.uid = a.uid')
            ->leftJoin('user_withinfo c','c.uid = a.uid')
            ->field('a.uid,b.phone,c.email')
            ->where([
                ['a.total_pay_score','>=',$pay_money],
                ['a.login_time','<=',bcsub(time(),bcmul($last_login_time,86400,0),0)],
                ['a.package_id','=',$package_id],
                ['b.phone','>',0],
                ['a.status','=',0]
            ])
            //->where('b.phone','>',0)
            //->whereOr('c.email','<>','')
            ->where(function ($query) {
                $query->where('b.phone', '>', 0)
                    ->whereOr('c.email', '<>', '');
            })
            ->group('uid')
            //->limit(2)
            ->select()
            ->toArray();
        //$ss = Db::name('')->getLastSql();
        // dd($uidArray);

        if(!$uidArray){
            return Json::fail("抱歉!暂无发送内容");
        }
        $res = $this->sendSms($uidArray,$recallold_package['url'],$adminId,$package_id);
        if($res['code'] != 200) Json::fail($res['msg']);
        return Json::successful('发送成功');
    }


    public function send(){

        $admin_id = $this->adminId;
//        $uidArray = input('uidArray');
        $phone = input('uidArray');
        $phoneArray = unserialize($phone);
        $content = input('content');
//        $uidArray = Db::name('share_strlog')->field('uid,phone')->where([['uid','in',$uidArray],['phone','>',0]])->select()->toArray();
        $recallold_package = Db::name('recallold_package')->field('url')->where('package_id',$content)->find();
        if(!$recallold_package)Json::fail('该包暂不支持发送短信');
        if(!$phoneArray || !$recallold_package){
            return Json::fail("抱歉!暂无发送内容");
        }
        $uidArray = [];
        foreach ($phoneArray as $v){
            $uidArray[] = [
                'uid' => 0,
                'phone' => $v,
            ];
        }
        $res = $this->sendSms($uidArray,$recallold_package['url'],$admin_id,$content);
        if($res['code'] != 200) Json::fail($res['msg']);
        return Json::successful('发送成功');

    }


    private function sendSms($uidArray,$content,$admin_id,$package_id = 0){
        $phoneCount = count($uidArray);
        $limit = 1000;//三方一次最多发送1000条数据这里向上取一下整
        $allPage = ceil($phoneCount/$limit);

        for ($i = 1 ;$i <= $allPage ; $i ++){
            $data = \customlibrary\Common::getData($i,$limit,$uidArray);
//            dd($data);
            $phones = [];
            $recallolduser_smssend = [];
            $email = [];
            foreach ($data as $v){
                if ($v['phone'] > 0) {
                    $recallolduser_smssend[] = [
                        'uid' => $v['uid'],
                        'phone' => $v['phone'],
                        'email' => '',
                        'content' => $content,
                        'admin_id' => $admin_id,
                        'updatetime' => time(),
                    ];
                    $phones[] = '91' . $v['phone'];
                }

                //邮件
                /*if (!empty($v['email'])){
                    $recallolduser_smssend[] = [
                        'uid' => $v['uid'],
                        'phone' => '',
                        'email' => $v['email'],
                        'content' => $content,
                        'admin_id' => $admin_id,
                        'updatetime' => time(),
                    ];
                    $email[] = $v['email'];
                }*/
            }
            if (!empty($phones)) {
                $res = \app\api\controller\Sms::bulkSending($phones, $content);
                if (!$res) {
                    return ['code' => 201, 'msg' => '发送短信失败!'];
                }
            }
            /*if (!empty($email)){
                $res = \app\api\controller\Sms::allSendEmali($email, $content);
                if (!$res) {
                    return ['code' => 201, 'msg' => '发送邮件失败!'];
                }
            }*/


            Db::name('recallolduser_smssend')->insertAll($recallolduser_smssend);
        }

        $this->recallOldStatistics($phoneCount,$package_id);
        return ['code' => 200,'msg' => '发送成功!'];
    }


    public function daoChuExcelPhone($list){
        $phone = [];
        foreach ($list as $k => $v){
            if($v[2]) $phone[$k]['phone'] = trim($v[2]);
        }
        $phone = array_values($phone);
        dd($phone);
        Common::daoChuExcel($phone,['手机号'],'发送短信的手机号');
    }

    /**
     * @param $filed
     * @return int 获取每个xsls对应字段 的key值
     */
    private function getXlsxKey($filed){
        $key = [
            'uid' => 0, //用户uid
        ];

        return $key[$filed];
    }

    /**
     * @return array
     */
    private function recallOldPackage(){
        return Db::name('recallold_package')
            ->alias('a')
            ->join('apppackage b','a.package_id = b.id')
            ->field('a.package_id,b.bagname')
            ->select()
            ->toArray();
    }


    /**
     * 召回数据统计
     * @return void
     *
     */
    private function recallOldStatistics($uidCount,$package_id = 0){

        Db::name('recallold_statistics')->insert([
            'time' => time(),
            'sms_num' => $uidCount,
            'package_id' => $package_id,
        ]);

    }
}



