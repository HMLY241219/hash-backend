<?php

namespace app\api\service\Order;

use app\admin\model\order\Orders;
use service\NewjsonService;
use think\Db;

class OrderService extends BaseService {
	
	/**
	 * 保存充值电话数据
	 *
	 * @param $uid
	 * @param $name
	 * @param $email
	 * @param $mobile
	 *
	 * @return int|string
	 * @throws \think\Exception
	 * @throws \think\exception\PDOException
	 */
	public static function saveRechargePhone($uid, $name, $email, $mobile) {
		if (Db::name('recharge_phone')->where('uid', $uid)->limit(1)->count()) {
			return Db::name('recharge_phone')->where('uid', $uid)
			         ->update(['name' => $name, 'email' => $email, 'phone' => $mobile]);
		} else {
			return Db::name('recharge_phone')->insertGetId(['uid' => $uid, 'name' => $name, 'email' => $email, 'phone' => $mobile]);
		}
	}
	
	/**
	 * 更新订单
	 *
	 * @param $createinfo
	 * @param $gps_adid
	 * @param $tradeorderid
	 * @param $rchanels
	 *
	 * @return ordersModel
	 */
	public static function updateOrder($createinfo, $gps_adid, $tradeorderid, $rchanels) {
		$data = [
			'google_token' => $gps_adid,
			'tradeorderid' => $tradeorderid,
			"rchanels"     => $rchanels,
		];
		
		return Orders::where('out_trade_no', $createinfo['out_trade_no'])->update($data);
	}
	
	/**
	 * 跳转地址并停止向下运行
	 *
	 * @param $jumpUrl
	 */
	public static function jumpUrlExit($jumpUrl) {
		header("Refresh:0;url=" . $jumpUrl);
		exit();
	}
	
	/**
	 * 输出并停止向下运行
	 *
	 * @param $str
	 */
	public static function echoExit($str) {
		echo($str);
		exit();
	}
	
	/**
	 * 更新订单，并跳转地址
	 *
	 * @param $createinfo
	 * @param $gps_adid
	 * @param $tradeorderid
	 * @param $rchanels
	 * @param $jumpUrl
	 */
	public static function updateOrderJumpUrl($createinfo, $gps_adid, $tradeorderid, $rchanels, $jumpUrl) {
		self::updateOrder($createinfo, $gps_adid, $tradeorderid, $rchanels);
		
		self::jumpUrlExit($jumpUrl);
	}
	
	/**
	 * 输出消息并停止向下运行
	 *
	 * @param $msg
	 */
	public static function echoMsgExit($msg) {
		echo "<h2>{$msg}</h2>";
		exit();
	}
	
	/**
	 * 返回失败操作
	 *
	 * @param $is_return_url
	 * @param $msg
	 * @param $packname 项目做兼容使用，237游戏服务器，返回值加密处理，需要传包名
	 */
	public static function returnFailOperate($is_return_url, $msg, $packname) {
		if ($is_return_url == config('const.yes')) {
			return NewjsonService::fail($msg, [], $packname);
		}
		
		self::echoMsgExit($msg);
	}
	
	
}


