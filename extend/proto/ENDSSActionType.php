<?php
/**
 * Auto generated from poker_common.proto at 2023-06-08 09:49:25
 */

namespace {
/**
 * ENDSSActionType enum
 */
final class ENDSSActionType
{
    const EN_DSS_ACTION_UNKNOWN = 0;
    const EN_DSS_ACTION_CHUPAI = 1;
    const EN_DSS_ACTION_NAPAI = 2;
    const EN_DSS_ACTION_CHI = 3;
    const EN_DSS_ACTION_PENG = 4;
    const EN_DSS_ACTION_GANG = 5;
    const EN_DSS_ACTION_HUPAI = 6;
    const EN_DSS_ACTION_PASS = 7;
    const EN_DSS_ACTION_AN = 8;
    const EN_DSS_ACTION_TOU = 9;
    const EN_DSS_ACTION_TING = 10;
    const EN_DSS_ACTION_OUT_CARD = 11;
    const EN_DSS_ACTION_PAY = 12;
    const EN_DSS_ACTION_DROP_CARD = 337;
    const EN_DSS_ACTION_SHOW_CARD = 338;
    const EN_DSS_ACTION_SORT_OUT_CARD = 339;
    const EN_DSS_ACTION_BU_PAI = 340;
    const EN_DSS_ACTION_LOST_MULIPLE = 341;
    const EN_DSS_ACTION_REWARD = 342;
    const EN_ZHJ_ACTION_LOOK = 501;
    const EN_ZHJ_ACTION_GIVE_UP = 502;
    const EN_ZHJ_ACTION_ADD = 503;
    const EN_ZHJ_ACTION_COMPARE = 504;
    const EN_ZHJ_ACTION_COMPARE_OK = 505;
    const EN_ZHJ_ACTION_COMPARE_NO = 506;
    const EN_CRASH_ACTION_ADD_BET = 601;
    const EN_CRASH_ACTION_ADD_NEXT_BET = 602;
    const EN_CRASH_ACTION_CANCEL_NEXT_BET = 603;
    const EN_CRASH_ACTION_CASH_OUT = 604;
    const EN_MINES_ACTION_ADD_BET = 620;
    const EN_MINES_ACTION_CLEAR = 621;
    const EN_MINES_ACTION_CASH_OUT = 622;
    const EN_COINS_ACTION_ADD_BET = 701;
    const EN_COINS_ACTION_PLAY_FLIP = 702;
    const EN_COINS_ACTION_CASH_OUT = 703;
    const EN_HILO_ACTION_ADD_BET = 801;
    const EN_HILO_ACTION_SKIP = 802;
    const EN_HILO_ACTION_PLAY_FLIP = 803;
    const EN_HILO_ACTION_CASH_OUT = 804;

    /**
     * Returns defined enum values
     *
     * @return int[]
     */
    public function getEnumValues()
    {
        return array(
            'EN_DSS_ACTION_UNKNOWN' => self::EN_DSS_ACTION_UNKNOWN,
            'EN_DSS_ACTION_CHUPAI' => self::EN_DSS_ACTION_CHUPAI,
            'EN_DSS_ACTION_NAPAI' => self::EN_DSS_ACTION_NAPAI,
            'EN_DSS_ACTION_CHI' => self::EN_DSS_ACTION_CHI,
            'EN_DSS_ACTION_PENG' => self::EN_DSS_ACTION_PENG,
            'EN_DSS_ACTION_GANG' => self::EN_DSS_ACTION_GANG,
            'EN_DSS_ACTION_HUPAI' => self::EN_DSS_ACTION_HUPAI,
            'EN_DSS_ACTION_PASS' => self::EN_DSS_ACTION_PASS,
            'EN_DSS_ACTION_AN' => self::EN_DSS_ACTION_AN,
            'EN_DSS_ACTION_TOU' => self::EN_DSS_ACTION_TOU,
            'EN_DSS_ACTION_TING' => self::EN_DSS_ACTION_TING,
            'EN_DSS_ACTION_OUT_CARD' => self::EN_DSS_ACTION_OUT_CARD,
            'EN_DSS_ACTION_PAY' => self::EN_DSS_ACTION_PAY,
            'EN_DSS_ACTION_DROP_CARD' => self::EN_DSS_ACTION_DROP_CARD,
            'EN_DSS_ACTION_SHOW_CARD' => self::EN_DSS_ACTION_SHOW_CARD,
            'EN_DSS_ACTION_SORT_OUT_CARD' => self::EN_DSS_ACTION_SORT_OUT_CARD,
            'EN_DSS_ACTION_BU_PAI' => self::EN_DSS_ACTION_BU_PAI,
            'EN_DSS_ACTION_LOST_MULIPLE' => self::EN_DSS_ACTION_LOST_MULIPLE,
            'EN_DSS_ACTION_REWARD' => self::EN_DSS_ACTION_REWARD,
            'EN_ZHJ_ACTION_LOOK' => self::EN_ZHJ_ACTION_LOOK,
            'EN_ZHJ_ACTION_GIVE_UP' => self::EN_ZHJ_ACTION_GIVE_UP,
            'EN_ZHJ_ACTION_ADD' => self::EN_ZHJ_ACTION_ADD,
            'EN_ZHJ_ACTION_COMPARE' => self::EN_ZHJ_ACTION_COMPARE,
            'EN_ZHJ_ACTION_COMPARE_OK' => self::EN_ZHJ_ACTION_COMPARE_OK,
            'EN_ZHJ_ACTION_COMPARE_NO' => self::EN_ZHJ_ACTION_COMPARE_NO,
            'EN_CRASH_ACTION_ADD_BET' => self::EN_CRASH_ACTION_ADD_BET,
            'EN_CRASH_ACTION_ADD_NEXT_BET' => self::EN_CRASH_ACTION_ADD_NEXT_BET,
            'EN_CRASH_ACTION_CANCEL_NEXT_BET' => self::EN_CRASH_ACTION_CANCEL_NEXT_BET,
            'EN_CRASH_ACTION_CASH_OUT' => self::EN_CRASH_ACTION_CASH_OUT,
            'EN_MINES_ACTION_ADD_BET' => self::EN_MINES_ACTION_ADD_BET,
            'EN_MINES_ACTION_CLEAR' => self::EN_MINES_ACTION_CLEAR,
            'EN_MINES_ACTION_CASH_OUT' => self::EN_MINES_ACTION_CASH_OUT,
            'EN_COINS_ACTION_ADD_BET' => self::EN_COINS_ACTION_ADD_BET,
            'EN_COINS_ACTION_PLAY_FLIP' => self::EN_COINS_ACTION_PLAY_FLIP,
            'EN_COINS_ACTION_CASH_OUT' => self::EN_COINS_ACTION_CASH_OUT,
            'EN_HILO_ACTION_ADD_BET' => self::EN_HILO_ACTION_ADD_BET,
            'EN_HILO_ACTION_SKIP' => self::EN_HILO_ACTION_SKIP,
            'EN_HILO_ACTION_PLAY_FLIP' => self::EN_HILO_ACTION_PLAY_FLIP,
            'EN_HILO_ACTION_CASH_OUT' => self::EN_HILO_ACTION_CASH_OUT,
        );
    }
}
}