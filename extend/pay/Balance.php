<?php
namespace pay;

use app\api\service\Common\RequestApiService;

use app\api\service\Order\ParamDataService;
use app\api\service\ThirdPay\CreateSignService;
use app\api\service\ThirdPay\ReturnDataService;
use app\common\xsex\Common;
use app\common\service\DBLog\OrderRequestLogService;

use think\facade\Db;
use think\facade\Log;


class Balance{

    private static $methodPost          = 'POST';
    private static $logSuccessTitle     = 'Successfully generated payment order';
    private static $createOrderMsg      = 'create order success';
    private static $createOrderFailMsg  = 'create order fail';
    private static $createOrderErrorMsg = 'create order error';


    //rr_pay
    private static $rrpay_url        = "https://top.adkjk.in/rpay-api/payout/balance/query";                 //下单地址
    private static $rrpay_merchantNo = "1103";
//    private static $rrpay_merchantNo = "999";
    private static $rrpay_appId      = "";                                   //下单地址-gesang
    private static $rrpay_notifyUrl  = "http://1.13.81.132:5001/api/Order/rrpayNotify";  //回调地址
    private static $rrpay_returnUrl  = "https://www.kingofrummy.com/success.php?order_id=";          //回调地址
    private static $rrpay_Key        = "7YzlqZ6xhpkhj5B0";
//    private static $rrpay_Key        = "abc#123!";


    //x_pay
    private static $xpay_url = "https://pay.xpay.wang/api/mch/balance";                                   //查询余额
    private static $xpay_merchantNo       = "M1669706824";                                   //下单地址-gesang
    private static $xpay_appId       = "6385b4487bd27c0dd2ccb6fb";                                   //下单地址-gesang
    private static $xpay_notifyUrl   = "https://great.plannedcompletion.xyz/api/Order/xpayNotify";               //回调地址
    private static $xpay_returnUrl   = "https://www.kingofrummy.com/success.php?order_id=";                  //回调地址
    private static $xpay_Key    = "Tc5YVPZKwck6esXi697jxMDTjvc7ojaWOluTFaiq4kvuO7rmvLIAmSqDQCanXu5NuItfanr4PPEs4bNmkXqTsRMiPiz6vfJI2JNj1AEDU7guTdsQ9IQ4fmFVRfJIoOSz";



    //serpay
    private static $serpay_url = "https://queryapi.metagopayments.com/cashier/balance.ac";//查余额api
    private static $serpay_key = "7939B221D853702A8167E5BA97D556A1";//商户密钥的值
    private static $serpay_orgNo = "8210600739";//机构号
    private static $serpay_mchid = "21061700002301";//商户编码
    private static $serpay_account = "210617000023010288";//子账户号
    private static $serpay_backUrl = "https://hmly.teenpatticlub.shop/api/Order/paserNotify";//回调地址


    //yodu_pay
    private static $yodupay_url = "https://www.yodugame.com/ext_api/v1/payment/add";                                   //下单地址
    private static $yodupay_merchantNo       = "6207922872";                                   //下单地址-gesang
    private static $yodupay_notifyUrl   = "https://great.plannedcompletion.xyz/api/Order/yodupayNotify";               //回调地址
    private static $yodupay_returnUrl   = "https://www.kingofrummy.com/success.php?order_id=";                  //回调地址
    private static $yodupay_Key    = "fFD1CeD446z5RnZrvuY5SYdvu4P8RPpm";

    //curry_pay
    private static $currypay_url = "https://www.yodugame.com/ext_api/v1/payment/add";          //下单地址
    private static $currypay_merchantNo       = "590005";                                   //商户号
    private static $currypay_notifyUrl   = "https://hmly.teenpatticlub.shop/api/Order/currypayNotify";
    private static $currypay_Key    = "04bda2e49b0840d262035e5bf95d98a0";


    //tm_pay
    private static $tmpay_url = "https://beespay.store/gateway/v1/pay/bal";          //下单地址

//    private static $tmpay_merchantNo       = "1M6S80Q0T1";                                   //商户号测试
    private static $tmpay_merchantNo       = "1HHF923W30";                                   //商户号正式
//    private static $tmpay_appid   = "M1E3123051824F36ABFBB75250B0A0DC";  //app_id 测试环境
    private static $tmpay_appid   = "37B6BD129BE9447E9070CFF6D69E956F";  //app_id 正式环境

//    private static $tmpay_Key    = 'KM@8gfWwK0WkZ1#!ux6svzV1ADV:Ftz!*9%A%yW@VZjG=lYMxyIjTB0fw0u#cz0l8RX7ir1#J7fjwop%XJ%f:cZUr$:g041sx^Se3f$X*?tNv3*1DFbT7%R39VTynS8D';//测试
    private static $tmpay_Key    = 'KZd!m7L?eL:A7lCH#vQHOCGC:AAUMSJ:$zX^gOREKpNuDWyl^h*ZU?LWOrbBYK7n00avVwwA=hAe~ZOCW7ll8gCY!l@5sSwRr9vQH8Af&Xd5NH5J:VNsgqK_bW!k1fdD'; //正式
    private static $tmpay_notifyUrl   = "https://hmly.teenpatticlub.shop/api/Order/tmpayNotify";


    //qart_pay
    private static $qartpay_url = "https://open.qartpayment.com/v2/payment/gateway";          //下单地址
    private static $qartpay_merchantNo       = "9CCQITDZ0RCE";                                   //商户号也是appid
    private static $qartpay_notifyUrl   = "http://1.13.81.132:5001/api/Order/qartpayNotify";
    private static $qartpay_Key    = "1WVZR98F5B9J6MD4WDDZ";


    //win_pay
    private static $winpay_url = "https://api.wins-pay.com/api/payment/createOrder";          //下单地址
    private static $winpay_merchantNo       = "214";                                   //商户号也是appid
    private static $winpay_notifyUrl   = "http://1.13.81.132:5001/api/Order/winpayNotify";
    private static $winpay_Key    = "HacMBmyM9MF0sAa";


    //z_pay
    private static $zpay_url = "http://api.spxysz.com/pay/getPartner";          //账户信息地址
    private static $zpay_merchantNo       = "1000100020003303";                                   //商户号也是appid
    private static $zpay_Key    = "5C6E442D6BD743FDBFBAC989A8A4B494"; //应用秘钥
    private static $zpay_appid    = "269";  //应用ID
    private static $zpay_notifyUrl   = "http://1.13.81.132:5001/api/Order/zpayNotify";


    //well_pay
    private static $wellpay_url = "https://pay.wellpay.world/well_c/view/server/aotori/addTrans.php";          //下单地址
    private static $wellpay_merchantNo       = "998800022";                                   //商户号也是appid
    private static $wellpay_Key    = "ZVF1TL0HMTUINI40";
    private static $wellpay_notifyUrl   = "http://1.13.81.132:5001/api/Order/wellpayNotify";


    //gre_pay
    private static $grepay_url = "https://api.metagopayments.com/cashier/pay.ac";          //下单地址
    private static $grepay_merchantNo       = "23071800002672";                                   //商户号也是appid
    private static $grepay_orgNo       = "8230701133";                                   //商户号也是机构号
    private static $grepay_Key    = "2AE6BA696B6DD4AD077F2A2B1441A1BB";
    private static $grepay_notifyUrl   = "http://1.13.81.132:5001/api/Order/grepayNotify";


