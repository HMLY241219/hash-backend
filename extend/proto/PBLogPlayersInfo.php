<?php
/**
 * Auto generated from poker_msg_log.proto at 2023-06-08 09:49:25
 */

namespace {
/**
 * PBLogPlayersInfo message
 */
class PBLogPlayersInfo extends \ProtobufMessage
{
    /* Field index constants */
    const UID = 1;
    const SEAT_INDEX = 2;
    const IS_ANDROID = 3;
    const FINAL_SCORE = 4;
    const BET_SCORE = 5;
    const SERVICE_SCORE = 6;
    const VIP = 7;
    const CONTROL_WIN_OR_LOSER = 13;
    const STOCK_SUB = 16;
    const CHANNEL = 17;
    const LOGIN_INDEX = 18;
    const COIN_CHANGE = 19;
    const TOTAL_SCORE = 20;
    const IS_ZHUANG = 21;
    const ADD_BET_0 = 22;
    const ADD_BET_1 = 23;
    const ADD_BET_2 = 24;
    const ADD_BET_3 = 25;
    const ADD_BET_4 = 26;
    const ADD_BET_5 = 27;
    const ADD_BET_6 = 28;
    const ADD_BET_7 = 29;
    const ADD_BET_8 = 30;
    const ADD_BET_9 = 31;
    const ADD_BET_10 = 32;
    const ADD_BET_11 = 33;
    const ADD_BET_12 = 34;
    const ADD_BET_13 = 35;
    const ADD_BET_14 = 36;
    const ADD_BET_15 = 37;
    const VALUE_1 = 38;
    const VALUE_2 = 39;
    const VALUE_3 = 40;
    const VALUE_4 = 41;
    const VALUE_5 = 42;
    const CARDS_0 = 43;
    const CARDS_1 = 44;
    const CARDS_2 = 45;
    const CARD_TYPE = 46;
    const PACKAGE_ID = 47;
    const BIND_UID = 48;

