<?php
/**
 * http请求
 */

namespace app\api\service\PGSoft;

class HttpService {
	
	/**
	 * post请求
	 *
	 * @param string $url
	 * @param array  $data
	 * @param array  $header
	 *
	 * @return bool|string
	 */
	public static function postCURL(string $url, array $data, array $header = []) {
		$data = http_build_query($data, '', '&');
		
		$headerData = ["Content-Type: application/x-www-form-urlencoded;charset='utf-8'"];
		if (!empty($header)) {
			$headerData = array_merge($headerData, $header);
		}
		
		$timeout = 30;
		
		// 启动一个CURL会话
		$curl = curl_init();
		
		curl_setopt($curl, CURLOPT_URL, $url); // 要访问的地址
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false); // 对认证证书来源的检查。https请求不验证证书和hosts
		curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false); // 从证书中检查SSL加密算法是否存在
		curl_setopt($curl, CURLOPT_POST, 1); // Post提交的数据包
		curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
		curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, $timeout); // 设置超时限制防止死循环
		curl_setopt($curl, CURLOPT_TIMEOUT, $timeout);
		curl_setopt($curl, CURLOPT_HTTPHEADER, $headerData); //模拟的header头
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1); // 获取的信息以文件流的形式返回
		
		$output = curl_exec($curl);
		
		curl_close($curl);
		
		return $output;
	}
	
}


