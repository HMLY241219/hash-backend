<?php

namespace app\admin\controller\statistics;
use app\admin\controller\AuthController;
use app\admin\model\ump\ExecPhp;
use crmeb\services\{FormBuilder as Form, JsonService as Json, UtilService as Util};
use think\facade\Db;
use app\admin\controller\Model;
use think\facade\Session;

/**
 *  基础数据列表
 */
class Adjustdata extends AuthController
{

    public function index()
    {
        /*$level = getAdminLevel($this->adminInfo);

        $this->assign('adminInfo', $this->adminInfo);
        $this->assign('adminlevel', $level);*/
        $adjust_app_config = Db::name('adjust_app_config')->order('package_id','asc')->select()->toArray();
        $adjust_network_config = Db::name('adjust_network_config')->order('channel','asc')->select()->toArray();
        $data = [];
        foreach ($adjust_app_config as $key => $value){
            $data[$value['package_id']] = [
                'name' => $value['name'],
                'value' => $value['app']
            ];
        }
        foreach ($adjust_network_config as $v){
            $data[$v['package_id']]['list'][] = [
                'name' => $v['name'],
                'value' => $v['network']
            ];
        }
        $data = array_values($data);
//        $data = config('channeldata');

        $adminInfo = $this->adminInfo;
        $is_export = Db::name('system_role')->where('id','=',$adminInfo->roles)->value('is_export');
        $defaultToolbar = $is_export == 1 ? ['print', 'exports'] : [];
        $this->assign('defaultToolbar', json_encode($defaultToolbar));

        $this->assign('ChannelData', json_encode($data));
        $this->assign('adminInfo',$adminInfo);
        return $this->fetch();
    }


    public function getlist(){
        $data =  request()->param();
        $newData['app'] = $data['app'] ?? '';  //应用名
        $newData['network'] = $data['network'] ?? ''; //渠道
        $date = $data['date'] ?? '';
        if(!$newData['app']) return json(['code' => 0, 'count' => 0, 'data' => []]);
        if(!$date)$date = date('Y-m-d').' - '.date('Y-m-d');
        $newData['date_period'] = str_replace(' - ', ':', $date); //时间
        [$count,$list] = $this->AdjustData($newData);
        return json(['code' => 0, 'count' => $count, 'data' => $list]);
    }

    private function AdjustData($data){
        $apiToken = 'e7ESkeEmbWZFAzyCAXCy';
        $baseUrl = 'https://automate.adjust.com/reports-service/report';

        // 定义请求参数
        $params = [
            'dimensions' => 'campaign_network',
            'metrics' => 'attribution_clicks,installs,CompleteRegistration_events,firstPurchase_events,todayfirstPurchase_events,Purchase_events,all_revenue,all_revenue_total_d0,waus,retention_rate_d1,retention_rate_d3,retention_rate_d7',
            'date_period' => $data['date_period'],
            // 'app_token__in' => 'epepxclosnb4',
            'utc_offset' => '+05:30',
        ];
        if($data['app'])$params['app__in'] = $data['app'];
        if($data['network'])$params['network__in'] = $data['network'];

// 构建查询字符串
        $queryString = http_build_query($params);

// 完整的请求 URL
        $url = $baseUrl . '?' . $queryString;



        $curl = curl_init();

        curl_setopt_array($curl, [
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HTTPHEADER => [
                'Authorization: Bearer ' . $apiToken
            ],
        ]);

        $response = curl_exec($curl);


        curl_close($curl);
        $list = json_decode($response, true);
        if(!isset($list['totals']))return [0,[]];
        $count = 1;
        $list['totals']['campaign_network'] = '合计';
        $list['totals']['retention_rate_d1'] = bcmul((string)$list['totals']['retention_rate_d1'],'100',2).'%';
        $list['totals']['retention_rate_d3'] = bcmul((string)$list['totals']['retention_rate_d3'],'100',2).'%';
        $list['totals']['retention_rate_d7'] = bcmul((string)$list['totals']['retention_rate_d7'],'100',2).'%';

        $newData[] = $list['totals'];


        $row = $list['rows'] ?? [];
        if($row)foreach ($row as $k => $v){
            $newData[] = $v;
        }

        return [count($newData),$newData];

    }


}

