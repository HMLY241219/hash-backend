<?php
/**
 * Auto generated from poker_common.proto at 2023-06-08 09:49:25
 */

namespace {
/**
 * ENSitError enum
 */
final class ENSitError
{
    const EN_Sit_Succ = 0;
    const EN_Sit_No_Empty_Seat = 1;
    const EN_Sit_No_Enough_Money = 2;
    const EN_Sit_Room_Limit = 3;
    const EN_Sit_Reconnect = 4;
    const EN_Sit_Bankrupt = 5;

    /**
     * Returns defined enum values
     *
     * @return int[]
     */
    public function getEnumValues()
    {
        return array(
            'EN_Sit_Succ' => self::EN_Sit_Succ,
            'EN_Sit_No_Empty_Seat' => self::EN_Sit_No_Empty_Seat,
            'EN_Sit_No_Enough_Money' => self::EN_Sit_No_Enough_Money,
            'EN_Sit_Room_Limit' => self::EN_Sit_Room_Limit,
            'EN_Sit_Reconnect' => self::EN_Sit_Reconnect,
            'EN_Sit_Bankrupt' => self::EN_Sit_Bankrupt,
        );
    }
}
}