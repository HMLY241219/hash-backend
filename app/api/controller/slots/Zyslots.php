<?php
/**
 * 游戏
 */

namespace app\api\controller\slots;


use app\api\controller\ReturnJson;
use app\Request;
use crmeb\basic\BaseController;
use crmeb\services\MqProducer;
use think\facade\Db;
use think\facade\Log;
use curl\Curl;
use customlibrary\Common;
use think\facade\Config;
use think\facade\Validate;
use app\api\controller\slots\Common as slotsCommon;

class Zyslots extends BaseController {

    /**
     * 测试环境自研游戏过渡使用
     * @param Request $request
     * @return \think\response\Json
     * @throws \RedisException
     */
    public function getBalance(Request $request){
        $param = $request->param();
        $validate = Validate::rule([
            'uid' => 'require',
        ]);
        if (!$validate->check($param)) {
            Log::record("获取redis余额接口数据验证失败===>".$validate->getError());
            return json(['code'=>201, 'message'=>'Missing parameters']);
        }

        try {
            $Reids = new \Redis();
            $Reids->connect(config('redis.ip'), config('redis.port5501'));

            $Reids->hSet("php_login_1_1", $param['uid'], isset($param['token']) ? $param['token'] : '');
            $Reids->hSet("TEXAS_ACCOUNT_1_1", $param['uid'], $param['uid']);

            $Redis5502 = new \Redis();
            $Redis5502->connect(config('redis.ip'), config('redis.port5502'));
            $data = [
                'coins' => isset($param['coins']) ? $param['coins'] : 0,
                'bonus' => isset($param['bonus']) ? $param['bonus'] : 0,
                'exchange' => isset($param['exchange']) ? $param['exchange'] : 0,
                'give' => isset($param['give']) ? $param['give'] : 0,
                'outside_score' => isset($param['outside_score']) ? $param['outside_score'] : 0,
                'pay' => isset($param['pay']) ? $param['pay'] : 0,
                'channel' => isset($param['channel']) ? $param['channel'] : 0,
                'package_id' => isset($param['package_id']) ? $param['package_id'] : 0,
            ];
            $Redis5502->hMSet('user_' . $param['uid'], $data);

            return json(['code' => 200, 'message' => '']);
        }catch (Exception $exception){
            Log::record("错误文件===" . $exception->getFile() . '===错误行数===' . $exception->getLine() . '===错误信息===' . $exception->getMessage());
            return json(['code'=>5, 'message'=>'Other error']);
        }

    }

    /**
     *
     * @param Request $request
     * @return \think\response\Json
     * @throws \RedisException
     */
    public function setBalance(Request $request){
        $param = $request->param();
        $validate = Validate::rule([
            'uid' => 'require',
        ]);
        if (!$validate->check($param)) {
            Log::record("设置获取redis余额接口数据验证失败===>".$validate->getError());
            return json(['code'=>201, 'message'=>'Missing parameters']);
        }

        try {

            $Redis5502 = new \Redis();
            $Redis5502->connect(config('redis.ip'), config('redis.port5502'));

            $res = $Redis5502->hGetAll('user_' . $param['uid']);

            return json(['code' => 200, 'message' => '', 'data' => $res]);
        }catch (Exception $exception){
            Log::record("错误文件===" . $exception->getFile() . '===错误行数===' . $exception->getLine() . '===错误信息===' . $exception->getMessage());
            return json(['code'=>5, 'message'=>'Other error']);
        }

    }

    /**
     * @param Request $request
     * @return \think\response\Json
     * @throws \RedisException
     */
    public function userRedis(Request $request){
        $param = $request->param();
        $validate = Validate::rule([
            'uid' => 'require',
        ]);
        if (!$validate->check($param)) {
            Log::record("获取用户redis余额接口数据验证失败===>".$validate->getError());
            return json(['code'=>201, 'message'=>'Missing parameters']);
        }

        try {

            $Redis5502 = new \Redis();
            $Redis5502->connect(config('redis.ip'), config('redis.port5502'));

            $res = $Redis5502->hGetAll('user_' . $param['uid']);

            return json(['code' => 200, 'message' => '', 'data' => $res]);
        }catch (Exception $exception){
            Log::record("错误文件===" . $exception->getFile() . '===错误行数===' . $exception->getLine() . '===错误信息===' . $exception->getMessage());
            return json(['code'=>5, 'message'=>'Other error']);
        }

    }

}






