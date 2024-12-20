<?php
/**
 * 执行GM命令
 */

namespace app\api\service\PGSoft;

use app\api\model\ExecPhp as ExecPhpModel;
use think\Db;

class ExecPhpService {
	
	/**
	 * 获取表名
	 *
	 * @return string
	 */
	public static function getName() {
		return (new ExecPhpModel())->name;
	}
	
	/**
	 * GM命令添加数据
	 *
	 * @param $uid
	 * @param $cashType
	 * @param $amount
	 *
	 * @return int|string
	 */
	public static function addData($uid, $cashType, $amount) {
		$amount = abs($amount);
		// 充值，GM减钱。转出所有余额，GM加钱
		$amount = $cashType == ConfigService::out() ? (int)$amount : (int) ("-{$amount}");
		$type   = 100;
		
		$json = [
			'msg_id'       => $type,
			'uid'          => $uid,
			'update_int64' => $amount,
			'reason'       => 28,
		];
		
		$data = [
			'type'        => $type,
			'jsonstr'     => json_encode($json),
			'description' => $cashType == ConfigService::in() ? '充值' : '转出所有金额',
			'response'    => 0,
			'status'      => 0,
		];
		
		$id = Db::name(self::getName())->insertGetId($data);
		
		$result = [
			'id'       => $id,
			'cashType' => $cashType,
			'data'     => $data,
		];
		
		return $result;
	}
	
	/**
	 * 未处理数量
	 *
	 * @param $uid
	 *
	 * @return int|string
	 * @throws \think\Exception
	 */
	public static function untreatedCount($uid) {
		$uid  = (int) $uid;
		$data = [
			'count' => 0,
			'sql'   => '',
		];
		if (empty($uid)) {
			return $data;
		}
		
		$count = Db::name(self::getName())->whereLike('jsonstr', '%"uid":' . $uid . '%')
		           ->where('response', 0)->where('status', 0)->count();
		
		$data['count'] = !empty($count) ? $count : 0;
		$data['sql']   = Db::name(self::getName())->getLastSql();
		
		return $data;
	}
	
}


