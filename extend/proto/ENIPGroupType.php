<?php
/**
 * Auto generated from poker_common.proto at 2023-06-08 09:49:25
 */

namespace {
/**
 * ENIPGroupType enum
 */
final class ENIPGroupType
{
    const EN_IP_Group_Type_Game = 1;
    const EN_IP_Group_Type_List = 2;

    /**
     * Returns defined enum values
     *
     * @return int[]
     */
    public function getEnumValues()
    {
        return array(
            'EN_IP_Group_Type_Game' => self::EN_IP_Group_Type_Game,
            'EN_IP_Group_Type_List' => self::EN_IP_Group_Type_List,
        );
    }
}
}