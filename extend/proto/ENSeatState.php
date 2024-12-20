<?php
/**
 * Auto generated from poker_common.proto at 2023-06-08 09:49:25
 */

namespace {
/**
 * ENSeatState enum
 */
final class ENSeatState
{
    const EN_SEAT_STATE_NO_PLAYER = 0;
    const EN_SEAT_STATE_WAIT_FOR_NEXT_ONE_GAME = 1;
    const EN_SEAT_STATE_READY_FOR_NEXT_ONE_GAME = 2;
    const EN_SEAT_STATE_PLAYING = 3;
    const EN_SEAT_STATE_WIN = 4;
    const EN_SEAT_STATE_WAIT_TO_LEAVE = 5;
    const EN_SEAT_STATE_KOU_PAI = 6;
    const EN_SEAT_STATE_SUFFLE_CARD = 7;
    const EN_SEAT_STATE_SORT_OUT_CARD = 8;
    const EN_SEAT_STATE_DROP_CARD = 9;
    const EN_SEAT_STATE_ALL_IN = 10;

    /**
     * Returns defined enum values
     *
     * @return int[]
     */
    public function getEnumValues()
    {
        return array(
            'EN_SEAT_STATE_NO_PLAYER' => self::EN_SEAT_STATE_NO_PLAYER,
            'EN_SEAT_STATE_WAIT_FOR_NEXT_ONE_GAME' => self::EN_SEAT_STATE_WAIT_FOR_NEXT_ONE_GAME,
            'EN_SEAT_STATE_READY_FOR_NEXT_ONE_GAME' => self::EN_SEAT_STATE_READY_FOR_NEXT_ONE_GAME,
            'EN_SEAT_STATE_PLAYING' => self::EN_SEAT_STATE_PLAYING,
            'EN_SEAT_STATE_WIN' => self::EN_SEAT_STATE_WIN,
            'EN_SEAT_STATE_WAIT_TO_LEAVE' => self::EN_SEAT_STATE_WAIT_TO_LEAVE,
            'EN_SEAT_STATE_KOU_PAI' => self::EN_SEAT_STATE_KOU_PAI,
            'EN_SEAT_STATE_SUFFLE_CARD' => self::EN_SEAT_STATE_SUFFLE_CARD,
            'EN_SEAT_STATE_SORT_OUT_CARD' => self::EN_SEAT_STATE_SORT_OUT_CARD,
            'EN_SEAT_STATE_DROP_CARD' => self::EN_SEAT_STATE_DROP_CARD,
            'EN_SEAT_STATE_ALL_IN' => self::EN_SEAT_STATE_ALL_IN,
        );
    }
}
}