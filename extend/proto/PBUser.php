<?php
/**
 * Auto generated from poker_data.proto at 2023-06-08 09:49:25
 */

namespace {
/**
 * PBUser message
 */
class PBUser extends \ProtobufMessage
{
    /* Field index constants */
    const UID = 1;
    const COIN_POS = 2;
    const HALLSVID = 3;
    const PIC_URL = 4;
    const NICK = 6;
    const IP = 7;
    const ACC_TYPE = 8;
    const CHANNEL = 9;
    const LIMIT = 10;
    const GENDER = 11;
    const ROLETYPE = 12;
    const VIP = 13;
    const COINS = 14;
    const GOLD = 15;
    const TPC_SCORE = 16;
    const TPC_UNLOCK = 17;
    const TOTAL_TPC_TO = 18;
    const NEED_SCORE_WATER = 19;
    const NOW_SCORE_WATER = 20;
    const TOTAL_GAME_NUM = 21;
    const TOTAL_WATER_SCORE = 22;
    const TOTAL_OUTSIDE_GAME_NUM = 23;
    const TOTAL_OUTSIDE_WATER_SCORE = 24;
    const TOTAL_PAY = 25;
    const TOTAL_GIVE = 26;
    const TOTAL_SERVICE_SCORE = 27;
    const BIND_UID = 28;
    const WATER_TO_COINS = 29;
    const TOTAL_WATER_TO_COINS = 30;
    const VIP_BACK = 31;
    const TOTAL_VIP_BACK = 32;
    const INIT = 33;
    const TOTAL_TASK_SCORE = 34;
    const TOTAL_SCORE = 35;
    const TOTAL_OUTSIDE_SCORE = 36;
    const PACKAGE_ID = 37;
    const CLEAN_WATER_TIME = 38;
    const PAY_TIME = 39;
    const EXCHANGE_SCORE = 40;

    /* @var array Field descriptors */
    protected static $fields = array(
        self::UID => array(
            'name' => 'uid',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_INT,
        ),
        self::COIN_POS => array(
            'name' => 'coin_pos',
            'required' => false,
            'type' => '\PBBPlayerPositionInfo'
        ),
        self::HALLSVID => array(
            'name' => 'hallsvid',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_INT,
        ),
        self::PIC_URL => array(
            'name' => 'pic_url',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_STRING,
        ),
        self::NICK => array(
            'name' => 'nick',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_STRING,
        ),
        self::IP => array(
            'name' => 'ip',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_STRING,
        ),
        self::ACC_TYPE => array(
            'name' => 'acc_type',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_INT,
        ),
        self::CHANNEL => array(
            'name' => 'channel',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_INT,
        ),
        self::LIMIT => array(
            'name' => 'limit',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_INT,
        ),
        self::GENDER => array(
            'name' => 'gender',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_INT,
        ),
        self::ROLETYPE => array(
            'name' => 'roletype',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_INT,
        ),
        self::VIP => array(
            'name' => 'vip',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_INT,
        ),
        self::COINS => array(
            'name' => 'coins',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_INT,
        ),
        self::GOLD => array(
            'name' => 'gold',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_INT,
        ),
        self::TPC_SCORE => array(
            'name' => 'tpc_score',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_INT,
        ),
        self::TPC_UNLOCK => array(
            'name' => 'tpc_unlock',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_INT,
        ),
        self::TOTAL_TPC_TO => array(
            'name' => 'total_tpc_to',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_INT,
        ),
        self::NEED_SCORE_WATER => array(
            'name' => 'need_score_water',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_INT,
        ),
        self::NOW_SCORE_WATER => array(
            'name' => 'now_score_water',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_INT,
        ),
        self::TOTAL_GAME_NUM => array(
            'name' => 'total_game_num',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_INT,
        ),
        self::TOTAL_WATER_SCORE => array(
            'name' => 'total_water_score',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_INT,
        ),
        self::TOTAL_OUTSIDE_GAME_NUM => array(
            'name' => 'total_outside_game_num',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_INT,
        ),
        self::TOTAL_OUTSIDE_WATER_SCORE => array(
            'name' => 'total_outside_water_score',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_INT,
        ),
        self::TOTAL_PAY => array(
            'name' => 'total_pay',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_INT,
        ),
        self::TOTAL_GIVE => array(
            'name' => 'total_give',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_INT,
        ),
        self::TOTAL_SERVICE_SCORE => array(
            'name' => 'total_service_score',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_INT,
        ),
        self::BIND_UID => array(
            'name' => 'bind_uid',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_INT,
        ),
        self::WATER_TO_COINS => array(
            'name' => 'water_to_coins',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_INT,
        ),
        self::TOTAL_WATER_TO_COINS => array(
            'name' => 'total_water_to_coins',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_INT,
        ),
        self::VIP_BACK => array(
            'name' => 'vip_back',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_INT,
        ),
        self::TOTAL_VIP_BACK => array(
            'name' => 'total_vip_back',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_INT,
        ),
        self::INIT => array(
            'name' => 'init',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_INT,
        ),
        self::TOTAL_TASK_SCORE => array(
            'name' => 'total_task_score',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_INT,
        ),
        self::TOTAL_SCORE => array(
            'name' => 'total_score',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_INT,
        ),
        self::TOTAL_OUTSIDE_SCORE => array(
            'name' => 'total_outside_score',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_INT,
        ),
        self::PACKAGE_ID => array(
            'name' => 'package_id',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_INT,
        ),
        self::CLEAN_WATER_TIME => array(
            'name' => 'clean_water_time',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_INT,
        ),
        self::PAY_TIME => array(
            'name' => 'pay_time',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_INT,
        ),
        self::EXCHANGE_SCORE => array(
            'name' => 'exchange_score',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_INT,
        ),
    );