    //joy_pay
    private static $joypay_url = "https://www.joypay.info/gold-pay/portal/queryBalance";          //查询余额
    private static $joypay_service       = "64b91883e4b064ff03614454";                        //服务号
    private static $joypay_Key    = "MIICdgIBADANBgkqhkiG9w0BAQEFAASCAmAwggJcAgEAAoGBANqoNBLBI/iDcYL2vkGKMcexV9YIK9CdLNM5S0Y8R4hbpbKx8v6lf3yj/ZTyJzVl5dMdjbpcJGdKOTu+Em6pQO3bA9+klDqP/4kKM2tNB3bwo3Dg1saED0nAmhdyMMSkw6Yz8iwcV20vNy5cvS81Evp3ZfojmGHfRbf8vFEgHxbHAgMBAAECgYAgRJVWtTEBQiiUuqQOGP5KqXW8bL1GjoNocnqU1V17FodH7THeeX7sXmkUO34kx7JYavKY73Mh2RbEJcMjmI+vpH9SO16eue/MyUTN+kAugkDVJGPDCsGpC+Wg9QF8iq41CCf/zzyIx4ArWBgn1yQFpkb+um14hc1Npc64gVuoNQJBAO2NjChXAJy/nnHNQkpOvxjn5ZPHAXnWllpdliBj57ZE0eTTJfRkI6JG/Bvu/nAaJKLFRgA44qbteWMctLg+Ak0CQQDrowOK0+oyLiZBe+X9A15Z2QVOcMhEyw5VefwHV8zfmYgN0e62B5bJpcE/bdR2XHV5POZyD8kJUB6mAGARAH9jAkBgx6YuWSO6uKaInqM/Os3IC9IQXqdPSAmBT1d2Yr1oGKmanBt+cb3Cw0C68KdgbIY4ej6GoKZWc7Fcm7lUxo6RAkEAuJ7cY6Vt1Ss7ZgtBQ1+kSRk0gyTyhJPkAyy0PryYFIkihFF7irufdRadtqjC0onWsMr6c1vS060mlkGtAyU0qQJAM6r4SCJna9ndkBgy0F/Fb50Je2tq/vMey3abD/Bf+vXjS/+86CBiRa/ieflLtm0kjziE7NX4cth9fehix9YD5w==";  //客户端私钥
    private static $joypay_notifyUrl   = "http://1.13.81.132:5001/api/Order/joypayNotify";


    //mas_pay
    private static $maspay_url = "https://payment.masterpay.vip/api/pay/pay";          //下单地址
    private static $maspay_merchantNo       = "M1690717883";                        //商户号
    private static $maspay_appid       = "64c64ebbe4b053230c3cd918";                        //appid
    private static $maspay_Key    = "4SRPuUUyy7FpoFUd1Cg5C0Jm9OeDJE3kt6OREHk67GpJbtQOM4nQRJUwgvZzQfWgH3yQvJnU78KATy6b6l2GFigkw6RFUpKPkZxxJkyMoSXbe79ARtmMCtX5CTUwHAnp";  //商户秘钥
    private static $maspay_notifyUrl   = "http://1.13.81.132:5001/api/Order/maspayNotify";

    //waka_pay
    private static $wakapay_url = "https://wkpluss.com/gateway/";          //下单地址
    private static $wakapay_merchantNo       = "8890439";                        //商户号
    private static $wakapay_Key    = "8eba3208c2b6070cbf431013bea8fd14";  //商户秘钥
    private static $wakapay_notifyUrl   = "https://hmly.teenpatticlub.shop/api/Order/wakapayNotify";

    //ab_pay
    private static $abpay_url = "https://pay.abpay888.com/queryBlance";          //下单地址
    private static $abpay_merchantNo       = "10386";                        //商户号
    private static $abpayKey    = "tfhFsLNsZY147l2EPIAtxjs0OPxF4a1Q";  //商户秘钥
    private static $abpay_notifyUrl   = "http://1.13.81.132:5001/api/Order/abpayNotify";

    //fun_pay
    private static $funpay_url = "https://api.stimulatepay.com/account/payout/balance";          //余额地址
    private static $funpay_merchantNo       = "pcI98HftC1SLR8qj";                        //商户号
    private static $funpayKey    = "5e48c9b9170f493185f8c9a96c45b487";  //商户秘钥
    private static $funpay_notifyUrl   = "http://1.13.81.132:5001/api/Order/funpayNotify";

    //go_pay
    private static $gopay_url = "https://goopay.online/api/balance";          //余额地址
    private static $gopay_merchantNo       = "2023100015";                        //商户号
    private static $gopayKey    = "d65cc4596f20499ea4af91a998321f5c";  //商户秘钥
    private static $gopay_notifyUrl   = "http://1.13.81.132:5001/api/Order/gopayNotify";

    //24hrpay
    // private static $hr24pay_url = "http://test-pay.24hrpay.vip/common/query/allBalance";          //测试
    private static $hr24pay_url = "https://pay.24hrpay.vip/common/query/allBalance";          //正式
    // private static $hr24pay_mchId    = "20000170"; //测试
    private static $hr24pay_mchId    = "50000567"; //正式
    // private static $hr24pay_appKey    = "QG8OZF7SDXVWEEOMQ6R9OPEWMJLLUUXLAA2ZDHHMI3KUBUYYFMGGDRPC4FEXMFX93RIJJYQTPJRTCWNXREB2IU4PCW56S5FW7ZVQ5RHL9J5N407ZG4SIUG22ME5IBITJ"; //测试
    private static $hr24pay_appKey    = "CABS32R2LZEGAQWRUMM1N7OLPHJ512N1Z9EL7BHYT1ZBQLHYNE1SXW8WF0LBO0XYFQLOT1VLHK0YUWO4T89G8QJC12SL8UCGSOKPAXZZFJTLZWVJ82K73UR6EUKLJSPK"; //正式
    private static $hr24pay_notifyUrl   = "http://124.221.1.74:9502/Order/hr24payNotify";


    //lets_pay
    private static $letspay_url = "http://check.letspayfast.com/qaccount";                                   //下单地址
    private static $letspay_mchId       = "722931450180";
    private static $letspay_notifyUrl   = "http://1.13.81.132:5001/api/Order/letspayNotify";               //回调地址
    private static $letspay_Key    = "YFYCHSXAY6DPNS5A0NUYGDD66NSUFXFCUIPCLTXWNQJF0HG5V5IMQKC7AIC071HXZZERDBOBLPIOQUUROFA2AIQKUZDWJTP3N06ZKJPXWJSBJRFORFLGDY5MP3U7VPHE";



    //letstwo_pay  lets_pay原生
    private static $letstwopay_url = "http://check.letspayfast.com/qaccount";                                   //下单地址
    private static $letstwopay_mchId       = "723450269337";
    private static $letstwopay_notifyUrl   = "http://1.13.81.132:5001/api/Order/letspayNotify";               //回调地址
    private static $letstwopay_Key    = "IZUGUT9LZR6LQIUGV6HMHJZUPREJTNWAZ8R99SJQNFCUBOUYKEK0LZUWWJ6GNIE6ENZNTKX9DKCYBRRJ0VJWXER9S1OVEVGLKWINIMRCL1HEHUJPKJ5IX0ZGX59SE0TL";

    //dragon_pay
    private static $dragonpay_url = "https://dragonpayment.net/api/inr/balance/query";                                   //下单地址
    private static $dragonpay_appKey       = "53E64C7EFACD3F30D1";
    private static $dragonpay_notifyUrl   = "http://124.221.1.74:9502/Order/dragonpayNotify";             //回调地址
    private static $dragonpay_secret    = "81d51489d6bbe4045e3c9b6d6e6067c6068e6e4b";

    //ant_pay
    private static $antpay_url = "https://api.antpay.io/v2/queryBalance";                                   //下单地址
    private static $antpay_merchant_code       = "AM1723630965609";
    private static $antpay_notifyUrl   = "http://124.221.1.74:9502/Order/antpayNotify";             //回调地址
    private static $antpay_key    = "43e795347e032fa4d439706ac01309f5";

    //ff_pay
    private static $ffpay_url = "https://api.ffpays.com/query/balance";                                   //下单地址
    private static $ffpay_mchId      = "100777805";//正式
    private static $ffpay_notifyUrl   = "http://124.221.1.74:9502/Order/ffpayNotify";             //回调地址
    private static $ffpay_key    = "c82fe00601a14d7b91a6bb2b44355f9b";//正式