    /* @var array Field descriptors */
    protected static $fields = array(
        self::UID => array(
            'name' => 'uid',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_INT,
        ),
        self::SEAT_INDEX => array(
            'name' => 'seat_index',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_INT,
        ),
        self::IS_ANDROID => array(
            'name' => 'is_android',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_BOOL,
        ),
        self::FINAL_SCORE => array(
            'name' => 'final_score',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_INT,
        ),
        self::BET_SCORE => array(
            'name' => 'bet_score',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_INT,
        ),
        self::SERVICE_SCORE => array(
            'name' => 'service_score',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_INT,
        ),
        self::VIP => array(
            'name' => 'vip',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_INT,
        ),
        self::CONTROL_WIN_OR_LOSER => array(
            'name' => 'control_win_or_loser',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_INT,
        ),
        self::STOCK_SUB => array(
            'name' => 'stock_sub',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_INT,
        ),
        self::CHANNEL => array(
            'name' => 'channel',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_INT,
        ),
        self::LOGIN_INDEX => array(
            'name' => 'login_index',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_INT,
        ),
        self::COIN_CHANGE => array(
            'name' => 'coin_change',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_INT,
        ),
        self::TOTAL_SCORE => array(
            'name' => 'total_score',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_INT,
        ),
        self::IS_ZHUANG => array(
            'name' => 'is_zhuang',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_BOOL,
        ),
        self::ADD_BET_0 => array(
            'name' => 'add_bet_0',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_INT,
        ),
        self::ADD_BET_1 => array(
            'name' => 'add_bet_1',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_INT,
        ),
        self::ADD_BET_2 => array(
            'name' => 'add_bet_2',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_INT,
        ),
        self::ADD_BET_3 => array(
            'name' => 'add_bet_3',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_INT,
        ),
        self::ADD_BET_4 => array(
            'name' => 'add_bet_4',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_INT,
        ),
        self::ADD_BET_5 => array(
            'name' => 'add_bet_5',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_INT,
        ),
        self::ADD_BET_6 => array(
            'name' => 'add_bet_6',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_INT,
        ),
        self::ADD_BET_7 => array(
            'name' => 'add_bet_7',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_INT,
        ),
        self::ADD_BET_8 => array(
            'name' => 'add_bet_8',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_INT,
        ),
        self::ADD_BET_9 => array(
            'name' => 'add_bet_9',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_INT,
        ),
        self::ADD_BET_10 => array(
            'name' => 'add_bet_10',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_INT,
        ),
        self::ADD_BET_11 => array(
            'name' => 'add_bet_11',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_INT,
        ),
        self::ADD_BET_12 => array(
            'name' => 'add_bet_12',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_INT,
        ),
        self::ADD_BET_13 => array(
            'name' => 'add_bet_13',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_INT,
        ),
        self::ADD_BET_14 => array(
            'name' => 'add_bet_14',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_INT,
        ),
        self::ADD_BET_15 => array(
            'name' => 'add_bet_15',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_INT,
        ),
        self::VALUE_1 => array(
            'name' => 'value_1',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_INT,
        ),
        self::VALUE_2 => array(
            'name' => 'value_2',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_INT,
        ),
        self::VALUE_3 => array(
            'name' => 'value_3',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_INT,
        ),
        self::VALUE_4 => array(
            'name' => 'value_4',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_INT,
        ),
        self::VALUE_5 => array(
            'name' => 'value_5',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_INT,
        ),
        self::CARDS_0 => array(
            'name' => 'cards_0',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_INT,
        ),
        self::CARDS_1 => array(
            'name' => 'cards_1',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_INT,
        ),
        self::CARDS_2 => array(
            'name' => 'cards_2',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_INT,
        ),
        self::CARD_TYPE => array(
            'name' => 'card_type',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_INT,
        ),
        self::PACKAGE_ID => array(
            'name' => 'package_id',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_INT,
        ),
        self::BIND_UID => array(
            'name' => 'bind_uid',
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
        $this->values[self::SEAT_INDEX] = null;
        $this->values[self::IS_ANDROID] = null;
        $this->values[self::FINAL_SCORE] = null;
        $this->values[self::BET_SCORE] = null;
        $this->values[self::SERVICE_SCORE] = null;
        $this->values[self::VIP] = null;
        $this->values[self::CONTROL_WIN_OR_LOSER] = null;
        $this->values[self::STOCK_SUB] = null;
        $this->values[self::CHANNEL] = null;
        $this->values[self::LOGIN_INDEX] = null;
        $this->values[self::COIN_CHANGE] = null;
        $this->values[self::TOTAL_SCORE] = null;
        $this->values[self::IS_ZHUANG] = null;
        $this->values[self::ADD_BET_0] = null;
        $this->values[self::ADD_BET_1] = null;
        $this->values[self::ADD_BET_2] = null;
        $this->values[self::ADD_BET_3] = null;
        $this->values[self::ADD_BET_4] = null;
        $this->values[self::ADD_BET_5] = null;
        $this->values[self::ADD_BET_6] = null;
        $this->values[self::ADD_BET_7] = null;
        $this->values[self::ADD_BET_8] = null;
        $this->values[self::ADD_BET_9] = null;
        $this->values[self::ADD_BET_10] = null;
        $this->values[self::ADD_BET_11] = null;
        $this->values[self::ADD_BET_12] = null;
        $this->values[self::ADD_BET_13] = null;
        $this->values[self::ADD_BET_14] = null;
        $this->values[self::ADD_BET_15] = null;
        $this->values[self::VALUE_1] = null;
        $this->values[self::VALUE_2] = null;
        $this->values[self::VALUE_3] = null;
        $this->values[self::VALUE_4] = null;
        $this->values[self::VALUE_5] = null;
        $this->values[self::CARDS_0] = null;
        $this->values[self::CARDS_1] = null;
        $this->values[self::CARDS_2] = null;
        $this->values[self::CARD_TYPE] = null;
        $this->values[self::PACKAGE_ID] = null;
        $this->values[self::BIND_UID] = null;
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
     * Sets value of 'seat_index' property
     *
     * @param integer $value Property value
     *
     * @return null
     */
    public function setSeatIndex($value)
    {
        return $this->set(self::SEAT_INDEX, $value);
    }

    /**
     * Returns value of 'seat_index' property
     *
     * @return integer
     */
    public function getSeatIndex()
    {
        $value = $this->get(self::SEAT_INDEX);
        return $value === null ? (integer)$value : $value;
    }

    /**
     * Returns true if 'seat_index' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasSeatIndex()
    {
        return $this->get(self::SEAT_INDEX) !== null;
    }

    /**
     * Sets value of 'is_android' property
     *
     * @param boolean $value Property value
     *
     * @return null
     */
    public function setIsAndroid($value)
    {
        return $this->set(self::IS_ANDROID, $value);
    }

    /**
     * Returns value of 'is_android' property
     *
     * @return boolean
     */
    public function getIsAndroid()
    {
        $value = $this->get(self::IS_ANDROID);
        return $value === null ? (boolean)$value : $value;
    }

    /**
     * Returns true if 'is_android' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasIsAndroid()
    {
        return $this->get(self::IS_ANDROID) !== null;
    }

    /**
     * Sets value of 'final_score' property
     *
     * @param integer $value Property value
     *
     * @return null
     */
    public function setFinalScore($value)
    {
        return $this->set(self::FINAL_SCORE, $value);
    }

    /**
     * Returns value of 'final_score' property
     *
     * @return integer
     */
    public function getFinalScore()
    {
        $value = $this->get(self::FINAL_SCORE);
        return $value === null ? (integer)$value : $value;
    }

    /**
     * Returns true if 'final_score' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasFinalScore()
    {
        return $this->get(self::FINAL_SCORE) !== null;
    }

    /**
     * Sets value of 'bet_score' property
     *
     * @param integer $value Property value
     *
     * @return null
     */
    public function setBetScore($value)
    {
        return $this->set(self::BET_SCORE, $value);
    }

    /**
     * Returns value of 'bet_score' property
     *
     * @return integer
     */
    public function getBetScore()
    {
        $value = $this->get(self::BET_SCORE);
        return $value === null ? (integer)$value : $value;
    }

    /**
     * Returns true if 'bet_score' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasBetScore()
    {
        return $this->get(self::BET_SCORE) !== null;
    }

    /**
     * Sets value of 'service_score' property
     *
     * @param integer $value Property value
     *
     * @return null
     */
    public function setServiceScore($value)
    {
        return $this->set(self::SERVICE_SCORE, $value);
    }

    /**
     * Returns value of 'service_score' property
     *
     * @return integer
     */
    public function getServiceScore()
    {
        $value = $this->get(self::SERVICE_SCORE);
        return $value === null ? (integer)$value : $value;
    }

    /**
     * Returns true if 'service_score' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasServiceScore()
    {
        return $this->get(self::SERVICE_SCORE) !== null;
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
     * Sets value of 'control_win_or_loser' property
     *
     * @param integer $value Property value
     *
     * @return null
     */
    public function setControlWinOrLoser($value)
    {
        return $this->set(self::CONTROL_WIN_OR_LOSER, $value);
    }

    /**
     * Returns value of 'control_win_or_loser' property
     *
     * @return integer
     */
    public function getControlWinOrLoser()
    {
        $value = $this->get(self::CONTROL_WIN_OR_LOSER);
        return $value === null ? (integer)$value : $value;
    }

    /**
     * Returns true if 'control_win_or_loser' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasControlWinOrLoser()
    {
        return $this->get(self::CONTROL_WIN_OR_LOSER) !== null;
    }

    /**
     * Sets value of 'stock_sub' property
     *
     * @param integer $value Property value
     *
     * @return null
     */
    public function setStockSub($value)
    {
        return $this->set(self::STOCK_SUB, $value);
    }

    /**
     * Returns value of 'stock_sub' property
     *
     * @return integer
     */
    public function getStockSub()
    {
        $value = $this->get(self::STOCK_SUB);
        return $value === null ? (integer)$value : $value;
    }

    /**
     * Returns true if 'stock_sub' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasStockSub()
    {
        return $this->get(self::STOCK_SUB) !== null;
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
     * Sets value of 'login_index' property
     *
     * @param integer $value Property value
     *
     * @return null
     */
    public function setLoginIndex($value)
    {
        return $this->set(self::LOGIN_INDEX, $value);
    }

    /**
     * Returns value of 'login_index' property
     *
     * @return integer
     */
    public function getLoginIndex()
    {
        $value = $this->get(self::LOGIN_INDEX);
        return $value === null ? (integer)$value : $value;
    }

    /**
     * Returns true if 'login_index' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasLoginIndex()
    {
        return $this->get(self::LOGIN_INDEX) !== null;
    }

    /**
     * Sets value of 'coin_change' property
     *
     * @param integer $value Property value
     *
     * @return null
     */
    public function setCoinChange($value)
    {
        return $this->set(self::COIN_CHANGE, $value);
    }

    /**
     * Returns value of 'coin_change' property
     *
     * @return integer
     */
    public function getCoinChange()
    {
        $value = $this->get(self::COIN_CHANGE);
        return $value === null ? (integer)$value : $value;
    }

    /**
     * Returns true if 'coin_change' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasCoinChange()
    {
        return $this->get(self::COIN_CHANGE) !== null;
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
     * Sets value of 'is_zhuang' property
     *
     * @param boolean $value Property value
     *
     * @return null
     */
    public function setIsZhuang($value)
    {
        return $this->set(self::IS_ZHUANG, $value);
    }

    /**
     * Returns value of 'is_zhuang' property
     *
     * @return boolean
     */
    public function getIsZhuang()
    {
        $value = $this->get(self::IS_ZHUANG);
        return $value === null ? (boolean)$value : $value;
    }

    /**
     * Returns true if 'is_zhuang' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasIsZhuang()
    {
        return $this->get(self::IS_ZHUANG) !== null;
    }

    /**
     * Sets value of 'add_bet_0' property
     *
     * @param integer $value Property value
     *
     * @return null
     */
    public function setAddBet0($value)
    {
        return $this->set(self::ADD_BET_0, $value);
    }

    /**
     * Returns value of 'add_bet_0' property
     *
     * @return integer
     */
    public function getAddBet0()
    {
        $value = $this->get(self::ADD_BET_0);
        return $value === null ? (integer)$value : $value;
    }

    /**
     * Returns true if 'add_bet_0' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasAddBet0()
    {
        return $this->get(self::ADD_BET_0) !== null;
    }

    /**
     * Sets value of 'add_bet_1' property
     *
     * @param integer $value Property value
     *
     * @return null
     */
    public function setAddBet1($value)
    {
        return $this->set(self::ADD_BET_1, $value);
    }

    /**
     * Returns value of 'add_bet_1' property
     *
     * @return integer
     */
    public function getAddBet1()
    {
        $value = $this->get(self::ADD_BET_1);
        return $value === null ? (integer)$value : $value;
    }

    /**
     * Returns true if 'add_bet_1' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasAddBet1()
    {
        return $this->get(self::ADD_BET_1) !== null;
    }

    /**
     * Sets value of 'add_bet_2' property
     *
     * @param integer $value Property value
     *
     * @return null
     */
    public function setAddBet2($value)
    {
        return $this->set(self::ADD_BET_2, $value);
    }

    /**
     * Returns value of 'add_bet_2' property
     *
     * @return integer
     */
    public function getAddBet2()
    {
        $value = $this->get(self::ADD_BET_2);
        return $value === null ? (integer)$value : $value;
    }

    /**
     * Returns true if 'add_bet_2' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasAddBet2()
    {
        return $this->get(self::ADD_BET_2) !== null;
    }

    /**
     * Sets value of 'add_bet_3' property
     *
     * @param integer $value Property value
     *
     * @return null
     */
    public function setAddBet3($value)
    {
        return $this->set(self::ADD_BET_3, $value);
    }

    /**
     * Returns value of 'add_bet_3' property
     *
     * @return integer
     */
    public function getAddBet3()
    {
        $value = $this->get(self::ADD_BET_3);
        return $value === null ? (integer)$value : $value;
    }

    /**
     * Returns true if 'add_bet_3' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasAddBet3()
    {
        return $this->get(self::ADD_BET_3) !== null;
    }

    /**
     * Sets value of 'add_bet_4' property
     *
     * @param integer $value Property value
     *
     * @return null
     */
    public function setAddBet4($value)
    {
        return $this->set(self::ADD_BET_4, $value);
    }

    /**
     * Returns value of 'add_bet_4' property
     *
     * @return integer
     */
    public function getAddBet4()
    {
        $value = $this->get(self::ADD_BET_4);
        return $value === null ? (integer)$value : $value;
    }

    /**
     * Returns true if 'add_bet_4' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasAddBet4()
    {
        return $this->get(self::ADD_BET_4) !== null;
    }

    /**
     * Sets value of 'add_bet_5' property
     *
     * @param integer $value Property value
     *
     * @return null
     */
    public function setAddBet5($value)
    {
        return $this->set(self::ADD_BET_5, $value);
    }

    /**
     * Returns value of 'add_bet_5' property
     *
     * @return integer
     */
    public function getAddBet5()
    {
        $value = $this->get(self::ADD_BET_5);
        return $value === null ? (integer)$value : $value;
    }

    /**
     * Returns true if 'add_bet_5' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasAddBet5()
    {
        return $this->get(self::ADD_BET_5) !== null;
    }

    /**
     * Sets value of 'add_bet_6' property
     *
     * @param integer $value Property value
     *
     * @return null
     */
    public function setAddBet6($value)
    {
        return $this->set(self::ADD_BET_6, $value);
    }

    /**
     * Returns value of 'add_bet_6' property
     *
     * @return integer
     */
    public function getAddBet6()
    {
        $value = $this->get(self::ADD_BET_6);
        return $value === null ? (integer)$value : $value;
    }

    /**
     * Returns true if 'add_bet_6' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasAddBet6()
    {
        return $this->get(self::ADD_BET_6) !== null;
    }

    /**
     * Sets value of 'add_bet_7' property
     *
     * @param integer $value Property value
     *
     * @return null
     */
    public function setAddBet7($value)
    {
        return $this->set(self::ADD_BET_7, $value);
    }

    /**
     * Returns value of 'add_bet_7' property
     *
     * @return integer
     */
    public function getAddBet7()
    {
        $value = $this->get(self::ADD_BET_7);
        return $value === null ? (integer)$value : $value;
    }

    /**
     * Returns true if 'add_bet_7' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasAddBet7()
    {
        return $this->get(self::ADD_BET_7) !== null;
    }

    /**
     * Sets value of 'add_bet_8' property
     *
     * @param integer $value Property value
     *
     * @return null
     */
    public function setAddBet8($value)
    {
        return $this->set(self::ADD_BET_8, $value);
    }

    /**
     * Returns value of 'add_bet_8' property
     *
     * @return integer
     */
    public function getAddBet8()
    {
        $value = $this->get(self::ADD_BET_8);
        return $value === null ? (integer)$value : $value;
    }

    /**
     * Returns true if 'add_bet_8' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasAddBet8()
    {
        return $this->get(self::ADD_BET_8) !== null;
    }

    /**
     * Sets value of 'add_bet_9' property
     *
     * @param integer $value Property value
     *
     * @return null
     */
    public function setAddBet9($value)
    {
        return $this->set(self::ADD_BET_9, $value);
    }

    /**
     * Returns value of 'add_bet_9' property
     *
     * @return integer
     */
    public function getAddBet9()
    {
        $value = $this->get(self::ADD_BET_9);
        return $value === null ? (integer)$value : $value;
    }

    /**
     * Returns true if 'add_bet_9' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasAddBet9()
    {
        return $this->get(self::ADD_BET_9) !== null;
    }

    /**
     * Sets value of 'add_bet_10' property
     *
     * @param integer $value Property value
     *
     * @return null
     */
    public function setAddBet10($value)
    {
        return $this->set(self::ADD_BET_10, $value);
    }

    /**
     * Returns value of 'add_bet_10' property
     *
     * @return integer
     */
    public function getAddBet10()
    {
        $value = $this->get(self::ADD_BET_10);
        return $value === null ? (integer)$value : $value;
    }

    /**
     * Returns true if 'add_bet_10' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasAddBet10()
    {
        return $this->get(self::ADD_BET_10) !== null;
    }

    /**
     * Sets value of 'add_bet_11' property
     *
     * @param integer $value Property value
     *
     * @return null
     */
    public function setAddBet11($value)
    {
        return $this->set(self::ADD_BET_11, $value);
    }

    /**
     * Returns value of 'add_bet_11' property
     *
     * @return integer
     */
    public function getAddBet11()
    {
        $value = $this->get(self::ADD_BET_11);
        return $value === null ? (integer)$value : $value;
    }

    /**
     * Returns true if 'add_bet_11' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasAddBet11()
    {
        return $this->get(self::ADD_BET_11) !== null;
    }

    /**
     * Sets value of 'add_bet_12' property
     *
     * @param integer $value Property value
     *
     * @return null
     */
    public function setAddBet12($value)
    {
        return $this->set(self::ADD_BET_12, $value);
    }

    /**
     * Returns value of 'add_bet_12' property
     *
     * @return integer
     */
    public function getAddBet12()
    {
        $value = $this->get(self::ADD_BET_12);
        return $value === null ? (integer)$value : $value;
    }

    /**
     * Returns true if 'add_bet_12' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasAddBet12()
    {
        return $this->get(self::ADD_BET_12) !== null;
    }

    /**
     * Sets value of 'add_bet_13' property
     *
     * @param integer $value Property value
     *
     * @return null
     */
    public function setAddBet13($value)
    {
        return $this->set(self::ADD_BET_13, $value);
    }

    /**
     * Returns value of 'add_bet_13' property
     *
     * @return integer
     */
    public function getAddBet13()
    {
        $value = $this->get(self::ADD_BET_13);
        return $value === null ? (integer)$value : $value;
    }

    /**
     * Returns true if 'add_bet_13' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasAddBet13()
    {
        return $this->get(self::ADD_BET_13) !== null;
    }

    /**
     * Sets value of 'add_bet_14' property
     *
     * @param integer $value Property value
     *
     * @return null
     */
    public function setAddBet14($value)
    {
        return $this->set(self::ADD_BET_14, $value);
    }

    /**
     * Returns value of 'add_bet_14' property
     *
     * @return integer
     */
    public function getAddBet14()
    {
        $value = $this->get(self::ADD_BET_14);
        return $value === null ? (integer)$value : $value;
    }

    /**
     * Returns true if 'add_bet_14' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasAddBet14()
    {
        return $this->get(self::ADD_BET_14) !== null;
    }

    /**
     * Sets value of 'add_bet_15' property
     *
     * @param integer $value Property value
     *
     * @return null
     */
    public function setAddBet15($value)
    {
        return $this->set(self::ADD_BET_15, $value);
    }

    /**
     * Returns value of 'add_bet_15' property
     *
     * @return integer
     */
    public function getAddBet15()
    {
        $value = $this->get(self::ADD_BET_15);
        return $value === null ? (integer)$value : $value;
    }

    /**
     * Returns true if 'add_bet_15' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasAddBet15()
    {
        return $this->get(self::ADD_BET_15) !== null;
    }

    /**
     * Sets value of 'value_1' property
     *
     * @param integer $value Property value
     *
     * @return null
     */
    public function setValue1($value)
    {
        return $this->set(self::VALUE_1, $value);
    }

    /**
     * Returns value of 'value_1' property
     *
     * @return integer
     */
    public function getValue1()
    {
        $value = $this->get(self::VALUE_1);
        return $value === null ? (integer)$value : $value;
    }

    /**
     * Returns true if 'value_1' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasValue1()
    {
        return $this->get(self::VALUE_1) !== null;
    }

    /**
     * Sets value of 'value_2' property
     *
     * @param integer $value Property value
     *
     * @return null
     */
    public function setValue2($value)
    {
        return $this->set(self::VALUE_2, $value);
    }

    /**
     * Returns value of 'value_2' property
     *
     * @return integer
     */
    public function getValue2()
    {
        $value = $this->get(self::VALUE_2);
        return $value === null ? (integer)$value : $value;
    }

    /**
     * Returns true if 'value_2' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasValue2()
    {
        return $this->get(self::VALUE_2) !== null;
    }

    /**
     * Sets value of 'value_3' property
     *
     * @param integer $value Property value
     *
     * @return null
     */
    public function setValue3($value)
    {
        return $this->set(self::VALUE_3, $value);
    }

    /**
     * Returns value of 'value_3' property
     *
     * @return integer
     */
    public function getValue3()
    {
        $value = $this->get(self::VALUE_3);
        return $value === null ? (integer)$value : $value;
    }

    /**
     * Returns true if 'value_3' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasValue3()
    {
        return $this->get(self::VALUE_3) !== null;
    }

    /**
     * Sets value of 'value_4' property
     *
     * @param integer $value Property value
     *
     * @return null
     */
    public function setValue4($value)
    {
        return $this->set(self::VALUE_4, $value);
    }

    /**
     * Returns value of 'value_4' property
     *
     * @return integer
     */
    public function getValue4()
    {
        $value = $this->get(self::VALUE_4);
        return $value === null ? (integer)$value : $value;
    }

    /**
     * Returns true if 'value_4' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasValue4()
    {
        return $this->get(self::VALUE_4) !== null;
    }

    /**
     * Sets value of 'value_5' property
     *
     * @param integer $value Property value
     *
     * @return null
     */
    public function setValue5($value)
    {
        return $this->set(self::VALUE_5, $value);
    }

    /**
     * Returns value of 'value_5' property
     *
     * @return integer
     */
    public function getValue5()
    {
        $value = $this->get(self::VALUE_5);
        return $value === null ? (integer)$value : $value;
    }

    /**
     * Returns true if 'value_5' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasValue5()
    {
        return $this->get(self::VALUE_5) !== null;
    }

    /**
     * Sets value of 'cards_0' property
     *
     * @param integer $value Property value
     *
     * @return null
     */
    public function setCards0($value)
    {
        return $this->set(self::CARDS_0, $value);
    }

    /**
     * Returns value of 'cards_0' property
     *
     * @return integer
     */
    public function getCards0()
    {
        $value = $this->get(self::CARDS_0);
        return $value === null ? (integer)$value : $value;
    }

    /**
     * Returns true if 'cards_0' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasCards0()
    {
        return $this->get(self::CARDS_0) !== null;
    }

    /**
     * Sets value of 'cards_1' property
     *
     * @param integer $value Property value
     *
     * @return null
     */
    public function setCards1($value)
    {
        return $this->set(self::CARDS_1, $value);
    }

    /**
     * Returns value of 'cards_1' property
     *
     * @return integer
     */
    public function getCards1()
    {
        $value = $this->get(self::CARDS_1);
        return $value === null ? (integer)$value : $value;
    }

    /**
     * Returns true if 'cards_1' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasCards1()
    {
        return $this->get(self::CARDS_1) !== null;
    }

    /**
     * Sets value of 'cards_2' property
     *
     * @param integer $value Property value
     *
     * @return null
     */
    public function setCards2($value)
    {
        return $this->set(self::CARDS_2, $value);
    }

    /**
     * Returns value of 'cards_2' property
     *
     * @return integer
     */
    public function getCards2()
    {
        $value = $this->get(self::CARDS_2);
        return $value === null ? (integer)$value : $value;
    }

    /**
     * Returns true if 'cards_2' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasCards2()
    {
        return $this->get(self::CARDS_2) !== null;
    }

    /**
     * Sets value of 'card_type' property
     *
     * @param integer $value Property value
     *
     * @return null
     */
    public function setCardType($value)
    {
        return $this->set(self::CARD_TYPE, $value);
    }

    /**
     * Returns value of 'card_type' property
     *
     * @return integer
     */
    public function getCardType()
    {
        $value = $this->get(self::CARD_TYPE);
        return $value === null ? (integer)$value : $value;
    }

    /**
     * Returns true if 'card_type' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasCardType()
    {
        return $this->get(self::CARD_TYPE) !== null;
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
}
}