<?php
/**
 * 配置
 */

namespace app\api\service\PGSoft;


class ConfigService {
	
	/**
	 * 获取配置
	 *
	 * @return mixed
	 */
	public static function getConfig() {
		return config('pgsoft');
	}
	
	/**
	 * 名称
	 *
	 * @return mixed
	 */
	public static function getName() {
		$config = self::getConfig();
		
		return $config['Name'];
	}
	
	/**
	 * 运营商独有的身份识别
	 *
	 * @return mixed
	 */
	public static function operatorToken() {
		$config = self::getConfig();
		
		return $config['OperatorToken'];
	}
	
	/**
	 * 密码
	 *
	 * @return mixed
	 */
	public static function secretKey() {
		$config = self::getConfig();
		
		return $config['SecretKey'];
	}
	
	/**
	 * salt
	 *
	 * @return mixed
	 */
	public static function salt() {
		$config = self::getConfig();
		
		return $config['Salt'];
	}
	
	/**
	 * backOfficeURL
	 *
	 * @return mixed
	 */
	public static function backOfficeURL() {
		$config = self::getConfig();
		
		return $config['BackOfficeURL'];
	}
	
	/**
	 * username
	 *
	 * @return mixed
	 */
	public static function username() {
		$config = self::getConfig();
		
		return $config['Username'];
	}
	
	/**
	 * password
	 *
	 * @return mixed
	 */
	public static function password() {
		$config = self::getConfig();
		
		return $config['Password'];
	}
	
	/**
	 * 币种
	 *
	 * @return mixed
	 */
	public static function currency() {
		$config = self::getConfig();
		
		return $config['currency'];
	}
	
	/**
	 * 交易类型-充值
	 *
	 * @return mixed
	 */
	public static function in() {
		$config = self::getConfig();
		
		return $config['cash_type']['in']['value'];
	}
	
	/**
	 * 交易类型-转出
	 *
	 * @return mixed
	 */
	public static function out() {
		$config = self::getConfig();
		
		return $config['cash_type']['out']['value'];
	}
	
	/**
	 * 是否验证ip地址
	 *
	 * @return mixed
	 */
	public static function isCheckIP() {
		$config = self::getConfig();
		
		return $config['check_ip'];
	}
	
	/**
	 * 验证ip地址
	 *
	 * @return mixed
	 */
	public static function checkIPAdress() {
		$config = self::getConfig();
		
		return $config['check_ip_address'];
	}
	
	/**
	 * 进入PG游戏地址
	 *
	 * @return mixed
	 */
	public static function entryAddress() {
		$config = self::getConfig();
		
		return $config['entry_address'];
	}
	
	/**
	 * 接口请求地址
	 *
	 * @return mixed
	 */
	public static function apiUrl() {
		$config = self::getConfig();
		
		return $config['api_url'];
	}
	
}