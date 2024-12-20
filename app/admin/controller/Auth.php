<?php

namespace app\admin\controller;

use crmeb\basic\BaseController;
use think\facade\{Cookie, Session};
use app\admin\model\system\{SystemAdmin, SystemConfig};
use think\facade\Db;

class Auth extends BaseController
{

    public function login()
    {
        $site_name = SystemConfig::getOne('site_name');
        $this->assign('site_name', $site_name);

        return $this->fetch();
    }

    public function doLogin()
    {
        if (!$this->request->isAjax() || !$this->request->isPost()) {
            return $this->error('非法操作!');
        }

        [$act, $pwd, $code, $rem] = $this->basePost([
            'account', 'password', 'vercode', ['remember', '']
        ], true);

        $error
            = Session::has('login_error')
            ? Session::get('login_error')
            : ['num' => 0, 'time' => time()];

        if ($error['num'] > 3 && $error['time'] > strtotime('-5 minutes')) {
            return $this->error('操作频繁, 请稍候再试!');
        }

        //测试环境不需要验证
//        $googleSecret  = Db::name('system_admin')->where('account',$act)->value('googlesecret');
//        if(!$googleSecret) return $this->error('请联系管理员添加谷歌验证私钥');
//        if (!\googleAuth\GoogleAuth::verifyCode($googleSecret,$code))return $this->error('验证码错误，请重新输入!');

        //验证码的时候需要打开
//        if (!captcha_check($code)) {
//            $error['num']  += 1;
//            $error['time'] = time();
//            Session::set('login_error', $error);
//            Session::save();
//
//            return $this->error('验证码错误, 请重新输入!');
//        }

        if (true === SystemAdmin::checkLogin($act, $pwd)) {
            if ($rem == 'on')
                Cookie::set('act', $act);
            else
                Cookie::delete('act');

            Cookie::save();

            Session::delete('login_error');
            Session::save();

            return $this->success(['url' => (string)url('/')]);
        }
        else {
            $error['num']  += 1;
            $error['time'] = time();
            Session::set('login_error', $error);
            Session::save();

            return $this->error(SystemAdmin::getErrorInfo());
        }
    }

    public function captcha()
    {
        ob_clean();
        return captcha();
    }


    public function logout()
    {
        SystemAdmin::clearLoginInfo();

        $this->redirect((string)url('auth/login'));
    }
}