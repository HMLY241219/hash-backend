<?php
/**
 * 生成签名
 */

namespace app\api\service\ThirdPay;


class CreateSignService {
     /**
	 * zw_pay
	 *
	 * @param $params
	 *
	 * @return string
	 */
	public static function easebuzz_pay($posted, $salt_key) {
		$hash_sequence = "key|txnid|amount|productinfo|firstname|email|udf1|udf2|udf3|udf4|udf5|udf6|udf7|udf8|udf9|udf10";

        // make an array or split into array base on pipe sign.
        $hash_sequence_array = explode('|', $hash_sequence);
        $hash = null;

        // prepare a string based on hash sequence from the $params array.
        foreach ($hash_sequence_array as $value) {
            $hash .= isset($posted[$value]) ? $posted[$value] : '';
            $hash .= '|';
        }

        $hash .= $salt_key;
        #echo $hash;
        #echo " ";
        #echo strtolower(hash('sha512', $hash));
        // generate hash key using hash function(predefine) and return
        return strtolower(hash('sha512', $hash));
	}
	/**
	 * zw_pay
	 *
	 * @param $params
	 *
	 * @return string
	 */
	public static function zw_pay($str, $aes_key,$aes_iv) {
		return base64_encode(openssl_encrypt($str, 'AES-128-CBC', (($aes_key)), OPENSSL_RAW_DATA, $aes_iv));
	}
	/**
	 * zw_pay
	 *
	 * @param $params
	 *
	 * @return string
	 */
	public static function hind_pay($str, $aes_key,$aes_iv) {
		return base64_encode(openssl_encrypt($str, 'AES-128-CBC', (($aes_key)), OPENSSL_RAW_DATA, $aes_iv));
	}
	

	/**
	 * skye_pay
	 *
	 * @param $params
	 *
	 * @return string
	 */
	public static function skye_pay($params, $secretkey) {
		if (empty($params)) {
			return '';
		}
		$md5str='';
			ksort($params);  reset($params);
        foreach ($params as $k=>$v){
            $md5str .= $k.'='.$v.'&';
        }
        
        $rsaPri = "-----BEGIN PRIVATE KEY-----\n" .
          wordwrap($secretkey, 64, "\n", true) .
          "\n-----END PRIVATE KEY-----";
        $merchant_private_key = openssl_get_privatekey($rsaPri);
        openssl_sign($md5str, $sign_info, $merchant_private_key);
        $sign = base64_encode($sign_info);
		
		return $sign;
	}
		/**
	 * bao_pay
	 *
	 * @param $params
	 *
	 * @return string
	 */
	public static function bao_pay($params, $secretkey) {
		if (empty($params)) {
			return '';
		}
		
		ksort($params);  // Sort the $data array based on keys
		
		$postData = "";
		foreach ($params as $k => $val) {
			$postData .= $k . '=' . $val . '&';
		}
		$postData  = rtrim($postData, '&');
		$postData .="&key=".$secretkey;
	    return hash('sha256', $postData);
	}
		/**
	 * rr_pay
	 *
	 * @param $params
	 *
	 * @return string
	 */
	public static function rr_pay($params, $secretkey) {
		if (empty($params)) {
			return '';
		}
		
		$postData = "";
		foreach ($params as $k => $val) {
			$postData .= $k . '=' . $val . '&';
		}
		$postData .= $secretkey;
		
		return md5($postData);
	}
	/**
	 * uu_pay
	 *
	 * @param $params
	 *
	 * @return string
	 */
	public static function uu_pay($params, $secretkey) {
		if (empty($params)) {
			return '';
		}
		
		$p = ksort($params);
		if ($p) {
			$str = '';
			foreach ($params as $k => $val) {
				$str .= $k . '=' . $val . '&';
			}
			$strs = rtrim($str, '&');
			
			$strs .= "&key=" . $secretkey;
			$strs = strtolower(md5($strs));
			
			return $strs;
		}
		
		return '';
	}
		/**
	 * yodu_pay
	 *
	 * @param $params
	 *
	 * @return string
	 */
	public static function yodu_pay($params, $secretkey) {
		if (empty($params)) {
			return '';
		}
		
		$p = ksort($params);
		if ($p) {
			$str = '';
			foreach ($params as $k => $val) {
				$str .= $k . '=' . $val . '&';
			}
			$strs = rtrim($str, '&');
			
			$strs .= "&signKey=" . $secretkey;
			$strs = md5($strs);
			
			return $strs;
		}
		
		return '';
	}
	
