<?php
/**
 * Auto generated from poker_common.proto at 2023-06-08 09:49:25
 */

namespace {
/**
 * ENConnectionState enum
 */
final class ENConnectionState
{
    const EN_Connection_State_Online = 0;
    const EN_Connection_State_Offline = 1;

    /**
     * Returns defined enum values
     *
     * @return int[]
     */
    public function getEnumValues()
    {
        return array(
            'EN_Connection_State_Online' => self::EN_Connection_State_Online,
            'EN_Connection_State_Offline' => self::EN_Connection_State_Offline,
        );
    }
}
}