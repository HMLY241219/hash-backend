<?php
/**
 * Auto generated from poker_msg_basic.proto at 2023-06-08 09:49:25
 */

namespace {
/**
 * PBDSSGameTable message
 */
class PBDSSGameTable extends \ProtobufMessage
{
    /* Field index constants */
    const TID = 1;
    const SEATS = 2;
    const DEALER_INDEX = 3;
    const CONFIG = 4;
    const STATE = 5;
    const CREATOR_UID = 6;
    const ROUND = 7;
    const CARDS = 8;
    const OPERATION_INDEX = 9;
    const TOTAL_ACTION_FLOWS = 10;
    const REPLAY_ACTION_FLOWS = 11;
    const MAX_PRE_CHOICE = 12;
    const COMMON_CARD = 13;
    const LAST_WINNER = 14;
    const IS_GAME_OVER = 15;
    const IS_DISSOLVE_FINISH = 16;
    const MAX_HU_INDEX = 17;
    const OUT_CARDS = 18;
    const START_TIME = 19;
    const OPERATE_LIMIT_TIMESTAMP = 20;
    const JOKER_CARD = 21;
    const NOW_MULTIPLE = 22;
    const TABLE_NOW_MULTIPLE = 23;
    const HISTORY_INFO = 24;
    const HISTORY_AB = 25;
    const AB_BET_SCORE = 26;
    const IS_TABLE_CARD_END = 101;
    const LAST_TIME = 102;
    const LAST_LONG = 103;
    const NA_PAI_TIMER = 104;
    const ALL_REWARD = 105;
    const ROBOT_FACE_INDEX = 106;