    /**
     * Constructs new message container and clears its internal state
     */
    public function __construct()
    {
        $this->reset();
    }

    /**
     * Clears message values and sets default ones
     *
     * @return null
     */
    public function reset()
    {
        $this->values[self::UID] = null;
        $this->values[self::COIN_POS] = null;
        $this->values[self::HALLSVID] = null;
        $this->values[self::PIC_URL] = null;
        $this->values[self::NICK] = null;
        $this->values[self::IP] = null;
        $this->values[self::ACC_TYPE] = null;
        $this->values[self::CHANNEL] = null;
        $this->values[self::LIMIT] = null;
        $this->values[self::GENDER] = null;
        $this->values[self::ROLETYPE] = null;
        $this->values[self::VIP] = null;
        $this->values[self::COINS] = null;
        $this->values[self::GOLD] = null;
        $this->values[self::TPC_SCORE] = null;
        $this->values[self::TPC_UNLOCK] = null;
        $this->values[self::TOTAL_TPC_TO] = null;
        $this->values[self::NEED_SCORE_WATER] = null;
        $this->values[self::NOW_SCORE_WATER] = null;
        $this->values[self::TOTAL_GAME_NUM] = null;
        $this->values[self::TOTAL_WATER_SCORE] = null;
        $this->values[self::TOTAL_OUTSIDE_GAME_NUM] = null;
        $this->values[self::TOTAL_OUTSIDE_WATER_SCORE] = null;
        $this->values[self::TOTAL_PAY] = null;
        $this->values[self::TOTAL_GIVE] = null;
        $this->values[self::TOTAL_SERVICE_SCORE] = null;
        $this->values[self::BIND_UID] = null;
        $this->values[self::WATER_TO_COINS] = null;
        $this->values[self::TOTAL_WATER_TO_COINS] = null;
        $this->values[self::VIP_BACK] = null;
        $this->values[self::TOTAL_VIP_BACK] = null;
        $this->values[self::INIT] = null;
        $this->values[self::TOTAL_TASK_SCORE] = null;
        $this->values[self::TOTAL_SCORE] = null;
        $this->values[self::TOTAL_OUTSIDE_SCORE] = null;
        $this->values[self::PACKAGE_ID] = null;
        $this->values[self::CLEAN_WATER_TIME] = null;
        $this->values[self::PAY_TIME] = null;
        $this->values[self::EXCHANGE_SCORE] = null;
    }

