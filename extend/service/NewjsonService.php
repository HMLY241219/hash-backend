<?php
/**
 *
 * @author:
 * @day:
 */

namespace service;


use think\facade\Log;

class NewjsonService
{
    private static $SUCCESSFUL_DEFAULT_MSG = 'ok';

    private static $FAIL_DEFAULT_MSG = 'no';

    private static $encryption;

    private static $securityKey16 = 'Sjese(eE%68sLOap';

    private static $iv = '1234567890123456';

    public static function result($status,$msg='',$data=[],$count=0)
    {
        exit(json_encode(compact('status','msg','data','count')));
    }


    public static function successful($msg = 'ok',$data=[],$status=1,$is_en=true)
    {
        self::$encryption = new EncryptionService(self::$securityKey16,'AES-128-ECB',self::$iv);

        if(false == is_string($msg)){
            $data = $msg;
            $msg = self::$SUCCESSFUL_DEFAULT_MSG;
        }

        if($is_en) {
            $data = self::$encryption->encrypt(json_encode($data));
        }

        return json_encode(compact('status','msg','data'));
    }

    public static function status($status,$msg,$result = [])
    {
        $status = strtoupper($status);
        if(true == is_array($msg)){
            $result = $msg;
            $msg = self::$SUCCESSFUL_DEFAULT_MSG;
        }
        return self::result(200,$msg,compact('status','result'));
    }

    public static function fail($msg,$data=[],$packname='awcv.nIWVwKmcp.wqyft',$ret = 400,$count=0,$errorCode=0)
    {
        if(true == is_array($msg)){
            $packname=$data;
            $data = $msg;
            $msg = self::$FAIL_DEFAULT_MSG;
        }
       
         if(!in_array($packname,self::$OLD_PACKNAME)){
            return base64_encode(self::rc4(json_encode(compact('ret','msg','data','count','errorCode')),$packname));
        }else{
             return json_encode(compact('ret','msg','data','count','errorCode'));
        }
    }

    public static function success($msg,$data=[],$packname='awcv.nIWVwKmcp.wqyft',$count=0)
    {
        if(true == is_array($msg)){
            $packname=$data;
            $data = $msg;
            $msg = self::$SUCCESSFUL_DEFAULT_MSG;
        }
        $ret=200;
        if(!in_array($packname,self::$OLD_PACKNAME)){
            return base64_encode(self::rc4(json_encode(compact('ret','msg','data','count')),$packname));
        }else{
             return json_encode(compact('ret','msg','data','count'));   
        }
    }

}