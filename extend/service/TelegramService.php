<?php

namespace service;

use crmeb\basic\BaseController;
use think\facade\Db;
use think\facade\Log;
use app\api\controller\Sms;
class TelegramService extends BaseController
{
    const URL = 'https://cg.akali.live/api/TelegramService/sendMessage';
    //const URL = 'http://52.66.230.166/api/TelegramService/sendMessage';


    /**
     * 用户提现失败发消息到tg群
     * @param $data 提现订单数据/订单号
     * @param $error_response 错误数据
     * @return void
     */
    public static function withdrawFail($data=[],$error_response=[]){
        $text = '';
        if (!empty($data)){
            if (!is_array($data) && is_string($data)){
                $data = Db::name('withdraw_log')->where('ordersn',$data)->find();
            }
            $uid = $data['uid'];
            $money = $data['money']/100;
            $status = self::withdrawStatus($data['status']);
            $out_trade_no = $data['ordersn'];
            $error_parm = '';
            $is_server = true;
            if (isset($error_response['error'])){
                $error_parm = $error_response['error'];
            }elseif (isset($error_response['message'])){
                $error_parm = $error_response['message'];
            }elseif (isset($error_response['casDesc'])){
                $error_parm = $error_response['casDesc'];
            }elseif (isset($error_response['errMsg'])){
                $error_parm = $error_response['errMsg'];
            }elseif (isset($error_response['data']['errMsg'])){
                $error_parm = $error_response['data']['errMsg'];
            }elseif (isset($error_response['data']['trade_status'])){
                $error_parm = $error_response['data']['trade_status'];
            }elseif (isset($error_response['msg'])){
                $error_parm = $error_response['msg'];
            }elseif (isset($error_response['errorMessage'])){
                $error_parm = $error_response['errorMessage'];
            }elseif (isset($error_response['resMsg'])){
                $error_parm = $error_response['resMsg'];
            }else{
                $error_parm = json_encode($error_response);
                $is_server = false;
            }
            $error = '';
            $emailText = '';
            if($error_parm)[$error,$emailText] = self::getErrorCn($error_parm,$is_server);

            //发送App邮件
            if($emailText){
                //修改次数
                try {
                    Db::name('withdraw_logcenter')
                        ->where('withdraw_id',$data['id'])
                        ->update([
                            'send_fail_num' => Db::raw('send_fail_num + 1'),
                            'chinese_error' => $error,
                        ]);
                }catch (\Exception $e){
                    Log::error('withdraw_logcenter数据修改失败:'.$e->getMessage());
                }

                //存储发送内容
                Db::name('user_information')->insert([
                    'uid' => $data['uid'],
                    'title' => 'Withdrawal Failed',
                    'content' => $emailText,
                    'createtime' => time(),
                ]);
            }



            $createtime = date('Y-m-d H:i:s',$data['createtime']);
            $text .= "*************提现失败，请检查代付通道*************\r\n玩家ID:".$uid."，提现金额:".$money."，提现平台订单号:".$out_trade_no."，提现订单状态:".$status."，错误原因:".$error."，提现时间:".$createtime."\r\n";

            //self::send(-955997183,$text);
            self::send(-1002189448489,$text);
        }
    }


