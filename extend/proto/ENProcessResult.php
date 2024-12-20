<?php
/**
 * Auto generated from poker_common.proto at 2023-06-08 09:49:25
 */

namespace {
/**
 * ENProcessResult enum
 */
final class ENProcessResult
{
    const EN_Process_Result_Failed = 0;
    const EN_Process_Result_Succ = 1;
    const EN_Process_Result_Completed = 2;

    /**
     * Returns defined enum values
     *
     * @return int[]
     */
    public function getEnumValues()
    {
        return array(
            'EN_Process_Result_Failed' => self::EN_Process_Result_Failed,
            'EN_Process_Result_Succ' => self::EN_Process_Result_Succ,
            'EN_Process_Result_Completed' => self::EN_Process_Result_Completed,
        );
    }
}
}