    //cow_pay
    private static $cowpay_url = "https://pay365.cowpay.co/v2/queryBalance";                                   //下单地址
    private static $cowpay_mchId      = "1723714607199";
    private static $cowpay_notifyUrl   = "http://124.221.1.74:9502/Order/cowpayNotify";             //回调地址
    private static $cowpay_key    = "9c8303152d19b5aac5336bcd5f16fc34";

    //wdd_pay
    private static $wddpay_url = "https://www.wddeasypay.com/out/balance";                                   //下单地址
    private static $wddpay_mchId      = "10238";
    private static $wddpay_notifyUrl   = "https://www.3377win.com/Order/wddpayNotify";             //回调地址
    private static $wddpay_key    = "sLwEMOQjDKorywnP";

    //timi_pay
    private static $timipay_url = "https://www.timipay.shop/lh_daifu/money_query";                                   //下单地址
    private static $timipay_mchId      = "529098346";
    private static $timipay_notifyUrl   = "https://www.3377win.com/Order/timipayNotify";             //回调地址
    private static $timipay_key    = "56c773f8e761b72c722e1ff1991d2547";

    //newfun_pay
    private static $newfunpay_url = "https://api.funpay.tv/balanceOf";                                   //下单地址
    private static $newfunpay_mchId      = "1059"; //正式
    private static $newfunpay_notifyUrl   = "https://www.3377win.com/Order/newfunpayNotify";             //回调地址
    private static $newfunpay_key    = "MIICdgIBADANBgkqhkiG9w0BAQEFAASCAmAwggJcAgEAAoGBAJMRc60xlWTJmdtm6jFkbk2LNiax2d/bFWw46oXydTuR4HXU2eX0QVpClogKn2CdkA4vwmYt9pc8POwEfwBqq3jMz8Si/5i6YIskdmnktiNa6D/lB0K22CFWQxo+ks/BH7k+pas2+IyL6KO2EHsSwG/67jrjnB3XTLqIndvYNV+zAgMBAAECgYAabL7Tpj6ZEu4tsWKwCEMXdMWAk2E56zQAs4NUGPn+f5oMofea7VXWwXMps3rqkbUCD4vG70hI6T5rC+3D5ea0Mpk5YFd2HW8LEyS2VBAcADkfLYRf6KIChFQ3fvTiqxP1qmVyO7mDlxkuLgMOPSX5kp6JL/hsf3esS+gNcvqFLQJBALvxkkh/JBT0MRMp9zb33ma0Yl/gqqvU9ujqmVzgEknKpNFF2kVpWBdJ56ORTEwgR8BuXisYYfQdsfCGUy/seh8CQQDIUraK4H5HgLYRQoCkBBNFSlMvZV60FicEd3RHjY0QDa4fJrD+LJMFt9loAZXBC226uxYXtjyc1w6EPFT9z4/tAkAzPa2wblmcDOfEXdC0/+d3AP9BPLPLnYikADJIDB9wVvuQwwa7nfkSgGfTRK4Uo0hswqqR/VfXgrEc7sKHcmXpAkBkFi9uI8v0HbLZ3Mg5KnAWZpQ5UgSHJapI6QYH2glow+0DU2mLFOpAKSNOe7w+v18LtP3MyxhtpGV0XFB6n4HhAkEArnUMYgOQHWJHqNrxoDuzYA3alfpHe8/S7VHZ3oPB3FAmpLQDx81C3+7q5MOlHASTU8qvMNEirJeAW3wuyhteaw==";//正式

    //lq_pay
    private static $lqpay_url = "http://lqpay.txzfpay.top/sys/apple/api/balance";                                   //下单地址
    private static $lqpay_deptId      = "1710169284135714818";  //机构号
    private static $lqpay_mchId      = "22000023";
    private static $lqpay_notifyUrl   = "https://www.3377win.com/Order/lqpayNotify";             //回调地址
    private static $lqpay_key    = "MIICdQIBADANBgkqhkiG9w0BAQEFAASCAl8wggJbAgEAAoGBAN231QFbn8xmA83LecawDmnoHPD4asBG79dJkknggqQgW8yG1dRNnevsJRPZyDMQMRObPnIYIB0KOQ3ewyUjfrEsphJdTeIZUn1zYfuTPAkRsjv8w5xvMwG3WF7RSDh4p7wnXleowmxw2D5U5/k3cahfL5SNqaJXBzLVprHRZK3DAgMBAAECgYAZnJs38XAXqe8ljiwuhfbcSApT0bZvKKKbAW4rJ4qfz/cavLaltCOadahgzyb/sw6gP64qetv2ztABaKqtNxjywmfXZkG5eKk5sHUdHJAPXe5xGvVbXcXtCg9uFLuolu0Qhh6g4MuEXfZ5/HhIMHopJKW1eneYOoJJKr+3miopxQJBAPjk+qZ2QMLLx2E9VCnK7sZCkZA6UntagvaMg7ml9pWjxRrTDjWqBBcl3XyXvsj848W21hdCwWdhUKfnPsoiTq0CQQDkDDy40PpPc77soa8u+BRcP7smKuYf9wluSaCv/4sYKw6yWmPLX8leHXCWf9oZbqSvJwH8bVBaxl/NT198rKwvAkBz4aB1ul8CkwAcXQJ/htVPB5VgUlcuyYBqLBf0arn5B8vwZk2aXLMU1/NcXAZe66dc2XiqUdFcQanc0sSgNgLtAkBipFhvqRVc4LgpKxbXvj8wV/Df5ZZ9JSJTLk3vUx4baiSFSUv5YIl9yEY3Ez6H2bAqgzj8s1wap8wwxrCLATXJAkA7DE4k6B9cSwndrS2djI9JHItrLUkoFNjVq79frH8PcFXVJG7c3mG3nxXxb8n4dl5qt8W9Iy6hE3zCilz7AcRb";

    //threeq_pay
    private static $threeqpay_url = "https://pay.3qpay.org/api/payout/balance";                                   //下单地址
    private static $threeqpay_appId      = "66c81be0e4b00bf3fc383a31";
    private static $threeqpay_mchId      = "M1724390368";
    private static $threeqpay_notifyUrl   = "https://www.3377win.com/Order/threeqpayNotify";             //回调地址
    private static $threeqpay_key    = "HsSxrEU6sHIW32udk8xKR055q5lqzqtJzbCoMnBFmrXAGc2TvAFrMRKONSuXfuMaBKh8f2RvEP0o3buoKl7i5WINymzPnkYMgg5BPyE5FDb7E5UjSm9ePjEDCrKDUjsK";

    //tata_pay
    private static $tatapay_url = "http://meapi.kakamesh.com/pay_api/POrder";
    private static $tatapay_mchId      = "20000024";
    private static $tatapay_notifyUrl   = "https://www.3377win.com/Order/tatapayNotify";
    private static $tatapay_key    = "4796B2AAE9074E409D3CAC4CEA16FEAE";

    //pay_pay
    private static $paypay_url = "https://api.paypayonline.vip/api/queryMerBalance";
    private static $paypay_mchId      = "3132FB00A9144EABA6E5243DA32FA23F";
    private static $paypay_notifyUrl   = "https://www.3377win.com/Order/paypayNotify";
    private static $paypay_key    = "3CxPH8MjrtWxU3chLfbA3t4cbcH43OFo4gf4U1gOhtEMgTS8grP9iOTelwLoKWGy";

    //g_pay
    private static $gpay_url = "https://api.gpayindia.com/admin/platform/api/out/balance";
    private static $gpay_mchId      = "1828416315993178114";
    private static $gpay_notifyUrl   = "https://www.3377win.com/Order/gpayNotify";
    private static $gpay_key    = "0356d6cd250eee7ba9ef9f7a1aa10250";

