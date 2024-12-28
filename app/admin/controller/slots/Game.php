<?php

namespace app\admin\controller\slots;

use app\admin\controller\AuthController;
use app\api\controller\slots\Egslots;
use crmeb\services\{FormBuilder as Form, JsonService as Json, UtilService as Util};
use think\facade\Db;
use app\admin\controller\Model;
use app\admin\controller\Common;
/**
 *  三方Slots游戏管理
 */
class Game extends AuthController
{


    private $table = 'slots_game';

    public function index()
    {
//        $admin = $this->adminInfo;

        $slots_terrace = Db::name('slots_terrace')->column('name,id,maintain_status,type');

        $this->assign('slots_terrace',$slots_terrace);

        return $this->fetch();
    }



    public function getlist(){
        $data =  request()->param();

        $page = $data['page'] ?: 1;
        $limit = $data['limit'] ?: 30;

        $field = 'a.id,a.name,a.englishname,a.image,a.status,a.weight,a.type,a.hot,a.recommend,a.love_num,b.name as terrace_name,a.maintain_status,a.free,a.min_money,a.image2,a.terrace_id,a.slotsgameid';

        $orderfield = "weight";
        $sort = "desc";
        $join = ['slots_terrace b','b.id = a.terrace_id'];
        $alias = 'a';
        $date = 'a.createtime';

        $data = Model::joinGetdata($this->table,$field,$data,$orderfield,$sort,$page,$limit,$join,$alias,$date,'left');
        return json(['code' => 0, 'count' => $data['count'], 'data' => $data['data']]);
    }

    /**
     * @return void 修改
     */
    public function edit($id = ''){
        $slots_game = Db::name('slots_game')->where('id',$id)->find();

        if(!$slots_game){
            Json::fail('参数错误!');
        }
        Form::style()->labelWidth('200px');
//        $f[] = Form::input('name', 'Slots游戏名称',$slots_game['name']);
        $f[] = Form::uploadImageOne('image', '游戏图片',url('widget.Image/file',['file'=>'image']),$slots_game['image']);
        $f[] = Form::uploadImageOne('image2', '正方形图片',url('widget.Image/file',['file'=>'image2']),$slots_game['image2']);
        $f[] = Form::input('englishname', '游戏名称', $slots_game['englishname'])->readonly(true);
        $f[] = Form::input('weight', '游戏权重(数值越大越靠前展示)',$slots_game['weight']);
        $f[] = Form::input('min_money', '最低进入金额',$slots_game['min_money']);
        $f[] = Form::select('type', '游戏类型', (string)$slots_game['type'])->options([['label' => '未知', 'value' => 0],['label' => 'Slots', 'value' => 1], ['label' => '真人', 'value' => 2],['label' => '转盘', 'value' => 3],['label' => '区块链', 'value' => 4],['label' => '彩票', 'value' => 5],['label' => '街机', 'value' => 6],['label' => '捕鱼', 'value' => 7],['label' => '体育', 'value' => 8],['label' => '牌桌', 'value' => 9]]);
        $f[] = Form::select('hot', '热门',(string)$slots_game['hot'])->options([['label' => '是', 'value' => 1], ['label' => '否', 'value' => 0]]);
        $f[] = Form::select('recommend', '推荐',(string)$slots_game['recommend'])->options([['label' => '是', 'value' => 1], ['label' => '否', 'value' => 0]]);
        $f[] = Form::select('free', '是否试玩',(string)$slots_game['free'])->options([['label' => '是', 'value' => 1], ['label' => '否', 'value' => 0]]);


        $f[] = Form::select('orientation', '游戏显示方向',$slots_game['orientation'])->options([['label' => '竖版', 'value' => 1], ['label' => '横版', 'value' => 2]]);
        $f[] = Form::switches('status', '状态', (string)$slots_game['status'])->trueValue('1')->falseValue('0');

        $form = Form::make_post_form('修改数据', $f, url('save',['id' => $id]),6);
        $this->assign(compact('form'));
        return $this->fetch('public/form-builder');
    }

