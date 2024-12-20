<?php
/**
 * Auto generated from poker_common.proto at 2023-06-08 09:49:25
 */

namespace {
/**
 * ENNodeType enum
 */
final class ENNodeType
{
    const EN_Node_Client = 0;
    const EN_Node_Connect = 1;
    const EN_Node_Hall = 2;
    const EN_Node_Route = 3;
    const EN_Node_Game = 4;
    const EN_Node_User = 6;
    const EN_Node_Room = 7;
    const EN_Node_DBProxy = 8;
    const EN_Node_GM = 9;
    const EN_Node_Log = 10;
    const EN_Node_Robot = 11;
    const EN_Node_PHP = 12;
    const EN_Node_Unknown = 100;
    const EN_Node_DSS_YD_LM_COIN = 1001;
    const EN_Node_DSS_YD_ZJH_COIN = 1002;
    const EN_Node_DSS_AB_COIN = 1501;
    const EN_Node_DSS_Rotary_COIN = 1502;
    const EN_Node_DSS_DvsT_COIN = 1503;
    const EN_Node_DSS_SZ_COIN = 1504;
    const EN_Node_DSS_YD_SZ_COIN = 1505;
    const EN_Node_DSS_Wingo_COIN = 1506;
    const EN_Node_DSS_KvsQ_COIN = 1507;
    const EN_Node_DSS_3Patti_COIN = 1508;
    const EN_Node_DSS_Crash_COIN = 1509;
    const EN_Node_DSS_Mines_COIN = 1510;
    const EN_Node_DSS_Sgj_COIN = 2001;
    const EN_Node_DSS_COINS_COIN = 2002;
    const EN_Node_DSS_HILO_COIN = 2003;

    /**
     * Returns defined enum values
     *
     * @return int[]
     */
    public function getEnumValues()
    {
        return array(
            'EN_Node_Client' => self::EN_Node_Client,
            'EN_Node_Connect' => self::EN_Node_Connect,
            'EN_Node_Hall' => self::EN_Node_Hall,
            'EN_Node_Route' => self::EN_Node_Route,
            'EN_Node_Game' => self::EN_Node_Game,
            'EN_Node_User' => self::EN_Node_User,
            'EN_Node_Room' => self::EN_Node_Room,
            'EN_Node_DBProxy' => self::EN_Node_DBProxy,
            'EN_Node_GM' => self::EN_Node_GM,
            'EN_Node_Log' => self::EN_Node_Log,
            'EN_Node_Robot' => self::EN_Node_Robot,
            'EN_Node_PHP' => self::EN_Node_PHP,
            'EN_Node_Unknown' => self::EN_Node_Unknown,
            'EN_Node_DSS_YD_LM_COIN' => self::EN_Node_DSS_YD_LM_COIN,
            'EN_Node_DSS_YD_ZJH_COIN' => self::EN_Node_DSS_YD_ZJH_COIN,
            'EN_Node_DSS_AB_COIN' => self::EN_Node_DSS_AB_COIN,
            'EN_Node_DSS_Rotary_COIN' => self::EN_Node_DSS_Rotary_COIN,
            'EN_Node_DSS_DvsT_COIN' => self::EN_Node_DSS_DvsT_COIN,
            'EN_Node_DSS_SZ_COIN' => self::EN_Node_DSS_SZ_COIN,
            'EN_Node_DSS_YD_SZ_COIN' => self::EN_Node_DSS_YD_SZ_COIN,
            'EN_Node_DSS_Wingo_COIN' => self::EN_Node_DSS_Wingo_COIN,
            'EN_Node_DSS_KvsQ_COIN' => self::EN_Node_DSS_KvsQ_COIN,
            'EN_Node_DSS_3Patti_COIN' => self::EN_Node_DSS_3Patti_COIN,
            'EN_Node_DSS_Crash_COIN' => self::EN_Node_DSS_Crash_COIN,
            'EN_Node_DSS_Mines_COIN' => self::EN_Node_DSS_Mines_COIN,
            'EN_Node_DSS_Sgj_COIN' => self::EN_Node_DSS_Sgj_COIN,
            'EN_Node_DSS_COINS_COIN' => self::EN_Node_DSS_COINS_COIN,
            'EN_Node_DSS_HILO_COIN' => self::EN_Node_DSS_HILO_COIN,
        );
    }
}
}