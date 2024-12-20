<?php
/**
 * Auto generated from poker_common.proto at 2023-06-08 09:49:25
 */

namespace {
/**
 * ENKVDataResponseResult enum
 */
final class ENKVDataResponseResult
{
    const EN_KV_Data_Response_Result_OK = 0;
    const EN_KV_Data_Response_Result_Failed = 1;

    /**
     * Returns defined enum values
     *
     * @return int[]
     */
    public function getEnumValues()
    {
        return array(
            'EN_KV_Data_Response_Result_OK' => self::EN_KV_Data_Response_Result_OK,
            'EN_KV_Data_Response_Result_Failed' => self::EN_KV_Data_Response_Result_Failed,
        );
    }
}
}