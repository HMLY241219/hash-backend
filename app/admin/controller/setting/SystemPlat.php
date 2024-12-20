<?php

namespace app\admin\controller\setting;

use app\admin\controller\AuthController;
use app\admin\model\system\SystemConfig as ConfigModel;
use app\models\system\Cache as CacheModel;
use crmeb\services\{CacheService, ExpressService, FormBuilder, JsonService as Json, product\Product, UtilService};
use EasyWeChat\Js\Js;
use think\facade\Route as Url;
use crmeb\services\CrmebPlatService;
use crmeb\services\sms\Sms;
use crmeb\services\express\Express;

/**
 * crmeb 平台
 * Class SystemPlat
 * @package app\admin\controller\setting
 */
class SystemPlat extends AuthController
{
    protected $account = NULL;

    protected $secret = NULL;
    /**
     * @var $crmebPlatHandle
     */
    protected $crmebPlatHandle;
    /**
     * @var $smsHandle
     */
    protected $smsHandle;
    /**
     * @var $expressHandle
     */
    protected $expressHandle;
    /**
     * @var $productHandle
     */
    protected $productHandle;

    protected $allowAction = ['index', 'verify', 'login', 'go_login', 'register', 'go_register', 'modify', 'go_modify', 'forget', 'go_forget', 'loginOut', 'meal', 'sms_temp'];

    /**
     * @var string
     */
    protected $cacheTokenPrefix = "_crmeb_plat";

    protected $cacheKey;

    protected function initialize()
    {
        parent::initialize();
        $this->account = sys_config('sms_account');
        $this->secret = sys_config('sms_token');
        $config = ['account' => $this->account, 'secret' => $this->secret];
        $this->crmebPlatHandle = new CrmebPlatService();
        $this->smsHandle = new Sms('sms', $config);
        $this->expressHandle = new Express('express', $config);
        $this->productHandle = new Product('copy', $config);
        $this->cacheKey = md5($this->account . '_' . $this->secret . $this->cacheTokenPrefix);
    }

    /**
     * 显示资源列表
     *
     * @return \think\Response
     */
    public function index()
    {
        if (!CacheModel::getDbCache($this->cacheKey, '')) {
            return redirect(Url('login')->build() . '?url=index');
        }
        [$out, $type] = UtilService::postMore([
            ['out', 0],
            ['type', 'sms']
        ], null, true);
        try {
            $info = $this->crmebPlatHandle->info();
        } catch (\Throwable $e) {
            $info = [];
        }
        $this->assign('info', $info);
        $this->assign('type', $type);
        if ($out == 0 && $info) {
            return $this->fetch();
        } else {
            $this->assign('account', $this->account);
            $this->assign('password', $this->secret);
            return $this->fetch('login');
        }

    }

    /**
     * 获取短信验证码
     */
    public function verify()
    {
        [$phone] = UtilService::postMore([
            ['phone', '']
        ], null, true);
        if (!$phone) {
            return Json::fail('请输入手机号');
        }
        if (!check_phone($phone)) {
            return Json::fail('请输入正确的手机号');
        }
        $this->crmebPlatHandle->code($phone);
        return Json::success('获取成功');
    }

    /**
     * 登录页面
     * @return string
     * @throws \Exception
     */
    public function login()
    {
        $this->assign('account', $this->account);
        $this->assign('password', $this->secret);
        return $this->fetch();
    }

    /**
     * 退出登录
     * @return string
     * @throws \Exception
     */
    public function loginOut()
    {
        CacheModel::delectDbCache($this->cacheKey);
        return Json::success('退出成功', $this->crmebPlatHandle->loginOut());
    }


    /**
     * 登录逻辑
     */
    public function go_login()
    {
        $data = UtilService::postMore([
            ['account', ''],
            ['password', '']
        ]);
        if (!$data['account']) {
            return Json::fail('请输入账号');
        }
        if (!$data['password']) {
            return Json::fail('请输入秘钥');
        }
        $this->save_basics(['sms_account' => $data['account'], 'sms_token' => $data['password']]);
        $token = $this->crmebPlatHandle->login($data['account'], $data['password']);
        CacheModel::setDbCache($this->cacheKey, $token, 0);
        return Json::success('登录成功', $token);
    }

    /**
     * 注册页面
     * @return string
     * @throws \Exception
     */
    public function register()
    {
        return $this->fetch();
    }

    /**
     * 注册逻辑
     */
    public function go_register()
    {
        $data = UtilService::postMore([
            ['account', ''],
            ['phone', ''],
            ['password', ''],
            ['verify_code', ''],
        ]);
        if (!$data['account']) {
            return Json::fail('请输入账号');
        }
        if (!$data['phone']) {
            return Json::fail('请输入手机号');
        }
        if (!check_phone($data['phone'])) {
            return Json::fail('请输入正确的手机号');
        }
        if (!$data['password']) {
            return Json::fail('请设置秘钥');
        }
        if (strlen($data['password']) < 6 || strlen($data['password']) > 32) {
            return Json::fail('密码长度6~32位');
        }
        if (!$data['verify_code']) {
            return Json::fail('请先获取短信验证码');
        }
        $result = $this->crmebPlatHandle->register($data['account'], $data['phone'], $data['password'], $data['verify_code']);
        $this->save_basics(['sms_account' => $data['account'], 'sms_token' => $data['password']]);
        return Json::success('注册成功', $result);
    }