    /**
     * 提现风控需要审核发送tg消息
     * @param $data 提现订单数据/订单号
     * @return void
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public static function withdrawRisk($data=[]){
        $text = '';
        if (!empty($data)) {
            if (!is_array($data) && is_string($data)){
                $data = Db::name('withdraw_log')->where('ordersn',$data)->find();
                if ($data['idle_order'] == 1) return;
            }
            $uid = $data['uid'];
            $money = $data['money']/100;
            $auditdesc = self::withdrawAuditdesc($data['auditdesc']);
            $ordersn = $data['ordersn'];
            $createtime = date('Y-m-d H:i:s',$data['createtime']);
            $text .= "****************需要运营人员审核****************\r\n用户ID:".$uid."，提现金额:".$money."，提现平台订单号:".$ordersn."，触发风控的原因:".$auditdesc."，提现时间:".$createtime."\r\n";

            //self::send(-864414145, $text);
            self::send(-1002224055491, $text);
        }
    }

    /**
     * 提现成功发送tg消息
     * @param $data 提现订单数据/订单号
     * @return void
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public static function withdrawSuc($data=[]){
        $text = '';
        if (!empty($data)) {
            if (!is_array($data) && is_string($data)){
                $data = Db::name('withdraw_log')->where('ordersn',$data)->find();
            }
            $uid = $data['uid'];
            $money = $data['money']/100;
            $status = self::withdrawStatus(1);//$data['status']
            $ordersn = $data['ordersn'];
            $createtime = date('Y-m-d H:i:s',$data['createtime']);

            //用户信息
            $user_info = Db::name('userinfo')->where('uid',$data['uid'])->find();
            $day_time = strtotime(date('Y-m-d 00:00:00'));//印度今日凌晨12点时间戳
            $user_type = '老用户';
            if ($user_info['regist_time'] > $day_time){
                $user_type = '新用户';
            }

            $text .= "****************提现成功****************\r\n用户ID:".$uid."，提现金额:".$money."，用户类型:".$user_type."，用户VIP等级:".$user_info['vip']."，用户历史提现金额:".($user_info['total_exchange']/100 - $money)."，提现平台订单号:".$ordersn."，提现订单状态:".$status."，提现时间:".$createtime."\r\n";

            //self::send(-991200289, $text);
            self::send(-1001962846118, $text);
        }
    }

    /**
     * 充值成功tg消息
     * @param $order
     * @return void
     */
    public static function rechargeSuc($order=[]){
        $text = '';
        if (!empty($order)) {
            $uid = $order['uid'];
            $money = $order['price']/100;
            $status = self::orderStatus(1);//$order['pay_status']
            $ordersn = $order['ordersn'];
            $paytype = $order['paytype'];
            $createtime = date('Y-m-d H:i:s',$order['createtime']);
            $active_type = '普通充值';
            if ($order['active_id'] > 0){
                $active_type = Db::name('active')->where('id',$order['active_id'])->value('name');
            }
            //用户信息
            $user_info = Db::name('userinfo')->where('uid',$order['uid'])->find();
            $day_time = strtotime(date('Y-m-d 00:00:00'));//印度今日凌晨12点时间戳
            $user_type = '老用户';
            if ($user_info['regist_time'] > $day_time){
                $user_type = '新用户';
            }
            $regist_time = date('Y-m-d H:i:s',$user_info['regist_time']);
            $chanel = Db::name('chanel')->where('channel',$order['channel'])->value('cname');

            $text .= "****************充值成功****************\r\n用户ID:".$uid."，充值金额:".$money."，赠送金额:".($order['zs_money']/100)."，赠送bonus:".($order['zs_bonus']/100)."，用户类型:".$user_type."，用户VIP等级:".$user_info['vip']."，注册时间：".$regist_time."，游戏天数：".$user_info['total_game_day']."，用户历史充值金额:".($order['all_price']/100)."，活动类型:".$active_type."，充值平台订单号:".$ordersn."，充值订单状态:".$status."，充值渠道:".$paytype."，包名:".$order['packname']."，渠道名:".$chanel."，充值时间:".$createtime."\r\n";

            //self::send(-948714463, $text);
            self::send(-1002232857626, $text);
        }
    }

    public function orderFail(){
        $text = '';
        self::send(-915404148,$text);
    }