	/**
	 * cashfree
	 *
	 * @param $params
	 * @param $secretkey
	 *
	 * @return string
	 */
	public static function cashfree($params, $secretkey) {
		if (empty($params)) {
			return '';
		}
		
		ksort($params);  // Sort the $data array based on keys
		
		$postData = "";
		foreach ($params as $k => $val) {
			$postData .= $k . '=' . $val . '&';
		}
		$postData  = rtrim($postData, '&');
		$hash_hmac = hash_hmac('sha256', $postData, $secretkey, true);
		
		// Use the clientSecret from the oldest active Key Pair.
		return base64_encode($hash_hmac);
	}
	
		/**
	 * cashfree
	 *
	 * @param $params
	 * @param $secretkey
	 *
	 * @return string
	 */
	public static function goodsinfo_pay($params, $secretkey) {
		if (empty($params)) {
			return '';
		}
		
		ksort($params);  // Sort the $data array based on keys
		
		$postData = "";
		foreach ($params as $k => $val) {
			$postData .= $k . '=' . $val . '&';
		}
		$postData  = rtrim($postData, '&');
		$private_key="MIICdgIBADANBgkqhkiG9w0BAQEFAASCAmAwggJcAgEAAoGBALGm5lsuXXd3x2nAjqJhWdfqTZZHL55yKVDaSGZ6TV49VHdJXHRnNkQBid5Xr8O5KTO8w9JjcUBUlPpatpsRbXmeXsYcJ8t66KZspPE4TPeYHpXg85nfF68x9e7tZMEspoBNR1sFYXKv9zHrzsCQe3wZ+S++5Sfl+3f+valFMktHAgMBAAECgYBcTh/62Ihv/qh6Zja2YGbSLUfLAYnYhfC5tfFQbdOtV6h/onqLcOVdSH9eK6mDxL2HyFjnBAxgJJKT0nZ29AMxAp5pKuzPAfuwqu5n2ZkSymo3oVeWYkwP6u7m/hln6ccD/IqzueNhbv6iKKxQexveUYJ6c+o6f0Ag9scqt57VIQJBAPHUlUqr7rT3AWugSJbhe/hNreXt2BeALHLwFIW9nZKmrPMXiVFiGEae4L6LExSVqm2G3xC+TwTBYYEpDFuha5UCQQC8D6Z6iCWtDewLKMiv2OkmKyp46IeERejgiBQ5o+gBdDCMNLBRsy/P6z0QaDTAKGMPSTzQo4lE3VhiwXBD3ARrAkAkYDe8rbQQYH9EMy34FB7TsMuRpH82ub714wsTOvxyzMODJW0wYrMIHGnt/3l1RTYHl5wCJr44FuaVyRjkx5kpAkALgznBzovf6DZHCJwgh7reJ05WUIXbRxxWgn4aeTo+vIosSx1wIvQOWmxGkNqJ2O8XhHhAnYJNwO8kPItO3C05AkEA2eCJmtmGt2nlKus/HFcNfc70YFmZ08tjiHkatCNiUPv6LBBfx6fW4wGuCQMBf/EfLiHQ/Bny/Wy/8T6SSau7lQ==";
		
		$private_key = "-----BEGIN RSA PRIVATE KEY-----\n" . wordwrap($private_key, 64, "\n", true) . "\n-----END RSA PRIVATE KEY-----";

            $key = openssl_get_privatekey($private_key);
            openssl_sign($postData, $signature, $key);
            openssl_free_key($key);
            $sign = base64_encode($signature);
            return $sign;
	}
	