    /**
     * @return void 存储数据
     */
    public function save($id=0){

        $data = request()->post();
        if($id > 0){
            $data['updatetime'] = time();
            $res = Db::name('slots_game')->where('id',$id)->update($data);
        }else{
            $data['updatetime'] = time();
            $data['createtime'] = time();
            $res = Db::name('slots_game')->insert($data);
        }
        if(!$res){
            Json::fail('添加失败');
        }
        return Json::successful($id > 0 ? '修改成功!' : '添加成功!');
    }
    /**
     * @return void 修改状态
     */
    public function is_show(){

        $id = request()->post('id');
        $data['status'] = request()->post('status');
        $data['updatetime'] = time();

        $res = Db::name('slots_game')->where('id',$id)->update($data);
        if(!$res){
            return Json::fail('修改失败2');
        }
        return Json::successful('修改成功!');

    }


    public function maintainstatus(){
        $id = request()->post('id');
        $slots_terrace = Db::name('slots_terrace')->where('id',$id)->find();
        if(!$slots_terrace){
            return Json::fail('参数错误');
        }

        $status = $slots_terrace['maintain_status'] == 1 ? 0 : 1;
        Db::startTrans();
        $res = Db::name('slots_terrace')->where(['id' => $id])->update(['updatetime' => time(),'maintain_status' => $status]);
        if(!$res){
            Db::rollback();
            return Json::fail('修改失败1');
        }
        $res = Db::name('slots_game')->where(['terrace_id' => $id])->update(['updatetime' => time(),'maintain_status' => $status]);
        if(!$res){
            Db::rollback();
            return Json::fail('修改失败2');
        }
        Db::commit();
        return Json::successful('修改成功!');
    }




    public function upload(){
        if(request()->isPost()) {
            // 获取表单上传文件
            $file = $_FILES['file'];
            //获取Excel数据
            $data = Common::leadingIn($file);
            if($data){
                $configData = $this->getUploadConfig();
                //老的历史数据
                $old_slots = Db::name('slots_game')->where('terrace_id',$configData['terrace_id'])->column('slotsgameid');
                $slots_game_data = [];
                foreach ($data as $key => $value){
                    if(!$value[$configData['slotsgameid']])continue;
                    if($configData['is_gameid_status'])if(in_array($value[$configData['slotsgameid']],$old_slots))continue; //重复的不导入
                    $slots_game_data[] = [
                        'slotsgameid' => $value[$configData['slotsgameid']],
                        'englishname' => $value[$configData['englishname']],
                        'name' => $value[$configData['name']] ?? '',
                        'table_id' => $value[$configData['table_id']] ?? '',
                        'createtime' => time(),
                        'terrace_id' => $configData['terrace_id'],
                    ];

                }

                if($slots_game_data){
                    Db::name('slots_game')->insertAll($slots_game_data);
                    return Json::successful('数据导入成功!');
                }
                return Json::successful('无数据存储!');
            }
        }

        return Json::fail('数据获取失败');
    }

    /**
     * @return void 获取游戏列表
     */
    public function getSlotsList(){
        $type = request()->post('type');
        if($type == 'pg'){
            $save_data = $this->getPgSolts();
        }elseif ($type == 'pp'){
            $save_data = $this->getPpSolts();
        }elseif ($type == 'td'){
            $save_data = $this->getTdSolts();
        }elseif ($type == 'eg'){
            $save_data = $this->getEgSolts();
        }elseif ($type == 'jl'){
            $save_data = $this->getJlSolts();
        }elseif ($type == 'we'){
            $save_data = $this->getWeSolts();
            return Json::successful('数据获取成功!');
        }elseif ($type == 'jdb'){
            $save_data = $this->getJdbSolts();
        }/*elseif ($type == 'spr'){
            $save_data = $this->getSprSolts();
        }*/elseif ($type == 'evo'){
            $save_data = $this->getEvoSolts();
        }elseif ($type == 'bg'){
            $save_data = $this->getBgSolts();
        }elseif ($type == 'joker'){
            $save_data = $this->getJokerSolts();
        }else{
            return Json::fail('该平台暂不支持获取游戏列表');
        }
        if(!$save_data){
            return Json::successful('数据获取成功!');
        }
        $res = Db::name('slots_game')->insertAll($save_data);
        if(!$res){
            return Json::fail('获取失败!');
        }
        return Json::successful('数据获取成功!');

    }



    public function guid() {
        mt_srand((double) microtime() * 10000);//optional for php 4.2.0 and up.
        $charid = strtoupper(md5(uniqid(rand(), true)));
        $hyphen = chr(45);// "-"
        $uuid   = substr($charid, 0, 8) . $hyphen
            . substr($charid, 8, 4) . $hyphen
            . substr($charid, 12, 4) . $hyphen
            . substr($charid, 16, 4) . $hyphen
            . substr($charid, 20, 12);

        return $uuid;
    }





