<?php
namespace app\middleware;

use EasyWeChat\Support\Log;
use think\facade\Db;
use app\api\controller\ReturnJson;
class TokenMiddleware
{


    private $except = ['Auth/editPassword','home/userinfo','Withdrawlog/add','active.active/turntableActive','active.active/turntable','active.active/getCash']; // 检查是否是需要验证Token的控制器和方法 //'Withinfo/add'
    private $notControllers = ''; //不需要效验的控制器
    private $trueControllers = ['Tasks','Text','slots.Zyslots']; //直接通过的控制器，啥都不需要管
    private $trueExcept = [ 'Cash/TransferInOut','Cash/Get','auth','bet','cancelBet','Sms/getcode'];

    public function handle($request, \Closure $next)
    {
        return $next($request);
        $pathinfo = $request->pathinfo();
        $module = explode('/',$pathinfo)[0] ?? '';

        if(in_array($module,$this->trueControllers) || in_array($pathinfo,$this->trueExcept))return $next($request);

        //设置语言
        $lang = $request->header('lang') ?? 'en'; //语言验证
        $request->lang = $lang;
        //设置包名
        $packname =$request->header('packname') ?? ''; //获取请求头包名

        if(!$packname){
            return ReturnJson::failFul(402,'',2);
        }
        $request->packname = base64_decode($packname);

        if (!in_array($pathinfo, $this->except) && strpos($this->notControllers, $module) === false) {
            // 不需要验证Token的控制器和方法，直接通过
            return $next($request);
        }

        $smstype = input('smstype') ?? 1; // 如果为2的就不需要验证用户UID与token
        if($smstype == 2){
            $request->uid = 0;
            // 继续执行下一个中间件或控制器方法
            return $next($request);
        }

        // 验证Token
        $token = $request->header('user-token');
        if (empty($token)) {
            // Token不存在，返回错误响应
            return ReturnJson::failFul(404,[],2);
        }



        // 解析Token，获取用户ID
        $tokenArray = $this->parseToken($token);
        if($tokenArray['code'] != 200){
            return json(['code'=>401,'msg'=>'token失效']);
        }

        $request->uid = $tokenArray['data'];

        // 继续执行下一个中间件或控制器方法
        return $next($request);
    }


    /**
     * 通过token获取jwt的uid
     * @param $token token
     * @param $loginType 登录来源
     * @return array
     */
    private function parseToken($token)
    {

        $uid = Db::name('user_token')->where('token',$token)->value('uid');


        if(!$uid){
            return ['code' => 201,'msg' => '无效的令牌!','data' => ''];
        }
        return ['code' => 200,'msg' => '成功','data' => $uid];
//        return \jwt\Jwt::check($token);
    }
}

