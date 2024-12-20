<?php
/**
 * Auto generated from poker_common.proto at 2023-06-08 09:49:25
 */

namespace {
/**
 * ENDataType enum
 */
final class ENDataType
{
    const EN_Data_Int = 0;
    const EN_Data_Str = 1;

    /**
     * Returns defined enum values
     *
     * @return int[]
     */
    public function getEnumValues()
    {
        return array(
            'EN_Data_Int' => self::EN_Data_Int,
            'EN_Data_Str' => self::EN_Data_Str,
        );
    }
}
}