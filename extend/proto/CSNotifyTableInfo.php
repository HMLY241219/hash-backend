<?php
/**
 * Auto generated from poker_msg_cs.proto at 2023-06-08 09:49:25
 */

namespace {
/**
 * CSNotifyTableInfo message
 */
class CSNotifyTableInfo extends \ProtobufMessage
{
    /* Field index constants */
    const STATE = 1;
    const LEFT_TILE_NUM = 2;
    const DEALER = 3;
    const TID = 4;
    const OWNER = 5;
    const ROUND = 6;
    const LEFT_CARD_NUM = 8;
    const CREATOR_UID = 9;
    const OPERATION_INDEX = 10;
    const DEST_CARD = 11;
    const DSS_SEATS = 12;
    const DSS_CONF = 13;
    const CUR_TIMESTAMP = 14;
    const READY_PERIOD = 15;
    const READY_LIMIT_TIMESTAMP = 16;
    const OPERATE_PERIOD = 17;
    const OPERATE_LIMIT_TIMESTAMP = 18;
    const NOW_MULTIPLE = 19;
    const TABLE_NOW_MULTIPLE = 20;
    const JOKER_CARD = 21;
    const OUT_CARDS = 22;
    const ALL_REWARD = 23;
    const DIAMOND_SCORE = 24;
    const CLUB_SCORE = 25;
    const HEART_SCORE = 26;
    const SPADE_SCORE = 27;
    const LEFT_SCORE = 28;
    const RIGHT_SCORE = 29;
    const HISTORY_INFO = 30;
    const HISTORY_AB = 31;
    const AB_BET_SCORE = 32;
    const SERVER_JACK_POT_SCORE = 33;
    const ACTION = 34;
    const SEED_HASH = 35;
    const ROUND_HASH = 36;
    const DAY_NUM = 37;
    const SCORE_MAX = 38;
    const PAY_MAX = 39;
    const SEED_HASH_TILL_NOW = 40;
    const SEED_BEFORE = 41;

