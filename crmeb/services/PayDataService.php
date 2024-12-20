<?php

namespace crmeb\services;

class PayDataService
{
    /**
     * 获取渠道
     * @return array[]
     */
    public static function getPayChannel(){
        $channel = [
            ['label' => 'Facebook Ads', 'value' => 'Facebook Ads'],
            ['label' => 'googleadwords_int', 'value' => 'googleadwords_int'],
            ['label' => 'restricted', 'value' => 'restricted']
        ];
        return $channel;
    }

    /**
     * 获取包名
     * @return array[]
     */
    public static function getPkgName(){
        $pkg_name = [
            ['label' => 'com.brtest.game', 'value' => 'com.brtest.game'],
            ['label' => 'com.default.brtest', 'value' => 'com.default.brtest'],
            ['label' => 'com.doublewinslots.brgame', 'value' => 'com.doublewinslots.brgame'],
            ['label' => 'com.doublewinslots.brgame.share', 'value' => 'com.doublewinslots.brgame.share'],
            ['label' => 'com.doublewinslots.brgame.sharf', 'value' => 'com.doublewinslots.brgame.sharf']
        ];
        return $pkg_name;
    }

    /**
     * 获取交易场景类型
     * @return array[]
     */
    public static function getTransactionScenario(){
        $scenario_name = [
            ['label' => '活动赠送', 'value' => '1'],
            ['label' => '游戏交易', 'value' => '2'],
            ['label' => '充值', 'value' => '3'],
            ['label' => '退款', 'value' => '4'],
        ];
        return $scenario_name;
    }
}