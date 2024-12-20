<?php
/**
 * 返回数据
 */

namespace app\api\service\ThirdPay;

use app\admin\model\user\WithdrawLog;
use app\admin\Redis\pbuser\PBUserModel;

class ReturnDataService {
	// 动作类型
	public static $actionJumpUrl  = 1; // url地址跳转
	public static $actionShowPage = 2; // 页面显示
	
	// 请求方法
	public static $methodPost = 'POST';
	public static $methodGet  = 'GET';
	
	/**
	 * 设置支付api数据
	 *
	 * @param        $url 请求地址
	 * @param        $data 请求数据
	 * @param        $head 请求头
	 * @param        $jumpUrl 跳转url
	 * @param int    $result 结果
	 * @param string $method 请求方法
	 *@param string $appPayUrl APP支付url
	 * @return array
	 */
	public static function setPayApiData($url, $data, $head, $jumpUrl, $result, $method = '',$appPayUrl = '') {
		return [
			'result'  => $result ? true : false,
			'url'     => $url,
			'data'    => $data,
			'method'  => !empty($method) ? $method : self::$methodPost,
			'head'    => $head,
			'jumpUrl' => $jumpUrl,
            'appPayUrl' => $appPayUrl,
		];
	}
	
	/**
	 * 设置支付api请求结果数据
	 *
	 * @param $payApiData 支付api数据
	 * @param $result 响应结果
	 * @param $resultDecode 响应结果json_decode后结果
	 * @param $returnMsg 返回消息，一般用于日志，或者显示给用户
	 * @param $msg 响应消息
	 * @param $code 响应code
	 * @param $msgCode 响应消息code
	 * @param $errorLevel 错误级别
	 */
	public static function setPayApiResultData(&$payApiData, $result, $resultDecode, $returnMsg, $msg, $code, $msgCode, $errorLevel) {
		$payApiData['resultData']   = $result;
		$payApiData['resultDecode'] = $resultDecode;
		$payApiData['returnMsg']    = $returnMsg;
		$payApiData['msg']          = $msg;
		$payApiData['code']         = $code;
		$payApiData['msgCode']      = $msgCode;
		$payApiData['errorLevel']   = $errorLevel;
	}
	
	/**
	 * 设置支付api请求交易数据
	 *
	 * @param $payApiData 支付api数据
	 * @param $tradeOrderId 交易号
	 * @param $payTypeName 充值渠道名称
	 */
	public static function setPayApiTrade(&$payApiData, $tradeOrderId, $payTypeName) {
		$payApiData['tradeOrderId'] = $tradeOrderId;
		$payApiData['payTypeName']  = $payTypeName;
	}
	
	/**
	 * 设置动作类型
	 *
	 * @param     $payApiData 支付api数据
	 * @param int $type 类型
	 */
	public static function setActionType(&$payApiData, $type = 0) {
		$payApiData['actionType'] = in_array($type, [self::$actionJumpUrl, self::$actionShowPage]) ? $type : self::$actionJumpUrl;
	}
	
}


