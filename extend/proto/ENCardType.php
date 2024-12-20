<?php
/**
 * Auto generated from poker_common.proto at 2023-06-08 09:49:25
 */

namespace {
/**
 * ENCardType enum
 */
final class ENCardType
{
    const EN_CARD_TYPE_DIAMOND = 1;
    const EN_CARD_TYPE_CLUB = 2;
    const EN_CARD_TYPE_HEART = 3;
    const EN_CARD_TYPE_SPADE = 4;

    /**
     * Returns defined enum values
     *
     * @return int[]
     */
    public function getEnumValues()
    {
        return array(
            'EN_CARD_TYPE_DIAMOND' => self::EN_CARD_TYPE_DIAMOND,
            'EN_CARD_TYPE_CLUB' => self::EN_CARD_TYPE_CLUB,
            'EN_CARD_TYPE_HEART' => self::EN_CARD_TYPE_HEART,
            'EN_CARD_TYPE_SPADE' => self::EN_CARD_TYPE_SPADE,
        );
    }
}
}