    /**
     * 修改秘钥页面
     * @return string
     * @throws \Exception
     */
    public function modify()
    {
        $this->assign('account', $this->account);
        return $this->fetch();
    }

    /**
     * 修改秘钥逻辑
     */
    public function go_modify()
    {
        $data = UtilService::postMore([
            ['account', ''],
            ['phone', ''],
            ['password', ''],
            ['verify_code', ''],
        ]);
        if (!$data['account']) {
            return Json::fail('请输入账号');
        }
        if (!$data['phone']) {
            return Json::fail('请输入手机号');
        }
        if (!check_phone($data['phone'])) {
            return Json::fail('请输入正确的手机号');
        }
        if (!$data['password']) {
            return Json::fail('请设置秘钥');
        }
        if (strlen($data['password']) < 6 || strlen($data['password']) > 32) {
            return Json::fail('密码长度6~32位');
        }
        if (!$data['verify_code']) {
            return Json::fail('请先获取短信验证码');
        }
        $result = $this->crmebPlatHandle->modify($data['account'], $data['phone'], $data['password'], $data['verify_code']);
        $this->save_basics(['sms_account' => $data['account'], 'sms_token' => $data['password']]);
        return Json::success('修改成功', $result);
    }

    /**
     * 找回账号
     * @return string
     * @throws \Exception
     */
    public function forget()
    {
        return $this->fetch();
    }

    /**
     * 找回账号逻辑
     */
    public function go_fotget()
    {
        $data = $where = UtilService::postMore([
            ['phone', ''],
            ['verify_code', ''],
        ]);
        if (!isset($data['phone']) || $data['phone']) {
            return Json::fail('请输入手机号');
        }
        if (!check_phone($data['phone'])) {
            return Json::fail('请输入正确的手机号');
        }
        if (!isset($data['verify_code']) || $data['verify_code']) {
            return Json::fail('请先获取短信验证码');
        }
        $result = $this->crmebPlatHandle->fotget($data['phone'], $data['verify_code']);
        return Json::success('修改成功', $result);
    }

    /**
     * 获取消费记录
     */
    public function record()
    {
        [$type, $page, $limit] = UtilService::getMore([
            ['type', 'sms'],
            ['page', 1],
            ['limit', 20]
        ], null, true);
        $result = $this->crmebPlatHandle->record($type, $page, $limit);
        if ($type == 'expr_query') {
            $express = ExpressService::expressList();
            $express = array_combine(array_column($express, 'code'), $express);
            foreach ($result['data'] as $key => $value) {
                $result['data'][$key]['name'] = $express[$value['code']]['name'] ?? '';
                $result['data'][$key]['num'] = $value['content']['num'] ?? '';
            }
        }
        return Json::successlayui($result);
    }

    /**
     * @return string
     * @throws \Exception
     */
    public function meal()
    {
        if (!CacheModel::getDbCache($this->cacheKey, '')) {
            return redirect(Url('login')->build() . '?url=meal');
        }
        return $this->fetch();
    }

    /**
     * 获取套餐列表
     */
    public function get_meal()
    {
        [$type] = UtilService::getMore([
            ['type', 'sms']
        ], null, true);
        return Json::success($this->crmebPlatHandle->meal($type));
    }

    /**
     * 获取支付二维码
     * @return string
     * @throws \Exception
     */
    public function pay()
    {
        [$meal_id, $price, $num, $type, $pay_type] = UtilService::postMore([
            ['meal_id', 0],
            ['price', ''],
            ['num', 0],
            ['type', ''],
            ['pay_type', 'weixin']
        ], null, true);
        if (!$meal_id) {
            return Json::fail('请选择套餐');
        }
        return Json::success($this->crmebPlatHandle->pay($type, $meal_id, $price, $num, $pay_type));
    }


    /**
     * 保存一号通配置
     */
    public function save_basics($data)
    {
        if ($data) {
            CacheService::clear();
            foreach ($data as $k => $v) {
                ConfigModel::edit(['value' => json_encode($v)], $k, 'menu_name');
            }
        }
        return true;
    }

    /**
     * 开通短信服务页面
     * @return string
     * @throws \Exception
     */
    public function sms_open()
    {
        try {
            $info = $this->crmebPlatHandle->info();
        } catch (\Throwable $e) {
            $info = [];
        }
        $this->assign('info', $info);
        return $this->fetch();
    }