    /**
     * Returns field descriptors
     *
     * @return array
     */
    public function fields()
    {
        return self::$fields;
    }

    /**
     * Sets value of 'uid' property
     *
     * @param integer $value Property value
     *
     * @return null
     */
    public function setUid($value)
    {
        return $this->set(self::UID, $value);
    }

    /**
     * Returns value of 'uid' property
     *
     * @return integer
     */
    public function getUid()
    {
        $value = $this->get(self::UID);
        return $value === null ? (integer)$value : $value;
    }

    /**
     * Returns true if 'uid' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasUid()
    {
        return $this->get(self::UID) !== null;
    }

    /**
     * Sets value of 'coin_pos' property
     *
     * @param \PBBPlayerPositionInfo $value Property value
     *
     * @return null
     */
    public function setCoinPos(\PBBPlayerPositionInfo $value=null)
    {
        return $this->set(self::COIN_POS, $value);
    }

    /**
     * Returns value of 'coin_pos' property
     *
     * @return \PBBPlayerPositionInfo
     */
    public function getCoinPos()
    {
        return $this->get(self::COIN_POS);
    }

    /**
     * Returns true if 'coin_pos' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasCoinPos()
    {
        return $this->get(self::COIN_POS) !== null;
    }

    /**
     * Sets value of 'hallsvid' property
     *
     * @param integer $value Property value
     *
     * @return null
     */
    public function setHallsvid($value)
    {
        return $this->set(self::HALLSVID, $value);
    }

    /**
     * Returns value of 'hallsvid' property
     *
     * @return integer
     */
    public function getHallsvid()
    {
        $value = $this->get(self::HALLSVID);
        return $value === null ? (integer)$value : $value;
    }

    /**
     * Returns true if 'hallsvid' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasHallsvid()
    {
        return $this->get(self::HALLSVID) !== null;
    }

    /**
     * Sets value of 'pic_url' property
     *
     * @param string $value Property value
     *
     * @return null
     */
    public function setPicUrl($value)
    {
        return $this->set(self::PIC_URL, $value);
    }

    /**
     * Returns value of 'pic_url' property
     *
     * @return string
     */
    public function getPicUrl()
    {
        $value = $this->get(self::PIC_URL);
        return $value === null ? (string)$value : $value;
    }

    /**
     * Returns true if 'pic_url' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasPicUrl()
    {
        return $this->get(self::PIC_URL) !== null;
    }

    /**
     * Sets value of 'nick' property
     *
     * @param string $value Property value
     *
     * @return null
     */
    public function setNick($value)
    {
        return $this->set(self::NICK, $value);
    }

    /**
     * Returns value of 'nick' property
     *
     * @return string
     */
    public function getNick()
    {
        $value = $this->get(self::NICK);
        return $value === null ? (string)$value : $value;
    }

    /**
     * Returns true if 'nick' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasNick()
    {
        return $this->get(self::NICK) !== null;
    }

    /**
     * Sets value of 'ip' property
     *
     * @param string $value Property value
     *
     * @return null
     */
    public function setIp($value)
    {
        return $this->set(self::IP, $value);
    }

    /**
     * Returns value of 'ip' property
     *
     * @return string
     */
    public function getIp()
    {
        $value = $this->get(self::IP);
        return $value === null ? (string)$value : $value;
    }

    /**
     * Returns true if 'ip' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasIp()
    {
        return $this->get(self::IP) !== null;
    }

    /**
     * Sets value of 'acc_type' property
     *
     * @param integer $value Property value
     *
     * @return null
     */
    public function setAccType($value)
    {
        return $this->set(self::ACC_TYPE, $value);
    }

    /**
     * Returns value of 'acc_type' property
     *
     * @return integer
     */
    public function getAccType()
    {
        $value = $this->get(self::ACC_TYPE);
        return $value === null ? (integer)$value : $value;
    }

