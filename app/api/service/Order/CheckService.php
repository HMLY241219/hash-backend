<?php
/**
 * 验证层
 */

namespace app\api\service\Order;

use app\admin\model\system\SystemShop;
use app\admin\model\user\WithdrawLog;
use app\admin\Redis\pbuser\PBUserModel;
use think\Db;

class CheckService extends BaseService {
	
	public function __construct() {
	
	}
	
	/**
	 * 常规验证
	 *
	 * @param $email
	 * @param $mobile
	 *
	 * @return string
	 * @throws \think\Exception
	 */
	public static function commonCheck($uid, $email, $mobile, $platform) {
		if ($email != '') {
			if (Db::name('black_list')->where('email', $email)->count()) {
				return 'In maintenance';
			}
		}
		
		if ($mobile != '') {
			if (Db::name('black_list')->where('mobile', $mobile)->count()) {
				return 'In maintenance !!';
			}
		}
		
// 		if ($platform == 'gold') {
// 			return "There is no such recharge method,please try again";
// 		}
		
		//查询是否是黑名单关联人员
		// if ((Db::name('black_list')->where('uidstr','like','%'.$uid.'%')->count()) > 0) {
		// 	return 'Now maintenance ';
		// }
		
		// 订单数量验证
		// if ((Orders::where('uid',$uid)->whereTime('addtime','today')->where('pay_status','no')->count()) > 10) {
		// 	return 'You have too many unpaid orders, please try again tomorrow~';
		// }
		
		return '';
	}
	
	/**
	 * 产品信息验证
	 *
	 * @param $product_id
	 *
	 * @return array
	 * @throws \think\Exception
	 * @throws \think\db\exception\DataNotFoundException
	 * @throws \think\db\exception\ModelNotFoundException
	 * @throws \think\exception\DbException
	 */
	public static function productInfo($product_id) {
		$product_id = (int) $product_id;
		
		$data = [
			'result' => false,
			'msg'    => '',
			'data'   => [],
		];
		if (empty($product_id) || $product_id < 1) {
			$data['msg'] = 'product param error';
			
			return $data;
		}
		
		// 大于1000要减去1000，是用户手动输入金额
		if ($product_id > 1000) {
			if ($product_id < 1100) {
				$data['msg'] = 'The minimum amount is 100 rupees';
				
				return $data;
			}
			
			if ($product_id > 101000) {
				$data['msg'] = 'The maximum amount is 100000 rupees';
				
				return $data;
			}
			$info["id"] = $product_id;
		} elseif ($product_id == 1000) {
			$info["id"] = $product_id;
		} else {
			$info = SystemShop::where("id", $product_id)->find();
			if (empty($info)) {
				$data['msg'] = 'no product info';
				
				return $data;
			}
			$info = $info->toArray();
		}

		$data['result'] = true;
		$data['msg']    = 'success';
		$data['data']   = $info;
		
		return $data;
	}
	
}