    //show_pay

    private static $showpay_url = "https://api.newbhh.com/v1/pay/balance"; //正式
    private static $showpay_mchId      = "594"; //测试
    private static $showpay_notifyUrl   = "https://www.3377win.com/Order/showpayNotify";
    private static $showpay_key    = "c5b4e62bd506ba8b78a7284a2f9bbf73"; //测试

    //tmtwo_pay
    private static $tmtwopay_url = "https://beespay.store/gateway/v1/pay/bal";          //下单地址

    private static $tmtwopay_merchantNo       = "192UNCC334";                                   //商户号正式

    private static $tmtwopay_appid   = "3E2591A316794E53969538D4CFF849D8";  //app_id 正式环境

    private static $tmtwopay_Key    = 'K#wuMZPkbp8HD^TipRxv1R2~_Ux*Ua^JlSxZrLok=7^3urQ%QG_qpxfCQYPS0A7%tcWDSIea%Z7g1k!xOkAuRTpk&sWcWm_k6::41?nB$ewpA$*EBj7db@S~5UPTgefD'; //正式
    private static $tmtwopay_notifyUrl   = "https://www.3377win.com/Order/tmpayNotify";

    //yh_pay
    private static $yhpay_url = "http://gateway.yhpay365.com/api/balance";
    // private string $yhpay_mchId      = "91000005"; //测试
    private static $yhpay_mchId      = "91000048";  //正式
    private static $yhpay_notifyUrl   = "https://www.3377win.com/Order/yhpayNotify";
    // private string $yhpay_key    = "3jdS5RnwUnSNsOUQvfICZhps";//测试
    private static $yhpay_key    = "7jqPfsyzqLSfuPlKpxkuEpQk";//正式

    //allin1_pay
    private static $allin1pay_url = "https://app.allin1pay.com/order/deposit/create";          //下单地址
    private static $allin1pay_merchantNo       = "197";                                   //商户号正式
    private static $allin1pay_appid   = "197";  //app_id 正式环境
    private static $allin1pay_Key    = 'f5baf5bbaf9f6d8eb6420684a60a717d'; //正式
    private static $allin1pay_notifyUrl   = "https://www.3377win.com/Order/allin1payNotify";

    //make_pay
    private static $makepay_url = "https://novo.txzfpay.top/sys/zapi/balance";          //下单地址
    private static $makepay_appkey   = "1829113188401680385-1840045975921152002";  // 正式环境
    private static $makepay_Key    = '04003728683241822137002479242609'; //正式
    private static $makepay_notifyUrl   = "https://www.3377win.com/Order/makepayNotify";

    //best_pay
    private static $bestpay_url  = "https://gateway.bestpay-cus.com/payment/merchantQuery";                 //下单地址

    private static $bestpay_merchantNo = "67";

    private static $bestpay_notifyUrl  = "https://www.3377win.com/Order/bestpayNotify";  //回调地址
    private static $bestpay_Key        = "MIICeQIBADANBgkqhkiG9w0BAQEFAASCAmMwggJfAgEAAoGBALB+zfoVSdUZKUladjZZOL68mzCcvCN2TVvIZTd2OlPnSMTYvRKy+WXNI3FyZCTiXxjDgYhNXNRUgrz7eRzKYGUEAAbJW6UIRxQlCvXzInDanoA5xQpGJO1VuyQq2khX2FuZHnjsNhzghSeufEwsXoi+IrpTGB7irhTZMY4kucHRAgMBAAECgYEAqAG9Lw7uvmR6MbJkDu41nxNIoyi/yv4FO5ZyCy6G7XGfiopKyS8HSwnQcGCUxaubHKaWeloyQIjF/wFe07ItuMY6Z/nFrrzBfSzve29UsQx/bRPD8bRwMjscyIVhTfUrj97vODByWbP6MqVByfvRkMRyyQUNz60jc8Ow7BowfgECQQDVotdAkEawM8A1lPxcr0YlgeaN6lIkUf/W9ftDiAgtKPpft+lstCKF4R9zLZl0BD8niFpzCxm9pipXcVa7Ap6hAkEA036GtJGBof3oWdJ5xWTbLxmhjKFf04U4WuFkykbughvtPlhUNAEY3NSVMvaOlfuyveFD+c8+BBZLl5daqXhFMQJBAMHfP1w2EhBBRoLZq5Mo9I2BLwtGxDh1uakIHXeRcWoaL+zBZ7HgXxwDypipnwKr/+wOT5brUfbLXs1v63dWz0ECQQC5yLHIOPGpPYQ4Mz4o+lnYXCmfgbrN8n74xnplfj3SKXoUhD8jl7shcdTGefPzKLFxP0sZTMXrjTJGLfzEVhRhAkEAzNi5Znfp5PoPsmCMcn3rLDFK6lJevroeAOfhgb11bwKjLwhFJtIHG9EWJ+hhMuTu4bLGZRg6aE3Woo0uSWycRw==";

    //zip_pay
    private static $zippay_url  = "https://gateway.zippay-in.com/payment/merchantQuery";                 //下单地址

    private static $zippay_merchantNo = "483";

    private static $zippay_notifyUrl  = "http://124.221.1.74:9502/Order/zippayNotify";  //回调地址
    private static $zippay_Key        = "MIICdgIBADANBgkqhkiG9w0BAQEFAASCAmAwggJcAgEAAoGBAKg/rFB1IrwElT/dv7PdmgzjrN0SaCEivGFcmQccIjpUg1ZY2UgWKm95ZH/uM7obiXxPV5jA0w7Tyk8vooY5+IIUiZhlF7WcyQqV6hjZQxQW99lsQDTas+94xNDjZU4IOfm8wYDV6HfcrdZ//kSJajMNiYct8qj9n2JkPKEly2MlAgMBAAECgYALvB0to23fxUYPpUzIo80p1vtok+8VWJHhDI9T0p+Eh/59GEdXYsxk6AedcKTE90S4meQXMGPIJfd3XHAugn6VnxeZQXpQqoIl0YCzl0Fxlptt70rRG4DJPfqdDArIoU8V0Pi9qVpV4hFTRNvd4KaRAoY7JqGZz04yafWJlNR4oQJBANaXM5tQRiX2+PsLuCdqRLoh4GPx43USkqQZJN34bs1c9ls3UXuzYFOgDM/Yz9UCO8caI9dXpPFeLXOP3BsvzL0CQQDIty06CaAkgNfFZ04ozNVoijksjiQ9JP0+MUyNMQVO7d0gUYc4KAeNIW1E438XvAx+/KbGvfA6LbuRaaUnZDqJAkEApqJ1LZcRUevNfcyk7N6FjfA+ef3cvg11F756tW90Qz58A2saeC9bjrSLHl9jTCpW1w5CZLcnW1LhgopkxivBFQJAGWUzz7gQDw5OPqfHd9oS1ltGyKBjbWkUsZ3DNcoSBd6Kr+Ag37YQ3oZwMNsn5XThj9+fql2122aV6NwZDVbdIQJAcjQW5+Ef7HlROzf4WfUEk6wE3+AR7HMCCXeuX2FTPXUz/e92ZJC00Hqwefpg+ziF0gk65aVOFxad7abJ57pNqQ==";//测试

    //upi_pay
    private static $upipay_url  = "https://api.upi-pays.com/api/payout/balance";                 //下单地址

    private static $upipay_merchantNo = "258"; //正式

    private static $upipay_notifyUrl  = "https://www.3377win.com/Order/upipayNotify";  //回调地址

    private static $upipay_Key        = "c5C6XrNbA82a134";//正式

    //支付成功页面
    private static $paySuccessHtml = "https://hmly.teenpatticlub.shop/h5/pay/success.html";
    //支付失败页面
    private static $payFailHtml = "https://hmly.teenpatticlub.shop/h5/pay/fail.html";

