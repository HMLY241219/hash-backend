<?php
/**
 * Auto generated from poker_common.proto at 2023-06-08 09:49:25
 */

namespace {
/**
 * ENMessageError enum
 */
final class ENMessageError
{
    const EN_MESSAGE_ERROR_OK = 0;
    const EN_MESSAGE_DB_NOT_FOUND = 1;
    const EN_MESSAGE_DB_INVALID = 2;
    const EN_MESSAGE_DB_SAVE_FAILED = 3;
    const EN_MESSAGE_ERROR_REQUEST_PROCESSING = 4;
    const EN_MESSAGE_INVALID_ACC_TOKEN = 100;
    const EN_MESSAGE_TABLE_NOT_EXIST = 101;
    const EN_MESSAGE_NO_EMPTY_SEAT = 102;
    const EN_MESSAGE_INVALID_SEAT_INDEX = 103;
    const EN_MESSAGE_INVALID_ACTION = 104;
    const EN_MESSAGE_INVALID_TABLE_STATE = 105;
    const EN_MESSAGE_SYSTEM_FAILED = 106;
    const EN_MESSAGE_ALREADY_IN_TABLE = 107;
    const EN_MESSAGE_PERMISSION_DENY = 108;
    const EN_MESSAGE_NO_ENOUGH_COIN = 109;
    const EN_MESSAGE_COIN_TOO_MUCH = 110;
    const EN_MESSAGE_PLAYING_CANNOT_CHANGE_TABLE = 111;
    const EN_MESSAGE_ALLOC_TABLE_FAILED = 112;
    const EN_MESSAGE_EMAIL_STATE = 113;
    const EN_MESSAGE_EMAIL_TYPE = 114;
    const EN_MESSAGE_CURRENCIE_TYPE = 115;
    const EN_MESSAGE_ROTARY_NUM = 116;
    const EN_MESSAGE_NO_GET = 117;

    /**
     * Returns defined enum values
     *
     * @return int[]
     */
    public function getEnumValues()
    {
        return array(
            'EN_MESSAGE_ERROR_OK' => self::EN_MESSAGE_ERROR_OK,
            'EN_MESSAGE_DB_NOT_FOUND' => self::EN_MESSAGE_DB_NOT_FOUND,
            'EN_MESSAGE_DB_INVALID' => self::EN_MESSAGE_DB_INVALID,
            'EN_MESSAGE_DB_SAVE_FAILED' => self::EN_MESSAGE_DB_SAVE_FAILED,
            'EN_MESSAGE_ERROR_REQUEST_PROCESSING' => self::EN_MESSAGE_ERROR_REQUEST_PROCESSING,
            'EN_MESSAGE_INVALID_ACC_TOKEN' => self::EN_MESSAGE_INVALID_ACC_TOKEN,
            'EN_MESSAGE_TABLE_NOT_EXIST' => self::EN_MESSAGE_TABLE_NOT_EXIST,
            'EN_MESSAGE_NO_EMPTY_SEAT' => self::EN_MESSAGE_NO_EMPTY_SEAT,
            'EN_MESSAGE_INVALID_SEAT_INDEX' => self::EN_MESSAGE_INVALID_SEAT_INDEX,
            'EN_MESSAGE_INVALID_ACTION' => self::EN_MESSAGE_INVALID_ACTION,
            'EN_MESSAGE_INVALID_TABLE_STATE' => self::EN_MESSAGE_INVALID_TABLE_STATE,
            'EN_MESSAGE_SYSTEM_FAILED' => self::EN_MESSAGE_SYSTEM_FAILED,
            'EN_MESSAGE_ALREADY_IN_TABLE' => self::EN_MESSAGE_ALREADY_IN_TABLE,
            'EN_MESSAGE_PERMISSION_DENY' => self::EN_MESSAGE_PERMISSION_DENY,
            'EN_MESSAGE_NO_ENOUGH_COIN' => self::EN_MESSAGE_NO_ENOUGH_COIN,
            'EN_MESSAGE_COIN_TOO_MUCH' => self::EN_MESSAGE_COIN_TOO_MUCH,
            'EN_MESSAGE_PLAYING_CANNOT_CHANGE_TABLE' => self::EN_MESSAGE_PLAYING_CANNOT_CHANGE_TABLE,
            'EN_MESSAGE_ALLOC_TABLE_FAILED' => self::EN_MESSAGE_ALLOC_TABLE_FAILED,
            'EN_MESSAGE_EMAIL_STATE' => self::EN_MESSAGE_EMAIL_STATE,
            'EN_MESSAGE_EMAIL_TYPE' => self::EN_MESSAGE_EMAIL_TYPE,
            'EN_MESSAGE_CURRENCIE_TYPE' => self::EN_MESSAGE_CURRENCIE_TYPE,
            'EN_MESSAGE_ROTARY_NUM' => self::EN_MESSAGE_ROTARY_NUM,
            'EN_MESSAGE_NO_GET' => self::EN_MESSAGE_NO_GET,
        );
    }
}
}