    /**
     * Returns true if 'acc_type' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasAccType()
    {
        return $this->get(self::ACC_TYPE) !== null;
    }

    /**
     * Sets value of 'channel' property
     *
     * @param integer $value Property value
     *
     * @return null
     */
    public function setChannel($value)
    {
        return $this->set(self::CHANNEL, $value);
    }

    /**
     * Returns value of 'channel' property
     *
     * @return integer
     */
    public function getChannel()
    {
        $value = $this->get(self::CHANNEL);
        return $value === null ? (integer)$value : $value;
    }

    /**
     * Returns true if 'channel' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasChannel()
    {
        return $this->get(self::CHANNEL) !== null;
    }

    /**
     * Sets value of 'limit' property
     *
     * @param integer $value Property value
     *
     * @return null
     */
    public function setLimit($value)
    {
        return $this->set(self::LIMIT, $value);
    }

    /**
     * Returns value of 'limit' property
     *
     * @return integer
     */
    public function getLimit()
    {
        $value = $this->get(self::LIMIT);
        return $value === null ? (integer)$value : $value;
    }

    /**
     * Returns true if 'limit' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasLimit()
    {
        return $this->get(self::LIMIT) !== null;
    }

    /**
     * Sets value of 'gender' property
     *
     * @param integer $value Property value
     *
     * @return null
     */
    public function setGender($value)
    {
        return $this->set(self::GENDER, $value);
    }

    /**
     * Returns value of 'gender' property
     *
     * @return integer
     */
    public function getGender()
    {
        $value = $this->get(self::GENDER);
        return $value === null ? (integer)$value : $value;
    }

    /**
     * Returns true if 'gender' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasGender()
    {
        return $this->get(self::GENDER) !== null;
    }

    /**
     * Sets value of 'roletype' property
     *
     * @param integer $value Property value
     *
     * @return null
     */
    public function setRoletype($value)
    {
        return $this->set(self::ROLETYPE, $value);
    }

    /**
     * Returns value of 'roletype' property
     *
     * @return integer
     */
    public function getRoletype()
    {
        $value = $this->get(self::ROLETYPE);
        return $value === null ? (integer)$value : $value;
    }

    /**
     * Returns true if 'roletype' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasRoletype()
    {
        return $this->get(self::ROLETYPE) !== null;
    }

    /**
     * Sets value of 'vip' property
     *
     * @param integer $value Property value
     *
     * @return null
     */
    public function setVip($value)
    {
        return $this->set(self::VIP, $value);
    }

    /**
     * Returns value of 'vip' property
     *
     * @return integer
     */
    public function getVip()
    {
        $value = $this->get(self::VIP);
        return $value === null ? (integer)$value : $value;
    }

    /**
     * Returns true if 'vip' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasVip()
    {
        return $this->get(self::VIP) !== null;
    }

    /**
     * Sets value of 'coins' property
     *
     * @param integer $value Property value
     *
     * @return null
     */
    public function setCoins($value)
    {
        return $this->set(self::COINS, $value);
    }

    /**
     * Returns value of 'coins' property
     *
     * @return integer
     */
    public function getCoins()
    {
        $value = $this->get(self::COINS);
        return $value === null ? (integer)$value : $value;
    }

    /**
     * Returns true if 'coins' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasCoins()
    {
        return $this->get(self::COINS) !== null;
    }

    /**
     * Sets value of 'gold' property
     *
     * @param integer $value Property value
     *
     * @return null
     */
    public function setGold($value)
    {
        return $this->set(self::GOLD, $value);
    }

    /**
     * Returns value of 'gold' property
     *
     * @return integer
     */
    public function getGold()
    {
        $value = $this->get(self::GOLD);
        return $value === null ? (integer)$value : $value;
    }

