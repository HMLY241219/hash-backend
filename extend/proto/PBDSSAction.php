<?php
/**
 * Auto generated from poker_msg_basic.proto at 2023-06-08 09:49:25
 */

namespace {
/**
 * PBDSSAction message
 */
class PBDSSAction extends \ProtobufMessage
{
    /* Field index constants */
    const TID = 1;
    const SEAT_INDEX = 2;
    const ACT_TYPE = 3;
    const DEST_CARD = 4;
    const COL_INFO = 5;
    const LEFT_CARD_NUM = 6;
    const CHOICE_TOKEN = 7;
    const IS_AUTO_ACTION = 8;
    const NOW_MULTIPLE = 9;
    const TABLE_NOW_MULTIPLE = 10;
    const BET_TYPE = 11;
    const BET_SCORE = 12;
    const COMPARE_INDEX = 13;
    const ADD_MULTIPLE = 14;
    const WIN_INDEX = 15;
    const LOOK_CARD = 16;
    const AB_BET_SCORE = 17;
    const TABLE_AB_BET_SCORE = 18;
    const WIN_SCORE = 19;
    const ROTARY_NUM = 20;
    const DORP_MULTIPLE = 21;
    const IS_NA_PAI_OUT_CARD = 22;
    const HAND_GROUP_INFO = 23;
    const LOST_MULTIPLE = 24;
    const TIMER_INDEX = 25;
    const IS_DROP = 26;
    const REWARD_SCORE = 27;
    const ALL_REWARD = 28;
    const CHAT_TYPE = 29;
    const MESS_TYPE = 30;
    const OPERATION_INDEX = 31;
    const CARDTYPE = 101;
    const REAL = 102;
    const NUM = 103;
    const CARDS = 104;
    const SEED_BEFORE = 201;
    const SEED_HASH_NEXT = 202;
    const PAY_OUT_0 = 203;
    const PAY_OUT_1 = 204;
    const PAY_OUT_END = 205;

