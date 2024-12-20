<?php
/**
 * 参数数据
 */

namespace app\api\service\Order;

use app\admin\model\user\WithdrawLog;
use app\admin\Redis\pbuser\PBUserModel;
use think\Db;
use think\Config;
class ParamDataService extends BaseService {
	
	/**
	 * 获取支付类型
	 *
	 * @param $paytype
	 *
	 * @return mixed
	 * @throws \think\Exception
	 */
	public static function getPayType($paytype) {
		/**
		 * TODO::支付类型处理逻辑：
		 * 1-每次切换支付方式时，在管理后台->运营管理->充值通道开关，设置要打开或者关闭的支付方式即可。
		 * 2-再在管理后台->设置->支付方式版本，原来数字加+1，保存，即可完成切换充值通道
		 */
		
		// 支付类型是否存在
		$paytype_count = Db::name('pay_type')->where('switch', 1)->where('isvalid', 1)->where('id','<>',28)->where('id', $paytype)->count();
		// 支付类型不存在，选择一个打开的支付类型
		if (empty($paytype_count)) {
			// 获取打开的支付类型
			$pay_type_new = Db::name('pay_type')->where('switch', 1)->where('isvalid', 1)->where('id','<>',28)->value('id');
			// 如果没有支付类型打开的，再给一个默认支付类型的值，让支付类型始终有值，用户可以进行支付
			$paytype = !empty($pay_type_new) ? $pay_type_new : (config('paytype'))['onionpay']['value'];
		}
		
		return $paytype;
	}
	
/**
	 * 设置支付基本用户信息
	 *
	 * @param $email
	 * @param $mobile
	 * @param $name
	 * @param $kkk
	 *
	 * @return array
	 */
	public static function setPayBaseUserInfo($uid, $email, $mobile, $name, $kkk) {
		//使用制作的数据
		//使用制作的数据
		if ($email == ' ' || $name == ' ' || $mobile == ' ') {
			$datauser = WithdrawLog::where('status', 1)->where('uid',$uid)->order('id', 'desc')
			                       ->limit(10)->column('email,username,mobile');
            if(count($datauser)>0){
			   $rand     = array_rand($datauser);
            }else{
                $datauser = WithdrawLog::where('status', 1)->order('id', 'desc')
			                       ->limit(50)->column('email,username,mobile');
                $rand     = array_rand($datauser);
            }
			$userinfo = PBUserModel::changuserfield("nick,acc_type", $key = 0, $kkk, []);
			$loginType = config('const.login_acc_type');
			
			if ($userinfo['acc_type'] == $loginType['phone']['value']) {
				$basename = substr($userinfo['nick'], 0, 6);
				$name_array=Config::get('women_avatar');
		        $name=str_replace(" ","",$name_array[array_rand($name_array)]);
				$mobile = PBUserModel::searchuserphone1($uid);
			} elseif ($userinfo['acc_type'] == $loginType['facebook']['value']) {
				$name = str_replace(" ", "", $userinfo['nick']);
				$name = strtolower($name);
			} else {
				//游客
				$name = $datauser[$rand]['username'] ?? '';
				$name = str_replace(" ", "", $name);
				$name = strtolower($name);
			}
			if ($mobile == ' ') {
				$mobile = PBUserModel::searchuserphone1($uid);
				if ($mobile == config('const.default_phone')) {
					$mobile = (string) mt_rand(8165687543, 9999998758);
				}
			}
		}
		$mobile = str_replace(" ", "", $mobile);
		$mobile = str_replace(["\r\n", "\r", "\n"], "", $mobile);
		$name   = str_replace(" ", "", $name);
		$name   = str_replace(["\r\n", "\r", "\n"], "", $name);
		
		if(count($datauser)>0){
		        $email = $rand ?? '';
		}else{
		   $email = self::createRandomStr(5).self::randStr()."@gmail.com";   
		}
		$email  = str_replace(" ", "", $email);
	    $email  = str_replace(["\r\n", "\r", "\n"], "", $email);
		return [
			'mobile' => $mobile,
			'email'  => $email,
			'name'   => $name,
		];
	}
	public static function createRandomStr($length){

        $str = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';//62个字符
        
        $strlen = 62;
        
        while($length > $strlen){
        
        $str .= $str;
        
        $strlen += 62;
        
        }
        
        $str = str_shuffle($str);
        
        return substr($str,0,$length);
        
    }
    	public static	function randStr($len = 6, $format = 'default')
    
    {
            switch ($format) {
            case 'ALL':
            
            $chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789-@#~';
            
            break;
            
            case 'CHAR':
            
            $chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz-@#~';
            
            break;
            
            case 'NUMBER':
            
            $chars = '0123456789';
            
            break;
            
            default :
            
            $chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
            
            break;
            
            }
            
            mt_srand((double)microtime() * 1000000 * getmypid());
            
            $password = "";
            
            while (strlen($password) < $len)
            
            $password .= substr($chars, (mt_rand() % strlen($chars)), 1);
            
            return $password;
    
    }
	/**
	 * 设置用户基本信息
	 *
	 * @param $email
	 * @param $mobile
	 * @param $name
	 *
	 * @return array
	 */
	public static function setBaseUserInfo($email, $mobile, $name) {
		return [
			'email'  => $email,
			'mobile' => $mobile,
			'name'   => $name,
		];
	}
	
	/**
	 * 设置支付基本用户信息(广州包)
	 *
	 * @param $email
	 * @param $mobile
	 * @param $name
	 * @param $kkk
	 *
	 * @return array
	 */
	public static function setPayUserInfoGZ($uid) {
		$datauser = WithdrawLog::where('status', 1)->order('id', 'desc')->limit(50)->column('email,username,mobile');
		$rand     = array_rand($datauser);
		$kkk      = PBUserModel::searchuser($uid);
		$userinfo = PBUserModel::changuserfield("nick,acc_type", $key = 0, $kkk, []);
		$loginType = config('const.login_acc_type');
		
		if ($userinfo['acc_type'] == $loginType['phone']['value']) {
			$basename = substr($userinfo['nick'], 0, 6);
			$userName = str_replace(" ", "", $userName);
			$userName = strtolower($userName);
			$email    = $userName . $basename . "@gmail.com";
			if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
				$email = $userName . mt_rand(800000, 999999) . "@gmail.com";
			}
		} elseif ($userinfo['acc_type'] == $loginType['facebook']['value']) {
			$userName = str_replace(" ", "", $userinfo['nick']);
			$userName = strtolower($userName);
			$email    = $userName . mt_rand(800000, 999999) . "@gmail.com";
		} else {
			//游客
			$userName = $datauser[$rand]['username'] ?? '';
			$userName = str_replace(" ", "", $userName);
			$userName = strtolower($userName);
			$email    = $userName . mt_rand(800000, 999999) . "@gmail.com";
		}
		
		$phone_number = PBUserModel::searchuserphone1($uid);
		if ($phone_number == config('const.default_phone')) {
			$phone_number = (string) mt_rand(8165687543, 9999998758);
		}
		return [
			'mobile' => $phone_number,
			'email'  => $email,
			'name'   => $userName,
		];
	}
	
}

