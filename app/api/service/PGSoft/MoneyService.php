<?php
/**
 * 金钱计算
 */

namespace app\api\service\PGSoft;

class MoneyService {
	
	// 零元
	const ZERO = '0.00';
	
	
	/**
	 * 加法-两个任意精度数字的加法计算
	 *
	 * @param $num1
	 * @param $num2
	 *
	 * @return string
	 */
	public static function _bcadd($num1, $num2, $scale = 2) {
		return bcadd($num1, $num2, $scale);
	}
	
	/**
	 * 减法-两个任意精度数字的减法
	 *
	 * @param $num1
	 * @param $num2
	 *
	 * @return string
	 */
	public static function _bcsub($num1, $num2, $scale = 2) {
		return bcsub($num1, $num2, $scale);
	}
	
	/**
	 *  乘法-两个任意精度数字乘法计算
	 *
	 * @param $num1
	 * @param $num2
	 * @param $scale
	 *
	 * @return string
	 */
	public static function _bcmul($num1, $num2 = 100, $scale = 2) {
		return bcmul($num1, $num2, $scale);
	}
	
	/**
	 * 除法-两个任意精度的数字除法计算
	 *
	 * @param $num
	 *
	 * @return string|null
	 */
	public static function _bcdiv($num, $divisor = 100, $scale = 2) {
		return bcdiv($num, $divisor, $scale);
	}
	
	/**
	 * 列表除法格式化
	 *
	 * @param array $list 列表
	 *
	 * @return array
	 */
	public static function listDcdivFormat(array $list) {
		if (empty($list)) {
			return [];
		}
		
		foreach ($list as &$value) {
			$value = self::_bcdiv($value);
		}
		
		return $list;
	}
	
	/**
	 * 列表除法格绝对值式化
	 *
	 * @param array $list 列表
	 *
	 * @return array
	 */
	public static function listDcdivAbsFormat(array $list) {
		if (empty($list)) {
			return [];
		}
		
		foreach ($list as &$value) {
			$value = abs(self::_bcdiv($value));
		}
		
		return $list;
	}
	
	
	/**
	 * 乘法100
	 *
	 * @param $num
	 *
	 * @return string|null
	 */
	public static function bcmul100($num) {
		return !empty($num) ? bcmul($num, 100, 2) : 0;
	}
	
	/**
	 * 除以100
	 *
	 * @param $num
	 *
	 * @return string|null
	 */
	public static function bcdiv100($num) {
		return !empty($num) ? bcdiv($num, 100, 2) : 0;
	}
	
	/**
	 * 获取比例
	 *
	 * @param $num1
	 * @param $num2
	 *
	 * @return string|null
	 */
	public static function getRate($num1, $num2) {
		return !empty($num1) && !empty($num2) ? self::bcmul100($num1 / $num2) : 0;
	}
	
	/**
	 * 获取平均
	 *
	 * @param $num1
	 * @param $num2
	 *
	 * @return string|null
	 */
	public static function getAvg($num1, $num2) {
		// 先乘以100，再除以100，目的为了保留小数点后两位数
		return !empty($num1) && !empty($num2) ? self::bcdiv100(($num1 / $num2) * 100) : 0;
	}
	
	
}