    /**
     * Returns true if 'gold' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasGold()
    {
        return $this->get(self::GOLD) !== null;
    }

    /**
     * Sets value of 'tpc_score' property
     *
     * @param integer $value Property value
     *
     * @return null
     */
    public function setTpcScore($value)
    {
        return $this->set(self::TPC_SCORE, $value);
    }

    /**
     * Returns value of 'tpc_score' property
     *
     * @return integer
     */
    public function getTpcScore()
    {
        $value = $this->get(self::TPC_SCORE);
        return $value === null ? (integer)$value : $value;
    }

    /**
     * Returns true if 'tpc_score' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasTpcScore()
    {
        return $this->get(self::TPC_SCORE) !== null;
    }

    /**
     * Sets value of 'tpc_unlock' property
     *
     * @param integer $value Property value
     *
     * @return null
     */
    public function setTpcUnlock($value)
    {
        return $this->set(self::TPC_UNLOCK, $value);
    }

    /**
     * Returns value of 'tpc_unlock' property
     *
     * @return integer
     */
    public function getTpcUnlock()
    {
        $value = $this->get(self::TPC_UNLOCK);
        return $value === null ? (integer)$value : $value;
    }

    /**
     * Returns true if 'tpc_unlock' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasTpcUnlock()
    {
        return $this->get(self::TPC_UNLOCK) !== null;
    }

    /**
     * Sets value of 'total_tpc_to' property
     *
     * @param integer $value Property value
     *
     * @return null
     */
    public function setTotalTpcTo($value)
    {
        return $this->set(self::TOTAL_TPC_TO, $value);
    }

    /**
     * Returns value of 'total_tpc_to' property
     *
     * @return integer
     */
    public function getTotalTpcTo()
    {
        $value = $this->get(self::TOTAL_TPC_TO);
        return $value === null ? (integer)$value : $value;
    }

    /**
     * Returns true if 'total_tpc_to' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasTotalTpcTo()
    {
        return $this->get(self::TOTAL_TPC_TO) !== null;
    }

    /**
     * Sets value of 'need_score_water' property
     *
     * @param integer $value Property value
     *
     * @return null
     */
    public function setNeedScoreWater($value)
    {
        return $this->set(self::NEED_SCORE_WATER, $value);
    }

    /**
     * Returns value of 'need_score_water' property
     *
     * @return integer
     */
    public function getNeedScoreWater()
    {
        $value = $this->get(self::NEED_SCORE_WATER);
        return $value === null ? (integer)$value : $value;
    }

    /**
     * Returns true if 'need_score_water' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasNeedScoreWater()
    {
        return $this->get(self::NEED_SCORE_WATER) !== null;
    }

    /**
     * Sets value of 'now_score_water' property
     *
     * @param integer $value Property value
     *
     * @return null
     */
    public function setNowScoreWater($value)
    {
        return $this->set(self::NOW_SCORE_WATER, $value);
    }

    /**
     * Returns value of 'now_score_water' property
     *
     * @return integer
     */
    public function getNowScoreWater()
    {
        $value = $this->get(self::NOW_SCORE_WATER);
        return $value === null ? (integer)$value : $value;
    }

    /**
     * Returns true if 'now_score_water' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasNowScoreWater()
    {
        return $this->get(self::NOW_SCORE_WATER) !== null;
    }

    /**
     * Sets value of 'total_game_num' property
     *
     * @param integer $value Property value
     *
     * @return null
     */
    public function setTotalGameNum($value)
    {
        return $this->set(self::TOTAL_GAME_NUM, $value);
    }

    /**
     * Returns value of 'total_game_num' property
     *
     * @return integer
     */
    public function getTotalGameNum()
    {
        $value = $this->get(self::TOTAL_GAME_NUM);
        return $value === null ? (integer)$value : $value;
    }

    /**
     * Returns true if 'total_game_num' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasTotalGameNum()
    {
        return $this->get(self::TOTAL_GAME_NUM) !== null;
    }

    /**
     * Sets value of 'total_water_score' property
     *
     * @param integer $value Property value
     *
     * @return null
     */
    public function setTotalWaterScore($value)
    {
        return $this->set(self::TOTAL_WATER_SCORE, $value);
    }

