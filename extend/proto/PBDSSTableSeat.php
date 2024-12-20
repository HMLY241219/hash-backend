<?php
/**
 * Auto generated from poker_msg_basic.proto at 2023-06-08 09:49:25
 */

namespace {
/**
 * PBDSSTableSeat message
 */
class PBDSSTableSeat extends \ProtobufMessage
{
    /* Field index constants */
    const USER = 1;
    const STATE = 2;
    const INDEX = 3;
    const HAND_CARDS = 4;
    const OUT_CARDS = 5;
    const TOTAL_SCORE = 6;
    const FINAL_SCORE = 7;
    const HU_XI = 8;
    const MULTIPLE = 9;
    const ACTION_CHOICE = 10;
    const OUT_COL = 11;
    const ACTION_TOKEN = 12;
    const IS_ROBOT_SORT_OUT = 13;
    const ROBOT_CHOICE_INDEX = 14;
    const END_LOOK_UID = 15;
    const SERVICE_SCORE = 16;
    const IS_LEAVE_ROOM = 17;
    const ENABLE_READY_STAMP = 18;
    const IS_TRUSTEESHIP = 19;
    const TRUSTEESHIP_NUM = 20;
    const GAME_NUM = 22;
    const HAND_COL_INFO = 23;
    const HISTORY_SCORES = 24;
    const SESSION_ID = 25;
    const AB_BET_SCORE = 26;
    const LOOK_CARD = 27;
    const BET_SCORE = 28;
    const FREE_NUM = 29;
    const ROTARY_NUM = 30;
    const LINE_NUM = 31;
    const ROTARY_PRIZE_NUM = 32;
    const NOW_JACK_POT = 33;
    const MIN_WIN_MULTIPLE = 34;
    const MAX_WIN_MULTIPLE = 35;
    const ANDROID_INFO = 125;
    const TRUSTEESHIP_CHU_PAI = 128;
    const FACE_INDEX = 129;
    const ROBOT_GAME_NUM = 130;
    const IS_HE_HUO = 105;