    private static $header = array(
        "Content-Type: application/x-www-form-urlencoded",
    );

    private static $zr_header = array(
        "Content-Type: application/json",
    );


    /**
     * @return void 统一支付渠道
     * @param $paytype 支付渠道
     * @param $createinfo 创建订单信息
     * @param $baseUserInfo 基本用户信息
     */
    public static function pay($paytype){
        $res = self::$paytype();
        return $res;
    }


    /**
     * rr_pay
     *
     * @param $createinfo 创建订单信息
     * @param $baseUserInfo 基本用户信息
     *
     * @return array
     */
    public static function rr_pay() {
        $url    = self::$rrpay_url;
        $data   = [
            "merchantId"      => (int)self::$rrpay_merchantNo,
        ];

        // TODO::暂不使用签名方式
        $data['sign'] = CreateSignService::rr_pay($data,self::$rrpay_Key);

        $data['timestamp'] = time() * 1000;

// 		$http     = RequestApiService::httpsPost($url, json_encode($data1), $header);
// 		var_dump($http);exit;
        $http     = RequestApiService::httpRequest($url, ReturnDataService::$methodPost, stripslashes(json_encode($data)), self::$zr_header,false);

        $response = !empty($http) ? json_decode($http, true) : [];

        $re_data = [];
        if (!empty($response)) {
            $re_data['balance'] = isset($response['data']['abalance']) ? $response['data']['abalance'] : '';
        }
        return $re_data;
    }


    /**
     * x_pay
     *
     * @param $createinfo 创建订单信息
     * @param $baseUserInfo 基本用户信息
     *
     * @return array
     */
    public static function x_pay() {
        $url    = self::$xpay_url;
        $data = [
            "mchNo" => self::$xpay_merchantNo,
            "appId" => self::$xpay_appId,
            "reqTime" => time()."000",
        ];

        // TODO::暂不使用签名方式
        $data['sign'] = CreateSignService::x_pay($data,self::$xpay_Key);


        $http     = RequestApiService::httpRequest($url, ReturnDataService::$methodPost, json_encode($data), self::$zr_header,false);
        $response = !empty($http) ? json_decode($http, true) : [];

        $re_data = [];
        if (!empty($response)) {
            $re_data['balance'] = isset($response['data']['mchBalance']) ? $response['data']['mchBalance'] : '';
        }
        return $re_data;
    }


    /**
     * ser_pay
     *
     * @param $createinfo 创建订单信息
     * @param $baseUserInfo 基本用户信息
     *
     * @return array
     */
    public static function ser_pay() {

        $url    = self::$serpay_url;
        $header = self::$header;

        $data         = [
            "version"     => "2.1",
            "orgNo"       => self::$serpay_orgNo,
            "custId"      => self::$serpay_mchid,
            "account"      => self::$serpay_account,
        ];

        $data['sign'] = CreateSignService::ser_pay($data, self::$serpay_key);

        $http     = RequestApiService::httpRequest($url, ReturnDataService::$methodPost, $data, $header);
        $response = !empty($http) ? json_decode($http, true) : [];

        $re_data = [];
        if (!empty($response)) {
            $re_data['balance'] = isset($response['acT0']) ? $response['acT0']/100 : '';
        }
        return $re_data;
    }



    /**
     * tm_pay
     *
     * @param $createinfo 创建订单信息
     * @param $baseUserInfo 基本用户信息
     *
     * @return array
     */
    public static function tm_pay() {
        $url    = self::$tmpay_url;
        //self::$header[] = "user_ip: ".request()->ip();
        $header = ["Content-Type: application/json;charset='utf-8'"];
        $data = [
            "mch_no"   => self::$tmpay_merchantNo,
            "app_id"   => self::$tmpay_appid,
            "timestamp" => time().'000',
        ];
        $data['sign'] = \customlibrary\Common::asciiKeyStrtoupperSign($data,self::$tmpay_Key,'app_key');

        $http = \curl\Curl::post($url,$data,$header);

        $response = !empty($http) ? json_decode($http, true) : [];

        $re_data = [];
        if (!empty($response)) {
            $re_data['balance'] = isset($response['data']['availableAmount']) ? $response['data']['availableAmount'] : '';
        }
        return $re_data;
    }


    /**
     * joy_pay
     *
     * @param $createinfo 创建订单信息
     * @param $baseUserInfo 基本用户信息
     *
     * @return array
     */
    public static function joy_pay() {
        $url    = self::$joypay_url;
        $header = self::$zr_header;
        $data = [
            "serviceCode" => self::$joypay_service,
        ];

        /*$data_str = \pay\Sign::dataString($data,2);

        $sign = \pay\Sign::JoySign($data_str,self::$joypay_Key);

        //请求头
        $header[] = "X-SIGN: ".$sign;
        $header[] = "X-SERVICE-CODE: ".self::$joypay_service;*/

        $http = \curl\Curl::get($url,$data,$header);

        $response = !empty($http) ? json_decode($http, true) : [];

        $re_data = [];
        if (!empty($response)) {
            $re_data['balance'] = isset($response['data']['deductAmount']) ? $response['data']['deductAmount'] : '';//支付账户资金   data.paymentAmount为代付账户资金
        }
        return $re_data;

    }


    /**
     * z_pay
     *
     * @param $createinfo 创建订单信息
     * @param $baseUserInfo 基本用户信息
     *
     * @return array
     */
    public static function z_pay() {
        $url    = self::$zpay_url;
        $header = self::$header;
        $data = [
            "partnerId"   => self::$zpay_merchantNo,
            "type"    => "default",
            "version"    => '1.0',
        ];

        $data['sign'] = \customlibrary\Common::asciiKeyStrtoupperSign($data,self::$zpay_Key);
        $http = \curl\Curl::get($url,$data);

        $response = !empty($http) ? json_decode($http, true) : [];

        $re_data = [];
        if (!empty($response)) {
            $re_data['balance'] = isset($response['data']['availableAmount']) ? $response['data']['availableAmount'] : '';//
        }
        return $re_data;
    }

    /**
     * waka_pay
     *
     * @return array
     */
    public static function waka_pay() {
        $url    = self::$wakapay_url;
        $header = self::$zr_header;
        $data = [
            "mer_no"   => self::$wakapay_merchantNo,
            'method' => 'fund.query',
        ];

        $data['sign'] = \pay\Sign::asciiKeyStrtolowerNotSign($data,self::$wakapay_Key);

        $http = \curl\Curl::post($url,$data,$header);

        $response = !empty($http) ? json_decode($http, true) : [];

        $re_data = [];
        if (!empty($response)) {
            $re_data['balance'] = isset($response['currency']['INR']) ? $response['currency']['INR'] : '';//
        }
        return $re_data;
    }

    public static function ab_pay() {
        $url    = self::$abpay_url;
        $header = self::$zr_header;
        $data = [
            "mid"   => self::$abpay_merchantNo,
        ];

        $data['sign'] = \pay\Sign::asciiKeyStrtoupperSign($data,self::$abpayKey);

        $http = \curl\Curl::post($url,$data,$header);

        $response = !empty($http) ? json_decode($http, true) : [];

        $re_data = [];
        if (!empty($response)) {
            $re_data['balance'] = isset($response['data']['balance']) ? $response['data']['balance'] : '';//
        }
        return $re_data;
    }


    /**
     * fun_pay
     *
     * @param $createinfo 创建订单信息
     * @param $baseUserInfo 基本用户信息
     *
     * @return array
     */
    public static function fun_pay(){
        $url    = self::$funpay_url;
        $header = self::$zr_header;
        $data = [
            "merchantId"   => self::$funpay_merchantNo,
        ];

        $data['sign'] = \pay\Sign::asciiKeyStrtoupperSign($data,self::$funpayKey);

        $http = \curl\Curl::post($url,$data,$header);

        $response = !empty($http) ? json_decode($http, true) : [];

        $re_data = [];
        if (!empty($response)) {
            $re_data['balance'] = isset($response['data']['payableBalance']) ? $response['data']['payableBalance'] : '';//
        }
        return $re_data;

    }


