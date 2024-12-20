<?php
/**
 * Auto generated from poker_data.proto at 2023-06-08 09:49:25
 */

namespace {
/**
 * ENUpdateStrategy enum
 */
final class ENUpdateStrategy
{
    const EN_Update_Strategy_Replace = 0;
    const EN_Update_Strategy_Inc = 1;
    const EN_Update_Strategy_Add = 2;
    const EN_Update_Strategy_Del = 3;

    /**
     * Returns defined enum values
     *
     * @return int[]
     */
    public function getEnumValues()
    {
        return array(
            'EN_Update_Strategy_Replace' => self::EN_Update_Strategy_Replace,
            'EN_Update_Strategy_Inc' => self::EN_Update_Strategy_Inc,
            'EN_Update_Strategy_Add' => self::EN_Update_Strategy_Add,
            'EN_Update_Strategy_Del' => self::EN_Update_Strategy_Del,
        );
    }
}
}