    /* @var array Field descriptors */
    protected static $fields = array(
        self::TID => array(
            'name' => 'tid',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_INT,
        ),
        self::SEATS => array(
            'name' => 'seats',
            'repeated' => true,
            'type' => '\PBDSSTableSeat'
        ),
        self::DEALER_INDEX => array(
            'name' => 'dealer_index',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_INT,
        ),
        self::CONFIG => array(
            'name' => 'config',
            'required' => false,
            'type' => '\PBDSSTableConfig'
        ),
        self::STATE => array(
            'name' => 'state',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_INT,
        ),
        self::CREATOR_UID => array(
            'name' => 'creator_uid',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_INT,
        ),
        self::ROUND => array(
            'name' => 'round',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_INT,
        ),
        self::CARDS => array(
            'name' => 'cards',
            'repeated' => true,
            'type' => \ProtobufMessage::PB_TYPE_INT,
        ),
        self::OPERATION_INDEX => array(
            'name' => 'operation_index',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_INT,
        ),
        self::TOTAL_ACTION_FLOWS => array(
            'name' => 'total_action_flows',
            'repeated' => true,
            'type' => '\PBDSSActionFlow'
        ),
        self::REPLAY_ACTION_FLOWS => array(
            'name' => 'replay_action_flows',
            'repeated' => true,
            'type' => '\PBDSSActionFlow'
        ),
        self::MAX_PRE_CHOICE => array(
            'name' => 'max_pre_choice',
            'required' => false,
            'type' => '\PBDSSActionChoice'
        ),
        self::COMMON_CARD => array(
            'name' => 'common_card',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_INT,
        ),
        self::LAST_WINNER => array(
            'name' => 'last_winner',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_INT,
        ),
        self::IS_GAME_OVER => array(
            'name' => 'is_game_over',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_BOOL,
        ),
        self::IS_DISSOLVE_FINISH => array(
            'name' => 'is_dissolve_finish',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_BOOL,
        ),
        self::MAX_HU_INDEX => array(
            'name' => 'max_hu_index',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_INT,
        ),
        self::OUT_CARDS => array(
            'name' => 'out_cards',
            'repeated' => true,
            'type' => \ProtobufMessage::PB_TYPE_INT,
        ),
        self::START_TIME => array(
            'name' => 'start_time',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_INT,
        ),
        self::OPERATE_LIMIT_TIMESTAMP => array(
            'name' => 'operate_limit_timestamp',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_INT,
        ),
        self::JOKER_CARD => array(
            'name' => 'joker_card',
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
        self::IS_TABLE_CARD_END => array(
            'name' => 'is_table_card_end',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_INT,
        ),
        self::LAST_TIME => array(
            'name' => 'last_time',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_INT,
        ),
        self::LAST_LONG => array(
            'name' => 'last_long',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_INT,
        ),
        self::NA_PAI_TIMER => array(
            'name' => 'na_pai_timer',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_INT,
        ),
        self::ALL_REWARD => array(
            'name' => 'all_reward',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_INT,
        ),
        self::ROBOT_FACE_INDEX => array(
            'name' => 'robot_face_index',
            'repeated' => true,
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
        $this->values[self::TID] = null;
        $this->values[self::SEATS] = array();
        $this->values[self::DEALER_INDEX] = null;
        $this->values[self::CONFIG] = null;
        $this->values[self::STATE] = null;
        $this->values[self::CREATOR_UID] = null;
        $this->values[self::ROUND] = null;
        $this->values[self::CARDS] = array();
        $this->values[self::OPERATION_INDEX] = null;
        $this->values[self::TOTAL_ACTION_FLOWS] = array();
        $this->values[self::REPLAY_ACTION_FLOWS] = array();
        $this->values[self::MAX_PRE_CHOICE] = null;
        $this->values[self::COMMON_CARD] = null;
        $this->values[self::LAST_WINNER] = null;
        $this->values[self::IS_GAME_OVER] = null;
        $this->values[self::IS_DISSOLVE_FINISH] = null;
        $this->values[self::MAX_HU_INDEX] = null;
        $this->values[self::OUT_CARDS] = array();
        $this->values[self::START_TIME] = null;
        $this->values[self::OPERATE_LIMIT_TIMESTAMP] = null;
        $this->values[self::JOKER_CARD] = null;
        $this->values[self::NOW_MULTIPLE] = null;
        $this->values[self::TABLE_NOW_MULTIPLE] = null;
        $this->values[self::HISTORY_INFO] = array();
        $this->values[self::HISTORY_AB] = array();
        $this->values[self::AB_BET_SCORE] = array();
        $this->values[self::IS_TABLE_CARD_END] = null;
        $this->values[self::LAST_TIME] = null;
        $this->values[self::LAST_LONG] = null;
        $this->values[self::NA_PAI_TIMER] = null;
        $this->values[self::ALL_REWARD] = null;
        $this->values[self::ROBOT_FACE_INDEX] = array();
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
     * Appends value to 'seats' list
     *
     * @param \PBDSSTableSeat $value Value to append
     *
     * @return null
     */
    public function appendSeats(\PBDSSTableSeat $value)
    {
        return $this->append(self::SEATS, $value);
    }

    /**
     * Clears 'seats' list
     *
     * @return null
     */
    public function clearSeats()
    {
        return $this->clear(self::SEATS);
    }

    /**
     * Returns 'seats' list
     *
     * @return \PBDSSTableSeat[]
     */
    public function getSeats()
    {
        return $this->get(self::SEATS);
    }

    /**
     * Returns true if 'seats' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasSeats()
    {
        return count($this->get(self::SEATS)) !== 0;
    }

    /**
     * Returns 'seats' iterator
     *
     * @return \ArrayIterator
     */
    public function getSeatsIterator()
    {
        return new \ArrayIterator($this->get(self::SEATS));
    }

    /**
     * Returns element from 'seats' list at given offset
     *
     * @param int $offset Position in list
     *
     * @return \PBDSSTableSeat
     */
    public function getSeatsAt($offset)
    {
        return $this->get(self::SEATS, $offset);
    }

    /**
     * Returns count of 'seats' list
     *
     * @return int
     */
    public function getSeatsCount()
    {
        return $this->count(self::SEATS);
    }

    /**
     * Sets value of 'dealer_index' property
     *
     * @param integer $value Property value
     *
     * @return null
     */
    public function setDealerIndex($value)
    {
        return $this->set(self::DEALER_INDEX, $value);
    }

    /**
     * Returns value of 'dealer_index' property
     *
     * @return integer
     */
    public function getDealerIndex()
    {
        $value = $this->get(self::DEALER_INDEX);
        return $value === null ? (integer)$value : $value;
    }

    /**
     * Returns true if 'dealer_index' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasDealerIndex()
    {
        return $this->get(self::DEALER_INDEX) !== null;
    }

    /**
     * Sets value of 'config' property
     *
     * @param \PBDSSTableConfig $value Property value
     *
     * @return null
     */
    public function setConfig(\PBDSSTableConfig $value=null)
    {
        return $this->set(self::CONFIG, $value);
    }

    /**
     * Returns value of 'config' property
     *
     * @return \PBDSSTableConfig
     */
    public function getConfig()
    {
        return $this->get(self::CONFIG);
    }

    /**
     * Returns true if 'config' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasConfig()
    {
        return $this->get(self::CONFIG) !== null;
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
     * Appends value to 'total_action_flows' list
     *
     * @param \PBDSSActionFlow $value Value to append
     *
     * @return null
     */
    public function appendTotalActionFlows(\PBDSSActionFlow $value)
    {
        return $this->append(self::TOTAL_ACTION_FLOWS, $value);
    }

    /**
     * Clears 'total_action_flows' list
     *
     * @return null
     */
    public function clearTotalActionFlows()
    {
        return $this->clear(self::TOTAL_ACTION_FLOWS);
    }

    /**
     * Returns 'total_action_flows' list
     *
     * @return \PBDSSActionFlow[]
     */
    public function getTotalActionFlows()
    {
        return $this->get(self::TOTAL_ACTION_FLOWS);
    }

    /**
     * Returns true if 'total_action_flows' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasTotalActionFlows()
    {
        return count($this->get(self::TOTAL_ACTION_FLOWS)) !== 0;
    }

    /**
     * Returns 'total_action_flows' iterator
     *
     * @return \ArrayIterator
     */
    public function getTotalActionFlowsIterator()
    {
        return new \ArrayIterator($this->get(self::TOTAL_ACTION_FLOWS));
    }

    /**
     * Returns element from 'total_action_flows' list at given offset
     *
     * @param int $offset Position in list
     *
     * @return \PBDSSActionFlow
     */
    public function getTotalActionFlowsAt($offset)
    {
        return $this->get(self::TOTAL_ACTION_FLOWS, $offset);
    }

    /**
     * Returns count of 'total_action_flows' list
     *
     * @return int
     */
    public function getTotalActionFlowsCount()
    {
        return $this->count(self::TOTAL_ACTION_FLOWS);
    }

    /**
     * Appends value to 'replay_action_flows' list
     *
     * @param \PBDSSActionFlow $value Value to append
     *
     * @return null
     */
    public function appendReplayActionFlows(\PBDSSActionFlow $value)
    {
        return $this->append(self::REPLAY_ACTION_FLOWS, $value);
    }

    /**
     * Clears 'replay_action_flows' list
     *
     * @return null
     */
    public function clearReplayActionFlows()
    {
        return $this->clear(self::REPLAY_ACTION_FLOWS);
    }

    /**
     * Returns 'replay_action_flows' list
     *
     * @return \PBDSSActionFlow[]
     */
    public function getReplayActionFlows()
    {
        return $this->get(self::REPLAY_ACTION_FLOWS);
    }

    /**
     * Returns true if 'replay_action_flows' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasReplayActionFlows()
    {
        return count($this->get(self::REPLAY_ACTION_FLOWS)) !== 0;
    }

    /**
     * Returns 'replay_action_flows' iterator
     *
     * @return \ArrayIterator
     */
    public function getReplayActionFlowsIterator()
    {
        return new \ArrayIterator($this->get(self::REPLAY_ACTION_FLOWS));
    }

    /**
     * Returns element from 'replay_action_flows' list at given offset
     *
     * @param int $offset Position in list
     *
     * @return \PBDSSActionFlow
     */
    public function getReplayActionFlowsAt($offset)
    {
        return $this->get(self::REPLAY_ACTION_FLOWS, $offset);
    }

    /**
     * Returns count of 'replay_action_flows' list
     *
     * @return int
     */
    public function getReplayActionFlowsCount()
    {
        return $this->count(self::REPLAY_ACTION_FLOWS);
    }

    /**
     * Sets value of 'max_pre_choice' property
     *
     * @param \PBDSSActionChoice $value Property value
     *
     * @return null
     */
    public function setMaxPreChoice(\PBDSSActionChoice $value=null)
    {
        return $this->set(self::MAX_PRE_CHOICE, $value);
    }

    /**
     * Returns value of 'max_pre_choice' property
     *
     * @return \PBDSSActionChoice
     */
    public function getMaxPreChoice()
    {
        return $this->get(self::MAX_PRE_CHOICE);
    }

    /**
     * Returns true if 'max_pre_choice' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasMaxPreChoice()
    {
        return $this->get(self::MAX_PRE_CHOICE) !== null;
    }

    /**
     * Sets value of 'common_card' property
     *
     * @param integer $value Property value
     *
     * @return null
     */
    public function setCommonCard($value)
    {
        return $this->set(self::COMMON_CARD, $value);
    }

    /**
     * Returns value of 'common_card' property
     *
     * @return integer
     */
    public function getCommonCard()
    {
        $value = $this->get(self::COMMON_CARD);
        return $value === null ? (integer)$value : $value;
    }

    /**
     * Returns true if 'common_card' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasCommonCard()
    {
        return $this->get(self::COMMON_CARD) !== null;
    }

    /**
     * Sets value of 'last_winner' property
     *
     * @param integer $value Property value
     *
     * @return null
     */
    public function setLastWinner($value)
    {
        return $this->set(self::LAST_WINNER, $value);
    }

    /**
     * Returns value of 'last_winner' property
     *
     * @return integer
     */
    public function getLastWinner()
    {
        $value = $this->get(self::LAST_WINNER);
        return $value === null ? (integer)$value : $value;
    }

    /**
     * Returns true if 'last_winner' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasLastWinner()
    {
        return $this->get(self::LAST_WINNER) !== null;
    }

    /**
     * Sets value of 'is_game_over' property
     *
     * @param boolean $value Property value
     *
     * @return null
     */
    public function setIsGameOver($value)
    {
        return $this->set(self::IS_GAME_OVER, $value);
    }

    /**
     * Returns value of 'is_game_over' property
     *
     * @return boolean
     */
    public function getIsGameOver()
    {
        $value = $this->get(self::IS_GAME_OVER);
        return $value === null ? (boolean)$value : $value;
    }

    /**
     * Returns true if 'is_game_over' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasIsGameOver()
    {
        return $this->get(self::IS_GAME_OVER) !== null;
    }

    /**
     * Sets value of 'is_dissolve_finish' property
     *
     * @param boolean $value Property value
     *
     * @return null
     */
    public function setIsDissolveFinish($value)
    {
        return $this->set(self::IS_DISSOLVE_FINISH, $value);
    }

    /**
     * Returns value of 'is_dissolve_finish' property
     *
     * @return boolean
     */
    public function getIsDissolveFinish()
    {
        $value = $this->get(self::IS_DISSOLVE_FINISH);
        return $value === null ? (boolean)$value : $value;
    }

    /**
     * Returns true if 'is_dissolve_finish' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasIsDissolveFinish()
    {
        return $this->get(self::IS_DISSOLVE_FINISH) !== null;
    }

    /**
     * Sets value of 'max_hu_index' property
     *
     * @param integer $value Property value
     *
     * @return null
     */
    public function setMaxHuIndex($value)
    {
        return $this->set(self::MAX_HU_INDEX, $value);
    }

    /**
     * Returns value of 'max_hu_index' property
     *
     * @return integer
     */
    public function getMaxHuIndex()
    {
        $value = $this->get(self::MAX_HU_INDEX);
        return $value === null ? (integer)$value : $value;
    }

    /**
     * Returns true if 'max_hu_index' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasMaxHuIndex()
    {
        return $this->get(self::MAX_HU_INDEX) !== null;
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
     * Sets value of 'start_time' property
     *
     * @param integer $value Property value
     *
     * @return null
     */
    public function setStartTime($value)
    {
        return $this->set(self::START_TIME, $value);
    }

    /**
     * Returns value of 'start_time' property
     *
     * @return integer
     */
    public function getStartTime()
    {
        $value = $this->get(self::START_TIME);
        return $value === null ? (integer)$value : $value;
    }

    /**
     * Returns true if 'start_time' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasStartTime()
    {
        return $this->get(self::START_TIME) !== null;
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
     * Sets value of 'is_table_card_end' property
     *
     * @param integer $value Property value
     *
     * @return null
     */
    public function setIsTableCardEnd($value)
    {
        return $this->set(self::IS_TABLE_CARD_END, $value);
    }

    /**
     * Returns value of 'is_table_card_end' property
     *
     * @return integer
     */
    public function getIsTableCardEnd()
    {
        $value = $this->get(self::IS_TABLE_CARD_END);
        return $value === null ? (integer)$value : $value;
    }

    /**
     * Returns true if 'is_table_card_end' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasIsTableCardEnd()
    {
        return $this->get(self::IS_TABLE_CARD_END) !== null;
    }

    /**
     * Sets value of 'last_time' property
     *
     * @param integer $value Property value
     *
     * @return null
     */
    public function setLastTime($value)
    {
        return $this->set(self::LAST_TIME, $value);
    }

    /**
     * Returns value of 'last_time' property
     *
     * @return integer
     */
    public function getLastTime()
    {
        $value = $this->get(self::LAST_TIME);
        return $value === null ? (integer)$value : $value;
    }

    /**
     * Returns true if 'last_time' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasLastTime()
    {
        return $this->get(self::LAST_TIME) !== null;
    }

    /**
     * Sets value of 'last_long' property
     *
     * @param integer $value Property value
     *
     * @return null
     */
    public function setLastLong($value)
    {
        return $this->set(self::LAST_LONG, $value);
    }

    /**
     * Returns value of 'last_long' property
     *
     * @return integer
     */
    public function getLastLong()
    {
        $value = $this->get(self::LAST_LONG);
        return $value === null ? (integer)$value : $value;
    }

    /**
     * Returns true if 'last_long' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasLastLong()
    {
        return $this->get(self::LAST_LONG) !== null;
    }

    /**
     * Sets value of 'na_pai_timer' property
     *
     * @param integer $value Property value
     *
     * @return null
     */
    public function setNaPaiTimer($value)
    {
        return $this->set(self::NA_PAI_TIMER, $value);
    }

    /**
     * Returns value of 'na_pai_timer' property
     *
     * @return integer
     */
    public function getNaPaiTimer()
    {
        $value = $this->get(self::NA_PAI_TIMER);
        return $value === null ? (integer)$value : $value;
    }

    /**
     * Returns true if 'na_pai_timer' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasNaPaiTimer()
    {
        return $this->get(self::NA_PAI_TIMER) !== null;
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
     * Appends value to 'robot_face_index' list
     *
     * @param integer $value Value to append
     *
     * @return null
     */
    public function appendRobotFaceIndex($value)
    {
        return $this->append(self::ROBOT_FACE_INDEX, $value);
    }

    /**
     * Clears 'robot_face_index' list
     *
     * @return null
     */
    public function clearRobotFaceIndex()
    {
        return $this->clear(self::ROBOT_FACE_INDEX);
    }

    /**
     * Returns 'robot_face_index' list
     *
     * @return integer[]
     */
    public function getRobotFaceIndex()
    {
        return $this->get(self::ROBOT_FACE_INDEX);
    }

    /**
     * Returns true if 'robot_face_index' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasRobotFaceIndex()
    {
        return count($this->get(self::ROBOT_FACE_INDEX)) !== 0;
    }

    /**
     * Returns 'robot_face_index' iterator
     *
     * @return \ArrayIterator
     */
    public function getRobotFaceIndexIterator()
    {
        return new \ArrayIterator($this->get(self::ROBOT_FACE_INDEX));
    }

    /**
     * Returns element from 'robot_face_index' list at given offset
     *
     * @param int $offset Position in list
     *
     * @return integer
     */
    public function getRobotFaceIndexAt($offset)
    {
        return $this->get(self::ROBOT_FACE_INDEX, $offset);
    }

    /**
     * Returns count of 'robot_face_index' list
     *
     * @return int
     */
    public function getRobotFaceIndexCount()
    {
        return $this->count(self::ROBOT_FACE_INDEX);
    }
}
}