	/**
	 * onionpay_pay
	 *
	 * @param $params
	 * @param $key
	 *
	 * @return string
	 */
	public static function onionpay_pay($params, $secretkey) {
		if (empty($params)) {
			return '';
		}
		
		$signStr = self::joinMap($params);
		$signStr .= '&key=' . $secretkey;
		// ksort($params);
		// $string = [];
		// foreach ($params as $key => $value) {
		//     if ($key == 'sign') continue;
		//     $string[] = $key . '=' . $value;
		// }
		// $sign = (implode('&', $string)) . '&key=' . $secretkey;
		
		return hash('sha256', $signStr);
	}
	
	/**
	 * max_pay
	 *
	 * @param $params
	 * @param $key
	 * @param $iv
	 *
	 * @return string
	 */
	public static function max_pay($params, $secretkey, $iv) {
		if (empty($params)) {
			return '';
		}
		
		return base64_encode(openssl_encrypt(json_encode($params), 'AES-128-CBC', $secretkey, OPENSSL_RAW_DATA, $iv));
	}
	
	/**
	 * nb_pay
	 *
	 * @param $params
	 * @param $secretkey
	 *
	 * @return string
	 */
	public static function verve_pay($params, $secretkey) {
	    if (empty($params)) {
			return '';
		}
		$alldata   = $params['buyerEmail'].$params['buyerFirstName'].$params['buyerLastName'].$params['buyerAddress'].$params['buyerCity'].$params['buyerState'].$params['buyerCountry'].$params['amount'].$params['orderid'];
		$username =  '7595201'; // Username
        $password =  'MgUFY5em'; // Password
        $secret =    '6KeetYvu2TSdsegD'; // API key
        $mercid = '21720'; //Merchant ID
		$privatekey = hash('SHA256', $secret.'@'.$username.":|:".$password);
		$keySha256 = hash('SHA256', $username."~:~".$password);
		$checksum = hash('SHA256', $keySha256.'@'.$alldata.date('Y-m-d'));
		
		return $checksum;
	}
	
	/**
	 * vpay
	 *
	 * @param $params
	 * @param $secretkey
	 *
	 * @return string
	 */
	public static function vpay($params, $secretkey) {
		return self::commonSign($params, $secretkey);
	}
	/**
	 * xpay
	 *
	 * @param $params
	 * @param $secretkey
	 *
	 * @return string
	 */
	public static function x_pay($params, $secretkey) {
		if (empty($params)) {
			return '';
		}
		
		ksort($params);
		$string = [];
		foreach ($params as $key => $value) {
			if ($key == "sign") {
				continue;
			}
			$string[] = $key . '=' . $value;
		}
		$sign = (implode('&', $string)) . '&key=' . $secretkey;
		return strtoupper(md5($sign));
	}
	/**
	 * vpay
	 *
	 * @param $params
	 * @param $secretkey
	 *
	 * @return string
	 */
	public static function tiger_pay($params, $secretkey) {
		if (empty($params)) {
			return '';
		}
		
		ksort($params);
		$string = [];
		foreach ($params as $key => $value) {
			if ($key == "sign") {
				continue;
			}
			$string[] = $key . '=' . $value;
		}
		$sign = (implode('&', $string)) . '&key=' . $secretkey;
		return md5($sign);
	}
	
