<?php
/**
 * Auto generated from poker_common.proto at 2023-06-08 09:49:25
 */

namespace {
/**
 * ENDSSWinType enum
 */
final class ENDSSWinType
{
    const EN_DSS_WINNER = 1;
    const EN_DSS_LOST = 2;
    const EN_DSS_DROP = 3;

    /**
     * Returns defined enum values
     *
     * @return int[]
     */
    public function getEnumValues()
    {
        return array(
            'EN_DSS_WINNER' => self::EN_DSS_WINNER,
            'EN_DSS_LOST' => self::EN_DSS_LOST,
            'EN_DSS_DROP' => self::EN_DSS_DROP,
        );
    }
}
}