    /**
     * 错误信息中文转换
     * @param $error
     * @return string
     */
    public static function getErrorCn($error='',$is_server=true){
        $emailText = ': Ji, Sorry sir! the bank payment channel is under maintenance, please try again later!';
        if (strpos($error,'param wrong VPA not support yet') !== false){
            $text = '参数错误，VPA尚不支持';
        }elseif (strpos($error,'ip not in white list') !== false){
            $text = '服务器IP未加入支付平台白名单';
        }elseif (strpos($error,'merchant order duplicate check') !== false){
            $text = '商户订单号重复';
        }elseif (strpos($error,'param wrong amount should less than') !== false){
            $text = '参数错误，金额过大';
        }elseif (strpos($error,'The order_amount must be greater than') !== false){
            $text = '金额必须大于配置值';
        }elseif (strpos($error,'Sign verification failed') !== false){
            $text = '签名验证失败';
        }elseif (strpos($error,'E-mail format is incorrect') !== false || strpos($error,"Invalid value for parameter 'email'") !== false || strpos($error,"invalid email") !== false || strpos($error,'THE EMAIL IS NOT VALID') || strpos($error,'email')){
            $text = '电子邮件格式不正确';
            $emailText = ': Ji, E-mail format is incorrect';
        }elseif (strpos($error,'The payment channel has been closed') !== false || strpos($error,'Transaction failed at bank')){
            $text = '付款通道已关闭';
            $emailText = ': Ji, The bank channel payment failed! Please change your bank account or wait for a while to withdraw money again';
        }elseif (strpos($error,'there are special characters not allowed') !== false){
            $text = '用户名不允许使用特殊字符';
            $emailText = ': Ji, Username cannot use special characters';
        }elseif (strpos($error,'Merchant OrderNo Exists') !== false){
            $text = '商户订单不存在';
        }elseif (strpos($error,'upi is not supported') !== false){
            $text = '不支持的upi';
        }elseif (strpos($error,'FAILURE INVALID ACCOUNT') !== false || strpos($error,'AccountNo format is incorrect') !== false|| strpos('cardNo has spaces',$error) !== false || strpos($error,"cardNo has spaces[UCO BANK]") !== false){
            $emailText = ': Ji, There is a problem with your bank card number. Please correct it and submit it later.';
            $text = '错误的银行账户';
        }elseif (strpos($error,'Invalid IFSC') !== false || strpos($error,'Please provide valid ifsc') !== false || strpos($error,'Invalid Beneficiary IFSC') || strpos($error,'IFSC Invalid')){
            $emailText = ': Ji, Sorry! IFSC error, please make modifications and try again later';
            $text = '错误的IFSC';
        }elseif (strpos($error,"Invalid value for parameter 'phone'") !== false){
            $emailText = ': Ji, Phone number format is incorrect';
            $text = '无效的手机号';
        }elseif (strpos($error,"queue") !== false || strpos($error,"Payout service is currently down") !== false || strpos($error,"The Payout Method Was Stoped") !== false){
            $emailText = ': Ji, Sorry sir! The current channel is closed! Please apply again later.';
            $text = '付款通道已关闭';
        }elseif (strpos($error,"invalid bank account number") !== false || strpos($error,"Validation Error") !== false){
            $emailText = ': Ji, Sorry! Your bank account is invalid, please change your bank account and apply for cash withdrawal again';
            $text = 'NO\/MAS银行卡错误';
        }elseif (strpos($error,"FAILURE INVALID BENEFICIARY MOBILE NO/MAS") !== false){
            $emailText = ': Ji,Sorry! Your mobile phone number is invalid, please change your mobile phone and try again.';
            $text = '手机号无效';
        }elseif (strpos($error,"Sucess! Enquiry success.") !== false){
            $emailText = ': Ji, Your withdrawal information is incorrect, please correct it and submit again.';
            $text = 'NO\/MAS银行卡错误';
        }elseif (strpos($error,"UPSTREAM ERROR") !== false || strpos($error,"Insufficient withdrawal funds") !== false){
            $emailText = ': Ji, The channel fluctuates, please wait for about 30 minutes before withdrawing money.';
            $text = '提现资金不足';
        }elseif (strpos($error,"Either Transaction Id or Corp Id is invalid") !== false){
            $emailText = ': Ji, Your withdrawal information is wrong! Please modify it and try again.';
            $text = 'NO\/MAS银行卡错误';
        }elseif (strpos($error,"Fail") !== false || strpos($error,"TRANSFER_FAILURE") !== false || strpos($error,'failed') !== false){
            $text = '暂无具体错误信息';
        }else{
            if ($is_server){
                $text = \customlibrary\Common::translate($error);
            }else {
                $text = '原因：' . $error;
            }
        }
        return [$text,$emailText];
    }

    /**
     * 提现withdraw表状态status解析
     * @param $status
     * @return string
     */
    public static function withdrawStatus($status=0){
        $text = '';
        switch ($status){
            case 0:
                $text = '申请中';
                break;
            case 1:
                $text = '已处理';
                break;
            case 2:
                $text = '已拒绝';
                break;
            case 3:
                $text = '待审核';
                break;
            case -1:
                $text = '审核驳回';
                break;
            default:
                $text = '其他';
                break;
        }
        return $text;
    }

    /**
     * 提现withdraw表状态auditdesc解析
     * @param $status
     * @return string
     */
    public static function withdrawAuditdesc($status=0){
        $text = '';
        switch ($status){
            case 0:
                $text = '正常提现';
                break;
            case 1:
                $text = '客损金额小于了配置';
                break;
            case 2:
                $text = '打码量充值比小于配置';
                break;
            case 3:
                $text = '非广告用户特殊地区今日总充值大于配置';
                break;
            case 4:
                $text = '非广告用户特殊地区今日总提现大于配置';
                break;
            case 5:
                $text = '非广告用户累计退款最大金额';
                break;
            case 6:
                $text = '非广告用户单笔最大退款金额';
                break;
            case 7:
                $text = '标签需要审核的用户';
                break;
            default:
                $text = '其他';
                break;
        }
        return $text;
    }

    /**
     * 充值订单状态解析
     * @param $status
     * @return string
     */
    public static function orderStatus($status=0){
        $text = '';
        switch ($status){
            case 0:
                $text = '待支付';
                break;
            case 1:
                $text = '已支付';
                break;
            default:
                $text = '其他';
                break;
        }
        return $text;
    }

    /**
     * tg发送
     * @param $chat_id 群id
     * @param $text 发送内容
     * @return void
     */
    public static function send($chat_id,$text){
        try {
            //发送
            $url = self::URL;
            $param = [
                'chat_id' => $chat_id,
                'text' => $text
            ];
            $data = \customlibrary\Common::httpRequest($url,'POST',json_encode($param),array("Content-Type: application/json"),false);
            if (!$data){
                Log::error('发送TG消息失败');
            }

        }catch (\Exception $exception){
            //echo $exception->getMessage();
            Log::error('withdrawFail tg fail==>'.$exception->getMessage());
        }
    }

}