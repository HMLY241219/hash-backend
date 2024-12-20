<?php
/**
 * Auto generated from poker_common.proto at 2023-06-08 09:49:25
 */

namespace {
/**
 * ENChatType enum
 */
final class ENChatType
{
    const EN_CHAT_TYPE_CHARACTER = 0;
    const EN_CHAT_TYPE_BIGFACE = 1;
    const EN_CHAT_TYPE_VOICE = 2;
    const EN_CHAT_TYPE_REWARD = 3;

    /**
     * Returns defined enum values
     *
     * @return int[]
     */
    public function getEnumValues()
    {
        return array(
            'EN_CHAT_TYPE_CHARACTER' => self::EN_CHAT_TYPE_CHARACTER,
            'EN_CHAT_TYPE_BIGFACE' => self::EN_CHAT_TYPE_BIGFACE,
            'EN_CHAT_TYPE_VOICE' => self::EN_CHAT_TYPE_VOICE,
            'EN_CHAT_TYPE_REWARD' => self::EN_CHAT_TYPE_REWARD,
        );
    }
}
}