    /**
     * Returns value of 'total_water_score' property
     *
     * @return integer
     */
    public function getTotalWaterScore()
    {
        $value = $this->get(self::TOTAL_WATER_SCORE);
        return $value === null ? (integer)$value : $value;
    }

    /**
     * Returns true if 'total_water_score' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasTotalWaterScore()
    {
        return $this->get(self::TOTAL_WATER_SCORE) !== null;
    }

    /**
     * Sets value of 'total_outside_game_num' property
     *
     * @param integer $value Property value
     *
     * @return null
     */
    public function setTotalOutsideGameNum($value)
    {
        return $this->set(self::TOTAL_OUTSIDE_GAME_NUM, $value);
    }

    /**
     * Returns value of 'total_outside_game_num' property
     *
     * @return integer
     */
    public function getTotalOutsideGameNum()
    {
        $value = $this->get(self::TOTAL_OUTSIDE_GAME_NUM);
        return $value === null ? (integer)$value : $value;
    }

    /**
     * Returns true if 'total_outside_game_num' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasTotalOutsideGameNum()
    {
        return $this->get(self::TOTAL_OUTSIDE_GAME_NUM) !== null;
    }

    /**
     * Sets value of 'total_outside_water_score' property
     *
     * @param integer $value Property value
     *
     * @return null
     */
    public function setTotalOutsideWaterScore($value)
    {
        return $this->set(self::TOTAL_OUTSIDE_WATER_SCORE, $value);
    }

    /**
     * Returns value of 'total_outside_water_score' property
     *
     * @return integer
     */
    public function getTotalOutsideWaterScore()
    {
        $value = $this->get(self::TOTAL_OUTSIDE_WATER_SCORE);
        return $value === null ? (integer)$value : $value;
    }

    /**
     * Returns true if 'total_outside_water_score' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasTotalOutsideWaterScore()
    {
        return $this->get(self::TOTAL_OUTSIDE_WATER_SCORE) !== null;
    }

    /**
     * Sets value of 'total_pay' property
     *
     * @param integer $value Property value
     *
     * @return null
     */
    public function setTotalPay($value)
    {
        return $this->set(self::TOTAL_PAY, $value);
    }

    /**
     * Returns value of 'total_pay' property
     *
     * @return integer
     */
    public function getTotalPay()
    {
        $value = $this->get(self::TOTAL_PAY);
        return $value === null ? (integer)$value : $value;
    }

    /**
     * Returns true if 'total_pay' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasTotalPay()
    {
        return $this->get(self::TOTAL_PAY) !== null;
    }

    /**
     * Sets value of 'total_give' property
     *
     * @param integer $value Property value
     *
     * @return null
     */
    public function setTotalGive($value)
    {
        return $this->set(self::TOTAL_GIVE, $value);
    }

    /**
     * Returns value of 'total_give' property
     *
     * @return integer
     */
    public function getTotalGive()
    {
        $value = $this->get(self::TOTAL_GIVE);
        return $value === null ? (integer)$value : $value;
    }

    /**
     * Returns true if 'total_give' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasTotalGive()
    {
        return $this->get(self::TOTAL_GIVE) !== null;
    }

    /**
     * Sets value of 'total_service_score' property
     *
     * @param integer $value Property value
     *
     * @return null
     */
    public function setTotalServiceScore($value)
    {
        return $this->set(self::TOTAL_SERVICE_SCORE, $value);
    }

    /**
     * Returns value of 'total_service_score' property
     *
     * @return integer
     */
    public function getTotalServiceScore()
    {
        $value = $this->get(self::TOTAL_SERVICE_SCORE);
        return $value === null ? (integer)$value : $value;
    }

    /**
     * Returns true if 'total_service_score' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasTotalServiceScore()
    {
        return $this->get(self::TOTAL_SERVICE_SCORE) !== null;
    }

    /**
     * Sets value of 'bind_uid' property
     *
     * @param integer $value Property value
     *
     * @return null
     */
    public function setBindUid($value)
    {
        return $this->set(self::BIND_UID, $value);
    }

