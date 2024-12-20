<?php
/**
 * 签名
 */

namespace app\api\service\PGSoft;


class SignService {
	
	/**
	 * 签名头数据
	 *
	 * @param array $data
	 *
	 * @return array
	 */
	public static function headerData(array $data) {
		return [
			self::headerDate(),
			self::headerContentSha256($data),
			self::headerAuthorization($data),
		];
	}
	
	/**
	 * sha256加密
	 *
	 * @param array $data
	 *
	 * @return string
	 */
	public static function sha256(array $data) {
		$str  = implode('&', $data);
		$sign = strtolower(hash('sha256', $str));
		
		return $sign;
	}
	
	/**
	 * 头日期
	 *
	 * @return string
	 */
	private static function headerDate() {
		return 'x-date: ' . self::dateMark();
	}
	
	/**
	 * 头内容加密
	 *
	 * @return string
	 */
	private static function headerContentSha256(array $data) {
		return 'x-content-sha256: ' . self::sha256($data);
	}
	
	/**
	 * 头认证
	 *
	 * @param array $data
	 *
	 * @return string
	 */
	private static function headerAuthorization(array $data) {
		// Authorization: PWS-HMAC-SHA256 Credential=20190902/OPERATORTOKENEXAMPLE/pws/v1,SignedHeaders=host;x-content-sha256;x-date,Signature=d78220cf06ae85f9d1db11dad9c3fd926799619eab3d28574aadb8cf328cd7aa
		$str = 'Authorization: PWS-HMAC-SHA256 ' . self::credential() . self::signHeader() . self::getSign($data);
		
		return $str;
	}
	
	/**
	 * HmacSHA256
	 *
	 * @param $salt
	 * @param $host
	 * @param $sha256
	 * @param $date
	 *
	 * @return string
	 */
	private static function hmacSha256($salt, $host, $sha256, $date) {
		$salt = utf8_encode($salt);
		$str  = utf8_encode($host . $sha256 . $date);
		
		$sign = hash_hmac("sha256", $str, $salt, true);
		$sign = strtolower(bin2hex($sign));
		
		return $sign;
	}
	
	/**
	 * 获取签名
	 *
	 * @param array $data
	 *
	 * @return string
	 */
	private static function getSign(array $data) {
		$host = request()->header('host');
		$salt = ConfigService::salt();
		$date = self::dateMark();
		
		// 请求数据加密
		$content = self::sha256($data);
		
		// 签名
		$sign = self::hmacSha256($salt, $host, $content, $date);
		$sign = 'Signature=' . $sign;
		
		return $sign;
	}
	
	/**
	 * 资质
	 *
	 * @return string
	 */
	private static function credential() {
		/**
		 * Credential 资质
		 * 您的访问密钥 ID 和范围信息，包括用于计算签名的日期、运营商令牌和服务。
		 * 该字符串具有以下形式：{x-date}/{operator_token}/pws/v1
		 * 例子：20190902/OPERATORTOKENEXAMPLE/pws/v1
		 */
		
		$str = 'Credential=' . self::dateMark() . '/' . ConfigService::operatorToken() . '/pws/v1,';
		
		return $str;
	}
	
	/**
	 * 签名头
	 *
	 * @return string
	 */
	private static function signHeader() {
		/**
		 * SignedHeaders 以分号分隔的请求头列表，用于计算签名。该列表仅包含标头名称，并且标头名称必须为小写。
		 * 固定值：host;x-content-sha256;x-date
		 */
		
		return 'SignedHeaders=host;x-content-sha256;x-date,';
	}
	
	/**
	 * 日期标识
	 *
	 * @return string
	 */
	private static function dateMark() {
		return ToolService::dateMark();
	}
	
}