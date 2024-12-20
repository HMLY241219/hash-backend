<?php

namespace googleAuth;
require_once root_path().'vendor/googleAuth/PHPGangsta/GoogleAuthenticator.php';

class GoogleAuth
{

    /**
     * 生产谷歌secret
     * @return string
     * @throws \Exception
     */
    public static function createSecret(){
        $ga = new \PHPGangsta_GoogleAuthenticator();
        return $ga->createSecret();
    }


    /**
     * 谷歌验证
     * @param $secret 谷歌生成的secret
     * @param $code 验证码
     * @return void
     */
    public static function verifyCode($secret,$code){
        $ga = new \PHPGangsta_GoogleAuthenticator();

        $checkResult = $ga->verifyCode($secret, $code,1);

        if (!$checkResult) {
            return 0;
        }
        return 1;
    }
}