    /* @var array Field descriptors */
    protected static $fields = array(
        self::TID => array(
            'name' => 'tid',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_INT,
        ),
        self::SEAT_INDEX => array(
            'name' => 'seat_index',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_INT,
        ),
        self::ACT_TYPE => array(
            'name' => 'act_type',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_INT,
        ),
        self::DEST_CARD => array(
            'name' => 'dest_card',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_INT,
        ),
        self::COL_INFO => array(
            'name' => 'col_info',
            'required' => false,
            'type' => '\PBDSSColumnInfo'
        ),
        self::LEFT_CARD_NUM => array(
            'name' => 'left_card_num',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_INT,
        ),
        self::CHOICE_TOKEN => array(
            'name' => 'choice_token',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_INT,
        ),
        self::IS_AUTO_ACTION => array(
            'default' => false,
            'name' => 'is_auto_action',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_BOOL,
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
        self::BET_TYPE => array(
            'name' => 'bet_type',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_INT,
        ),
        self::BET_SCORE => array(
            'name' => 'bet_score',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_INT,
        ),
        self::COMPARE_INDEX => array(
            'name' => 'compare_index',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_INT,
        ),
        self::ADD_MULTIPLE => array(
            'name' => 'add_multiple',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_INT,
        ),
        self::WIN_INDEX => array(
            'name' => 'win_index',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_INT,
        ),
        self::LOOK_CARD => array(
            'name' => 'look_card',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_BOOL,
        ),
        self::AB_BET_SCORE => array(
            'name' => 'ab_bet_score',
            'repeated' => true,
            'type' => \ProtobufMessage::PB_TYPE_INT,
        ),
        self::TABLE_AB_BET_SCORE => array(
            'name' => 'table_ab_bet_score',
            'repeated' => true,
            'type' => \ProtobufMessage::PB_TYPE_INT,
        ),
        self::WIN_SCORE => array(
            'name' => 'win_score',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_INT,
        ),
        self::ROTARY_NUM => array(
            'name' => 'rotary_num',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_INT,
        ),
        self::DORP_MULTIPLE => array(
            'name' => 'dorp_multiple',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_INT,
        ),
        self::IS_NA_PAI_OUT_CARD => array(
            'name' => 'is_na_pai_out_card',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_BOOL,
        ),
        self::HAND_GROUP_INFO => array(
            'name' => 'hand_group_info',
            'repeated' => true,
            'type' => '\PBDSSColumnInfo'
        ),
        self::LOST_MULTIPLE => array(
            'name' => 'lost_multiple',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_INT,
        ),
        self::TIMER_INDEX => array(
            'name' => 'timer_index',
            'repeated' => true,
            'type' => \ProtobufMessage::PB_TYPE_INT,
        ),
        self::IS_DROP => array(
            'default' => false,
            'name' => 'is_drop',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_BOOL,
        ),
        self::REWARD_SCORE => array(
            'name' => 'reward_score',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_INT,
        ),
        self::ALL_REWARD => array(
            'name' => 'all_reward',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_INT,
        ),
        self::CHAT_TYPE => array(
            'name' => 'chat_type',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_INT,
        ),
        self::MESS_TYPE => array(
            'name' => 'mess_type',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_INT,
        ),
        self::OPERATION_INDEX => array(
            'name' => 'operation_index',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_INT,
        ),
        self::CARDTYPE => array(
            'name' => 'cardtype',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_INT,
        ),
        self::REAL => array(
            'name' => 'real',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_INT,
        ),
        self::NUM => array(
            'name' => 'num',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_INT,
        ),
        self::CARDS => array(
            'name' => 'cards',
            'repeated' => true,
            'type' => \ProtobufMessage::PB_TYPE_INT,
        ),
        self::SEED_BEFORE => array(
            'name' => 'seed_before',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_STRING,
        ),
        self::SEED_HASH_NEXT => array(
            'name' => 'seed_hash_next',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_STRING,
        ),
        self::PAY_OUT_0 => array(
            'name' => 'pay_out_0',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_FLOAT,
        ),
        self::PAY_OUT_1 => array(
            'name' => 'pay_out_1',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_FLOAT,
        ),
        self::PAY_OUT_END => array(
            'name' => 'pay_out_end',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_FLOAT,
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
        $this->values[self::TID] = null;
        $this->values[self::SEAT_INDEX] = null;
        $this->values[self::ACT_TYPE] = null;
        $this->values[self::DEST_CARD] = null;
        $this->values[self::COL_INFO] = null;
        $this->values[self::LEFT_CARD_NUM] = null;
        $this->values[self::CHOICE_TOKEN] = null;
        $this->values[self::IS_AUTO_ACTION] = self::$fields[self::IS_AUTO_ACTION]['default'];
        $this->values[self::NOW_MULTIPLE] = null;
        $this->values[self::TABLE_NOW_MULTIPLE] = null;
        $this->values[self::BET_TYPE] = null;
        $this->values[self::BET_SCORE] = null;
        $this->values[self::COMPARE_INDEX] = null;
        $this->values[self::ADD_MULTIPLE] = null;
        $this->values[self::WIN_INDEX] = null;
        $this->values[self::LOOK_CARD] = null;
        $this->values[self::AB_BET_SCORE] = array();
        $this->values[self::TABLE_AB_BET_SCORE] = array();
        $this->values[self::WIN_SCORE] = null;
        $this->values[self::ROTARY_NUM] = null;
        $this->values[self::DORP_MULTIPLE] = null;
        $this->values[self::IS_NA_PAI_OUT_CARD] = null;
        $this->values[self::HAND_GROUP_INFO] = array();
        $this->values[self::LOST_MULTIPLE] = null;
        $this->values[self::TIMER_INDEX] = array();
        $this->values[self::IS_DROP] = self::$fields[self::IS_DROP]['default'];
        $this->values[self::REWARD_SCORE] = null;
        $this->values[self::ALL_REWARD] = null;
        $this->values[self::CHAT_TYPE] = null;
        $this->values[self::MESS_TYPE] = null;
        $this->values[self::OPERATION_INDEX] = null;
        $this->values[self::CARDTYPE] = null;
        $this->values[self::REAL] = null;
        $this->values[self::NUM] = null;
        $this->values[self::CARDS] = array();
        $this->values[self::SEED_BEFORE] = null;
        $this->values[self::SEED_HASH_NEXT] = null;
        $this->values[self::PAY_OUT_0] = null;
        $this->values[self::PAY_OUT_1] = null;
        $this->values[self::PAY_OUT_END] = null;
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
     * Sets value of 'act_type' property
     *
     * @param integer $value Property value
     *
     * @return null
     */
    public function setActType($value)
    {
        return $this->set(self::ACT_TYPE, $value);
    }

    /**
     * Returns value of 'act_type' property
     *
     * @return integer
     */
    public function getActType()
    {
        $value = $this->get(self::ACT_TYPE);
        return $value === null ? (integer)$value : $value;
    }

    /**
     * Returns true if 'act_type' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasActType()
    {
        return $this->get(self::ACT_TYPE) !== null;
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
     * Sets value of 'col_info' property
     *
     * @param \PBDSSColumnInfo $value Property value
     *
     * @return null
     */
    public function setColInfo(\PBDSSColumnInfo $value=null)
    {
        return $this->set(self::COL_INFO, $value);
    }

    /**
     * Returns value of 'col_info' property
     *
     * @return \PBDSSColumnInfo
     */
    public function getColInfo()
    {
        return $this->get(self::COL_INFO);
    }

    /**
     * Returns true if 'col_info' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasColInfo()
    {
        return $this->get(self::COL_INFO) !== null;
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
     * Sets value of 'choice_token' property
     *
     * @param integer $value Property value
     *
     * @return null
     */
    public function setChoiceToken($value)
    {
        return $this->set(self::CHOICE_TOKEN, $value);
    }

    /**
     * Returns value of 'choice_token' property
     *
     * @return integer
     */
    public function getChoiceToken()
    {
        $value = $this->get(self::CHOICE_TOKEN);
        return $value === null ? (integer)$value : $value;
    }

    /**
     * Returns true if 'choice_token' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasChoiceToken()
    {
        return $this->get(self::CHOICE_TOKEN) !== null;
    }

    /**
     * Sets value of 'is_auto_action' property
     *
     * @param boolean $value Property value
     *
     * @return null
     */
    public function setIsAutoAction($value)
    {
        return $this->set(self::IS_AUTO_ACTION, $value);
    }

    /**
     * Returns value of 'is_auto_action' property
     *
     * @return boolean
     */
    public function getIsAutoAction()
    {
        $value = $this->get(self::IS_AUTO_ACTION);
        return $value === null ? (boolean)$value : $value;
    }

    /**
     * Returns true if 'is_auto_action' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasIsAutoAction()
    {
        return $this->get(self::IS_AUTO_ACTION) !== null;
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
     * Sets value of 'bet_type' property
     *
     * @param integer $value Property value
     *
     * @return null
     */
    public function setBetType($value)
    {
        return $this->set(self::BET_TYPE, $value);
    }

    /**
     * Returns value of 'bet_type' property
     *
     * @return integer
     */
    public function getBetType()
    {
        $value = $this->get(self::BET_TYPE);
        return $value === null ? (integer)$value : $value;
    }

    /**
     * Returns true if 'bet_type' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasBetType()
    {
        return $this->get(self::BET_TYPE) !== null;
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
     * Sets value of 'compare_index' property
     *
     * @param integer $value Property value
     *
     * @return null
     */
    public function setCompareIndex($value)
    {
        return $this->set(self::COMPARE_INDEX, $value);
    }

    /**
     * Returns value of 'compare_index' property
     *
     * @return integer
     */
    public function getCompareIndex()
    {
        $value = $this->get(self::COMPARE_INDEX);
        return $value === null ? (integer)$value : $value;
    }

    /**
     * Returns true if 'compare_index' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasCompareIndex()
    {
        return $this->get(self::COMPARE_INDEX) !== null;
    }

    /**
     * Sets value of 'add_multiple' property
     *
     * @param integer $value Property value
     *
     * @return null
     */
    public function setAddMultiple($value)
    {
        return $this->set(self::ADD_MULTIPLE, $value);
    }

    /**
     * Returns value of 'add_multiple' property
     *
     * @return integer
     */
    public function getAddMultiple()
    {
        $value = $this->get(self::ADD_MULTIPLE);
        return $value === null ? (integer)$value : $value;
    }

    /**
     * Returns true if 'add_multiple' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasAddMultiple()
    {
        return $this->get(self::ADD_MULTIPLE) !== null;
    }

    /**
     * Sets value of 'win_index' property
     *
     * @param integer $value Property value
     *
     * @return null
     */
    public function setWinIndex($value)
    {
        return $this->set(self::WIN_INDEX, $value);
    }

    /**
     * Returns value of 'win_index' property
     *
     * @return integer
     */
    public function getWinIndex()
    {
        $value = $this->get(self::WIN_INDEX);
        return $value === null ? (integer)$value : $value;
    }

    /**
     * Returns true if 'win_index' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasWinIndex()
    {
        return $this->get(self::WIN_INDEX) !== null;
    }

    /**
     * Sets value of 'look_card' property
     *
     * @param boolean $value Property value
     *
     * @return null
     */
    public function setLookCard($value)
    {
        return $this->set(self::LOOK_CARD, $value);
    }

    /**
     * Returns value of 'look_card' property
     *
     * @return boolean
     */
    public function getLookCard()
    {
        $value = $this->get(self::LOOK_CARD);
        return $value === null ? (boolean)$value : $value;
    }

    /**
     * Returns true if 'look_card' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasLookCard()
    {
        return $this->get(self::LOOK_CARD) !== null;
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
     * Appends value to 'table_ab_bet_score' list
     *
     * @param integer $value Value to append
     *
     * @return null
     */
    public function appendTableAbBetScore($value)
    {
        return $this->append(self::TABLE_AB_BET_SCORE, $value);
    }

    /**
     * Clears 'table_ab_bet_score' list
     *
     * @return null
     */
    public function clearTableAbBetScore()
    {
        return $this->clear(self::TABLE_AB_BET_SCORE);
    }

    /**
     * Returns 'table_ab_bet_score' list
     *
     * @return integer[]
     */
    public function getTableAbBetScore()
    {
        return $this->get(self::TABLE_AB_BET_SCORE);
    }

    /**
     * Returns true if 'table_ab_bet_score' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasTableAbBetScore()
    {
        return count($this->get(self::TABLE_AB_BET_SCORE)) !== 0;
    }

    /**
     * Returns 'table_ab_bet_score' iterator
     *
     * @return \ArrayIterator
     */
    public function getTableAbBetScoreIterator()
    {
        return new \ArrayIterator($this->get(self::TABLE_AB_BET_SCORE));
    }

    /**
     * Returns element from 'table_ab_bet_score' list at given offset
     *
     * @param int $offset Position in list
     *
     * @return integer
     */
    public function getTableAbBetScoreAt($offset)
    {
        return $this->get(self::TABLE_AB_BET_SCORE, $offset);
    }

    /**
     * Returns count of 'table_ab_bet_score' list
     *
     * @return int
     */
    public function getTableAbBetScoreCount()
    {
        return $this->count(self::TABLE_AB_BET_SCORE);
    }

    /**
     * Sets value of 'win_score' property
     *
     * @param integer $value Property value
     *
     * @return null
     */
    public function setWinScore($value)
    {
        return $this->set(self::WIN_SCORE, $value);
    }

    /**
     * Returns value of 'win_score' property
     *
     * @return integer
     */
    public function getWinScore()
    {
        $value = $this->get(self::WIN_SCORE);
        return $value === null ? (integer)$value : $value;
    }

    /**
     * Returns true if 'win_score' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasWinScore()
    {
        return $this->get(self::WIN_SCORE) !== null;
    }

    /**
     * Sets value of 'rotary_num' property
     *
     * @param integer $value Property value
     *
     * @return null
     */
    public function setRotaryNum($value)
    {
        return $this->set(self::ROTARY_NUM, $value);
    }

    /**
     * Returns value of 'rotary_num' property
     *
     * @return integer
     */
    public function getRotaryNum()
    {
        $value = $this->get(self::ROTARY_NUM);
        return $value === null ? (integer)$value : $value;
    }

    /**
     * Returns true if 'rotary_num' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasRotaryNum()
    {
        return $this->get(self::ROTARY_NUM) !== null;
    }

    /**
     * Sets value of 'dorp_multiple' property
     *
     * @param integer $value Property value
     *
     * @return null
     */
    public function setDorpMultiple($value)
    {
        return $this->set(self::DORP_MULTIPLE, $value);
    }

    /**
     * Returns value of 'dorp_multiple' property
     *
     * @return integer
     */
    public function getDorpMultiple()
    {
        $value = $this->get(self::DORP_MULTIPLE);
        return $value === null ? (integer)$value : $value;
    }

    /**
     * Returns true if 'dorp_multiple' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasDorpMultiple()
    {
        return $this->get(self::DORP_MULTIPLE) !== null;
    }

    /**
     * Sets value of 'is_na_pai_out_card' property
     *
     * @param boolean $value Property value
     *
     * @return null
     */
    public function setIsNaPaiOutCard($value)
    {
        return $this->set(self::IS_NA_PAI_OUT_CARD, $value);
    }

    /**
     * Returns value of 'is_na_pai_out_card' property
     *
     * @return boolean
     */
    public function getIsNaPaiOutCard()
    {
        $value = $this->get(self::IS_NA_PAI_OUT_CARD);
        return $value === null ? (boolean)$value : $value;
    }

    /**
     * Returns true if 'is_na_pai_out_card' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasIsNaPaiOutCard()
    {
        return $this->get(self::IS_NA_PAI_OUT_CARD) !== null;
    }

    /**
     * Appends value to 'hand_group_info' list
     *
     * @param \PBDSSColumnInfo $value Value to append
     *
     * @return null
     */
    public function appendHandGroupInfo(\PBDSSColumnInfo $value)
    {
        return $this->append(self::HAND_GROUP_INFO, $value);
    }

    /**
     * Clears 'hand_group_info' list
     *
     * @return null
     */
    public function clearHandGroupInfo()
    {
        return $this->clear(self::HAND_GROUP_INFO);
    }

    /**
     * Returns 'hand_group_info' list
     *
     * @return \PBDSSColumnInfo[]
     */
    public function getHandGroupInfo()
    {
        return $this->get(self::HAND_GROUP_INFO);
    }

    /**
     * Returns true if 'hand_group_info' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasHandGroupInfo()
    {
        return count($this->get(self::HAND_GROUP_INFO)) !== 0;
    }

    /**
     * Returns 'hand_group_info' iterator
     *
     * @return \ArrayIterator
     */
    public function getHandGroupInfoIterator()
    {
        return new \ArrayIterator($this->get(self::HAND_GROUP_INFO));
    }

    /**
     * Returns element from 'hand_group_info' list at given offset
     *
     * @param int $offset Position in list
     *
     * @return \PBDSSColumnInfo
     */
    public function getHandGroupInfoAt($offset)
    {
        return $this->get(self::HAND_GROUP_INFO, $offset);
    }

    /**
     * Returns count of 'hand_group_info' list
     *
     * @return int
     */
    public function getHandGroupInfoCount()
    {
        return $this->count(self::HAND_GROUP_INFO);
    }

    /**
     * Sets value of 'lost_multiple' property
     *
     * @param integer $value Property value
     *
     * @return null
     */
    public function setLostMultiple($value)
    {
        return $this->set(self::LOST_MULTIPLE, $value);
    }

    /**
     * Returns value of 'lost_multiple' property
     *
     * @return integer
     */
    public function getLostMultiple()
    {
        $value = $this->get(self::LOST_MULTIPLE);
        return $value === null ? (integer)$value : $value;
    }

    /**
     * Returns true if 'lost_multiple' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasLostMultiple()
    {
        return $this->get(self::LOST_MULTIPLE) !== null;
    }

    /**
     * Appends value to 'timer_index' list
     *
     * @param integer $value Value to append
     *
     * @return null
     */
    public function appendTimerIndex($value)
    {
        return $this->append(self::TIMER_INDEX, $value);
    }

    /**
     * Clears 'timer_index' list
     *
     * @return null
     */
    public function clearTimerIndex()
    {
        return $this->clear(self::TIMER_INDEX);
    }

    /**
     * Returns 'timer_index' list
     *
     * @return integer[]
     */
    public function getTimerIndex()
    {
        return $this->get(self::TIMER_INDEX);
    }

    /**
     * Returns true if 'timer_index' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasTimerIndex()
    {
        return count($this->get(self::TIMER_INDEX)) !== 0;
    }

    /**
     * Returns 'timer_index' iterator
     *
     * @return \ArrayIterator
     */
    public function getTimerIndexIterator()
    {
        return new \ArrayIterator($this->get(self::TIMER_INDEX));
    }

    /**
     * Returns element from 'timer_index' list at given offset
     *
     * @param int $offset Position in list
     *
     * @return integer
     */
    public function getTimerIndexAt($offset)
    {
        return $this->get(self::TIMER_INDEX, $offset);
    }

    /**
     * Returns count of 'timer_index' list
     *
     * @return int
     */
    public function getTimerIndexCount()
    {
        return $this->count(self::TIMER_INDEX);
    }

    /**
     * Sets value of 'is_drop' property
     *
     * @param boolean $value Property value
     *
     * @return null
     */
    public function setIsDrop($value)
    {
        return $this->set(self::IS_DROP, $value);
    }

    /**
     * Returns value of 'is_drop' property
     *
     * @return boolean
     */
    public function getIsDrop()
    {
        $value = $this->get(self::IS_DROP);
        return $value === null ? (boolean)$value : $value;
    }

    /**
     * Returns true if 'is_drop' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasIsDrop()
    {
        return $this->get(self::IS_DROP) !== null;
    }

    /**
     * Sets value of 'reward_score' property
     *
     * @param integer $value Property value
     *
     * @return null
     */
    public function setRewardScore($value)
    {
        return $this->set(self::REWARD_SCORE, $value);
    }

    /**
     * Returns value of 'reward_score' property
     *
     * @return integer
     */
    public function getRewardScore()
    {
        $value = $this->get(self::REWARD_SCORE);
        return $value === null ? (integer)$value : $value;
    }

    /**
     * Returns true if 'reward_score' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasRewardScore()
    {
        return $this->get(self::REWARD_SCORE) !== null;
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
     * Sets value of 'chat_type' property
     *
     * @param integer $value Property value
     *
     * @return null
     */
    public function setChatType($value)
    {
        return $this->set(self::CHAT_TYPE, $value);
    }

    /**
     * Returns value of 'chat_type' property
     *
     * @return integer
     */
    public function getChatType()
    {
        $value = $this->get(self::CHAT_TYPE);
        return $value === null ? (integer)$value : $value;
    }

    /**
     * Returns true if 'chat_type' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasChatType()
    {
        return $this->get(self::CHAT_TYPE) !== null;
    }

    /**
     * Sets value of 'mess_type' property
     *
     * @param integer $value Property value
     *
     * @return null
     */
    public function setMessType($value)
    {
        return $this->set(self::MESS_TYPE, $value);
    }

    /**
     * Returns value of 'mess_type' property
     *
     * @return integer
     */
    public function getMessType()
    {
        $value = $this->get(self::MESS_TYPE);
        return $value === null ? (integer)$value : $value;
    }

    /**
     * Returns true if 'mess_type' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasMessType()
    {
        return $this->get(self::MESS_TYPE) !== null;
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
     * Sets value of 'cardtype' property
     *
     * @param integer $value Property value
     *
     * @return null
     */
    public function setCardtype($value)
    {
        return $this->set(self::CARDTYPE, $value);
    }

    /**
     * Returns value of 'cardtype' property
     *
     * @return integer
     */
    public function getCardtype()
    {
        $value = $this->get(self::CARDTYPE);
        return $value === null ? (integer)$value : $value;
    }

    /**
     * Returns true if 'cardtype' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasCardtype()
    {
        return $this->get(self::CARDTYPE) !== null;
    }

    /**
     * Sets value of 'real' property
     *
     * @param integer $value Property value
     *
     * @return null
     */
    public function setReal($value)
    {
        return $this->set(self::REAL, $value);
    }

    /**
     * Returns value of 'real' property
     *
     * @return integer
     */
    public function getReal()
    {
        $value = $this->get(self::REAL);
        return $value === null ? (integer)$value : $value;
    }

    /**
     * Returns true if 'real' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasReal()
    {
        return $this->get(self::REAL) !== null;
    }

    /**
     * Sets value of 'num' property
     *
     * @param integer $value Property value
     *
     * @return null
     */
    public function setNum($value)
    {
        return $this->set(self::NUM, $value);
    }

    /**
     * Returns value of 'num' property
     *
     * @return integer
     */
    public function getNum()
    {
        $value = $this->get(self::NUM);
        return $value === null ? (integer)$value : $value;
    }

    /**
     * Returns true if 'num' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasNum()
    {
        return $this->get(self::NUM) !== null;
    }

    /**
     * Appends value to 'cards' list
     *
     * @param integer $value Value to append
     *
     * @return null
     */
    public function appendCards($value)
    {
        return $this->append(self::CARDS, $value);
    }

    /**
     * Clears 'cards' list
     *
     * @return null
     */
    public function clearCards()
    {
        return $this->clear(self::CARDS);
    }

    /**
     * Returns 'cards' list
     *
     * @return integer[]
     */
    public function getCards()
    {
        return $this->get(self::CARDS);
    }

    /**
     * Returns true if 'cards' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasCards()
    {
        return count($this->get(self::CARDS)) !== 0;
    }

    /**
     * Returns 'cards' iterator
     *
     * @return \ArrayIterator
     */
    public function getCardsIterator()
    {
        return new \ArrayIterator($this->get(self::CARDS));
    }

    /**
     * Returns element from 'cards' list at given offset
     *
     * @param int $offset Position in list
     *
     * @return integer
     */
    public function getCardsAt($offset)
    {
        return $this->get(self::CARDS, $offset);
    }

    /**
     * Returns count of 'cards' list
     *
     * @return int
     */
    public function getCardsCount()
    {
        return $this->count(self::CARDS);
    }

    /**
     * Sets value of 'seed_before' property
     *
     * @param string $value Property value
     *
     * @return null
     */
    public function setSeedBefore($value)
    {
        return $this->set(self::SEED_BEFORE, $value);
    }

    /**
     * Returns value of 'seed_before' property
     *
     * @return string
     */
    public function getSeedBefore()
    {
        $value = $this->get(self::SEED_BEFORE);
        return $value === null ? (string)$value : $value;
    }

    /**
     * Returns true if 'seed_before' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasSeedBefore()
    {
        return $this->get(self::SEED_BEFORE) !== null;
    }

    /**
     * Sets value of 'seed_hash_next' property
     *
     * @param string $value Property value
     *
     * @return null
     */
    public function setSeedHashNext($value)
    {
        return $this->set(self::SEED_HASH_NEXT, $value);
    }

    /**
     * Returns value of 'seed_hash_next' property
     *
     * @return string
     */
    public function getSeedHashNext()
    {
        $value = $this->get(self::SEED_HASH_NEXT);
        return $value === null ? (string)$value : $value;
    }

    /**
     * Returns true if 'seed_hash_next' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasSeedHashNext()
    {
        return $this->get(self::SEED_HASH_NEXT) !== null;
    }

    /**
     * Sets value of 'pay_out_0' property
     *
     * @param double $value Property value
     *
     * @return null
     */
    public function setPayOut0($value)
    {
        return $this->set(self::PAY_OUT_0, $value);
    }

    /**
     * Returns value of 'pay_out_0' property
     *
     * @return double
     */
    public function getPayOut0()
    {
        $value = $this->get(self::PAY_OUT_0);
        return $value === null ? (double)$value : $value;
    }

    /**
     * Returns true if 'pay_out_0' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasPayOut0()
    {
        return $this->get(self::PAY_OUT_0) !== null;
    }

    /**
     * Sets value of 'pay_out_1' property
     *
     * @param double $value Property value
     *
     * @return null
     */
    public function setPayOut1($value)
    {
        return $this->set(self::PAY_OUT_1, $value);
    }

    /**
     * Returns value of 'pay_out_1' property
     *
     * @return double
     */
    public function getPayOut1()
    {
        $value = $this->get(self::PAY_OUT_1);
        return $value === null ? (double)$value : $value;
    }

    /**
     * Returns true if 'pay_out_1' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasPayOut1()
    {
        return $this->get(self::PAY_OUT_1) !== null;
    }

    /**
     * Sets value of 'pay_out_end' property
     *
     * @param double $value Property value
     *
     * @return null
     */
    public function setPayOutEnd($value)
    {
        return $this->set(self::PAY_OUT_END, $value);
    }

    /**
     * Returns value of 'pay_out_end' property
     *
     * @return double
     */
    public function getPayOutEnd()
    {
        $value = $this->get(self::PAY_OUT_END);
        return $value === null ? (double)$value : $value;
    }

    /**
     * Returns true if 'pay_out_end' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasPayOutEnd()
    {
        return $this->get(self::PAY_OUT_END) !== null;
    }
}
}