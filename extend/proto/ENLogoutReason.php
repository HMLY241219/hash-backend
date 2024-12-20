<?php
/**
 * Auto generated from poker_common.proto at 2023-06-08 09:49:25
 */

namespace {
/**
 * ENLogoutReason enum
 */
final class ENLogoutReason
{
    const EN_Logout_Reason_Normal = 1;
    const EN_Logout_Reason_Change_Table = 2;
    const EN_Logout_Reason_No_Enough_Chip = 3;

    /**
     * Returns defined enum values
     *
     * @return int[]
     */
    public function getEnumValues()
    {
        return array(
            'EN_Logout_Reason_Normal' => self::EN_Logout_Reason_Normal,
            'EN_Logout_Reason_Change_Table' => self::EN_Logout_Reason_Change_Table,
            'EN_Logout_Reason_No_Enough_Chip' => self::EN_Logout_Reason_No_Enough_Chip,
        );
    }
}
}