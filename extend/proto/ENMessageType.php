<?php
/**
 * Auto generated from poker_common.proto at 2023-06-08 09:49:25
 */

namespace {
/**
 * ENMessageType enum
 */
final class ENMessageType
{
    const EN_Message_Unknown = 0;
    const EN_Message_Request = 1;
    const EN_Message_Response = 2;
    const EN_Message_Push = 3;

    /**
     * Returns defined enum values
     *
     * @return int[]
     */
    public function getEnumValues()
    {
        return array(
            'EN_Message_Unknown' => self::EN_Message_Unknown,
            'EN_Message_Request' => self::EN_Message_Request,
            'EN_Message_Response' => self::EN_Message_Response,
            'EN_Message_Push' => self::EN_Message_Push,
        );
    }
}
}