		/**
	 * cashfree
	 *
	 * @param $params
	 * @param $secretkey
	 *
	 * @return string
	 */
	public static function dida_pay($params, $secretkey) {
		if (empty($params)) {
			return '';
		}
		
		ksort($params);  // Sort the $data array based on keys
		
		$request_data = "";
		foreach ($params as $k => $val) {
			$request_data .=  $val;
		}
		$private_key=$secretkey;
		
		$private_key = "-----BEGIN RSA PRIVATE KEY-----\n" . wordwrap($private_key, 64, "\n", true) . "\n-----END RSA PRIVATE KEY-----";

           $res = openssl_pkey_get_private($private_key);

        $content = '';
        //使用私钥加密
        foreach (str_split($request_data, 117) as $str1) {
            openssl_private_encrypt($str1, $crypted, $res);
            $content .= $crypted;
        }
        
        //编码转换
        $encrypted = base64_encode($content);
        return $encrypted;
	}
	
	
	/**
	 * global_pay
	 *
	 * @param $params
	 * @param $secretkey
	 *
	 * @return string
	 */
	public static function global_pay($params, $secretkey) {
		return self::commonSign($params, $secretkey);
	}
	
	/**
	 * we_pay
	 *
	 * @param $params
	 * @param $secretkey
	 *
	 * @return string
	 */
	public static function we_pay($params, $secretkey) {
		return self::commonSign($params, $secretkey);
	}
	
	public static function qe_pay($params, $secretkey) {
		return self::commonSign($params, $secretkey);
	}
	
	/**
	 * zaak_pay
	 *
	 * @param $params
	 * @param $secretkey
	 *
	 * @return string
	 */
	public static function zaak_pay($params, $secretkey) {
		if (empty($params)) {
			return '';
		}
		
		$checksumsequence = [
			"amount",
			"bankid",
			"buyerAddress",
			"buyerCity",
			"buyerCountry",
			"buyerEmail",
			"buyerFirstName",
			"buyerLastName",
			"buyerPhoneNumber",
			"buyerPincode",
			"buyerState",
			"currency",
			"debitorcredit",
			"merchantIdentifier",
			"merchantIpAddress",
			"mode",
			"orderId",
			"product1Description",
			"product2Description",
			"product3Description",
			"product4Description",
			"productDescription",
			"productInfo",
			"purpose",
			"returnUrl",
			"shipToAddress",
			"shipToCity",
			"shipToCountry",
			"shipToFirstname",
			"shipToLastname",
			"shipToPhoneNumber",
			"shipToPincode",
			"shipToState",
			"showMobile",
			"txnDate",
			"txnType",
			"zpPayOption",
		];
		
		$all = '';
		foreach ($checksumsequence as $seqvalue) {
			if (array_key_exists($seqvalue, $params)) {
				if (!$params[$seqvalue] == "") {
					if ($seqvalue != 'checksum') {
						$all .= $seqvalue;
						$all .= "=";
						$all .= $params[$seqvalue];
						$all .= "&";
					}
				}
				
			}
		}
		
		return hash_hmac('sha256', $all, $secretkey);
	}
	
	/**
	 * ser_pay
	 *
	 * @param $params
	 * @param $secretkey
	 *
	 * @return string
	 */
	public static function ser_pay($params, $secretkey) {
		return self::commonSign($params, $secretkey);
	}
	
	/**
	 * inpay_pay
	 *
	 * @param $params
	 * @param $secretkey
	 *
	 * @return string
	 */
	public static function inpay_pay($params, $secretkey) {
		return self::commonSign($params, $secretkey);
	}
	
	/**
	 * sep_pay
	 *
	 * @param $params
	 * @param $secretkey
	 *
	 * @return string
	 */
	public static function sep_pay($params, $secretkey) {
		return self::commonSign($params, $secretkey);
	}
	
	/**
	 * bmart_pay
	 *
	 * @param $params
	 * @param $secretkey
	 *
	 * @return string
	 */
	public static function bmart_pay($params, $secretkey) {
		return self::commonSign($params, $secretkey);
	}
	
	/**
	 * gold_pay
	 *
	 * @param $params
	 * @param $secretkey
	 *
	 * @return string
	 */
	public static function gold_pay($params, $secretkey) {
		return self::commonSign($params, $secretkey);
	}
	
