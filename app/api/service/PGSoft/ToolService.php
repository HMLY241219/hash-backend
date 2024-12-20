<?php
/**
 * 工具
 */

namespace app\api\service\PGSoft;

class ToolService {
	
	/**
	 * guid
	 *
	 * @return string
	 */
	public static function guid() {
		mt_srand((double) microtime() * 10000);//optional for php 4.2.0 and up.
		$charid = strtoupper(md5(uniqid(rand(), true)));
		$hyphen = chr(45);// "-"
		$uuid   = substr($charid, 0, 8) . $hyphen
		          . substr($charid, 8, 4) . $hyphen
		          . substr($charid, 12, 4) . $hyphen
		          . substr($charid, 16, 4) . $hyphen
		          . substr($charid, 20, 12);
		
		return $uuid;
	}
	
	/**
	 * 创建订单号
	 *
	 * @return string
	 */
	public static function createOrderNo() {
		return date('YmdHis', time()) . '_' . uniqid();
	}
	
	/**
	 * 日期标识
	 *
	 * @return string
	 */
	public static function dateMark() {
		return date('Ymd', time());
	}
	
	/**
	 * 是否从redis中获取数据
	 *
	 * @return mixed
	 */
	public static function isGetFedis() {
		return config('const.is_get_redis');
	}
	
}
