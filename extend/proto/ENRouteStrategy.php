<?php
/**
 * Auto generated from poker_common.proto at 2023-06-08 09:49:25
 */

namespace {
/**
 * ENRouteStrategy enum
 */
final class ENRouteStrategy
{
    const EN_Route_Strategy_Node_To_Node = 0;
    const EN_Route_Strategy_Random = 1;
    const EN_Route_Strategy_HashByUid = 2;
    const EN_Route_Strategy_BroadCast = 3;

    /**
     * Returns defined enum values
     *
     * @return int[]
     */
    public function getEnumValues()
    {
        return array(
            'EN_Route_Strategy_Node_To_Node' => self::EN_Route_Strategy_Node_To_Node,
            'EN_Route_Strategy_Random' => self::EN_Route_Strategy_Random,
            'EN_Route_Strategy_HashByUid' => self::EN_Route_Strategy_HashByUid,
            'EN_Route_Strategy_BroadCast' => self::EN_Route_Strategy_BroadCast,
        );
    }
}
}