	/**
	 * z_pay
	 *
	 * @param $params
	 * @param $secretkey
	 *
	 * @return string
	 */
	public static function z_pay($params, $secretkey) {
		return self::commonSign($params, $secretkey);
	}
	
	/**
	 * glo_pay
	 *
	 * @param $params
	 *
	 * @return string|string[]
	 */
	public static function glo_pay($params) {
		if (empty($params)) {
			return '';
		}
		
		ksort($params);
		$str = '';
		foreach ($params as $k => $v) {
			if (!empty($v)) {
				$str .= (string) $k . '=' . $v . '&';
			}
		}
		$str = rtrim($str, '&');
		
		//替换成自己的私钥
		$pem         = chunk_split('MIICdgIBADANBgkqhkiG9w0BAQEFAASCAmAwggJcAgEAAoGBALZpkPf6zgKnldIPlHQEVudbGfvcFolS6MGa8zrNdH/Rracd7o6cW22C6mflLy7cNcbEwUNJN1qqYK8noSP9nroK/jZDWzt0uzHiFge1nS5RrM+ghcZ0Sjsx1HygVClK669fsk7gEVyJnvN/YG0uDPAhSCPviyQbwleG8oavBl0TAgMBAAECgYEAk8sGjRTlU1tK1S6QXkuhycOTUu/oRo0pTqvnxE3wxRsy8oMa5OskXJ9EorcbOoFrBMgnugeZVNlUirW2Jr33mnA8CH41pPANXrKK+9AazTsizvP5nLQDNDM7X3Qm/so3GmMI1CSGz333fBloOabjOEGnCDrItKJ4EX8s4TWZvGkCQQDliRA2aipuEEGIDFZykeS3wXBfjkNjZPQ/l5xK/RE4S6UuPo8Oouq+zGVeSeE2yifmeVScqbVVFIaF3mhnIf7nAkEAy3GgK4HeumUnSOF8o2R5E2ORjeGbJ4lNagbnmKp2U2wgkot/YZqz72ah+Axw9j1JCbKo14pjmYjrifDFt9wG9QJACID3dMyiHcnEY8HxQfVdv+EOxLuEi54l3mVDiROvG6LRz9DJhAVNJRx1dPTPvzPmHofINrWi3jAQe80tmQSNaQJAVv2cBl5+1WbhWGmKePdCSkcd+vQH+uzb3EVdjEr/U4Z9mwvpCNw0ql5RTZZMSw5Dh9EMHzX+hq0kQhRhBtAfbQJANz1T5HHbkluj0eZzipNCSLNpxUycRBWK33xt1K0wHrdAUk6GRrrieGSCpmllEBtpOOajVyR9jQm/dLrYXpk6vw==', 64, "\n");
		$pem         = "-----BEGIN PRIVATE KEY-----\n" . $pem . "-----END PRIVATE KEY-----\n";
		$private_key = openssl_pkey_get_private($pem);
		$crypto      = '';
		foreach (str_split($str, 117) as $chunk) {
			openssl_private_encrypt($chunk, $encryptData, $private_key);
			$crypto .= $encryptData;
		}
		$encrypted = base64_encode($crypto);
		$encrypted = str_replace(['+', '/', '='], ['-', '_', ''], $encrypted);
		
		return $encrypted;
	}
	
	/**
	 * hx_pay
	 *
	 * @param $params
	 * @param $secretkey
	 *
	 * @return string
	 */
	public static function hx_pay($params, $secretkey) {
		if (empty($params)) {
			return '';
		}
		
		$string = $params['orderCode'] . $secretkey;
		$string = md5($string);
		
		return $string;
	}
	
	/**
	 * ax_pay
	 *
	 * @param $params
	 * @param $secretkey
	 *
	 * @return string
	 */
	public static function ax_pay($params, $secretkey) {
		return self::commonSign($params, $secretkey);
	}
	
	/**
	 * funzone_pay
	 *
	 * @param $params
	 * @param $secretkey
	 *
	 * @return string
	 */
	public static function funzone_pay($params, $secretkey) {
		return base64_encode(hash_hmac('sha256', json_encode($params), $secretkey));
	}
	