    /**
     * 处理开通短信服务
     */
    public function go_sms_open()
    {
        [$sign] = UtilService::postMore([
            ['sign', '']
        ], null, true);
        if (!$sign) {
            return Json::fail('请输入短信签名');
        }
        return Json::success('开通成功', $this->smsHandle->setSign($sign)->open());
    }

    /**
     * 短信账户信息
     */
    public function sms_info()
    {
        return Json::success($this->smsHandle->info());
    }

    /**
     * 修改签名页面
     * @return string
     * @throws \Exception
     */
    public function sms_modify()
    {
        return $this->fetch();
    }

    /**
     * 处理修改签名
     */
    public function go_sms_modify()
    {
        [$sign] = UtilService::postMore([
            ['sign', '']
        ], null, true);
        if (!$sign) {
            return Json::fail('请输入短信签名');
        }
        return Json::success($this->smsHandle->modify($sign));
    }

    /**
     * 短信模版页面
     */
    public function sms_temp()
    {
        if (!CacheModel::getDbCache($this->cacheKey, '')) {
            return redirect(Url('login')->build() . '?url=sms_temp');
        }
        [$type] = UtilService::getMore([
            ['type', 'temps'],
        ], null, true);
        $this->assign('type', $type);
        return $this->fetch();
    }

    /**
     * 显示创建资源表单页.
     *
     * @return string
     * @throws \FormBuilder\exception\FormBuilderException
     */
    public function create()
    {
        $field = [
            FormBuilder::input('title', '模板名称'),
            FormBuilder::textarea('text', '模板内容示例', '您的验证码是：{$code}，有效期为{$time}分钟。如非本人操作，可不用理会。（模板中的{$code}和{$time}需要替换成对应的变量，请开发者知晓。修改此项无效！）')->readonly(true),
            FormBuilder::input('content', '模板内容')->type('textarea'),
            FormBuilder::radio('type', '模板类型', 1)->options([['label' => '验证码', 'value' => 1], ['label' => '通知', 'value' => 2], ['label' => '推广', 'value' => 3]])
        ];
        $form = FormBuilder::make_post_form('申请短信模板', $field, Url::buildUrl('go_sms_temps_apply'), 2);
        $this->assign(compact('form'));
        return $this->fetch('public/form-builder');
    }

    /**
     * 短信模版
     */
    public function get_sms_temps()
    {
        [$page, $limit, $temp_type] = UtilService::getMore([
            ['page', 1],
            ['limit', 20],
            ['temp_type', ''],
        ], null, true);
        return Json::successlayui($this->smsHandle->temps($page, $limit, $temp_type));
    }

    /**
     * 短信模版申请记录
     */
    public function get_sms_appls()
    {
        [$temp_type, $page, $limit] = UtilService::getMore([
            ['temp_type', ''],
            ['page', 1],
            ['limit', 20]
        ], null, true);
        return Json::successlayui($this->smsHandle->applys($temp_type, $page, $limit));
    }

    /**
     * 短信发送记录
     */
    public function sms_record()
    {
        [$record_id] = UtilService::getMore([
            ['record_id', 0],
        ], null, true);
        return Json::success($this->smsHandle->record($record_id));
    }

    /**
     * 模版申请页面
     * @return string
     * @throws \Exception
     */
    public function sms_temps_apply()
    {
        return $this->fetch();
    }

    /**
     * 处理申请模版
     */
    public function go_sms_temps_apply()
    {
        [$type, $title, $content] = UtilService::getMore([
            ['type', 1],
            ['title', ''],
            ['content', '']
        ], null, true);
        if (!$type) {
            return Json::fail('请选择模版类型');
        }
        if (!$title) {
            return Json::fail('请输入模版标题');
        }
        if (!$content) {
            return Json::fail('请输入模版内容');
        }
        $this->smsHandle->apply($title, $content, $type);
        return Json::success('申请成功');
    }

    /**
     * 开通物流服务页面
     * @return string
     * @throws \Exception
     */
    public function express_open()
    {
        return $this->fetch();
    }

    /**
     * 处理开通物流服务
     */
    public function go_express_open()
    {
        return Json::success('开通成功', $this->expressHandle->open());
    }

    /**
     * 获取快递公司列表
     */
    public function express_list()
    {
        [$type, $page, $limit] = UtilService::postMore([
            ['sign', 1],
            ['page', 1],
            ['limit', 10]
        ], null, true);
        return Json::success($this->expressHandle->express($type, $page, $limit));
    }

    /**
     * 获取电子面单模版
     */
    public function express_temp()
    {
        [$com, $page, $limit] = UtilService::postMore([
            ['com', 0],
            ['page', 1],
            ['limit', 10]
        ], null, true);
        if (!$com) {
            return Json::fail('请选择快递');
        }
        return Json::success($this->expressHandle->temp($com, $page, $limit));
    }

    /**
     * 开通复制商品
     */
    public function go_copy_open()
    {
        return Json::success($this->productHandle->open());
    }
}