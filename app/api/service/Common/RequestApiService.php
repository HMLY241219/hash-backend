<?php
/**
 * 请求接口
 */

namespace app\api\service\Common;

use think\facade\Log;

class RequestApiService {
	
	/**
	 * CURL请求
	 *
	 * @param            $url        请求url地址
	 * @param            $method     请求方法 get post
	 * @param null       $postfields post数据数组
	 * @param array      $headers 请求header信息
	 * @param bool|false $debug 调试开启 默认false
	 *
	 * @return bool|string
	 */
	public static function httpRequest($url, $method, $postfields = null, $headers = [], $debug = false) {

		$method = strtoupper($method);
		$ci     = curl_init();
		
		/* Curl settings */
		curl_setopt($ci, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_0);
		curl_setopt($ci, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows NT 6.2; WOW64; rv:34.0) Gecko/20100101 Firefox/34.0");
		curl_setopt($ci, CURLOPT_CONNECTTIMEOUT, 60); /* 在发起连接前等待的时间，如果设置为0，则无限等待 */
		curl_setopt($ci, CURLOPT_TIMEOUT, 7); /* 设置cURL允许执行的最长秒数 */
		curl_setopt($ci, CURLOPT_RETURNTRANSFER, true);
		
		switch ($method) {
			case "POST":
				curl_setopt($ci, CURLOPT_POST, true);
				if (!empty($postfields)) {
					$tmpdatastr = is_array($postfields) ? http_build_query($postfields) : $postfields;

					curl_setopt($ci, CURLOPT_POSTFIELDS, $tmpdatastr);
				}
				break;
			default:
				curl_setopt($ci, CURLOPT_CUSTOMREQUEST, $method); /* //设置请求方式 */
				break;
		}
		
		$ssl = preg_match('/^https:\/\//i', $url) ? true : false;
		curl_setopt($ci, CURLOPT_URL, $url);
		if ($ssl) {
			curl_setopt($ci, CURLOPT_SSL_VERIFYPEER, false); // https请求 不验证证书和hosts
			curl_setopt($ci, CURLOPT_SSL_VERIFYHOST, false); // 不从证书中检查SSL加密算法是否存在
		}
		
		//curl_setopt($ci, CURLOPT_HEADER, true); /*启用时会将头文件的信息作为数据流输出*/
		curl_setopt($ci, CURLOPT_FOLLOWLOCATION, 1);
		curl_setopt($ci, CURLOPT_MAXREDIRS, 2);/*指定最多的HTTP重定向的数量，这个选项是和CURLOPT_FOLLOWLOCATION一起使用的*/
		curl_setopt($ci, CURLOPT_HTTPHEADER, $headers);
		curl_setopt($ci, CURLINFO_HEADER_OUT, true);
		
		/*curl_setopt($ci, CURLOPT_COOKIE, $Cookiestr); * *COOKIE带过去** */
		$response    = curl_exec($ci);
		$requestinfo = curl_getinfo($ci);
		if ($debug) {
			echo "=====post data======\r\n";
			var_dump($postfields);
			echo "=====info===== \r\n";
			print_r($requestinfo);
			echo "=====response=====\r\n";
			print_r($response);
		}
		curl_close($ci);
		
		return $response;
	}
	
}
