<?php
/**
 * 充值
 */

namespace app\api\service\PGSoft;

use app\admin\Redis\pbuser\PBUserModel;
use app\api\model\PgsoftCash as PgsoftCashModel;
use think\facade\Db;

class CashService {
	
	/**
	 * 充值
	 *  接口文档对应位置：5.2.4.1 充值
	 *
	 * @param $uid
	 * @param $orderNo
	 * @param $amount
	 *
	 * @return array
	 */
	public static function transferIn($uid, $orderNo, $amount) {
		$amount = MoneyService::bcdiv100($amount);
		
		$url  = ConfigService::apiUrl() . '/Cash/v3/TransferIn?trace_id=' . ToolService::guid();
		$body = [
			'operator_token'     => ConfigService::operatorToken(),
			'secret_key'         => ConfigService::secretKey(),
			'player_name'        => (string) $uid,
			'amount'             => (string) $amount,
			'transfer_reference' => $orderNo,
			'currency'           => ConfigService::currency(),
		];
		
		// 签名头数据
		// $header = SignService::headerData($body);
		$header = [];
		
		// post请求
		$postHttp = HttpService::postCURL($url, $body, $header);
		// 返回数据
		$returnData = self::returnData($url, $body, $postHttp, $header);
		
		return $returnData;
	}
	
	/**
	 * 转出所有余额
	 *  接口文档对应位置：5.2.6 转出所有余额（任选项）
	 *
	 * @param $uid
	 * @param $order_no
	 *
	 * @return array
	 */
	public static function transferAllOut($uid, $order_no) {
		
		$url  = ConfigService::apiUrl() . '/Cash/v3/TransferAllOut?trace_id=' . ToolService::guid();
		$body = [
			'operator_token'     => ConfigService::operatorToken(),
			'secret_key'         => ConfigService::secretKey(),
			'player_name'        => (string) $uid,
			'transfer_reference' => $order_no,
			'currency'           => ConfigService::currency(),
		];
		
		// 签名头数据
		// $header = SignService::headerData($body);
		$header = [];
		
		// post请求
		$postHttp = HttpService::postCURL($url, $body, $header);
		// 返回数据
		$returnData = self::returnData($url, $body, $postHttp, $header);
		
		return $returnData;
	}
	
	/**
	 * 用户余额
	 *
	 * @param $uid
	 *
	 * @return int|mixed
	 */
	public static function userBalance($uid) {
		if (!ToolService::isGetFedis() || empty($uid)) {
			return 0;
		}
		
		$searchuser = PBUserModel::searchuser($uid);
		if ($searchuser == false) {
			return 0;
		}
		
		$info = PBUserModel::changuserfield("uid,chips", 0, $searchuser, []);
		
		$chips = $info['chips'] ?? 0;
		
		return (int)$chips;
	}
	
	/**
	 * 金额信息乘以100
	 *
	 * @param array $amountInfo
	 */
	public static function amountAcmul100(array &$amountInfo) {
		if (!empty($amountInfo)) {
			$amountInfo['transactionId']       = (int) $amountInfo['transactionId'];
			$amountInfo['balanceAmountBefore'] = (int) ($amountInfo['balanceAmountBefore'] * 100);
			$amountInfo['balanceAmount']       = (int) ($amountInfo['balanceAmount'] * 100);
			$amountInfo['amount']              = (int) ($amountInfo['amount'] * 100);
		}
	}
	
	/**
	 * 返回数据
	 *
	 * @param string $url
	 * @param array  $body
	 * @param        $result
	 * @param array  $header
	 *
	 * @return array
	 */
	private static function returnData(string $url, array $body, $result, array $header) {
		$data      = !empty($result) ? json_decode($result, true) : [];
		$isSuccess = !empty($result) && !empty($data) && !empty($data['data']) ? true : false;
		
		if (!$isSuccess && empty($data)) {
			$data = [
				'data'  => null,
				'error' => ['code' => "10000", 'msg' => 'PGSoft获取不到数据'],
			];
		}
		
		return [
			'isSuccess'  => $isSuccess,
			'url'        => $url,
			'method'     => 'POST',
			'methodType' => 'Content-Type: application/x-www-form-urlencoded',
			'header'     => [
				'header'     => request()->header(),
				'signHeader' => $header,
			],
			'body'       => $body,
			'result'     => $result,
			'resultData' => $data,
		];
	}
	
	/**
	 * 获取表名
	 *
	 * @return string
	 */
	public static function getName() {
		return (new PgsoftCashModel())->name;
	}
	
	/**
	 * 添加数据
	 *
	 * @param $cashType
	 * @param $uid
	 * @param $orderNo
	 * @param $rechargeAmount
	 *
	 * @return int|string
	 */
	public static function addData($cashType, $uid, $orderNo, $rechargeAmount, $balance = 0) {
		$data = [
			'cash_type'       => $cashType,
			'uid'             => $uid,
			'order_no'        => $orderNo,
			'recharge_amount' => $rechargeAmount,
			'balance'         => $balance,
			'date_mark'       => ToolService::dateMark(),
			'time_stamp'      => time(),
		];
		
		$id = Db::name(self::getName())->insertGetId($data);
		
		$result = [
			'id'   => $id,
			'data' => $data,
		];
		
		return $result;
	}
	
	/**
	 * 更新数据
	 *
	 * @param       $id
	 * @param array $amountInfo
	 *
	 * @return array
	 * @throws \think\Exception
	 * @throws \think\exception\PDOException
	 */
	public static function updateData($id, array $amountInfo, $balance = 0) {
		$data = [
			'is_success'     => 1,
			'transaction_id' => $amountInfo['transactionId'] ?? '',
			'before'         => $amountInfo['balanceAmountBefore'] ?? 0,
			'after'          => $amountInfo['balanceAmount'] ?? 0,
			'amount'         => $amountInfo['amount'] ?? 0,
			'balance'        => $balance,
			'update_time'    => time(),
		];

		$result = Db::name(self::getName())->where('id', $id)->update($data);
		
		$return = [
			'id'     => $id,
			'result' => $result,
			'data'   => $data,
		];
		
		return $return;
	}
	
	/**
	 * 更新发送GM
	 *
	 * @param $id
	 *
	 * @return array
	 * @throws \think\Exception
	 * @throws \think\exception\PDOException
	 */
	public static function updateSendGM($id) {
		$data = [
			'is_send_gm' => 1,
		];
		
		$result = Db::name(self::getName())->where('id', $id)->update($data);
		
		$return = [
			'id'     => $id,
			'result' => $result,
			'data'   => $data,
		];
		
		return $return;
	}
	
}
