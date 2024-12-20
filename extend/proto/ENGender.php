<?php
/**
 * Auto generated from poker_common.proto at 2023-06-08 09:49:25
 */

namespace {
/**
 * ENGender enum
 */
final class ENGender
{
    const EN_Gender_Male = 0;
    const EN_Gender_Female = 1;
    const EN_Gender_Unknown = 2;

    /**
     * Returns defined enum values
     *
     * @return int[]
     */
    public function getEnumValues()
    {
        return array(
            'EN_Gender_Male' => self::EN_Gender_Male,
            'EN_Gender_Female' => self::EN_Gender_Female,
            'EN_Gender_Unknown' => self::EN_Gender_Unknown,
        );
    }
}
}