    /**
     * go_pay
     *
     * @param $createinfo
     * @param $baseUserInfo
     *
     * @return array
     */
    public static function go_pay(){
        $url    = self::$gopay_url;
        $header = self::$zr_header;
        $data = [
            "merId"   => self::$gopay_merchantNo,
        ];

        $data['sign'] = \pay\Sign::asciiKeyStrtoupperSign($data,self::$gopayKey);

        $http = \curl\Curl::post($url,$data,$header);

        $response = !empty($http) ? json_decode($http, true) : [];

        $re_data = [];
        if (!empty($response)) {
            $re_data['balance'] = isset($response['data']['free']) ? $response['data']['free']/100 : '';//
        }
        return $re_data;
    }


    /**
     * 24hrpay
     *
     * @param $createinfo 创建订单信息
     * @param $baseUserInfo 基本用户信息
     *
     * @return array
     */
    public static function hr24_pay(){

        $body = [
            'mchId' => self::$hr24pay_mchId,
            'areaId' => '7',
            'nonceStr' => (string)time(),
        ];


        $body['sign'] = Sign::asciiKeyStrtoupperSign($body, self::$hr24pay_appKey);
        $header = self::$zr_header;
        $url = self::$hr24pay_url;

        $http = \curl\Curl::post($url,$body,$header);

        $response = !empty($http) ? json_decode($http, true) : [];

        $re_data = [];
        if (!empty($response)) {
            $re_data['balance'] = isset($response['balance']) ? $response['balance']/100 : '';//
        }
        return $re_data;
    }

    /**
     * lets_pay
     *
     * @param $createinfo 创建订单信息
     * @param $baseUserInfo 基本用户信息
     *
     * @return array
     */
    public static function lets_pay(){
        $url    = self::$letspay_url;
        $header = self::$header;
        $data = [
            "mchId" => self::$letspay_mchId,
        ];

        $data['sign'] = \pay\Sign::asciiKeyStrtoupperSign($data,self::$letspay_Key);

        $http = \curl\Curl::post($url,$data,$header);

        $response = !empty($http) ? json_decode($http, true) : [];

        $re_data = [];
        if (!empty($response)) {
            $re_data['balance'] = isset($response['balance']) ? $response['balance'] : '';//
        }
        return $re_data;
    }

    /**
     * letstwo_pay
     *
     * @param $createinfo 创建订单信息
     * @param $baseUserInfo 基本用户信息
     *
     * @return array
     */
    public static function letstwo_pay(){
        $url    = self::$letstwopay_url;
        $header = self::$header;
        $data = [
            "mchId" => self::$letstwopay_mchId,
        ];


        $data['sign'] = \pay\Sign::asciiKeyStrtoupperSign($data,self::$letstwopay_Key);

        $http = \curl\Curl::post($url,$data,$header);

        $response = !empty($http) ? json_decode($http, true) : [];

        $re_data = [];
        if (!empty($response)) {
            $re_data['balance'] = isset($response['balance']) ? $response['balance'] : '';//
        }
        return $re_data;
    }


    /**
     * dragon_pay
     *
     * @param $createinfo 创建订单信息
     * @param $baseUserInfo 基本用户信息
     *
     * @return array
     */
    public static function dragon_pay(){
        $url    = self::$dragonpay_url;
        $header = self::$zr_header;
        $data = [
            "appKey" => self::$dragonpay_appKey,
            "nonce" => self::generateRandomString(),
        ];


        $data['sign'] = \pay\Sign::asciiKeyStrtoupperSign($data,self::$dragonpay_secret,'secret');

        $http = \curl\Curl::post($url,$data,$header);

        $response = !empty($http) ? json_decode($http, true) : [];

        $re_data = [];
        if (!empty($response)) {
            $re_data['balance'] = isset($response['data']['balance']) ? $response['data']['balance'] : '';//
        }
        return $re_data;
    }

    /**
     * ant_pay
     *
     * @param $createinfo 创建订单信息
     * @param $baseUserInfo 基本用户信息
     *
     * @return array
     */
    public static function ant_pay(){
        $url    = self::$antpay_url;
        $header = self::$zr_header;
        $data = [
            "merchant_code" => self::$antpay_merchant_code,
        ];


        $sign = \pay\Sign::asciiKeyStrtoupperSign($data,self::$antpay_key);

        $new_data = [
            'signtype' => 'MD5',
            'sign' => urlencode($sign),
            'transdata' => urlencode(json_encode($data)),
        ];

        $http = \curl\Curl::post($url,$new_data,$header);

        $response = !empty($http) ? json_decode($http, true) : [];

        $re_data = [];
        if (!empty($response)) {
            $re_data['balance'] = isset($response['balance']['balance']) ? $response['balance']['balance'] : '';//
        }
        return $re_data;
    }

    /**
     * ff_pay
     *
     * @param $createinfo 创建订单信息
     * @param $baseUserInfo 基本用户信息
     *
     * @return array
     */
    public static function ff_pay() {

        $data = [
            "mch_id" => self::$ffpay_mchId,
            "sign_type" => 'MD5',
        ];

        $data['sign'] = Sign::FfPaySign($data, self::$ffpay_key);

        $http = \curl\Curl::post(self::$ffpay_url, $data, self::$header);

        $response = !empty($http) ? json_decode($http, true) : [];

        $re_data = [];
        if (!empty($response)) {
            $re_data['balance'] = isset($response['availableAmount']) ? $response['availableAmount'] : '';//
        }
        return $re_data;

    }

    /**
     * cow_pay
     *
     * @param $createinfo 创建订单信息
     * @param $baseUserInfo 基本用户信息
     *
     * @return array
     */
    public static function cow_pay(){
        $url    = self::$cowpay_url;
        $header = self::$zr_header;
        $data = [
            "merchant_code" => self::$cowpay_mchId,
        ];


        $sign = \pay\Sign::asciiKeyStrtoupperSign($data,self::$cowpay_key);

        $new_data = [
            'signtype' => 'MD5',
            'sign' => urlencode($sign),
            'transdata' => urlencode(json_encode($data)),
        ];

        $http = \curl\Curl::post($url,$new_data,$header);

        $response = !empty($http) ? json_decode($http, true) : [];

        $re_data = [];
        if (!empty($response)) {
            $re_data['balance'] = isset($response['balance']['balance']) ? $response['balance']['balance'] : '';//
        }
        return $re_data;
    }

     /* wdd_pay
     *
     * @param $createinfo 创建订单信息
     * @param $baseUserInfo 基本用户信息
     *
     * @return array
     */
    public static function wdd_pay() {
        $url    = self::$wddpay_url;
        $header = self::$zr_header;
        $data = [
            "userID" => (int)self::$wddpay_mchId,
        ];

        $data['sign'] = Sign::asciiKeyStrtoupperSign($data,self::$wddpay_key);

        $http = \curl\Curl::get($url,$data,$header);

        $response = !empty($http) ? json_decode($http, true) : [];

        $re_data = [];
        if (!empty($response)) {
            $re_data['balance'] = isset($response['data']) ? $response['data'] : '';//
        }
        return $re_data;

    }

    /**
     * timi_pay
     *
     * @param $createinfo 创建订单信息
     * @param $baseUserInfo 基本用户信息
     *
     * @return array
     */
    public static function timi_pay() {
        $data = [
            "mch_id"   => self::$timipay_mchId,
            'nonce_str' => (string)time(),
        ];

        $data['sign'] = Sign::asciiKeyStrtoupperSign($data,self::$timipay_key);

        $http = \curl\Curl::post(self::$timipay_url,$data,self::$zr_header);

        $response = !empty($http) ? json_decode($http, true) : [];

        $re_data = [];
        if (!empty($response)) {
            $re_data['balance'] = isset($response['data']) ? json_decode($response['data'],true)[0]['quota'] : '';//
        }
        return $re_data;
    }