    /**
     * CURL请求
     *
     * @param            $url        请求url地址
     * @param            $method     请求方法 get post
     * @param null       $postfields post数据数组
     * @param array      $headers 请求header信息
     * @param bool|false $debug 调试开启 默认false
     *
     * @return mixed
     */

    public function http_post($url, $data, $header = [], $proxy = [])
    {

        $data = http_build_query($data, '', '&');

        $headerData = ["Content-Type: application/x-www-form-urlencoded;charset='utf-8'"];
        if (!empty($header)) {
            $headerData = array_merge($headerData, $header);
        }

        $timeout = 30;

        // 启动一个CURL会话
        $curl = curl_init();

        curl_setopt($curl, CURLOPT_URL, $url); // 要访问的地址
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false); // 对认证证书来源的检查。https请求不验证证书和hosts
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false); // 从证书中检查SSL加密算法是否存在
        curl_setopt($curl, CURLOPT_POST, 1); // Post提交的数据包
        curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
        curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, $timeout); // 设置超时限制防止死循环
        curl_setopt($curl, CURLOPT_TIMEOUT, $timeout);
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headerData); //模拟的header头
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1); // 获取的信息以文件流的形式返回

        $output = curl_exec($curl);

        curl_close($curl);

        return $output;
    }


    /**
     * 获取投注的最大和最小值
     * @param $legalBetAmounts
     * @return array
     */
    public function getMaxMinnum($legalBetAmounts){
        $distance = array_column($legalBetAmounts,'betAmount');
        array_multisort($distance,SORT_ASC,$legalBetAmounts);
        $min = $legalBetAmounts[0]['betAmount'];
        $max = array_pop($legalBetAmounts)['betAmount'];
        return [$min,$max];
    }

    public function getPgSolts(){
        //测试服
        $postHttp = $this->http_post('https://teenpatticlub.shop/api/Cepgbx/youxiliebiao',[],[]);

        //正式服
//        \app\api\controller\slots\Pgslots::getGameUrl();

        $data = isset(json_decode($postHttp,true)['data']) ? json_decode($postHttp,true)['data'] : '';
        if(!$data){
            return Json::fail('数据获取失败');
        }



        $save_data = [];
        $slots_game = Db::name('slots_game')->where('terrace_id',1)->column('id','slotsgameid');//获取最新的PG游戏
        foreach ($data as $k => $v){ //获取最新的PG游戏
            if(isset($slots_game[$v['gameId']])){
                continue;
            }
            $save_data[$k]['slotsgameid'] = $v['gameId'];
            $save_data[$k]['englishname'] = $v['gameName'];
            $save_data[$k]['createtime'] = time();
            $save_data[$k]['terrace_id'] = 1;
        }
        return $save_data;
    }


    public function getPpSolts(){

//        $localDateTime = '2023-07-04 11:10:00'; // 本地时间
//        $timezone = new \DateTimeZone('Asia/Shanghai'); // 设置本地时区为 'Asia/Shanghai'
//        $datetime = new \DateTime($localDateTime, $timezone); // 创建一个 DateTime 对象，设置时间为本地时间
//        $datetime->setTimezone(new \DateTimeZone('GMT')); // 将时区设置为 GMT0
//        $gmtTimestamp = $datetime->getTimestamp(); // 获取 GMT0 时间戳
//
//        $gameList = \app\api\controller\slots\Ppsoft::getHistory($gmtTimestamp.'000');
//
//        dd($gameList);
        $gameList = \app\api\controller\slots\Ppslots::GetGame();
        $gameListArray = json_decode($gameList,true);

        if($gameListArray['error'] != 0 || !isset($gameListArray['gameList'])){
            return Json::fail('数据拉取失败');
        }
        $slots_game = Db::name('slots_game')->where('terrace_id',2)->column('id','slotsgameid');//获取最新的PG游戏
        $save_data = [];

        foreach ($gameListArray['gameList'] as $k => $v){ //获取最新的PG游戏
            if(isset($slots_game[$v['gameID']])){
                continue;
            }
            $save_data[$k]['slotsgameid'] = $v['gameID'];
            $save_data[$k]['englishname'] = $v['gameName'];
            $save_data[$k]['createtime'] = time();

            $save_data[$k]['terrace_id'] = 2;
        }

        return $save_data;
    }

    private function getTdSolts(){
        $gameList = \app\api\controller\slots\Tdslots::GetGame();

        if($gameList['code'] != 200){
            return [];
        }
        $slots_game = Db::name('slots_game')->where('terrace_id',3)->column('id','slotsgameid');//获取最新的PG游戏
        $save_data = [];
        $game_type = [1 => 2,2 => 1,3=>10,5 =>11,8=>12];
        foreach ($gameList['data'] as $k => $v){ //获取最新的PG游戏
            if(isset($slots_game[$v['GameId']])){
                continue;
            }
            $save_data[$k]['slotsgameid'] = $v['GameId'];
            $save_data[$k]['englishname'] = $v['name']['en-US'];
            $save_data[$k]['name'] = $v['name']['zh-CN'];
            $save_data[$k]['createtime'] = time();
//            $save_data[$k]['free_spins'] = (strtoupper(trim($v['frbAvailable'])) == 'TRUE' || $v['frbAvailable'] = true)  ? 1 : -1;
            $save_data[$k]['terrace_id'] = 3;

        }
        return $save_data;
    }

    private function getJlSolts(){
        $gameList = \app\api\controller\slots\Jlslots::GetGame();

        if($gameList['code'] != 200){
            return [];
        }
        $slots_game = Db::name('slots_game')->where('terrace_id',9)->column('id','slotsgameid');//获取最新的PG游戏
        $save_data = [];
        $game_type = [1 => 2,2 => 1,3=>10,5 =>11,8=>12];
        foreach ($gameList['data'] as $k => $v){ //获取最新的PG游戏
            if(isset($slots_game[$v['GameId']])){
                continue;
            }
            $save_data[$k]['slotsgameid'] = $v['GameId'];
            $save_data[$k]['englishname'] = $v['name']['en-US'];
            $save_data[$k]['name'] = $v['name']['zh-CN'];
            $save_data[$k]['createtime'] = time();
//            $save_data[$k]['free_spins'] = (strtoupper(trim($v['frbAvailable'])) == 'TRUE' || $v['frbAvailable'] = true)  ? 1 : -1;
            $save_data[$k]['terrace_id'] = 9;

        }
        return $save_data;
    }


    private function getWeSolts(){
        $gameList = \app\api\controller\slots\Weslots::GetGame();

        if($gameList['code'] != 200){
            return [];
        }
        $slots_game = Db::name('slots_game')->where('terrace_id',10)->column('id','englishname');//获取最新的PG游戏
        $save_data = [];
        foreach ($gameList['data'] as $k => $v){ //获取最新的PG游戏
            if(isset($slots_game[$v['en']])){
                Db::name('slots_game')->where('id',$slots_game[$v['en']])->update(['slotsgameid' =>  $v['gameID']]);
                continue;
            }
            $save_data[$k]['slotsgameid'] = $v['gameID'];
            $save_data[$k]['englishname'] = $v['en'];
            $save_data[$k]['name'] = $v['zh'];
            $save_data[$k]['createtime'] = time();
            $save_data[$k]['terrace_id'] = 10;

        }
        if($save_data)Db::name('slots_game')->insertAll($save_data);
        return 1;

    }

    private function getEgSolts(){
        $gameList = \app\api\controller\slots\Egslots::GetGame();

        if($gameList['code'] != 200){
            return [];
        }
        $slots_game = Db::name('slots_game')->where('terrace_id',4)->column('id','slotsgameid');//获取最新的PG游戏
        $save_data = [];
        $game_type = [1 => 2,2 => 1,3=>10,5 =>11,8=>12];
        foreach ($gameList['data'] as $k => $v){ //获取最新的PG游戏
            if(isset($slots_game[$v['ID']])){
                continue;
            }
            $save_data[$k]['slotsgameid'] = $v['ID'];
            $save_data[$k]['englishname'] = $v['Name']['en'];
            $save_data[$k]['name'] = $v['Name']['zh-chs'];
            $save_data[$k]['createtime'] = time();
//            $save_data[$k]['free_spins'] = (strtoupper(trim($v['frbAvailable'])) == 'TRUE' || $v['frbAvailable'] = true)  ? 1 : -1;
            $save_data[$k]['terrace_id'] = 4;

        }
        return $save_data;
    }

    private function getJdbSolts(){
        $gameList = \app\api\controller\slots\Jdbslots::GetGame();

        if($gameList['code'] != 200){
            return [];
        }
        $slots_game = Db::name('slots_game')->where('terrace_id',12)->column('id','slotsgameid');//获取最新的PG游戏
        $save_data = [];
        foreach ($gameList['data'] as $k => $v){ //获取最新的PG游戏
            if (in_array($v['gType'], [0,7,9,12,18])) {
                $game_type = [0 => 1, 7 => 7, 9 => 6, 12 => 5, 18 => 9];
                $list = $v['list'];
                foreach ($list as $lk => $lv) {
                    if (isset($slots_game[$v['gType'] . '-' . $lv['mType']])) {
                        continue;
                    }
                    $save_data[] = [
                        'slotsgameid' => $v['gType'].'-'.$lv['mType'],
                        'englishname' => $lv['name'],
                        'name' => $lv['name'],
                        'createtime' => time(),
                        'terrace_id' => 12,
                        'image' => $lv['image'],
                        'type' => $game_type[$v['gType']],
                    ];
                }
            }

        }
        return $save_data;
    }

    private function getSprSolts(){
        $gameList = \app\api\controller\slots\Sprslots::GetGame();

        if($gameList['code'] != 200){
            return [];
        }
        $slots_game = Db::name('slots_game')->where('terrace_id',14)->column('id','slotsgameid');//获取最新的游戏
        $save_data = [];
        foreach ($gameList['data'] as $k => $v){ //获取最新的PG游戏
            if (in_array($v['gType'], [22])) {
                //$game_type = [0 => 1, 7 => 7, 9 => 6, 12 => 5, 18 => 9];
                $list = $v['list'];
                foreach ($list as $lk => $lv) {
                    if (isset($slots_game[$v['gType'] . '-' . $lv['mType']])) {
                        continue;
                    }
                    $save_data[] = [
                        'slotsgameid' => $v['gType'].'-'.$lv['mType'],
                        'englishname' => $lv['name'],
                        'name' => $lv['name'],
                        'createtime' => time(),
                        'terrace_id' => 14,
                        'image' => $lv['image'],
                        'type' => 6//$game_type[$v['gType']],
                    ];
                }
            }

        }
        return $save_data;
    }


    public function getEvoSolts(){
        $gameList = \app\api\controller\slots\Evoslots::GetGame();

        if($gameList['code'] != 200){
            return [];
        }
        $slots_game = Db::name('slots_game')->where('terrace_id',13)->column('id','table_id');//获取最新的PG游戏
        $save_data = [];
        foreach ($gameList['data'] as $k => $v){ //获取最新的PG游戏
            if(isset($slots_game[$v['Table ID']])){
                Db::name('slots_game')->where('terrace_id',13)->where('table_id',$v['Table ID'])->update(['slotsgameid' => $v['Direct Launch Table ID']]);
                continue;
            }
            $save_data[$k]['slotsgameid'] = $v['Direct Launch Table ID'];
            $save_data[$k]['englishname'] = $v['Table Name'];
            $save_data[$k]['name'] = $v['Table Name'];
            $save_data[$k]['createtime'] = time();
            $save_data[$k]['terrace_id'] = 13;
            $save_data[$k]['table_id'] = $v['Table ID'];

        }
        return $save_data;
    }

    private function getBgSolts(){
        $gameList = \app\api\controller\slots\Bgslots::GetGame();
        if($gameList['code'] != 200){
            return [];
        }
        $slots_game = Db::name('slots_game')->where('terrace_id',15)->column('id','slotsgameid');
        $save_data = [];
        foreach ($gameList['data'] as $k => $v){
            if(isset($slots_game[$v['identifier']])){
                continue;
            }
            $save_data[$k]['slotsgameid'] = $v['identifier'];
            $save_data[$k]['englishname'] = $v['title'];
            $save_data[$k]['name'] = $v['title'];
            $save_data[$k]['createtime'] = time();
//            $save_data[$k]['free_spins'] = (strtoupper(trim($v['frbAvailable'])) == 'TRUE' || $v['frbAvailable'] = true)  ? 1 : -1;
            $save_data[$k]['terrace_id'] = 15;

        }
        return $save_data;
    }



    private function getJokerSolts(){
        $gameList = \app\api\controller\slots\Jokerslots::GetGame();
        if($gameList['code'] != 200){
            return [];
        }
        $slots_game = Db::name('slots_game')->where('terrace_id',16)->column('id','slotsgameid');
        $save_data = [];
        foreach ($gameList['data'] as $k => $v){
            if(isset($slots_game[$v['GameCode']])){
                continue;
            }
            $save_data[$k]['slotsgameid'] = $v['GameCode'];
            $save_data[$k]['englishname'] = $v['GameName'];
            $save_data[$k]['name'] = $v['GameName'];
            $save_data[$k]['createtime'] = time();
//            $save_data[$k]['free_spins'] = (strtoupper(trim($v['frbAvailable'])) == 'TRUE' || $v['frbAvailable'] = true)  ? 1 : -1;
            $save_data[$k]['terrace_id'] = 16;

        }
        return $save_data;
    }

    private function getUploadConfig(){
        //记住导入方法里面需要修改key值与导入文档中的商家对应的索引相同
        return [
            'name' => -1,   //Slots中文游戏名称
            'englishname' => 2,   //Slots英文游戏名称
            'slotsgameid' => 0,    //游戏ID
            'table_id' => 1,    //游戏ID
            'terrace_id' => 11, //我们平台的厂商ID
            'is_gameid_status' => 1, //是否检查该三方平台gameID重复
        ];
    }

    /**
     * 编辑区块游戏规则
     * @return string
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function blockGameRule()
    {
        $params =  request()->param();
        $info = Db::name('block_game')->where('game_id',$params['game_id'])->find();
        if ($info) {
            $info['page_bet_rule'] = json_decode($info['page_bet_rule'], true);
            $info['transfer_bet_rule'] = json_decode($info['transfer_bet_rule'], true);
        }
        $this->assign('game_id', $info['game_id'] ?? []);
        $this->assign('game_name', $info['game_name'] ?? []);
        $this->assign('page_rule', $info['page_bet_rule'] ?? []);
        $this->assign('transfer_rule', $info['transfer_bet_rule'] ?? []);
        return $this->fetch('edit_bet_rule');
    }

    /**
     * 保存区块游戏投注规则
     * @return null
     * @throws \think\db\exception\DbException
     */
    public function saveBlockGameRule()
    {
        $params =  request()->param();
        $ruleType = $params['rule_type'] ?? '';
        $roomRule = $this->packRoomRule($params, $ruleType);
        if ($roomRule) {
            // 更新数据
            $res = Db::name('block_game')->where('game_id',$params['game_id'])->update([$ruleType.'_bet_rule' => json_encode($roomRule)]);
        }
        if (!$res) {
            return Json::fail('操作失败');
        }
        return Json::success('操作成功');
    }

    /**
     * 组装场次数据
     * @param array $params
     * @param string $ruleType
     * @return array
     */
    public function packRoomRule(array $params, string $ruleType): array
    {
        $rooms = ['room_cj', 'room_zj'];
        if ($ruleType == 'page') $rooms[] = 'room_gj';
        $roomRule = [];
        foreach ($rooms as $r) {
            // 赔率
            $roomRule[$r]['loss_ratio'] = $params[$r.'_loss_ratio'];
            if (isset($params[$r.'_nn_loss_ratio'])) $roomRule[$r]['nn_loss_ratio'] = $params[$r.'_nn_loss_ratio'];
            if (isset($params[$r.'_zx_equal_loss_ratio'])) $roomRule[$r]['zx_equal_loss_ratio'] = $params[$r.'_zx_equal_loss_ratio'];
            if (isset($params[$r.'_sxfee_refund_ratio'])) $roomRule[$r]['sxfee_refund_ratio'] = $params[$r.'_sxfee_refund_ratio'];

            // 限红
            if ($ruleType == 'transfer') {
                $roomRule[$r]['bet_limit']['usdt'] = explode('-', $params[$r.'_bet_limit_usdt']);
                $roomRule[$r]['bet_limit']['trx'] = explode('-', $params[$r.'_bet_limit_trx']);
                if (isset($params[$r.'_bet_limit_other_usdt'])) $roomRule[$r]['bet_limit_other']['usdt'] = explode('-', $params[$r.'_bet_limit_other_usdt']);
                if (isset($params[$r.'_bet_limit_other_trx'])) $roomRule[$r]['bet_limit_other']['trx'] = explode('-', $params[$r.'_bet_limit_other_trx']);
                $roomRule[$r]['bet_address'] = $params[$r.'_bet_address'];
            } else {
                $roomRule[$r]['bet_limit']['coin'] = explode('-', $params[$r.'_bet_limit_coin']);
                if (isset($params[$r.'_bet_limit_other_coin'])) $roomRule[$r]['bet_limit_other']['coin'] = explode('-', $params[$r.'_bet_limit_other_coin']);
            }
        }
        return $roomRule;
    }
}