    /**
     * Returns value of 'bind_uid' property
     *
     * @return integer
     */
    public function getBindUid()
    {
        $value = $this->get(self::BIND_UID);
        return $value === null ? (integer)$value : $value;
    }

    /**
     * Returns true if 'bind_uid' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasBindUid()
    {
        return $this->get(self::BIND_UID) !== null;
    }

    /**
     * Sets value of 'water_to_coins' property
     *
     * @param integer $value Property value
     *
     * @return null
     */
    public function setWaterToCoins($value)
    {
        return $this->set(self::WATER_TO_COINS, $value);
    }

    /**
     * Returns value of 'water_to_coins' property
     *
     * @return integer
     */
    public function getWaterToCoins()
    {
        $value = $this->get(self::WATER_TO_COINS);
        return $value === null ? (integer)$value : $value;
    }

    /**
     * Returns true if 'water_to_coins' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasWaterToCoins()
    {
        return $this->get(self::WATER_TO_COINS) !== null;
    }

    /**
     * Sets value of 'total_water_to_coins' property
     *
     * @param integer $value Property value
     *
     * @return null
     */
    public function setTotalWaterToCoins($value)
    {
        return $this->set(self::TOTAL_WATER_TO_COINS, $value);
    }

    /**
     * Returns value of 'total_water_to_coins' property
     *
     * @return integer
     */
    public function getTotalWaterToCoins()
    {
        $value = $this->get(self::TOTAL_WATER_TO_COINS);
        return $value === null ? (integer)$value : $value;
    }

    /**
     * Returns true if 'total_water_to_coins' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasTotalWaterToCoins()
    {
        return $this->get(self::TOTAL_WATER_TO_COINS) !== null;
    }

    /**
     * Sets value of 'vip_back' property
     *
     * @param integer $value Property value
     *
     * @return null
     */
    public function setVipBack($value)
    {
        return $this->set(self::VIP_BACK, $value);
    }

    /**
     * Returns value of 'vip_back' property
     *
     * @return integer
     */
    public function getVipBack()
    {
        $value = $this->get(self::VIP_BACK);
        return $value === null ? (integer)$value : $value;
    }

    /**
     * Returns true if 'vip_back' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasVipBack()
    {
        return $this->get(self::VIP_BACK) !== null;
    }

    /**
     * Sets value of 'total_vip_back' property
     *
     * @param integer $value Property value
     *
     * @return null
     */
    public function setTotalVipBack($value)
    {
        return $this->set(self::TOTAL_VIP_BACK, $value);
    }

    /**
     * Returns value of 'total_vip_back' property
     *
     * @return integer
     */
    public function getTotalVipBack()
    {
        $value = $this->get(self::TOTAL_VIP_BACK);
        return $value === null ? (integer)$value : $value;
    }

    /**
     * Returns true if 'total_vip_back' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasTotalVipBack()
    {
        return $this->get(self::TOTAL_VIP_BACK) !== null;
    }

    /**
     * Sets value of 'init' property
     *
     * @param integer $value Property value
     *
     * @return null
     */
    public function setInit($value)
    {
        return $this->set(self::INIT, $value);
    }

    /**
     * Returns value of 'init' property
     *
     * @return integer
     */
    public function getInit()
    {
        $value = $this->get(self::INIT);
        return $value === null ? (integer)$value : $value;
    }

    /**
     * Returns true if 'init' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasInit()
    {
        return $this->get(self::INIT) !== null;
    }

    /**
     * Sets value of 'total_task_score' property
     *
     * @param integer $value Property value
     *
     * @return null
     */
    public function setTotalTaskScore($value)
    {
        return $this->set(self::TOTAL_TASK_SCORE, $value);
    }

    /**
     * Returns value of 'total_task_score' property
     *
     * @return integer
     */
    public function getTotalTaskScore()
    {
        $value = $this->get(self::TOTAL_TASK_SCORE);
        return $value === null ? (integer)$value : $value;
    }