    /**
     * newfun_pay
     *
     * @param $createinfo 创建订单信息
     * @param $baseUserInfo 基本用户信息
     *
     * @return array
     */
    public static function newfun_pay() {
        $data = [
            "merchant"   => self::$newfunpay_mchId,
            'timestamp' => time()."000",
        ];

        $data['sign'] = Sign::newFunPaySing($data,self::$newfunpay_key);

        $http = \curl\Curl::post(self::$newfunpay_url,$data,self::$zr_header);

        $response = !empty($http) ? json_decode($http, true) : [];

        $re_data = [];
        if (!empty($response)) {
            $re_data['balance'] = isset($response['data']['balance']) ? $response['data']['balance'] : '';//
        }
        return $re_data;

    }

    /**
     * lq_pay
     *
     * @param $createinfo 创建订单信息
     * @param $baseUserInfo 基本用户信息
     *
     * @return array
     */
    public static function lq_pay() {
        $data = [
            'deptId' => self::$lqpay_deptId,
            "merchantNo" => self::$lqpay_mchId,

        ];
        $SignStr = Sign::dataNotEqualString($data);

        $data['signature'] = Sign::md5WithRsaSign($SignStr,self::$lqpay_key);

        $http = \curl\Curl::post(self::$lqpay_url,$data,self::$zr_header);

        $response = !empty($http) ? json_decode($http, true) : [];

        $re_data = [];
        if (!empty($response)) {
            $re_data['balance'] = isset($response['data']['balance']) ? $response['data']['balance'] : '';//
        }
        return $re_data;
    }

    /**
     * threeq_pay
     *
     * @param $createinfo 创建订单信息
     * @param $baseUserInfo 基本用户信息
     *
     * @return array
     */
    public static function threeq_pay() {
        $data = [
            "mchNo"   => self::$threeqpay_mchId,
            "appId"   => self::$threeqpay_appId,
        ];

        $data['sign'] = Sign::asciiKeyStrtoupperSign($data,self::$threeqpay_key);

        $http = \curl\Curl::post(self::$threeqpay_url,$data,self::$zr_header);

        $response = !empty($http) ? json_decode($http, true) : [];

        $re_data = [];
        if (!empty($response)) {
            $re_data['balance'] = isset($response['data']['balance']) ? $response['data']['balance'] : '';//
        }
        return $re_data;
    }

    /**
     * tata_pay
     *
     * @param $createinfo 创建订单信息
     * @param $baseUserInfo 基本用户信息
     *
     * @return array
     */
    public static function tata_pay() {
        return $re_data['balance'] = '';
        $data = [
            "mchNo"   => self::$threeqpay_mchId,
            "appId"   => self::$threeqpay_appId,
        ];

        $data['sign'] = Sign::asciiKeyStrtoupperSign($data,self::$threeqpay_key);

        $http = \curl\Curl::post(self::$threeqpay_url,$data,self::$zr_header);

        $response = !empty($http) ? json_decode($http, true) : [];

        $re_data = [];
        if (!empty($response)) {
            $re_data['balance'] = isset($response['data']['balance']) ? $response['data']['balance'] : '';//
        }
        return $re_data;
    }

    /**
     * pay_pay
     *
     * @param $createinfo 创建订单信息
     * @param $baseUserInfo 基本用户信息
     *
     * @return array
     */
    public static function pay_pay() {
        $data = [
            "merId"   => self::$paypay_mchId,
        ];

        $data['sign'] =  Sign::asciiKeyStrtolowerSign($data,self::$paypay_key);

        $http = \curl\Curl::post(self::$paypay_url,$data,self::$header,[],2);

        $response = !empty($http) ? json_decode($http, true) : [];

        $re_data = [];
        if (!empty($response)) {
            $re_data['balance'] = isset($response['merAvailable']) ? $response['merAvailable'] : '';//
        }
        return $re_data;

    }

    /**
     * g_pay
     *
     * @param $createinfo 创建订单信息
     * @param $baseUserInfo 基本用户信息
     *
     * @return array
     */
    public static function g_pay() {
        $data = [
            "merchantNo"   => self::$gpay_mchId,
        ];

        $data['sign'] =  Sign::asciiKeyStrtoupperSign($data,self::$gpay_key);

        $http = \curl\Curl::post(self::$gpay_url,$data,self::$zr_header);

        $response = !empty($http) ? json_decode($http, true) : [];

        $re_data = [];
        if (!empty($response)) {
            $re_data['balance'] = isset($response['balance']) ? $response['balance'] : '';//
        }
        return $re_data;

    }

    /**
     * show_pay
     *
     * @param $createinfo 创建订单信息
     * @param $baseUserInfo 基本用户信息
     *
     * @return array
     */
    public static function show_pay() {
        $data = [
            "merchant_id"   => self::$showpay_mchId,
        ];
        $private_key = preg_replace('/\\n/', "\n", self::$showpay_key); // 确保换行符正确
        $data['sign'] = strtoupper(md5($data['merchant_id'].$private_key));

        $http = \curl\Curl::post(self::$showpay_url,$data,self::$header,[],2);

        $response = !empty($http) ? json_decode($http, true) : [];

        $re_data = [];
        if (!empty($response)) {
            $re_data['balance'] = isset($response['data']['balance']) ? $response['data']['balance'] : '';//
        }
        return $re_data;

    }

    /**
     * tmtwo_pay
     *
     * @param $createinfo 创建订单信息
     * @param $baseUserInfo 基本用户信息
     *
     * @return array
     */
    public static function tmtwo_pay() {
        $url    = self::$tmtwopay_url;
        //self::$header[] = "user_ip: ".request()->ip();
        $header = ["Content-Type: application/json;charset='utf-8'"];
        $data = [
            "mch_no"   => self::$tmtwopay_merchantNo,
            "app_id"   => self::$tmtwopay_appid,
            "timestamp" => time().'000',
        ];
        $data['sign'] = \customlibrary\Common::asciiKeyStrtoupperSign($data,self::$tmtwopay_Key,'app_key');

        $http = \curl\Curl::post($url,$data,$header);

        $response = !empty($http) ? json_decode($http, true) : [];

        $re_data = [];
        if (!empty($response)) {
            $re_data['balance'] = isset($response['data']['availableAmount']) ? $response['data']['availableAmount'] : '';
        }
        return $re_data;
    }

    /**
     * yh_pay
     *
     * @param $createinfo 创建订单信息
     * @param $baseUserInfo 基本用户信息
     *
     * @return array
     */
    public static function yh_pay() {
        $data = [
            "currencyCode"   => 'INR',
            "merchNo"   => self::$yhpay_mchId,
            "charset" =>  'UTF-8',
        ];

        ksort($data);
        //JSON_UNESCAPED_SLASHES使用 JSON_UNESCAPED_SLASHES 标志：
        //在调用 json_encode 时，传递一个选项标志 JSON_UNESCAPED_SLASHES，这样它就不会转义斜杠了。
        $SignStr = json_encode($data,JSON_UNESCAPED_SLASHES).self::$yhpay_key;
        $data['sign'] = strtoupper(md5($SignStr));

        $http = \curl\Curl::post(self::$yhpay_url, $data, self::$zr_header);

        $response = !empty($http) ? json_decode($http, true) : [];

        $re_data = [];
        if (!empty($response)) {
            $re_data['balance'] = isset($response['data']['balance']) ? $response['data']['balance']/100 : '';
        }
        return $re_data;

    }