	/**
	 * lets_pay
	 *
	 * @param $params
	 * @param $secretkey
	 *
	 * @return string
	 */
	public static function lets_pay($params, $secretkey) {
		if (empty($params)) {
			return '';
		}
		
		$sign_str = '';
		$sign_str = $sign_str . 'amount=' . $params['amount'];
		$sign_str = $sign_str . '&bankcode=' . $params['bankcode'];
		$sign_str = $sign_str . '&goods=' . $params['goods'];
		$sign_str = $sign_str . '&mchId=' . $params['mchId'];
		$sign_str = $sign_str . '&notifyUrl=' . $params['notifyUrl'];
		$sign_str = $sign_str . '&orderNo=' . $params['orderNo'];
		$sign_str = $sign_str . '&product=' . $params['product'];
		$sign_str = $sign_str . '&returnUrl=' . $params['returnUrl'];
		$sign_str = $sign_str . '&key=' . $secretkey;
		
		return strtoupper(md5($sign_str));
	}
	
	/**
	 * paypid_pay
	 *
	 * @param       $salt
	 * @param array $input
	 *
	 * @return string
	 */
	public static function paypid_pay($salt, $input = []) {
		/* Columns used for hash calculation, Donot add or remove values from $hash_columns array */
		$hash_columns = ['address_line_1', 'address_line_2', 'amount', 'api_key', 'city', 'country', 'currency', 'description', 'email', 'mode', 'name', 'order_id', 'phone', 'return_url', 'state', 'udf1', 'udf2', 'udf3', 'udf4', 'udf5', 'zip_code',"expiry_in_minutes"];
		/*Sort the array before hashing*/
		sort($hash_columns);
		
		/*Create a | (pipe) separated string of all the $input values which are available in $hash_columns*/
		$hash_data = $salt;
		foreach ($hash_columns as $column) {
			if (isset($input[$column])) {
				if (strlen($input[$column]) > 0) {
					$hash_data .= '|' . trim($input[$column]);
				}
			}
		}
		
		return strtoupper(hash("sha512", $hash_data));
	}
	
	/**
	 * 常规加密
	 *
	 * @param $params
	 * @param $secretkey
	 *
	 * @return string
	 */
	private static function commonSign($params, $secretkey, $mark = 'sign') {
		if (empty($params)) {
			return '';
		}
		
		ksort($params);
		$string = [];
		foreach ($params as $key => $value) {
			if ($key == $mark) {
				continue;
			}
			$string[] = $key . '=' . $value;
		}
		$sign = (implode('&', $string)) . '&key=' . $secretkey;
		return strtolower(md5($sign));
	}
	
	private static function joinMap($map) {
		if (!is_array($map)) {
			return '';
		}
		
		if (!is_array($map)) {
			return [];
		}
		
		if (array_key_exists('sign', $map)) {
			unset($map['sign']);
		}
		ksort($map);
		reset($map);
		$pair = [];
		foreach ($map as $key => $value) {
			if (self::isIgnoredItem($key, $value)) {
				continue;
			}
			
			$tmp = $key . '=';
			if (0 === strcmp('extInfo', $key)) {
				$tmp .= self::joinMap($value);
			} else {
				$tmp .= $value;
			}
			
			$pair[] = $tmp;
		}
		
		if (empty($pair)) {
			return '';
		}
		
		return join('&', $pair);
	}
	
	private static function isIgnoredItem($key, $value) {
		if (empty($key) || empty($value)) {
			return true;
		}
		
		if (0 === strcmp('sign', $key)) {
			return true;
		}
		
		if (0 === strcmp('extInfo', $key)) {
			return false;
		}
		
		if (is_string($value)) {
			return false;
		}
		
		if (is_numeric($value)) {
			return false;
		}
		
		if (is_bool($value)) {
			return false;
		}
		
		return true;
	}
	
}


