<?php

namespace app\admin\controller\statistics;
use app\admin\controller\AuthController;
use crmeb\services\{FormBuilder as Form, JsonService as Json, UtilService as Util};
use think\facade\Db;
use app\admin\controller\Model;
use app\admin\common\Retention;
use app\admin\common\Roi as Rois;
use think\facade\Session;

/**
 *  成功付费留存-再登陆
 */
class Roi extends AuthController
{

    private $table = 'statistics_roi';

    public function index()
    {
        $app_config = Db::name('apppackage')->field('id as package_id,bagname,appname')->order('id','asc')->select()->toArray();
        $channel_config = Db::name('chanel')->field('channel,cname,package_id')->order('channel','asc')->select()->toArray();
        $data = [];
        foreach ($app_config as $key => $value){
            $data[$value['package_id']] = [
                'name' => $value['bagname'],
                'value' => $value['package_id']
            ];
        }
        foreach ($channel_config as $v){
            $data[$v['package_id']]['list'][] = [
                'name' => $v['cname'],
                'value' => $v['channel']
            ];
        }
        $data = array_values($data);
        //dd($data);

        $adminInfo = $this->adminInfo;
        $is_export = Db::name('system_role')->where('id','=',$adminInfo->roles)->value('is_export');
        $defaultToolbar = $is_export == 1 ? ['print', 'exports'] : [];
        $this->assign('defaultToolbar', json_encode($defaultToolbar));
        $this->assign('ChannelData', json_encode($data));
        return $this->fetch();
    }


    public function getlist(){
        $data =  request()->param();

        //平台与渠道
        $channel_where = [];
        if (!Session::get('chanel')) {
            if ($this->adminInfo['type'] == 0) {
                //$this->sqlwhere[] = ['a.channel', '<', 100000000];
            } else {
                $this->sqlwhere[] = ['a.channel', '>=', 100000000];
            }
        }
        if (isset($data['app']) && $data['app'] > 0){
            $this->sqlwhere[] = ['a.package_id', '=', $data['app']];
        }
        if (isset($data['network']) && $data['network'] > 0){
            $this->sqlwhere[] = ['a.channel', '=', $data['network']];
        }

        [$list,$count] = Rois::getlist($this->table,$data,$this->sqlWhere());
        if (!empty($list)){
            foreach ($list as $k=>&$v){
                $v['app'] = isset($data['app']) ? $data['app'] : '';
                $v['network'] = isset($data['network']) ? $data['network'] : '';
            }
        }
        return json(['code' => 0, 'count' => $count, 'data' => $list]);
    }


    public function userList(){
        $data = $this->request->param();
        $time = strtotime($data['time']);
        $type = $data['type'];

        //平台与渠道
        $channel_where = [];
        if (!Session::get('chanel')) {
            if ($this->adminInfo['type'] == 0) {
                //$channel_where = [['channel', '<', 100000000]];
            } else {
                $channel_where = [['channel', '>=', 100000000]];
            }
        }
        $NewWhere = [];
        if (!empty($this->sqlNewWhere)){
            $NewWhere = [$this->sqlNewWhere];
        }

        $all_users = Db::name('statistics_retainedwith')
            ->where('time', $time)
            ->where($channel_where)
            ->where($NewWhere)
            ->column('uids');
        $all_users = implode(",", $all_users);
        $user_day_table = 'login_'.date('Ymd',$time + ($type*86400));
        $users = Db::name($user_day_table)->whereIn('uid',$all_users)->column('uid');
        $users = implode(",",$users);

        $this->assign('users',$users);
        return $this->fetch();
    }

    public function getUserinfoList(){
        $data = $this->request->param();
//dd($data);
        $page = $data['page'] ?: 1;
        $limit = $data['limit'] ?: 30;

        $users = $data['users'] ? $data['users'] : '';
        $users_arr = explode(",",$users);
        $users_arr = array_unique($users_arr);
        if(!empty($users)){
            $list = Db::name('userinfo')
                ->field('uid,total_pay_score,total_exchange')
                ->whereIn('uid',$users_arr)
                ->order('total_pay_score','desc')
                ->order('regist_time','desc')
                ->page($page, $limit)
                ->select()
                ->toArray();
            $count = Db::name('userinfo')
                ->whereIn('uid',$users_arr)
                ->count();
            return json(['code' => 0, 'count' => $count, 'data' => $list]);
        }
        return json(['code' => 0, 'count' => 0, 'data' => []]);
    }


    public function edit($time = 0){
        $time = strtotime($time);
        $consume = Db::name('statistics_roi')->where('time',$time)->field('sum(consume) as consume')->find();
        if(!$consume){
            Json::fail('参数错误!');
        }

        $channel = Db::name('statistics_roi')
            ->alias('a')
            ->leftJoin('chanel b','a.channel = b.channel')
            ->leftJoin('apppackage c','a.package_id = c.id')
            ->where('time',$time)
            ->where('level',1)
            ->where('b.cname','<>','')
            ->group('a.channel')
            ->field('a.package_id,a.channel,a.consume,b.cname,c.bagname')->select()->toArray();
        $channel_sort = array_column($channel,'cname');
        array_multisort($channel_sort,SORT_ASC,$channel);

        $packageList = [];
        foreach ($channel as $package) {
            $packageId = $package['package_id'];
            // 如果包已存在于结果数组中，则将该渠道添加到对应的包条目中
            if (isset($packageList[$packageId])) {
                $packageList[$packageId]['children'][] = [
                    'id' => $package['channel'],
                    'label' => $package['cname'].'--'.$package['consume']/100,
                    'value' => $package['channel'],
                    // 其他渠道字段
                ];
            } else {
                // 创建新的包条目，并添加第一个渠道
                $packageList[$packageId] = [
                    'id' => $packageId,
                    'label' => $package['bagname'],
                    'value' => $packageId,
                    // 其他包字段
                    'children' => [
                        [
                            'id' => $package['channel'],
                            'label' => $package['cname'].'--'.$package['consume']/100,
                            'value' => $package['channel'],
                            // 其他渠道字段
                        ]
                    ]
                ];
            }
        }
        //sort($packageList);
        //dd($packageList);


        $f = array();
        /*$f[] = Form::select('channel','渠道')->required()->setOptions(function () use ($channel){
            $menus = [];
            foreach ($channel as $menu) {
                $menus[] = ['value' => $menu['package_id'].'_'.$menu['channel'], 'label' => $menu['cname'].':'.$menu['consume']/100];
            }
            return $menus;
        })->filterable(1);*/
        //$f[] = Form::tree('channel','渠道')->data($packageList);
        $f[] = Form::cascader('channel','渠道')->data($packageList)->trigger('hover')->size('large')->required();
        $f[] = Form::number('consume', '消耗')->required();

        $form = Form::make_post_form('修改数据', $f, url('save',['time' => $time]));
        $this->assign(compact('form'));
        return $this->fetch('public/form-builder');
    }

    /**
     * @return void 存储数据
     */
    public function save($time=0){
        $data = request()->post();
        $data['consume'] = $data['consume']*100;
        //$channel_arr = explode('_',$data['channel']);
        $channel_arr = $data['channel'];
        if($time > 0 && $data['channel'] > 0){
            $res = Db::name('statistics_roi')->where('time',$time)->where('package_id',$channel_arr[0])->where('channel',$channel_arr[1])->update(['consume' => $data['consume']]);
        }
        if(!$res){
            Json::fail('修改失败');
        }
        return Json::successful($time > 0 ? '修改成功!' : '添加成功!');
    }


}



