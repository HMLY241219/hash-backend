<?php
/**
 * Auto generated from poker_common.proto at 2023-06-08 09:49:25
 */

namespace {
/**
 * ENAccountType enum
 */
final class ENAccountType
{
    const EN_Accout_Guest = 0;
    const EN_Accout_Weixin = 1;
    const EN_Account_FB = 2;
    const EN_Account_Robot = 3;
    const EN_Account_Phone = 4;
    const EN_Account_FB_Phone = 7;

    /**
     * Returns defined enum values
     *
     * @return int[]
     */
    public function getEnumValues()
    {
        return array(
            'EN_Accout_Guest' => self::EN_Accout_Guest,
            'EN_Accout_Weixin' => self::EN_Accout_Weixin,
            'EN_Account_FB' => self::EN_Account_FB,
            'EN_Account_Robot' => self::EN_Account_Robot,
            'EN_Account_Phone' => self::EN_Account_Phone,
            'EN_Account_FB_Phone' => self::EN_Account_FB_Phone,
        );
    }
}
}