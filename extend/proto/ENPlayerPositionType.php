<?php
/**
 * Auto generated from poker_common.proto at 2023-06-08 09:49:25
 */

namespace {
/**
 * ENPlayerPositionType enum
 */
final class ENPlayerPositionType
{
    const EN_Position_Hall = 0;
    const EN_Position_Table = 1;
    const EN_Position_Fpf = 2;
    const EN_Position_Daer = 3;
    const EN_Position_DSS_YD_LM_COIN = 1001;
    const EN_Position_DSS_YD_ZJH_COIN = 1002;
    const EN_Position_DSS_AB_COIN = 1501;
    const EN_Position_DSS_Rotary_COIN = 1502;
    const EN_Position_DSS_DvsT_COIN = 1503;
    const EN_Position_DSS_SZ_COIN = 1504;
    const EN_Position_DSS_YD_SZ_COIN = 1505;
    const EN_Position_DSS_Wingo_COIN = 1506;
    const EN_Position_DSS_KvsQ_COIN = 1507;
    const EN_Position_DSS_3Patti_COIN = 1508;
    const EN_Position_DSS_Crash_COIN = 1509;
    const EN_Position_DSS_Mines_COIN = 1510;
    const EN_Position_DSS_Sgj_COIN = 2001;
    const EN_Position_DSS_COINS_COIN = 2002;
    const EN_Position_DSS_HILO_COIN = 2003;

    /**
     * Returns defined enum values
     *
     * @return int[]
     */
    public function getEnumValues()
    {
        return array(
            'EN_Position_Hall' => self::EN_Position_Hall,
            'EN_Position_Table' => self::EN_Position_Table,
            'EN_Position_Fpf' => self::EN_Position_Fpf,
            'EN_Position_Daer' => self::EN_Position_Daer,
            'EN_Position_DSS_YD_LM_COIN' => self::EN_Position_DSS_YD_LM_COIN,
            'EN_Position_DSS_YD_ZJH_COIN' => self::EN_Position_DSS_YD_ZJH_COIN,
            'EN_Position_DSS_AB_COIN' => self::EN_Position_DSS_AB_COIN,
            'EN_Position_DSS_Rotary_COIN' => self::EN_Position_DSS_Rotary_COIN,
            'EN_Position_DSS_DvsT_COIN' => self::EN_Position_DSS_DvsT_COIN,
            'EN_Position_DSS_SZ_COIN' => self::EN_Position_DSS_SZ_COIN,
            'EN_Position_DSS_YD_SZ_COIN' => self::EN_Position_DSS_YD_SZ_COIN,
            'EN_Position_DSS_Wingo_COIN' => self::EN_Position_DSS_Wingo_COIN,
            'EN_Position_DSS_KvsQ_COIN' => self::EN_Position_DSS_KvsQ_COIN,
            'EN_Position_DSS_3Patti_COIN' => self::EN_Position_DSS_3Patti_COIN,
            'EN_Position_DSS_Crash_COIN' => self::EN_Position_DSS_Crash_COIN,
            'EN_Position_DSS_Mines_COIN' => self::EN_Position_DSS_Mines_COIN,
            'EN_Position_DSS_Sgj_COIN' => self::EN_Position_DSS_Sgj_COIN,
            'EN_Position_DSS_COINS_COIN' => self::EN_Position_DSS_COINS_COIN,
            'EN_Position_DSS_HILO_COIN' => self::EN_Position_DSS_HILO_COIN,
        );
    }
}
}