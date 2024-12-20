<?php
/**
 * Auto generated from poker_common.proto at 2023-06-08 09:49:25
 */

namespace {
/**
 * ENRouteType enum
 */
final class ENRouteType
{
    const EN_Route_p2p = 0;
    const EN_Route_hash = 1;
    const EN_Route_broadcast = 2;

    /**
     * Returns defined enum values
     *
     * @return int[]
     */
    public function getEnumValues()
    {
        return array(
            'EN_Route_p2p' => self::EN_Route_p2p,
            'EN_Route_hash' => self::EN_Route_hash,
            'EN_Route_broadcast' => self::EN_Route_broadcast,
        );
    }
}
}