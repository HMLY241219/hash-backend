<?php
/**
 * Auto generated from poker_common.proto at 2023-06-08 09:49:25
 */

namespace {
/**
 * ENTableState enum
 */
final class ENTableState
{
    const EN_TABLE_STATE_WAIT = 0;
    const EN_TABLE_STATE_READY_TO_START = 1;
    const EN_TABLE_STATE_PLAYING = 2;
    const EN_TABLE_STATE_WAIT_DISSOLVE = 3;
    const EN_TABLE_STATE_SINGLE_OVER = 6;
    const EN_TABLE_STATE_FINISH = 5;
    const EN_TABLE_STATE_AUTO_DISSOLVING = 4;
    const EN_TABLE_STATE_ROUND_1 = 7;
    const EN_TABLE_STATE_ROUND_2 = 8;
    const EN_TABLE_STATE_ROUND_3 = 9;
    const EN_TABLE_STATE_WAIT_1 = 10;
    const EN_TABLE_STATE_WAIT_2 = 11;
    const EN_TABLE_STATE_WAIT_3 = 12;

    /**
     * Returns defined enum values
     *
     * @return int[]
     */
    public function getEnumValues()
    {
        return array(
            'EN_TABLE_STATE_WAIT' => self::EN_TABLE_STATE_WAIT,
            'EN_TABLE_STATE_READY_TO_START' => self::EN_TABLE_STATE_READY_TO_START,
            'EN_TABLE_STATE_PLAYING' => self::EN_TABLE_STATE_PLAYING,
            'EN_TABLE_STATE_WAIT_DISSOLVE' => self::EN_TABLE_STATE_WAIT_DISSOLVE,
            'EN_TABLE_STATE_SINGLE_OVER' => self::EN_TABLE_STATE_SINGLE_OVER,
            'EN_TABLE_STATE_FINISH' => self::EN_TABLE_STATE_FINISH,
            'EN_TABLE_STATE_AUTO_DISSOLVING' => self::EN_TABLE_STATE_AUTO_DISSOLVING,
            'EN_TABLE_STATE_ROUND_1' => self::EN_TABLE_STATE_ROUND_1,
            'EN_TABLE_STATE_ROUND_2' => self::EN_TABLE_STATE_ROUND_2,
            'EN_TABLE_STATE_ROUND_3' => self::EN_TABLE_STATE_ROUND_3,
            'EN_TABLE_STATE_WAIT_1' => self::EN_TABLE_STATE_WAIT_1,
            'EN_TABLE_STATE_WAIT_2' => self::EN_TABLE_STATE_WAIT_2,
            'EN_TABLE_STATE_WAIT_3' => self::EN_TABLE_STATE_WAIT_3,
        );
    }
}
}