    /**
     * allin1_pay
     *
     * @param $createinfo 创建订单信息
     * @param $baseUserInfo 基本用户信息
     *
     * @return array
     */
    public static function allin1_pay() {
        $data = [
            "app_id"   => self::$allin1pay_appid,
        ];


        $dataString =  Sign::dataString($data);
        $data['sign'] = strtolower(md5($dataString.self::$allin1pay_Key));

        $http = \curl\Curl::post(self::$allin1pay_url, $data, self::$header);

        $response = !empty($http) ? json_decode($http, true) : [];

        $re_data = [];
        if (!empty($response)) {
            $re_data['balance'] = isset($response['data']['balance']) ? $response['data']['balance'] : '';
        }
        return $re_data;
    }

    /**
     * make_pay
     *
     * @param $createinfo 创建订单信息
     * @param $baseUserInfo 基本用户信息
     *
     * @return array
     */
    public static function make_pay() {

        $data = array();

        $SignStr = json_encode($data,JSON_FORCE_OBJECT).self::$makepay_Key;
        // $SignStr = self::$makepay_Key;
        $sign = md5($SignStr);
        $herder = array(
            "Content-Type: application/json",
            "x-app-key: ".self::$makepay_appkey,
            "x-sign: ".$sign,
        );
        $http = \curl\Curl::post(self::$makepay_url,$data,$herder);

        $response = !empty($http) ? json_decode($http, true) : [];

        $re_data = [];
        if (!empty($response)) {
            $re_data['balance'] = isset($response['balance']) ? $response['balance'] : '';
        }
        return $re_data;

    }

    /**
     * best_pay
     *
     * @param $createinfo 创建订单信息
     * @param $baseUserInfo 基本用户信息
     *
     * @return array
     */
    public static function best_pay() {
        $data   = [
            "merchantId"      => (int)self::$bestpay_merchantNo,
            "currency"    => 'INR',
            "nonce"    => (string)rand(00000000,9999999999),
            "timestamp"  => time().'000',
        ];
        $dataSign = $data['currency'] . $data['merchantId'] . $data['nonce'] . $data['timestamp'];
        $data['sign'] = Sign::bestPaySign($dataSign,self::$bestpay_Key);

        //$response = $this->guzzle->post(self::$bestpay_url,$data,$this->zr_header);

        $http = \curl\Curl::post(self::$bestpay_url, $data, self::$zr_header);

        $response = !empty($http) ? json_decode($http, true) : [];

        $re_data = [];
        if (!empty($response)) {
            $re_data['balance'] = isset($response['data']['payBalance']) ? $response['data']['payBalance'] : '';
        }
        return $re_data;

    }

    /**
     * zip_pay
     *
     * @param $createinfo 创建订单信息
     * @param $baseUserInfo 基本用户信息
     *
     * @return array
     */
    public static function zip_pay() {
        $data   = [
            "merchantId"      => (int)self::$zippay_merchantNo,
            "currency"    => 'INR',
            "nonce"    => (string)rand(00000000,9999999999),
            "timestamp"  => time().'000',
        ];
        $dataSign = $data['currency'] . $data['merchantId'] . $data['nonce'] . $data['timestamp'];
        $data['sign'] = Sign::bestPaySign($dataSign,self::$zippay_Key);

        //$response = $this->guzzle->post(self::$bestpay_url,$data,$this->zr_header);

        $http = \curl\Curl::post(self::$zippay_url, $data, self::$zr_header);

        $response = !empty($http) ? json_decode($http, true) : [];

        $re_data = [];
        if (!empty($response)) {
            $re_data['balance'] = isset($response['data']['payBalance']) ? $response['data']['payBalance'] : '';
        }
        return $re_data;

    }

    /**
     * upi_pay
     *
     * @param $createinfo 创建订单信息
     * @param $baseUserInfo 基本用户信息
     *
     * @return array
     */
    public static function upi_pay() {
        $data = [
            "merchantId"   => self::$upipay_merchantNo,
        ];
        $timestamp = time().'000';

        $dataSign = $data['merchantId'] . $timestamp . self::$upipay_Key;

        $sign = md5($dataSign);

        $herder = array(
            "Content-Type: application/json",
            "X-TIMESTAMP: ".$timestamp,
            "X-SIGN: ".$sign,
        );

        //$response = Curl::post($this->upipay_url,$data,$herder);

        $http = \curl\Curl::post(self::$upipay_url, $data, $herder);

        $response = !empty($http) ? json_decode($http, true) : [];

        $re_data = [];
        if (!empty($response)) {
            $re_data['balance'] = isset($response['balance']) ? $response['balance']/100 : '';
        }
        return $re_data;

    }

    /**
     * q_pay
     *
     * @param $createinfo 创建订单信息
     * @param $baseUserInfo 基本用户信息
     *
     * @return array
     */
    public static function q_pay() {
        /*$data = [
            "merchantId"   => self::$upipay_merchantNo,
        ];
        $timestamp = time().'000';

        $dataSign = $data['merchantId'] . $timestamp . self::$upipay_Key;

        $sign = md5($dataSign);

        $herder = array(
            "Content-Type: application/json",
            "X-TIMESTAMP: ".$timestamp,
            "X-SIGN: ".$sign,
        );

        //$response = Curl::post($this->upipay_url,$data,$herder);

        $http = \curl\Curl::post(self::$upipay_url, $data, $herder);

        $response = !empty($http) ? json_decode($http, true) : [];

        $re_data = [];
        if (!empty($response)) {
            $re_data['balance'] = isset($response['balance']) ? $response['balance'] : '';
        }*/
        $re_data['balance'] = '';
        return $re_data;

    }

    public static function allin1two_pay() {
        $re_data['balance'] = '';
        return $re_data;

    }

    public static function vendoo_pay() {
        $re_data['balance'] = '';
        return $re_data;

    }

    /**
     * unive_pay
     * @return array
     */
    public static function unive_pay() {
        $re_data['balance'] = '';
        return $re_data;

    }

    /**
     * no_pay
     * @return array
     */
    public static function no_pay() {
        $re_data['balance'] = '';
        return $re_data;

    }

    /**
     * ms_pay
     * @return array
     */
    public static function ms_pay() {
        $re_data['balance'] = '';
        return $re_data;

    }

    /**
     * decent_pay
     * @return array
     */
    public static function decent_pay() {
        $re_data['balance'] = '';
        return $re_data;

    }

    /**
     * fly_pay
     * @return array
     */
    public static function fly_pay() {
        $re_data['balance'] = '';
        return $re_data;

    }

    /**
     * kk_pay
     * @return array
     */
    public static function kk_pay() {
        $re_data['balance'] = '';
        return $re_data;

    }

    /**
     * tk_pay
     * @return array
     */
    public static function tk_pay() {
        $re_data['balance'] = '';
        return $re_data;

    }

    /**
     * kktwo_pay
     * @return array
     */
    public static function kktwo_pay() {
        $re_data['balance'] = '';
        return $re_data;

    }

    /**
     * newai_pay
     * @return array
     */
    public static function newai_pay() {
        $re_data['balance'] = '';
        return $re_data;

    }

    /**
     * rupeelink_pay
     * @return array
     */
    public static function rupeelink_pay() {
        $re_data['balance'] = '';
        return $re_data;

    }

    /**
     * sertwo_pay
     * @return array
     */
    public static function sertwo_pay() {
        $re_data['balance'] = '';
        return $re_data;

    }

    /**
     * one_pay
     * @return array
     */
    public static function one_pay() {
        $re_data['balance'] = '';
        return $re_data;

    }

    /**
     * global_pay
     * @return array
     */
    public static function global_pay() {
        $re_data['balance'] = '';
        return $re_data;

    }

    /**
     * a777_pay
     * @return array
     */
    public static function a777_pay() {
        $re_data['balance'] = '';
        return $re_data;

    }

    /**
     * 随机生产几位字母
     * @param $length
     * @return string
     */
    private static function generateRandomString($uid = '',$length = 6){

        $characters = 'abcdefghijklmnopqrstuvwxyz';
        $randomString = '';

        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, strlen($characters) - 1)];
        }

        return $randomString.$uid;

    }


}