    /**
     * Returns true if 'total_task_score' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasTotalTaskScore()
    {
        return $this->get(self::TOTAL_TASK_SCORE) !== null;
    }

    /**
     * Sets value of 'total_score' property
     *
     * @param integer $value Property value
     *
     * @return null
     */
    public function setTotalScore($value)
    {
        return $this->set(self::TOTAL_SCORE, $value);
    }

    /**
     * Returns value of 'total_score' property
     *
     * @return integer
     */
    public function getTotalScore()
    {
        $value = $this->get(self::TOTAL_SCORE);
        return $value === null ? (integer)$value : $value;
    }

    /**
     * Returns true if 'total_score' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasTotalScore()
    {
        return $this->get(self::TOTAL_SCORE) !== null;
    }

    /**
     * Sets value of 'total_outside_score' property
     *
     * @param integer $value Property value
     *
     * @return null
     */
    public function setTotalOutsideScore($value)
    {
        return $this->set(self::TOTAL_OUTSIDE_SCORE, $value);
    }

    /**
     * Returns value of 'total_outside_score' property
     *
     * @return integer
     */
    public function getTotalOutsideScore()
    {
        $value = $this->get(self::TOTAL_OUTSIDE_SCORE);
        return $value === null ? (integer)$value : $value;
    }

    /**
     * Returns true if 'total_outside_score' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasTotalOutsideScore()
    {
        return $this->get(self::TOTAL_OUTSIDE_SCORE) !== null;
    }

    /**
     * Sets value of 'package_id' property
     *
     * @param integer $value Property value
     *
     * @return null
     */
    public function setPackageId($value)
    {
        return $this->set(self::PACKAGE_ID, $value);
    }

    /**
     * Returns value of 'package_id' property
     *
     * @return integer
     */
    public function getPackageId()
    {
        $value = $this->get(self::PACKAGE_ID);
        return $value === null ? (integer)$value : $value;
    }

    /**
     * Returns true if 'package_id' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasPackageId()
    {
        return $this->get(self::PACKAGE_ID) !== null;
    }

    /**
     * Sets value of 'clean_water_time' property
     *
     * @param integer $value Property value
     *
     * @return null
     */
    public function setCleanWaterTime($value)
    {
        return $this->set(self::CLEAN_WATER_TIME, $value);
    }

    /**
     * Returns value of 'clean_water_time' property
     *
     * @return integer
     */
    public function getCleanWaterTime()
    {
        $value = $this->get(self::CLEAN_WATER_TIME);
        return $value === null ? (integer)$value : $value;
    }

    /**
     * Returns true if 'clean_water_time' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasCleanWaterTime()
    {
        return $this->get(self::CLEAN_WATER_TIME) !== null;
    }

    /**
     * Sets value of 'pay_time' property
     *
     * @param integer $value Property value
     *
     * @return null
     */
    public function setPayTime($value)
    {
        return $this->set(self::PAY_TIME, $value);
    }

    /**
     * Returns value of 'pay_time' property
     *
     * @return integer
     */
    public function getPayTime()
    {
        $value = $this->get(self::PAY_TIME);
        return $value === null ? (integer)$value : $value;
    }

    /**
     * Returns true if 'pay_time' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasPayTime()
    {
        return $this->get(self::PAY_TIME) !== null;
    }

    /**
     * Sets value of 'exchange_score' property
     *
     * @param integer $value Property value
     *
     * @return null
     */
    public function setExchangeScore($value)
    {
        return $this->set(self::EXCHANGE_SCORE, $value);
    }

    /**
     * Returns value of 'exchange_score' property
     *
     * @return integer
     */
    public function getExchangeScore()
    {
        $value = $this->get(self::EXCHANGE_SCORE);
        return $value === null ? (integer)$value : $value;
    }

    /**
     * Returns true if 'exchange_score' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasExchangeScore()
    {
        return $this->get(self::EXCHANGE_SCORE) !== null;
    }
}
}