    /* @var array Field descriptors */
    protected static $fields = array(
        self::USER => array(
            'name' => 'user',
            'required' => false,
            'type' => '\PBTableUser'
        ),
        self::STATE => array(
            'name' => 'state',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_INT,
        ),
        self::INDEX => array(
            'name' => 'index',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_INT,
        ),
        self::HAND_CARDS => array(
            'name' => 'hand_cards',
            'repeated' => true,
            'type' => \ProtobufMessage::PB_TYPE_INT,
        ),
        self::OUT_CARDS => array(
            'name' => 'out_cards',
            'repeated' => true,
            'type' => \ProtobufMessage::PB_TYPE_INT,
        ),
        self::TOTAL_SCORE => array(
            'name' => 'total_score',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_INT,
        ),
        self::FINAL_SCORE => array(
            'name' => 'final_score',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_INT,
        ),
        self::HU_XI => array(
            'name' => 'hu_xi',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_INT,
        ),
        self::MULTIPLE => array(
            'name' => 'multiple',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_INT,
        ),
        self::ACTION_CHOICE => array(
            'name' => 'action_choice',
            'required' => false,
            'type' => '\PBDSSActionChoice'
        ),
        self::OUT_COL => array(
            'name' => 'out_col',
            'repeated' => true,
            'type' => '\PBDSSColumnInfo'
        ),
        self::ACTION_TOKEN => array(
            'name' => 'action_token',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_INT,
        ),
        self::IS_ROBOT_SORT_OUT => array(
            'name' => 'is_robot_sort_out',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_BOOL,
        ),
        self::ROBOT_CHOICE_INDEX => array(
            'name' => 'robot_choice_index',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_INT,
        ),
        self::END_LOOK_UID => array(
            'name' => 'end_look_uid',
            'repeated' => true,
            'type' => \ProtobufMessage::PB_TYPE_INT,
        ),
        self::SERVICE_SCORE => array(
            'name' => 'service_score',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_INT,
        ),
        self::IS_LEAVE_ROOM => array(
            'name' => 'is_leave_room',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_BOOL,
        ),
        self::ENABLE_READY_STAMP => array(
            'name' => 'enable_ready_stamp',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_INT,
        ),
        self::IS_TRUSTEESHIP => array(
            'name' => 'is_trusteeship',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_BOOL,
        ),
        self::TRUSTEESHIP_NUM => array(
            'name' => 'trusteeship_num',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_INT,
        ),
        self::GAME_NUM => array(
            'name' => 'game_num',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_INT,
        ),
        self::HAND_COL_INFO => array(
            'name' => 'hand_col_info',
            'required' => false,
            'type' => '\PBDSSColumnInfo'
        ),
        self::HISTORY_SCORES => array(
            'name' => 'history_scores',
            'repeated' => true,
            'type' => \ProtobufMessage::PB_TYPE_INT,
        ),
        self::SESSION_ID => array(
            'name' => 'session_id',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_INT,
        ),
        self::AB_BET_SCORE => array(
            'name' => 'ab_bet_score',
            'repeated' => true,
            'type' => \ProtobufMessage::PB_TYPE_INT,
        ),
        self::LOOK_CARD => array(
            'name' => 'look_card',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_BOOL,
        ),
        self::BET_SCORE => array(
            'name' => 'bet_score',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_INT,
        ),
        self::FREE_NUM => array(
            'name' => 'free_num',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_INT,
        ),
        self::ROTARY_NUM => array(
            'name' => 'rotary_num',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_INT,
        ),
        self::LINE_NUM => array(
            'name' => 'line_num',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_INT,
        ),
        self::ROTARY_PRIZE_NUM => array(
            'name' => 'rotary_prize_num',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_INT,
        ),
        self::NOW_JACK_POT => array(
            'name' => 'now_jack_pot',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_INT,
        ),
        self::MIN_WIN_MULTIPLE => array(
            'name' => 'min_win_multiple',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_INT,
        ),
        self::MAX_WIN_MULTIPLE => array(
            'name' => 'max_win_multiple',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_INT,
        ),
        self::ANDROID_INFO => array(
            'name' => 'android_info',
            'required' => false,
            'type' => '\PBAndroid'
        ),
        self::TRUSTEESHIP_CHU_PAI => array(
            'name' => 'trusteeship_chu_pai',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_INT,
        ),
        self::FACE_INDEX => array(
            'name' => 'face_index',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_INT,
        ),
        self::ROBOT_GAME_NUM => array(
            'name' => 'robot_game_num',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_INT,
        ),
        self::IS_HE_HUO => array(
            'name' => 'is_he_huo',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_BOOL,
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
        $this->values[self::USER] = null;
        $this->values[self::STATE] = null;
        $this->values[self::INDEX] = null;
        $this->values[self::HAND_CARDS] = array();
        $this->values[self::OUT_CARDS] = array();
        $this->values[self::TOTAL_SCORE] = null;
        $this->values[self::FINAL_SCORE] = null;
        $this->values[self::HU_XI] = null;
        $this->values[self::MULTIPLE] = null;
        $this->values[self::ACTION_CHOICE] = null;
        $this->values[self::OUT_COL] = array();
        $this->values[self::ACTION_TOKEN] = null;
        $this->values[self::IS_ROBOT_SORT_OUT] = null;
        $this->values[self::ROBOT_CHOICE_INDEX] = null;
        $this->values[self::END_LOOK_UID] = array();
        $this->values[self::SERVICE_SCORE] = null;
        $this->values[self::IS_LEAVE_ROOM] = null;
        $this->values[self::ENABLE_READY_STAMP] = null;
        $this->values[self::IS_TRUSTEESHIP] = null;
        $this->values[self::TRUSTEESHIP_NUM] = null;
        $this->values[self::GAME_NUM] = null;
        $this->values[self::HAND_COL_INFO] = null;
        $this->values[self::HISTORY_SCORES] = array();
        $this->values[self::SESSION_ID] = null;
        $this->values[self::AB_BET_SCORE] = array();
        $this->values[self::LOOK_CARD] = null;
        $this->values[self::BET_SCORE] = null;
        $this->values[self::FREE_NUM] = null;
        $this->values[self::ROTARY_NUM] = null;
        $this->values[self::LINE_NUM] = null;
        $this->values[self::ROTARY_PRIZE_NUM] = null;
        $this->values[self::NOW_JACK_POT] = null;
        $this->values[self::MIN_WIN_MULTIPLE] = null;
        $this->values[self::MAX_WIN_MULTIPLE] = null;
        $this->values[self::ANDROID_INFO] = null;
        $this->values[self::TRUSTEESHIP_CHU_PAI] = null;
        $this->values[self::FACE_INDEX] = null;
        $this->values[self::ROBOT_GAME_NUM] = null;
        $this->values[self::IS_HE_HUO] = null;
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
     * Sets value of 'user' property
     *
     * @param \PBTableUser $value Property value
     *
     * @return null
     */
    public function setUser(\PBTableUser $value=null)
    {
        return $this->set(self::USER, $value);
    }

    /**
     * Returns value of 'user' property
     *
     * @return \PBTableUser
     */
    public function getUser()
    {
        return $this->get(self::USER);
    }

    /**
     * Returns true if 'user' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasUser()
    {
        return $this->get(self::USER) !== null;
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
     * Sets value of 'index' property
     *
     * @param integer $value Property value
     *
     * @return null
     */
    public function setIndex($value)
    {
        return $this->set(self::INDEX, $value);
    }

    /**
     * Returns value of 'index' property
     *
     * @return integer
     */
    public function getIndex()
    {
        $value = $this->get(self::INDEX);
        return $value === null ? (integer)$value : $value;
    }

    /**
     * Returns true if 'index' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasIndex()
    {
        return $this->get(self::INDEX) !== null;
    }

    /**
     * Appends value to 'hand_cards' list
     *
     * @param integer $value Value to append
     *
     * @return null
     */
    public function appendHandCards($value)
    {
        return $this->append(self::HAND_CARDS, $value);
    }

    /**
     * Clears 'hand_cards' list
     *
     * @return null
     */
    public function clearHandCards()
    {
        return $this->clear(self::HAND_CARDS);
    }

    /**
     * Returns 'hand_cards' list
     *
     * @return integer[]
     */
    public function getHandCards()
    {
        return $this->get(self::HAND_CARDS);
    }

    /**
     * Returns true if 'hand_cards' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasHandCards()
    {
        return count($this->get(self::HAND_CARDS)) !== 0;
    }

    /**
     * Returns 'hand_cards' iterator
     *
     * @return \ArrayIterator
     */
    public function getHandCardsIterator()
    {
        return new \ArrayIterator($this->get(self::HAND_CARDS));
    }

    /**
     * Returns element from 'hand_cards' list at given offset
     *
     * @param int $offset Position in list
     *
     * @return integer
     */
    public function getHandCardsAt($offset)
    {
        return $this->get(self::HAND_CARDS, $offset);
    }

    /**
     * Returns count of 'hand_cards' list
     *
     * @return int
     */
    public function getHandCardsCount()
    {
        return $this->count(self::HAND_CARDS);
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
     * Sets value of 'hu_xi' property
     *
     * @param integer $value Property value
     *
     * @return null
     */
    public function setHuXi($value)
    {
        return $this->set(self::HU_XI, $value);
    }

    /**
     * Returns value of 'hu_xi' property
     *
     * @return integer
     */
    public function getHuXi()
    {
        $value = $this->get(self::HU_XI);
        return $value === null ? (integer)$value : $value;
    }

    /**
     * Returns true if 'hu_xi' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasHuXi()
    {
        return $this->get(self::HU_XI) !== null;
    }

    /**
     * Sets value of 'multiple' property
     *
     * @param integer $value Property value
     *
     * @return null
     */
    public function setMultiple($value)
    {
        return $this->set(self::MULTIPLE, $value);
    }

    /**
     * Returns value of 'multiple' property
     *
     * @return integer
     */
    public function getMultiple()
    {
        $value = $this->get(self::MULTIPLE);
        return $value === null ? (integer)$value : $value;
    }

    /**
     * Returns true if 'multiple' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasMultiple()
    {
        return $this->get(self::MULTIPLE) !== null;
    }

    /**
     * Sets value of 'action_choice' property
     *
     * @param \PBDSSActionChoice $value Property value
     *
     * @return null
     */
    public function setActionChoice(\PBDSSActionChoice $value=null)
    {
        return $this->set(self::ACTION_CHOICE, $value);
    }

    /**
     * Returns value of 'action_choice' property
     *
     * @return \PBDSSActionChoice
     */
    public function getActionChoice()
    {
        return $this->get(self::ACTION_CHOICE);
    }

    /**
     * Returns true if 'action_choice' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasActionChoice()
    {
        return $this->get(self::ACTION_CHOICE) !== null;
    }

    /**
     * Appends value to 'out_col' list
     *
     * @param \PBDSSColumnInfo $value Value to append
     *
     * @return null
     */
    public function appendOutCol(\PBDSSColumnInfo $value)
    {
        return $this->append(self::OUT_COL, $value);
    }

    /**
     * Clears 'out_col' list
     *
     * @return null
     */
    public function clearOutCol()
    {
        return $this->clear(self::OUT_COL);
    }

    /**
     * Returns 'out_col' list
     *
     * @return \PBDSSColumnInfo[]
     */
    public function getOutCol()
    {
        return $this->get(self::OUT_COL);
    }

    /**
     * Returns true if 'out_col' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasOutCol()
    {
        return count($this->get(self::OUT_COL)) !== 0;
    }

    /**
     * Returns 'out_col' iterator
     *
     * @return \ArrayIterator
     */
    public function getOutColIterator()
    {
        return new \ArrayIterator($this->get(self::OUT_COL));
    }

    /**
     * Returns element from 'out_col' list at given offset
     *
     * @param int $offset Position in list
     *
     * @return \PBDSSColumnInfo
     */
    public function getOutColAt($offset)
    {
        return $this->get(self::OUT_COL, $offset);
    }

    /**
     * Returns count of 'out_col' list
     *
     * @return int
     */
    public function getOutColCount()
    {
        return $this->count(self::OUT_COL);
    }

    /**
     * Sets value of 'action_token' property
     *
     * @param integer $value Property value
     *
     * @return null
     */
    public function setActionToken($value)
    {
        return $this->set(self::ACTION_TOKEN, $value);
    }

    /**
     * Returns value of 'action_token' property
     *
     * @return integer
     */
    public function getActionToken()
    {
        $value = $this->get(self::ACTION_TOKEN);
        return $value === null ? (integer)$value : $value;
    }

    /**
     * Returns true if 'action_token' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasActionToken()
    {
        return $this->get(self::ACTION_TOKEN) !== null;
    }

    /**
     * Sets value of 'is_robot_sort_out' property
     *
     * @param boolean $value Property value
     *
     * @return null
     */
    public function setIsRobotSortOut($value)
    {
        return $this->set(self::IS_ROBOT_SORT_OUT, $value);
    }

    /**
     * Returns value of 'is_robot_sort_out' property
     *
     * @return boolean
     */
    public function getIsRobotSortOut()
    {
        $value = $this->get(self::IS_ROBOT_SORT_OUT);
        return $value === null ? (boolean)$value : $value;
    }

    /**
     * Returns true if 'is_robot_sort_out' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasIsRobotSortOut()
    {
        return $this->get(self::IS_ROBOT_SORT_OUT) !== null;
    }

    /**
     * Sets value of 'robot_choice_index' property
     *
     * @param integer $value Property value
     *
     * @return null
     */
    public function setRobotChoiceIndex($value)
    {
        return $this->set(self::ROBOT_CHOICE_INDEX, $value);
    }

    /**
     * Returns value of 'robot_choice_index' property
     *
     * @return integer
     */
    public function getRobotChoiceIndex()
    {
        $value = $this->get(self::ROBOT_CHOICE_INDEX);
        return $value === null ? (integer)$value : $value;
    }

    /**
     * Returns true if 'robot_choice_index' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasRobotChoiceIndex()
    {
        return $this->get(self::ROBOT_CHOICE_INDEX) !== null;
    }

    /**
     * Appends value to 'end_look_uid' list
     *
     * @param integer $value Value to append
     *
     * @return null
     */
    public function appendEndLookUid($value)
    {
        return $this->append(self::END_LOOK_UID, $value);
    }

    /**
     * Clears 'end_look_uid' list
     *
     * @return null
     */
    public function clearEndLookUid()
    {
        return $this->clear(self::END_LOOK_UID);
    }

    /**
     * Returns 'end_look_uid' list
     *
     * @return integer[]
     */
    public function getEndLookUid()
    {
        return $this->get(self::END_LOOK_UID);
    }

    /**
     * Returns true if 'end_look_uid' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasEndLookUid()
    {
        return count($this->get(self::END_LOOK_UID)) !== 0;
    }

    /**
     * Returns 'end_look_uid' iterator
     *
     * @return \ArrayIterator
     */
    public function getEndLookUidIterator()
    {
        return new \ArrayIterator($this->get(self::END_LOOK_UID));
    }

    /**
     * Returns element from 'end_look_uid' list at given offset
     *
     * @param int $offset Position in list
     *
     * @return integer
     */
    public function getEndLookUidAt($offset)
    {
        return $this->get(self::END_LOOK_UID, $offset);
    }

    /**
     * Returns count of 'end_look_uid' list
     *
     * @return int
     */
    public function getEndLookUidCount()
    {
        return $this->count(self::END_LOOK_UID);
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
     * Sets value of 'is_leave_room' property
     *
     * @param boolean $value Property value
     *
     * @return null
     */
    public function setIsLeaveRoom($value)
    {
        return $this->set(self::IS_LEAVE_ROOM, $value);
    }

    /**
     * Returns value of 'is_leave_room' property
     *
     * @return boolean
     */
    public function getIsLeaveRoom()
    {
        $value = $this->get(self::IS_LEAVE_ROOM);
        return $value === null ? (boolean)$value : $value;
    }

    /**
     * Returns true if 'is_leave_room' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasIsLeaveRoom()
    {
        return $this->get(self::IS_LEAVE_ROOM) !== null;
    }

    /**
     * Sets value of 'enable_ready_stamp' property
     *
     * @param integer $value Property value
     *
     * @return null
     */
    public function setEnableReadyStamp($value)
    {
        return $this->set(self::ENABLE_READY_STAMP, $value);
    }

    /**
     * Returns value of 'enable_ready_stamp' property
     *
     * @return integer
     */
    public function getEnableReadyStamp()
    {
        $value = $this->get(self::ENABLE_READY_STAMP);
        return $value === null ? (integer)$value : $value;
    }

    /**
     * Returns true if 'enable_ready_stamp' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasEnableReadyStamp()
    {
        return $this->get(self::ENABLE_READY_STAMP) !== null;
    }

    /**
     * Sets value of 'is_trusteeship' property
     *
     * @param boolean $value Property value
     *
     * @return null
     */
    public function setIsTrusteeship($value)
    {
        return $this->set(self::IS_TRUSTEESHIP, $value);
    }

    /**
     * Returns value of 'is_trusteeship' property
     *
     * @return boolean
     */
    public function getIsTrusteeship()
    {
        $value = $this->get(self::IS_TRUSTEESHIP);
        return $value === null ? (boolean)$value : $value;
    }

    /**
     * Returns true if 'is_trusteeship' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasIsTrusteeship()
    {
        return $this->get(self::IS_TRUSTEESHIP) !== null;
    }

    /**
     * Sets value of 'trusteeship_num' property
     *
     * @param integer $value Property value
     *
     * @return null
     */
    public function setTrusteeshipNum($value)
    {
        return $this->set(self::TRUSTEESHIP_NUM, $value);
    }

    /**
     * Returns value of 'trusteeship_num' property
     *
     * @return integer
     */
    public function getTrusteeshipNum()
    {
        $value = $this->get(self::TRUSTEESHIP_NUM);
        return $value === null ? (integer)$value : $value;
    }

    /**
     * Returns true if 'trusteeship_num' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasTrusteeshipNum()
    {
        return $this->get(self::TRUSTEESHIP_NUM) !== null;
    }

    /**
     * Sets value of 'game_num' property
     *
     * @param integer $value Property value
     *
     * @return null
     */
    public function setGameNum($value)
    {
        return $this->set(self::GAME_NUM, $value);
    }

    /**
     * Returns value of 'game_num' property
     *
     * @return integer
     */
    public function getGameNum()
    {
        $value = $this->get(self::GAME_NUM);
        return $value === null ? (integer)$value : $value;
    }

    /**
     * Returns true if 'game_num' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasGameNum()
    {
        return $this->get(self::GAME_NUM) !== null;
    }

    /**
     * Sets value of 'hand_col_info' property
     *
     * @param \PBDSSColumnInfo $value Property value
     *
     * @return null
     */
    public function setHandColInfo(\PBDSSColumnInfo $value=null)
    {
        return $this->set(self::HAND_COL_INFO, $value);
    }

    /**
     * Returns value of 'hand_col_info' property
     *
     * @return \PBDSSColumnInfo
     */
    public function getHandColInfo()
    {
        return $this->get(self::HAND_COL_INFO);
    }

    /**
     * Returns true if 'hand_col_info' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasHandColInfo()
    {
        return $this->get(self::HAND_COL_INFO) !== null;
    }

    /**
     * Appends value to 'history_scores' list
     *
     * @param integer $value Value to append
     *
     * @return null
     */
    public function appendHistoryScores($value)
    {
        return $this->append(self::HISTORY_SCORES, $value);
    }

    /**
     * Clears 'history_scores' list
     *
     * @return null
     */
    public function clearHistoryScores()
    {
        return $this->clear(self::HISTORY_SCORES);
    }

    /**
     * Returns 'history_scores' list
     *
     * @return integer[]
     */
    public function getHistoryScores()
    {
        return $this->get(self::HISTORY_SCORES);
    }

    /**
     * Returns true if 'history_scores' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasHistoryScores()
    {
        return count($this->get(self::HISTORY_SCORES)) !== 0;
    }

    /**
     * Returns 'history_scores' iterator
     *
     * @return \ArrayIterator
     */
    public function getHistoryScoresIterator()
    {
        return new \ArrayIterator($this->get(self::HISTORY_SCORES));
    }

    /**
     * Returns element from 'history_scores' list at given offset
     *
     * @param int $offset Position in list
     *
     * @return integer
     */
    public function getHistoryScoresAt($offset)
    {
        return $this->get(self::HISTORY_SCORES, $offset);
    }

    /**
     * Returns count of 'history_scores' list
     *
     * @return int
     */
    public function getHistoryScoresCount()
    {
        return $this->count(self::HISTORY_SCORES);
    }

    /**
     * Sets value of 'session_id' property
     *
     * @param integer $value Property value
     *
     * @return null
     */
    public function setSessionId($value)
    {
        return $this->set(self::SESSION_ID, $value);
    }

    /**
     * Returns value of 'session_id' property
     *
     * @return integer
     */
    public function getSessionId()
    {
        $value = $this->get(self::SESSION_ID);
        return $value === null ? (integer)$value : $value;
    }

    /**
     * Returns true if 'session_id' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasSessionId()
    {
        return $this->get(self::SESSION_ID) !== null;
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
     * Sets value of 'free_num' property
     *
     * @param integer $value Property value
     *
     * @return null
     */
    public function setFreeNum($value)
    {
        return $this->set(self::FREE_NUM, $value);
    }

    /**
     * Returns value of 'free_num' property
     *
     * @return integer
     */
    public function getFreeNum()
    {
        $value = $this->get(self::FREE_NUM);
        return $value === null ? (integer)$value : $value;
    }

    /**
     * Returns true if 'free_num' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasFreeNum()
    {
        return $this->get(self::FREE_NUM) !== null;
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
     * Sets value of 'line_num' property
     *
     * @param integer $value Property value
     *
     * @return null
     */
    public function setLineNum($value)
    {
        return $this->set(self::LINE_NUM, $value);
    }

    /**
     * Returns value of 'line_num' property
     *
     * @return integer
     */
    public function getLineNum()
    {
        $value = $this->get(self::LINE_NUM);
        return $value === null ? (integer)$value : $value;
    }

    /**
     * Returns true if 'line_num' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasLineNum()
    {
        return $this->get(self::LINE_NUM) !== null;
    }

    /**
     * Sets value of 'rotary_prize_num' property
     *
     * @param integer $value Property value
     *
     * @return null
     */
    public function setRotaryPrizeNum($value)
    {
        return $this->set(self::ROTARY_PRIZE_NUM, $value);
    }

    /**
     * Returns value of 'rotary_prize_num' property
     *
     * @return integer
     */
    public function getRotaryPrizeNum()
    {
        $value = $this->get(self::ROTARY_PRIZE_NUM);
        return $value === null ? (integer)$value : $value;
    }

    /**
     * Returns true if 'rotary_prize_num' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasRotaryPrizeNum()
    {
        return $this->get(self::ROTARY_PRIZE_NUM) !== null;
    }

    /**
     * Sets value of 'now_jack_pot' property
     *
     * @param integer $value Property value
     *
     * @return null
     */
    public function setNowJackPot($value)
    {
        return $this->set(self::NOW_JACK_POT, $value);
    }

    /**
     * Returns value of 'now_jack_pot' property
     *
     * @return integer
     */
    public function getNowJackPot()
    {
        $value = $this->get(self::NOW_JACK_POT);
        return $value === null ? (integer)$value : $value;
    }

    /**
     * Returns true if 'now_jack_pot' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasNowJackPot()
    {
        return $this->get(self::NOW_JACK_POT) !== null;
    }

    /**
     * Sets value of 'min_win_multiple' property
     *
     * @param integer $value Property value
     *
     * @return null
     */
    public function setMinWinMultiple($value)
    {
        return $this->set(self::MIN_WIN_MULTIPLE, $value);
    }

    /**
     * Returns value of 'min_win_multiple' property
     *
     * @return integer
     */
    public function getMinWinMultiple()
    {
        $value = $this->get(self::MIN_WIN_MULTIPLE);
        return $value === null ? (integer)$value : $value;
    }

    /**
     * Returns true if 'min_win_multiple' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasMinWinMultiple()
    {
        return $this->get(self::MIN_WIN_MULTIPLE) !== null;
    }

    /**
     * Sets value of 'max_win_multiple' property
     *
     * @param integer $value Property value
     *
     * @return null
     */
    public function setMaxWinMultiple($value)
    {
        return $this->set(self::MAX_WIN_MULTIPLE, $value);
    }

    /**
     * Returns value of 'max_win_multiple' property
     *
     * @return integer
     */
    public function getMaxWinMultiple()
    {
        $value = $this->get(self::MAX_WIN_MULTIPLE);
        return $value === null ? (integer)$value : $value;
    }

    /**
     * Returns true if 'max_win_multiple' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasMaxWinMultiple()
    {
        return $this->get(self::MAX_WIN_MULTIPLE) !== null;
    }

    /**
     * Sets value of 'android_info' property
     *
     * @param \PBAndroid $value Property value
     *
     * @return null
     */
    public function setAndroidInfo(\PBAndroid $value=null)
    {
        return $this->set(self::ANDROID_INFO, $value);
    }

    /**
     * Returns value of 'android_info' property
     *
     * @return \PBAndroid
     */
    public function getAndroidInfo()
    {
        return $this->get(self::ANDROID_INFO);
    }

    /**
     * Returns true if 'android_info' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasAndroidInfo()
    {
        return $this->get(self::ANDROID_INFO) !== null;
    }

    /**
     * Sets value of 'trusteeship_chu_pai' property
     *
     * @param integer $value Property value
     *
     * @return null
     */
    public function setTrusteeshipChuPai($value)
    {
        return $this->set(self::TRUSTEESHIP_CHU_PAI, $value);
    }

    /**
     * Returns value of 'trusteeship_chu_pai' property
     *
     * @return integer
     */
    public function getTrusteeshipChuPai()
    {
        $value = $this->get(self::TRUSTEESHIP_CHU_PAI);
        return $value === null ? (integer)$value : $value;
    }

    /**
     * Returns true if 'trusteeship_chu_pai' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasTrusteeshipChuPai()
    {
        return $this->get(self::TRUSTEESHIP_CHU_PAI) !== null;
    }

    /**
     * Sets value of 'face_index' property
     *
     * @param integer $value Property value
     *
     * @return null
     */
    public function setFaceIndex($value)
    {
        return $this->set(self::FACE_INDEX, $value);
    }

    /**
     * Returns value of 'face_index' property
     *
     * @return integer
     */
    public function getFaceIndex()
    {
        $value = $this->get(self::FACE_INDEX);
        return $value === null ? (integer)$value : $value;
    }

    /**
     * Returns true if 'face_index' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasFaceIndex()
    {
        return $this->get(self::FACE_INDEX) !== null;
    }

    /**
     * Sets value of 'robot_game_num' property
     *
     * @param integer $value Property value
     *
     * @return null
     */
    public function setRobotGameNum($value)
    {
        return $this->set(self::ROBOT_GAME_NUM, $value);
    }

    /**
     * Returns value of 'robot_game_num' property
     *
     * @return integer
     */
    public function getRobotGameNum()
    {
        $value = $this->get(self::ROBOT_GAME_NUM);
        return $value === null ? (integer)$value : $value;
    }

    /**
     * Returns true if 'robot_game_num' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasRobotGameNum()
    {
        return $this->get(self::ROBOT_GAME_NUM) !== null;
    }

    /**
     * Sets value of 'is_he_huo' property
     *
     * @param boolean $value Property value
     *
     * @return null
     */
    public function setIsHeHuo($value)
    {
        return $this->set(self::IS_HE_HUO, $value);
    }

    /**
     * Returns value of 'is_he_huo' property
     *
     * @return boolean
     */
    public function getIsHeHuo()
    {
        $value = $this->get(self::IS_HE_HUO);
        return $value === null ? (boolean)$value : $value;
    }

    /**
     * Returns true if 'is_he_huo' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasIsHeHuo()
    {
        return $this->get(self::IS_HE_HUO) !== null;
    }
}
}