    /* @var array Field descriptors */
    protected static $fields = array(
        self::STATE => array(
            'name' => 'state',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_INT,
        ),
        self::LEFT_TILE_NUM => array(
            'name' => 'left_tile_num',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_INT,
        ),
        self::DEALER => array(
            'name' => 'dealer',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_INT,
        ),
        self::TID => array(
            'name' => 'tid',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_INT,
        ),
        self::OWNER => array(
            'name' => 'owner',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_INT,
        ),
        self::ROUND => array(
            'name' => 'round',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_INT,
        ),
        self::LEFT_CARD_NUM => array(
            'name' => 'left_card_num',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_INT,
        ),
        self::CREATOR_UID => array(
            'name' => 'creator_uid',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_INT,
        ),
        self::OPERATION_INDEX => array(
            'name' => 'operation_index',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_INT,
        ),
        self::DEST_CARD => array(
            'name' => 'dest_card',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_INT,
        ),
        self::DSS_SEATS => array(
            'name' => 'dss_seats',
            'repeated' => true,
            'type' => '\PBDSSTableSeat'
        ),
        self::DSS_CONF => array(
            'name' => 'dss_conf',
            'required' => false,
            'type' => '\PBDSSTableConfig'
        ),
        self::CUR_TIMESTAMP => array(
            'name' => 'cur_timestamp',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_INT,
        ),
        self::READY_PERIOD => array(
            'name' => 'ready_period',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_INT,
        ),
        self::READY_LIMIT_TIMESTAMP => array(
            'name' => 'ready_limit_timestamp',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_INT,
        ),
        self::OPERATE_PERIOD => array(
            'name' => 'operate_period',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_INT,
        ),
        self::OPERATE_LIMIT_TIMESTAMP => array(
            'name' => 'operate_limit_timestamp',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_INT,
        ),
        self::NOW_MULTIPLE => array(
            'name' => 'now_multiple',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_INT,
        ),
        self::TABLE_NOW_MULTIPLE => array(
            'name' => 'table_now_multiple',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_INT,
        ),
        self::JOKER_CARD => array(
            'name' => 'joker_card',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_INT,
        ),
        self::OUT_CARDS => array(
            'name' => 'out_cards',
            'repeated' => true,
            'type' => \ProtobufMessage::PB_TYPE_INT,
        ),
        self::ALL_REWARD => array(
            'name' => 'all_reward',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_INT,
        ),
        self::DIAMOND_SCORE => array(
            'name' => 'diamond_score',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_INT,
        ),
        self::CLUB_SCORE => array(
            'name' => 'club_score',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_INT,
        ),
        self::HEART_SCORE => array(
            'name' => 'heart_score',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_INT,
        ),
        self::SPADE_SCORE => array(
            'name' => 'spade_score',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_INT,
        ),
        self::LEFT_SCORE => array(
            'name' => 'left_score',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_INT,
        ),
        self::RIGHT_SCORE => array(
            'name' => 'right_score',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_INT,
        ),
        self::HISTORY_INFO => array(
            'name' => 'history_info',
            'repeated' => true,
            'type' => \ProtobufMessage::PB_TYPE_INT,
        ),
        self::HISTORY_AB => array(
            'name' => 'history_ab',
            'repeated' => true,
            'type' => '\PBHistoryAB'
        ),
        self::AB_BET_SCORE => array(
            'name' => 'ab_bet_score',
            'repeated' => true,
            'type' => \ProtobufMessage::PB_TYPE_INT,
        ),
        self::SERVER_JACK_POT_SCORE => array(
            'name' => 'server_jack_pot_score',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_INT,
        ),
        self::ACTION => array(
            'name' => 'action',
            'required' => false,
            'type' => '\PBDSSAction'
        ),
        self::SEED_HASH => array(
            'name' => 'seed_hash',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_STRING,
        ),
        self::ROUND_HASH => array(
            'name' => 'round_hash',
            'repeated' => true,
            'type' => \ProtobufMessage::PB_TYPE_STRING,
        ),
        self::DAY_NUM => array(
            'name' => 'day_num',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_STRING,
        ),
        self::SCORE_MAX => array(
            'name' => 'score_max',
            'repeated' => true,
            'type' => \ProtobufMessage::PB_TYPE_INT,
        ),
        self::PAY_MAX => array(
            'name' => 'pay_max',
            'repeated' => true,
            'type' => \ProtobufMessage::PB_TYPE_INT,
        ),
        self::SEED_HASH_TILL_NOW => array(
            'name' => 'seed_hash_till_now',
            'repeated' => true,
            'type' => \ProtobufMessage::PB_TYPE_STRING,
        ),
        self::SEED_BEFORE => array(
            'name' => 'seed_before',
            'repeated' => true,
            'type' => \ProtobufMessage::PB_TYPE_STRING,
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
        $this->values[self::STATE] = null;
        $this->values[self::LEFT_TILE_NUM] = null;
        $this->values[self::DEALER] = null;
        $this->values[self::TID] = null;
        $this->values[self::OWNER] = null;
        $this->values[self::ROUND] = null;
        $this->values[self::LEFT_CARD_NUM] = null;
        $this->values[self::CREATOR_UID] = null;
        $this->values[self::OPERATION_INDEX] = null;
        $this->values[self::DEST_CARD] = null;
        $this->values[self::DSS_SEATS] = array();
        $this->values[self::DSS_CONF] = null;
        $this->values[self::CUR_TIMESTAMP] = null;
        $this->values[self::READY_PERIOD] = null;
        $this->values[self::READY_LIMIT_TIMESTAMP] = null;
        $this->values[self::OPERATE_PERIOD] = null;
        $this->values[self::OPERATE_LIMIT_TIMESTAMP] = null;
        $this->values[self::NOW_MULTIPLE] = null;
        $this->values[self::TABLE_NOW_MULTIPLE] = null;
        $this->values[self::JOKER_CARD] = null;
        $this->values[self::OUT_CARDS] = array();
        $this->values[self::ALL_REWARD] = null;
        $this->values[self::DIAMOND_SCORE] = null;
        $this->values[self::CLUB_SCORE] = null;
        $this->values[self::HEART_SCORE] = null;
        $this->values[self::SPADE_SCORE] = null;
        $this->values[self::LEFT_SCORE] = null;
        $this->values[self::RIGHT_SCORE] = null;
        $this->values[self::HISTORY_INFO] = array();
        $this->values[self::HISTORY_AB] = array();
        $this->values[self::AB_BET_SCORE] = array();
        $this->values[self::SERVER_JACK_POT_SCORE] = null;
        $this->values[self::ACTION] = null;
        $this->values[self::SEED_HASH] = null;
        $this->values[self::ROUND_HASH] = array();
        $this->values[self::DAY_NUM] = null;
        $this->values[self::SCORE_MAX] = array();
        $this->values[self::PAY_MAX] = array();
        $this->values[self::SEED_HASH_TILL_NOW] = array();
        $this->values[self::SEED_BEFORE] = array();
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
     * Sets value of 'state' property
     *
     * @param integer $value Property value
     *
     * @return null
     */
    public function setState($value)
    {
        return $this->set(self::STATE, $value);
    }

    /**
     * Returns value of 'state' property
     *
     * @return integer
     */
    public function getState()
    {
        $value = $this->get(self::STATE);
        return $value === null ? (integer)$value : $value;
    }

    /**
     * Returns true if 'state' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasState()
    {
        return $this->get(self::STATE) !== null;
    }

    /**
     * Sets value of 'left_tile_num' property
     *
     * @param integer $value Property value
     *
     * @return null
     */
    public function setLeftTileNum($value)
    {
        return $this->set(self::LEFT_TILE_NUM, $value);
    }

    /**
     * Returns value of 'left_tile_num' property
     *
     * @return integer
     */
    public function getLeftTileNum()
    {
        $value = $this->get(self::LEFT_TILE_NUM);
        return $value === null ? (integer)$value : $value;
    }

    /**
     * Returns true if 'left_tile_num' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasLeftTileNum()
    {
        return $this->get(self::LEFT_TILE_NUM) !== null;
    }

    /**
     * Sets value of 'dealer' property
     *
     * @param integer $value Property value
     *
     * @return null
     */
    public function setDealer($value)
    {
        return $this->set(self::DEALER, $value);
    }

    /**
     * Returns value of 'dealer' property
     *
     * @return integer
     */
    public function getDealer()
    {
        $value = $this->get(self::DEALER);
        return $value === null ? (integer)$value : $value;
    }

    /**
     * Returns true if 'dealer' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasDealer()
    {
        return $this->get(self::DEALER) !== null;
    }

    /**
     * Sets value of 'tid' property
     *
     * @param integer $value Property value
     *
     * @return null
     */
    public function setTid($value)
    {
        return $this->set(self::TID, $value);
    }

    /**
     * Returns value of 'tid' property
     *
     * @return integer
     */
    public function getTid()
    {
        $value = $this->get(self::TID);
        return $value === null ? (integer)$value : $value;
    }

    /**
     * Returns true if 'tid' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasTid()
    {
        return $this->get(self::TID) !== null;
    }

    /**
     * Sets value of 'owner' property
     *
     * @param integer $value Property value
     *
     * @return null
     */
    public function setOwner($value)
    {
        return $this->set(self::OWNER, $value);
    }

    /**
     * Returns value of 'owner' property
     *
     * @return integer
     */
    public function getOwner()
    {
        $value = $this->get(self::OWNER);
        return $value === null ? (integer)$value : $value;
    }

    /**
     * Returns true if 'owner' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasOwner()
    {
        return $this->get(self::OWNER) !== null;
    }

    /**
     * Sets value of 'round' property
     *
     * @param integer $value Property value
     *
     * @return null
     */
    public function setRound($value)
    {
        return $this->set(self::ROUND, $value);
    }

    /**
     * Returns value of 'round' property
     *
     * @return integer
     */
    public function getRound()
    {
        $value = $this->get(self::ROUND);
        return $value === null ? (integer)$value : $value;
    }

    /**
     * Returns true if 'round' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasRound()
    {
        return $this->get(self::ROUND) !== null;
    }

    /**
     * Sets value of 'left_card_num' property
     *
     * @param integer $value Property value
     *
     * @return null
     */
    public function setLeftCardNum($value)
    {
        return $this->set(self::LEFT_CARD_NUM, $value);
    }

    /**
     * Returns value of 'left_card_num' property
     *
     * @return integer
     */
    public function getLeftCardNum()
    {
        $value = $this->get(self::LEFT_CARD_NUM);
        return $value === null ? (integer)$value : $value;
    }

    /**
     * Returns true if 'left_card_num' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasLeftCardNum()
    {
        return $this->get(self::LEFT_CARD_NUM) !== null;
    }

    /**
     * Sets value of 'creator_uid' property
     *
     * @param integer $value Property value
     *
     * @return null
     */
    public function setCreatorUid($value)
    {
        return $this->set(self::CREATOR_UID, $value);
    }

    /**
     * Returns value of 'creator_uid' property
     *
     * @return integer
     */
    public function getCreatorUid()
    {
        $value = $this->get(self::CREATOR_UID);
        return $value === null ? (integer)$value : $value;
    }

    /**
     * Returns true if 'creator_uid' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasCreatorUid()
    {
        return $this->get(self::CREATOR_UID) !== null;
    }

    /**
     * Sets value of 'operation_index' property
     *
     * @param integer $value Property value
     *
     * @return null
     */
    public function setOperationIndex($value)
    {
        return $this->set(self::OPERATION_INDEX, $value);
    }

    /**
     * Returns value of 'operation_index' property
     *
     * @return integer
     */
    public function getOperationIndex()
    {
        $value = $this->get(self::OPERATION_INDEX);
        return $value === null ? (integer)$value : $value;
    }

    /**
     * Returns true if 'operation_index' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasOperationIndex()
    {
        return $this->get(self::OPERATION_INDEX) !== null;
    }

    /**
     * Sets value of 'dest_card' property
     *
     * @param integer $value Property value
     *
     * @return null
     */
    public function setDestCard($value)
    {
        return $this->set(self::DEST_CARD, $value);
    }

    /**
     * Returns value of 'dest_card' property
     *
     * @return integer
     */
    public function getDestCard()
    {
        $value = $this->get(self::DEST_CARD);
        return $value === null ? (integer)$value : $value;
    }

    /**
     * Returns true if 'dest_card' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasDestCard()
    {
        return $this->get(self::DEST_CARD) !== null;
    }

    /**
     * Appends value to 'dss_seats' list
     *
     * @param \PBDSSTableSeat $value Value to append
     *
     * @return null
     */
    public function appendDssSeats(\PBDSSTableSeat $value)
    {
        return $this->append(self::DSS_SEATS, $value);
    }

    /**
     * Clears 'dss_seats' list
     *
     * @return null
     */
    public function clearDssSeats()
    {
        return $this->clear(self::DSS_SEATS);
    }

    /**
     * Returns 'dss_seats' list
     *
     * @return \PBDSSTableSeat[]
     */
    public function getDssSeats()
    {
        return $this->get(self::DSS_SEATS);
    }

    /**
     * Returns true if 'dss_seats' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasDssSeats()
    {
        return count($this->get(self::DSS_SEATS)) !== 0;
    }

    /**
     * Returns 'dss_seats' iterator
     *
     * @return \ArrayIterator
     */
    public function getDssSeatsIterator()
    {
        return new \ArrayIterator($this->get(self::DSS_SEATS));
    }

    /**
     * Returns element from 'dss_seats' list at given offset
     *
     * @param int $offset Position in list
     *
     * @return \PBDSSTableSeat
     */
    public function getDssSeatsAt($offset)
    {
        return $this->get(self::DSS_SEATS, $offset);
    }

    /**
     * Returns count of 'dss_seats' list
     *
     * @return int
     */
    public function getDssSeatsCount()
    {
        return $this->count(self::DSS_SEATS);
    }

    /**
     * Sets value of 'dss_conf' property
     *
     * @param \PBDSSTableConfig $value Property value
     *
     * @return null
     */
    public function setDssConf(\PBDSSTableConfig $value=null)
    {
        return $this->set(self::DSS_CONF, $value);
    }

    /**
     * Returns value of 'dss_conf' property
     *
     * @return \PBDSSTableConfig
     */
    public function getDssConf()
    {
        return $this->get(self::DSS_CONF);
    }

    /**
     * Returns true if 'dss_conf' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasDssConf()
    {
        return $this->get(self::DSS_CONF) !== null;
    }

    /**
     * Sets value of 'cur_timestamp' property
     *
     * @param integer $value Property value
     *
     * @return null
     */
    public function setCurTimestamp($value)
    {
        return $this->set(self::CUR_TIMESTAMP, $value);
    }

    /**
     * Returns value of 'cur_timestamp' property
     *
     * @return integer
     */
    public function getCurTimestamp()
    {
        $value = $this->get(self::CUR_TIMESTAMP);
        return $value === null ? (integer)$value : $value;
    }

    /**
     * Returns true if 'cur_timestamp' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasCurTimestamp()
    {
        return $this->get(self::CUR_TIMESTAMP) !== null;
    }

    /**
     * Sets value of 'ready_period' property
     *
     * @param integer $value Property value
     *
     * @return null
     */
    public function setReadyPeriod($value)
    {
        return $this->set(self::READY_PERIOD, $value);
    }

    /**
     * Returns value of 'ready_period' property
     *
     * @return integer
     */
    public function getReadyPeriod()
    {
        $value = $this->get(self::READY_PERIOD);
        return $value === null ? (integer)$value : $value;
    }

    /**
     * Returns true if 'ready_period' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasReadyPeriod()
    {
        return $this->get(self::READY_PERIOD) !== null;
    }

    /**
     * Sets value of 'ready_limit_timestamp' property
     *
     * @param integer $value Property value
     *
     * @return null
     */
    public function setReadyLimitTimestamp($value)
    {
        return $this->set(self::READY_LIMIT_TIMESTAMP, $value);
    }

    /**
     * Returns value of 'ready_limit_timestamp' property
     *
     * @return integer
     */
    public function getReadyLimitTimestamp()
    {
        $value = $this->get(self::READY_LIMIT_TIMESTAMP);
        return $value === null ? (integer)$value : $value;
    }

    /**
     * Returns true if 'ready_limit_timestamp' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasReadyLimitTimestamp()
    {
        return $this->get(self::READY_LIMIT_TIMESTAMP) !== null;
    }

    /**
     * Sets value of 'operate_period' property
     *
     * @param integer $value Property value
     *
     * @return null
     */
    public function setOperatePeriod($value)
    {
        return $this->set(self::OPERATE_PERIOD, $value);
    }

    /**
     * Returns value of 'operate_period' property
     *
     * @return integer
     */
    public function getOperatePeriod()
    {
        $value = $this->get(self::OPERATE_PERIOD);
        return $value === null ? (integer)$value : $value;
    }

    /**
     * Returns true if 'operate_period' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasOperatePeriod()
    {
        return $this->get(self::OPERATE_PERIOD) !== null;
    }

    /**
     * Sets value of 'operate_limit_timestamp' property
     *
     * @param integer $value Property value
     *
     * @return null
     */
    public function setOperateLimitTimestamp($value)
    {
        return $this->set(self::OPERATE_LIMIT_TIMESTAMP, $value);
    }

    /**
     * Returns value of 'operate_limit_timestamp' property
     *
     * @return integer
     */
    public function getOperateLimitTimestamp()
    {
        $value = $this->get(self::OPERATE_LIMIT_TIMESTAMP);
        return $value === null ? (integer)$value : $value;
    }

    /**
     * Returns true if 'operate_limit_timestamp' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasOperateLimitTimestamp()
    {
        return $this->get(self::OPERATE_LIMIT_TIMESTAMP) !== null;
    }

    /**
     * Sets value of 'now_multiple' property
     *
     * @param integer $value Property value
     *
     * @return null
     */
    public function setNowMultiple($value)
    {
        return $this->set(self::NOW_MULTIPLE, $value);
    }

    /**
     * Returns value of 'now_multiple' property
     *
     * @return integer
     */
    public function getNowMultiple()
    {
        $value = $this->get(self::NOW_MULTIPLE);
        return $value === null ? (integer)$value : $value;
    }

    /**
     * Returns true if 'now_multiple' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasNowMultiple()
    {
        return $this->get(self::NOW_MULTIPLE) !== null;
    }

    /**
     * Sets value of 'table_now_multiple' property
     *
     * @param integer $value Property value
     *
     * @return null
     */
    public function setTableNowMultiple($value)
    {
        return $this->set(self::TABLE_NOW_MULTIPLE, $value);
    }

    /**
     * Returns value of 'table_now_multiple' property
     *
     * @return integer
     */
    public function getTableNowMultiple()
    {
        $value = $this->get(self::TABLE_NOW_MULTIPLE);
        return $value === null ? (integer)$value : $value;
    }

    /**
     * Returns true if 'table_now_multiple' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasTableNowMultiple()
    {
        return $this->get(self::TABLE_NOW_MULTIPLE) !== null;
    }

    /**
     * Sets value of 'joker_card' property
     *
     * @param integer $value Property value
     *
     * @return null
     */
    public function setJokerCard($value)
    {
        return $this->set(self::JOKER_CARD, $value);
    }

    /**
     * Returns value of 'joker_card' property
     *
     * @return integer
     */
    public function getJokerCard()
    {
        $value = $this->get(self::JOKER_CARD);
        return $value === null ? (integer)$value : $value;
    }

    /**
     * Returns true if 'joker_card' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasJokerCard()
    {
        return $this->get(self::JOKER_CARD) !== null;
    }

    /**
     * Appends value to 'out_cards' list
     *
     * @param integer $value Value to append
     *
     * @return null
     */
    public function appendOutCards($value)
    {
        return $this->append(self::OUT_CARDS, $value);
    }

    /**
     * Clears 'out_cards' list
     *
     * @return null
     */
    public function clearOutCards()
    {
        return $this->clear(self::OUT_CARDS);
    }

    /**
     * Returns 'out_cards' list
     *
     * @return integer[]
     */
    public function getOutCards()
    {
        return $this->get(self::OUT_CARDS);
    }

    /**
     * Returns true if 'out_cards' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasOutCards()
    {
        return count($this->get(self::OUT_CARDS)) !== 0;
    }

    /**
     * Returns 'out_cards' iterator
     *
     * @return \ArrayIterator
     */
    public function getOutCardsIterator()
    {
        return new \ArrayIterator($this->get(self::OUT_CARDS));
    }

    /**
     * Returns element from 'out_cards' list at given offset
     *
     * @param int $offset Position in list
     *
     * @return integer
     */
    public function getOutCardsAt($offset)
    {
        return $this->get(self::OUT_CARDS, $offset);
    }

    /**
     * Returns count of 'out_cards' list
     *
     * @return int
     */
    public function getOutCardsCount()
    {
        return $this->count(self::OUT_CARDS);
    }

    /**
     * Sets value of 'all_reward' property
     *
     * @param integer $value Property value
     *
     * @return null
     */
    public function setAllReward($value)
    {
        return $this->set(self::ALL_REWARD, $value);
    }

    /**
     * Returns value of 'all_reward' property
     *
     * @return integer
     */
    public function getAllReward()
    {
        $value = $this->get(self::ALL_REWARD);
        return $value === null ? (integer)$value : $value;
    }

    /**
     * Returns true if 'all_reward' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasAllReward()
    {
        return $this->get(self::ALL_REWARD) !== null;
    }

    /**
     * Sets value of 'diamond_score' property
     *
     * @param integer $value Property value
     *
     * @return null
     */
    public function setDiamondScore($value)
    {
        return $this->set(self::DIAMOND_SCORE, $value);
    }

    /**
     * Returns value of 'diamond_score' property
     *
     * @return integer
     */
    public function getDiamondScore()
    {
        $value = $this->get(self::DIAMOND_SCORE);
        return $value === null ? (integer)$value : $value;
    }

    /**
     * Returns true if 'diamond_score' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasDiamondScore()
    {
        return $this->get(self::DIAMOND_SCORE) !== null;
    }

    /**
     * Sets value of 'club_score' property
     *
     * @param integer $value Property value
     *
     * @return null
     */
    public function setClubScore($value)
    {
        return $this->set(self::CLUB_SCORE, $value);
    }

    /**
     * Returns value of 'club_score' property
     *
     * @return integer
     */
    public function getClubScore()
    {
        $value = $this->get(self::CLUB_SCORE);
        return $value === null ? (integer)$value : $value;
    }

    /**
     * Returns true if 'club_score' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasClubScore()
    {
        return $this->get(self::CLUB_SCORE) !== null;
    }

    /**
     * Sets value of 'heart_score' property
     *
     * @param integer $value Property value
     *
     * @return null
     */
    public function setHeartScore($value)
    {
        return $this->set(self::HEART_SCORE, $value);
    }

    /**
     * Returns value of 'heart_score' property
     *
     * @return integer
     */
    public function getHeartScore()
    {
        $value = $this->get(self::HEART_SCORE);
        return $value === null ? (integer)$value : $value;
    }

    /**
     * Returns true if 'heart_score' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasHeartScore()
    {
        return $this->get(self::HEART_SCORE) !== null;
    }

    /**
     * Sets value of 'spade_score' property
     *
     * @param integer $value Property value
     *
     * @return null
     */
    public function setSpadeScore($value)
    {
        return $this->set(self::SPADE_SCORE, $value);
    }

    /**
     * Returns value of 'spade_score' property
     *
     * @return integer
     */
    public function getSpadeScore()
    {
        $value = $this->get(self::SPADE_SCORE);
        return $value === null ? (integer)$value : $value;
    }

    /**
     * Returns true if 'spade_score' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasSpadeScore()
    {
        return $this->get(self::SPADE_SCORE) !== null;
    }

    /**
     * Sets value of 'left_score' property
     *
     * @param integer $value Property value
     *
     * @return null
     */
    public function setLeftScore($value)
    {
        return $this->set(self::LEFT_SCORE, $value);
    }

    /**
     * Returns value of 'left_score' property
     *
     * @return integer
     */
    public function getLeftScore()
    {
        $value = $this->get(self::LEFT_SCORE);
        return $value === null ? (integer)$value : $value;
    }

    /**
     * Returns true if 'left_score' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasLeftScore()
    {
        return $this->get(self::LEFT_SCORE) !== null;
    }

    /**
     * Sets value of 'right_score' property
     *
     * @param integer $value Property value
     *
     * @return null
     */
    public function setRightScore($value)
    {
        return $this->set(self::RIGHT_SCORE, $value);
    }

    /**
     * Returns value of 'right_score' property
     *
     * @return integer
     */
    public function getRightScore()
    {
        $value = $this->get(self::RIGHT_SCORE);
        return $value === null ? (integer)$value : $value;
    }

    /**
     * Returns true if 'right_score' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasRightScore()
    {
        return $this->get(self::RIGHT_SCORE) !== null;
    }

    /**
     * Appends value to 'history_info' list
     *
     * @param integer $value Value to append
     *
     * @return null
     */
    public function appendHistoryInfo($value)
    {
        return $this->append(self::HISTORY_INFO, $value);
    }

    /**
     * Clears 'history_info' list
     *
     * @return null
     */
    public function clearHistoryInfo()
    {
        return $this->clear(self::HISTORY_INFO);
    }

    /**
     * Returns 'history_info' list
     *
     * @return integer[]
     */
    public function getHistoryInfo()
    {
        return $this->get(self::HISTORY_INFO);
    }

    /**
     * Returns true if 'history_info' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasHistoryInfo()
    {
        return count($this->get(self::HISTORY_INFO)) !== 0;
    }

    /**
     * Returns 'history_info' iterator
     *
     * @return \ArrayIterator
     */
    public function getHistoryInfoIterator()
    {
        return new \ArrayIterator($this->get(self::HISTORY_INFO));
    }

    /**
     * Returns element from 'history_info' list at given offset
     *
     * @param int $offset Position in list
     *
     * @return integer
     */
    public function getHistoryInfoAt($offset)
    {
        return $this->get(self::HISTORY_INFO, $offset);
    }

    /**
     * Returns count of 'history_info' list
     *
     * @return int
     */
    public function getHistoryInfoCount()
    {
        return $this->count(self::HISTORY_INFO);
    }

    /**
     * Appends value to 'history_ab' list
     *
     * @param \PBHistoryAB $value Value to append
     *
     * @return null
     */
    public function appendHistoryAb(\PBHistoryAB $value)
    {
        return $this->append(self::HISTORY_AB, $value);
    }

    /**
     * Clears 'history_ab' list
     *
     * @return null
     */
    public function clearHistoryAb()
    {
        return $this->clear(self::HISTORY_AB);
    }

    /**
     * Returns 'history_ab' list
     *
     * @return \PBHistoryAB[]
     */
    public function getHistoryAb()
    {
        return $this->get(self::HISTORY_AB);
    }

    /**
     * Returns true if 'history_ab' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasHistoryAb()
    {
        return count($this->get(self::HISTORY_AB)) !== 0;
    }

    /**
     * Returns 'history_ab' iterator
     *
     * @return \ArrayIterator
     */
    public function getHistoryAbIterator()
    {
        return new \ArrayIterator($this->get(self::HISTORY_AB));
    }

    /**
     * Returns element from 'history_ab' list at given offset
     *
     * @param int $offset Position in list
     *
     * @return \PBHistoryAB
     */
    public function getHistoryAbAt($offset)
    {
        return $this->get(self::HISTORY_AB, $offset);
    }

    /**
     * Returns count of 'history_ab' list
     *
     * @return int
     */
    public function getHistoryAbCount()
    {
        return $this->count(self::HISTORY_AB);
    }

    /**
     * Appends value to 'ab_bet_score' list
     *
     * @param integer $value Value to append
     *
     * @return null
     */
    public function appendAbBetScore($value)
    {
        return $this->append(self::AB_BET_SCORE, $value);
    }

    /**
     * Clears 'ab_bet_score' list
     *
     * @return null
     */
    public function clearAbBetScore()
    {
        return $this->clear(self::AB_BET_SCORE);
    }

    /**
     * Returns 'ab_bet_score' list
     *
     * @return integer[]
     */
    public function getAbBetScore()
    {
        return $this->get(self::AB_BET_SCORE);
    }

    /**
     * Returns true if 'ab_bet_score' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasAbBetScore()
    {
        return count($this->get(self::AB_BET_SCORE)) !== 0;
    }

    /**
     * Returns 'ab_bet_score' iterator
     *
     * @return \ArrayIterator
     */
    public function getAbBetScoreIterator()
    {
        return new \ArrayIterator($this->get(self::AB_BET_SCORE));
    }

    /**
     * Returns element from 'ab_bet_score' list at given offset
     *
     * @param int $offset Position in list
     *
     * @return integer
     */
    public function getAbBetScoreAt($offset)
    {
        return $this->get(self::AB_BET_SCORE, $offset);
    }

    /**
     * Returns count of 'ab_bet_score' list
     *
     * @return int
     */
    public function getAbBetScoreCount()
    {
        return $this->count(self::AB_BET_SCORE);
    }

    /**
     * Sets value of 'server_jack_pot_score' property
     *
     * @param integer $value Property value
     *
     * @return null
     */
    public function setServerJackPotScore($value)
    {
        return $this->set(self::SERVER_JACK_POT_SCORE, $value);
    }

    /**
     * Returns value of 'server_jack_pot_score' property
     *
     * @return integer
     */
    public function getServerJackPotScore()
    {
        $value = $this->get(self::SERVER_JACK_POT_SCORE);
        return $value === null ? (integer)$value : $value;
    }

    /**
     * Returns true if 'server_jack_pot_score' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasServerJackPotScore()
    {
        return $this->get(self::SERVER_JACK_POT_SCORE) !== null;
    }

    /**
     * Sets value of 'action' property
     *
     * @param \PBDSSAction $value Property value
     *
     * @return null
     */
    public function setAction(\PBDSSAction $value=null)
    {
        return $this->set(self::ACTION, $value);
    }

    /**
     * Returns value of 'action' property
     *
     * @return \PBDSSAction
     */
    public function getAction()
    {
        return $this->get(self::ACTION);
    }

    /**
     * Returns true if 'action' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasAction()
    {
        return $this->get(self::ACTION) !== null;
    }

    /**
     * Sets value of 'seed_hash' property
     *
     * @param string $value Property value
     *
     * @return null
     */
    public function setSeedHash($value)
    {
        return $this->set(self::SEED_HASH, $value);
    }

    /**
     * Returns value of 'seed_hash' property
     *
     * @return string
     */
    public function getSeedHash()
    {
        $value = $this->get(self::SEED_HASH);
        return $value === null ? (string)$value : $value;
    }

    /**
     * Returns true if 'seed_hash' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasSeedHash()
    {
        return $this->get(self::SEED_HASH) !== null;
    }

    /**
     * Appends value to 'round_hash' list
     *
     * @param string $value Value to append
     *
     * @return null
     */
    public function appendRoundHash($value)
    {
        return $this->append(self::ROUND_HASH, $value);
    }

    /**
     * Clears 'round_hash' list
     *
     * @return null
     */
    public function clearRoundHash()
    {
        return $this->clear(self::ROUND_HASH);
    }

    /**
     * Returns 'round_hash' list
     *
     * @return string[]
     */
    public function getRoundHash()
    {
        return $this->get(self::ROUND_HASH);
    }

    /**
     * Returns true if 'round_hash' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasRoundHash()
    {
        return count($this->get(self::ROUND_HASH)) !== 0;
    }

    /**
     * Returns 'round_hash' iterator
     *
     * @return \ArrayIterator
     */
    public function getRoundHashIterator()
    {
        return new \ArrayIterator($this->get(self::ROUND_HASH));
    }

    /**
     * Returns element from 'round_hash' list at given offset
     *
     * @param int $offset Position in list
     *
     * @return string
     */
    public function getRoundHashAt($offset)
    {
        return $this->get(self::ROUND_HASH, $offset);
    }

    /**
     * Returns count of 'round_hash' list
     *
     * @return int
     */
    public function getRoundHashCount()
    {
        return $this->count(self::ROUND_HASH);
    }

    /**
     * Sets value of 'day_num' property
     *
     * @param string $value Property value
     *
     * @return null
     */
    public function setDayNum($value)
    {
        return $this->set(self::DAY_NUM, $value);
    }

    /**
     * Returns value of 'day_num' property
     *
     * @return string
     */
    public function getDayNum()
    {
        $value = $this->get(self::DAY_NUM);
        return $value === null ? (string)$value : $value;
    }

    /**
     * Returns true if 'day_num' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasDayNum()
    {
        return $this->get(self::DAY_NUM) !== null;
    }

    /**
     * Appends value to 'score_max' list
     *
     * @param integer $value Value to append
     *
     * @return null
     */
    public function appendScoreMax($value)
    {
        return $this->append(self::SCORE_MAX, $value);
    }

    /**
     * Clears 'score_max' list
     *
     * @return null
     */
    public function clearScoreMax()
    {
        return $this->clear(self::SCORE_MAX);
    }

    /**
     * Returns 'score_max' list
     *
     * @return integer[]
     */
    public function getScoreMax()
    {
        return $this->get(self::SCORE_MAX);
    }

    /**
     * Returns true if 'score_max' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasScoreMax()
    {
        return count($this->get(self::SCORE_MAX)) !== 0;
    }

    /**
     * Returns 'score_max' iterator
     *
     * @return \ArrayIterator
     */
    public function getScoreMaxIterator()
    {
        return new \ArrayIterator($this->get(self::SCORE_MAX));
    }

    /**
     * Returns element from 'score_max' list at given offset
     *
     * @param int $offset Position in list
     *
     * @return integer
     */
    public function getScoreMaxAt($offset)
    {
        return $this->get(self::SCORE_MAX, $offset);
    }

    /**
     * Returns count of 'score_max' list
     *
     * @return int
     */
    public function getScoreMaxCount()
    {
        return $this->count(self::SCORE_MAX);
    }

    /**
     * Appends value to 'pay_max' list
     *
     * @param integer $value Value to append
     *
     * @return null
     */
    public function appendPayMax($value)
    {
        return $this->append(self::PAY_MAX, $value);
    }

    /**
     * Clears 'pay_max' list
     *
     * @return null
     */
    public function clearPayMax()
    {
        return $this->clear(self::PAY_MAX);
    }

    /**
     * Returns 'pay_max' list
     *
     * @return integer[]
     */
    public function getPayMax()
    {
        return $this->get(self::PAY_MAX);
    }

    /**
     * Returns true if 'pay_max' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasPayMax()
    {
        return count($this->get(self::PAY_MAX)) !== 0;
    }

    /**
     * Returns 'pay_max' iterator
     *
     * @return \ArrayIterator
     */
    public function getPayMaxIterator()
    {
        return new \ArrayIterator($this->get(self::PAY_MAX));
    }

    /**
     * Returns element from 'pay_max' list at given offset
     *
     * @param int $offset Position in list
     *
     * @return integer
     */
    public function getPayMaxAt($offset)
    {
        return $this->get(self::PAY_MAX, $offset);
    }

    /**
     * Returns count of 'pay_max' list
     *
     * @return int
     */
    public function getPayMaxCount()
    {
        return $this->count(self::PAY_MAX);
    }

    /**
     * Appends value to 'seed_hash_till_now' list
     *
     * @param string $value Value to append
     *
     * @return null
     */
    public function appendSeedHashTillNow($value)
    {
        return $this->append(self::SEED_HASH_TILL_NOW, $value);
    }

    /**
     * Clears 'seed_hash_till_now' list
     *
     * @return null
     */
    public function clearSeedHashTillNow()
    {
        return $this->clear(self::SEED_HASH_TILL_NOW);
    }

    /**
     * Returns 'seed_hash_till_now' list
     *
     * @return string[]
     */
    public function getSeedHashTillNow()
    {
        return $this->get(self::SEED_HASH_TILL_NOW);
    }

    /**
     * Returns true if 'seed_hash_till_now' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasSeedHashTillNow()
    {
        return count($this->get(self::SEED_HASH_TILL_NOW)) !== 0;
    }

    /**
     * Returns 'seed_hash_till_now' iterator
     *
     * @return \ArrayIterator
     */
    public function getSeedHashTillNowIterator()
    {
        return new \ArrayIterator($this->get(self::SEED_HASH_TILL_NOW));
    }

    /**
     * Returns element from 'seed_hash_till_now' list at given offset
     *
     * @param int $offset Position in list
     *
     * @return string
     */
    public function getSeedHashTillNowAt($offset)
    {
        return $this->get(self::SEED_HASH_TILL_NOW, $offset);
    }

    /**
     * Returns count of 'seed_hash_till_now' list
     *
     * @return int
     */
    public function getSeedHashTillNowCount()
    {
        return $this->count(self::SEED_HASH_TILL_NOW);
    }

    /**
     * Appends value to 'seed_before' list
     *
     * @param string $value Value to append
     *
     * @return null
     */
    public function appendSeedBefore($value)
    {
        return $this->append(self::SEED_BEFORE, $value);
    }

    /**
     * Clears 'seed_before' list
     *
     * @return null
     */
    public function clearSeedBefore()
    {
        return $this->clear(self::SEED_BEFORE);
    }

    /**
     * Returns 'seed_before' list
     *
     * @return string[]
     */
    public function getSeedBefore()
    {
        return $this->get(self::SEED_BEFORE);
    }

    /**
     * Returns true if 'seed_before' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasSeedBefore()
    {
        return count($this->get(self::SEED_BEFORE)) !== 0;
    }

    /**
     * Returns 'seed_before' iterator
     *
     * @return \ArrayIterator
     */
    public function getSeedBeforeIterator()
    {
        return new \ArrayIterator($this->get(self::SEED_BEFORE));
    }

    /**
     * Returns element from 'seed_before' list at given offset
     *
     * @param int $offset Position in list
     *
     * @return string
     */
    public function getSeedBeforeAt($offset)
    {
        return $this->get(self::SEED_BEFORE, $offset);
    }

    /**
     * Returns count of 'seed_before' list
     *
     * @return int
     */
    public function getSeedBeforeCount()
    {
        return $this->count(self::SEED_BEFORE);
    }
}
}