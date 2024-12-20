<?php
/**
 * Auto generated from poker_msg_basic.proto at 2023-06-08 09:49:25
 */

namespace {
/**
 * CSDssResult message
 */
class CSDssResult extends \ProtobufMessage
{
    /* Field index constants */
    const WINNER_INDEX = 1;
    const IS_FINISHED = 2;
    const PLAYERS = 3;
    const BOMB_NUM = 4;
    const CARDS = 5;
    const ACTIONS_FLOW = 6;
    const END_TIME = 7;
    const HISTORY_INFO = 8;
    const HISTORY_AB = 9;
    const WINNER_INDEX2 = 10;
    const SZ_REWARD = 11;
    const FRUIT_TYPE = 12;
    const FRUIT_SCORE = 13;
    const JACK_POT_SCORE = 14;
    const ROTARY_NUM = 15;
    const FREE_NUM = 16;
    const SEVER_JACK_POT_SCORE = 17;
    const SEED = 18;

    /* @var array Field descriptors */
    protected static $fields = array(
        self::WINNER_INDEX => array(
            'name' => 'winner_index',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_INT,
        ),
        self::IS_FINISHED => array(
            'name' => 'is_finished',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_BOOL,
        ),
        self::PLAYERS => array(
            'name' => 'players',
            'repeated' => true,
            'type' => '\CSDssPlayerInfo'
        ),
        self::BOMB_NUM => array(
            'name' => 'bomb_num',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_INT,
        ),
        self::CARDS => array(
            'name' => 'cards',
            'repeated' => true,
            'type' => \ProtobufMessage::PB_TYPE_INT,
        ),
        self::ACTIONS_FLOW => array(
            'name' => 'actions_flow',
            'repeated' => true,
            'type' => '\PBDSSActionFlow'
        ),
        self::END_TIME => array(
            'name' => 'end_time',
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
        self::WINNER_INDEX2 => array(
            'name' => 'winner_index2',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_INT,
        ),
        self::SZ_REWARD => array(
            'name' => 'sz_reward',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_INT,
        ),
        self::FRUIT_TYPE => array(
            'name' => 'fruit_type',
            'repeated' => true,
            'type' => \ProtobufMessage::PB_TYPE_INT,
        ),
        self::FRUIT_SCORE => array(
            'name' => 'fruit_score',
            'repeated' => true,
            'type' => \ProtobufMessage::PB_TYPE_INT,
        ),
        self::JACK_POT_SCORE => array(
            'name' => 'jack_pot_score',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_INT,
        ),
        self::ROTARY_NUM => array(
            'name' => 'rotary_num',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_INT,
        ),
        self::FREE_NUM => array(
            'name' => 'free_num',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_INT,
        ),
        self::SEVER_JACK_POT_SCORE => array(
            'name' => 'sever_jack_pot_score',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_INT,
        ),
        self::SEED => array(
            'name' => 'seed',
            'required' => false,
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
        $this->values[self::WINNER_INDEX] = null;
        $this->values[self::IS_FINISHED] = null;
        $this->values[self::PLAYERS] = array();
        $this->values[self::BOMB_NUM] = null;
        $this->values[self::CARDS] = array();
        $this->values[self::ACTIONS_FLOW] = array();
        $this->values[self::END_TIME] = null;
        $this->values[self::HISTORY_INFO] = array();
        $this->values[self::HISTORY_AB] = array();
        $this->values[self::WINNER_INDEX2] = null;
        $this->values[self::SZ_REWARD] = null;
        $this->values[self::FRUIT_TYPE] = array();
        $this->values[self::FRUIT_SCORE] = array();
        $this->values[self::JACK_POT_SCORE] = null;
        $this->values[self::ROTARY_NUM] = null;
        $this->values[self::FREE_NUM] = null;
        $this->values[self::SEVER_JACK_POT_SCORE] = null;
        $this->values[self::SEED] = null;
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
     * Sets value of 'winner_index' property
     *
     * @param integer $value Property value
     *
     * @return null
     */
    public function setWinnerIndex($value)
    {
        return $this->set(self::WINNER_INDEX, $value);
    }

    /**
     * Returns value of 'winner_index' property
     *
     * @return integer
     */
    public function getWinnerIndex()
    {
        $value = $this->get(self::WINNER_INDEX);
        return $value === null ? (integer)$value : $value;
    }

    /**
     * Returns true if 'winner_index' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasWinnerIndex()
    {
        return $this->get(self::WINNER_INDEX) !== null;
    }

    /**
     * Sets value of 'is_finished' property
     *
     * @param boolean $value Property value
     *
     * @return null
     */
    public function setIsFinished($value)
    {
        return $this->set(self::IS_FINISHED, $value);
    }

    /**
     * Returns value of 'is_finished' property
     *
     * @return boolean
     */
    public function getIsFinished()
    {
        $value = $this->get(self::IS_FINISHED);
        return $value === null ? (boolean)$value : $value;
    }

    /**
     * Returns true if 'is_finished' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasIsFinished()
    {
        return $this->get(self::IS_FINISHED) !== null;
    }

    /**
     * Appends value to 'players' list
     *
     * @param \CSDssPlayerInfo $value Value to append
     *
     * @return null
     */
    public function appendPlayers(\CSDssPlayerInfo $value)
    {
        return $this->append(self::PLAYERS, $value);
    }

    /**
     * Clears 'players' list
     *
     * @return null
     */
    public function clearPlayers()
    {
        return $this->clear(self::PLAYERS);
    }

    /**
     * Returns 'players' list
     *
     * @return \CSDssPlayerInfo[]
     */
    public function getPlayers()
    {
        return $this->get(self::PLAYERS);
    }

    /**
     * Returns true if 'players' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasPlayers()
    {
        return count($this->get(self::PLAYERS)) !== 0;
    }

    /**
     * Returns 'players' iterator
     *
     * @return \ArrayIterator
     */
    public function getPlayersIterator()
    {
        return new \ArrayIterator($this->get(self::PLAYERS));
    }

    /**
     * Returns element from 'players' list at given offset
     *
     * @param int $offset Position in list
     *
     * @return \CSDssPlayerInfo
     */
    public function getPlayersAt($offset)
    {
        return $this->get(self::PLAYERS, $offset);
    }

    /**
     * Returns count of 'players' list
     *
     * @return int
     */
    public function getPlayersCount()
    {
        return $this->count(self::PLAYERS);
    }

    /**
     * Sets value of 'bomb_num' property
     *
     * @param integer $value Property value
     *
     * @return null
     */
    public function setBombNum($value)
    {
        return $this->set(self::BOMB_NUM, $value);
    }

    /**
     * Returns value of 'bomb_num' property
     *
     * @return integer
     */
    public function getBombNum()
    {
        $value = $this->get(self::BOMB_NUM);
        return $value === null ? (integer)$value : $value;
    }

    /**
     * Returns true if 'bomb_num' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasBombNum()
    {
        return $this->get(self::BOMB_NUM) !== null;
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
     * Appends value to 'actions_flow' list
     *
     * @param \PBDSSActionFlow $value Value to append
     *
     * @return null
     */
    public function appendActionsFlow(\PBDSSActionFlow $value)
    {
        return $this->append(self::ACTIONS_FLOW, $value);
    }

    /**
     * Clears 'actions_flow' list
     *
     * @return null
     */
    public function clearActionsFlow()
    {
        return $this->clear(self::ACTIONS_FLOW);
    }

    /**
     * Returns 'actions_flow' list
     *
     * @return \PBDSSActionFlow[]
     */
    public function getActionsFlow()
    {
        return $this->get(self::ACTIONS_FLOW);
    }

    /**
     * Returns true if 'actions_flow' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasActionsFlow()
    {
        return count($this->get(self::ACTIONS_FLOW)) !== 0;
    }

    /**
     * Returns 'actions_flow' iterator
     *
     * @return \ArrayIterator
     */
    public function getActionsFlowIterator()
    {
        return new \ArrayIterator($this->get(self::ACTIONS_FLOW));
    }

    /**
     * Returns element from 'actions_flow' list at given offset
     *
     * @param int $offset Position in list
     *
     * @return \PBDSSActionFlow
     */
    public function getActionsFlowAt($offset)
    {
        return $this->get(self::ACTIONS_FLOW, $offset);
    }

    /**
     * Returns count of 'actions_flow' list
     *
     * @return int
     */
    public function getActionsFlowCount()
    {
        return $this->count(self::ACTIONS_FLOW);
    }

    /**
     * Sets value of 'end_time' property
     *
     * @param integer $value Property value
     *
     * @return null
     */
    public function setEndTime($value)
    {
        return $this->set(self::END_TIME, $value);
    }

    /**
     * Returns value of 'end_time' property
     *
     * @return integer
     */
    public function getEndTime()
    {
        $value = $this->get(self::END_TIME);
        return $value === null ? (integer)$value : $value;
    }

    /**
     * Returns true if 'end_time' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasEndTime()
    {
        return $this->get(self::END_TIME) !== null;
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
     * Sets value of 'winner_index2' property
     *
     * @param integer $value Property value
     *
     * @return null
     */
    public function setWinnerIndex2($value)
    {
        return $this->set(self::WINNER_INDEX2, $value);
    }

    /**
     * Returns value of 'winner_index2' property
     *
     * @return integer
     */
    public function getWinnerIndex2()
    {
        $value = $this->get(self::WINNER_INDEX2);
        return $value === null ? (integer)$value : $value;
    }

    /**
     * Returns true if 'winner_index2' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasWinnerIndex2()
    {
        return $this->get(self::WINNER_INDEX2) !== null;
    }

    /**
     * Sets value of 'sz_reward' property
     *
     * @param integer $value Property value
     *
     * @return null
     */
    public function setSzReward($value)
    {
        return $this->set(self::SZ_REWARD, $value);
    }

    /**
     * Returns value of 'sz_reward' property
     *
     * @return integer
     */
    public function getSzReward()
    {
        $value = $this->get(self::SZ_REWARD);
        return $value === null ? (integer)$value : $value;
    }

    /**
     * Returns true if 'sz_reward' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasSzReward()
    {
        return $this->get(self::SZ_REWARD) !== null;
    }

    /**
     * Appends value to 'fruit_type' list
     *
     * @param integer $value Value to append
     *
     * @return null
     */
    public function appendFruitType($value)
    {
        return $this->append(self::FRUIT_TYPE, $value);
    }

    /**
     * Clears 'fruit_type' list
     *
     * @return null
     */
    public function clearFruitType()
    {
        return $this->clear(self::FRUIT_TYPE);
    }

    /**
     * Returns 'fruit_type' list
     *
     * @return integer[]
     */
    public function getFruitType()
    {
        return $this->get(self::FRUIT_TYPE);
    }

    /**
     * Returns true if 'fruit_type' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasFruitType()
    {
        return count($this->get(self::FRUIT_TYPE)) !== 0;
    }

    /**
     * Returns 'fruit_type' iterator
     *
     * @return \ArrayIterator
     */
    public function getFruitTypeIterator()
    {
        return new \ArrayIterator($this->get(self::FRUIT_TYPE));
    }

    /**
     * Returns element from 'fruit_type' list at given offset
     *
     * @param int $offset Position in list
     *
     * @return integer
     */
    public function getFruitTypeAt($offset)
    {
        return $this->get(self::FRUIT_TYPE, $offset);
    }

    /**
     * Returns count of 'fruit_type' list
     *
     * @return int
     */
    public function getFruitTypeCount()
    {
        return $this->count(self::FRUIT_TYPE);
    }

    /**
     * Appends value to 'fruit_score' list
     *
     * @param integer $value Value to append
     *
     * @return null
     */
    public function appendFruitScore($value)
    {
        return $this->append(self::FRUIT_SCORE, $value);
    }

    /**
     * Clears 'fruit_score' list
     *
     * @return null
     */
    public function clearFruitScore()
    {
        return $this->clear(self::FRUIT_SCORE);
    }

    /**
     * Returns 'fruit_score' list
     *
     * @return integer[]
     */
    public function getFruitScore()
    {
        return $this->get(self::FRUIT_SCORE);
    }

    /**
     * Returns true if 'fruit_score' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasFruitScore()
    {
        return count($this->get(self::FRUIT_SCORE)) !== 0;
    }

    /**
     * Returns 'fruit_score' iterator
     *
     * @return \ArrayIterator
     */
    public function getFruitScoreIterator()
    {
        return new \ArrayIterator($this->get(self::FRUIT_SCORE));
    }

    /**
     * Returns element from 'fruit_score' list at given offset
     *
     * @param int $offset Position in list
     *
     * @return integer
     */
    public function getFruitScoreAt($offset)
    {
        return $this->get(self::FRUIT_SCORE, $offset);
    }

    /**
     * Returns count of 'fruit_score' list
     *
     * @return int
     */
    public function getFruitScoreCount()
    {
        return $this->count(self::FRUIT_SCORE);
    }

    /**
     * Sets value of 'jack_pot_score' property
     *
     * @param integer $value Property value
     *
     * @return null
     */
    public function setJackPotScore($value)
    {
        return $this->set(self::JACK_POT_SCORE, $value);
    }

    /**
     * Returns value of 'jack_pot_score' property
     *
     * @return integer
     */
    public function getJackPotScore()
    {
        $value = $this->get(self::JACK_POT_SCORE);
        return $value === null ? (integer)$value : $value;
    }

    /**
     * Returns true if 'jack_pot_score' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasJackPotScore()
    {
        return $this->get(self::JACK_POT_SCORE) !== null;
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
     * Sets value of 'sever_jack_pot_score' property
     *
     * @param integer $value Property value
     *
     * @return null
     */
    public function setSeverJackPotScore($value)
    {
        return $this->set(self::SEVER_JACK_POT_SCORE, $value);
    }

    /**
     * Returns value of 'sever_jack_pot_score' property
     *
     * @return integer
     */
    public function getSeverJackPotScore()
    {
        $value = $this->get(self::SEVER_JACK_POT_SCORE);
        return $value === null ? (integer)$value : $value;
    }

    /**
     * Returns true if 'sever_jack_pot_score' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasSeverJackPotScore()
    {
        return $this->get(self::SEVER_JACK_POT_SCORE) !== null;
    }

    /**
     * Sets value of 'seed' property
     *
     * @param string $value Property value
     *
     * @return null
     */
    public function setSeed($value)
    {
        return $this->set(self::SEED, $value);
    }

    /**
     * Returns value of 'seed' property
     *
     * @return string
     */
    public function getSeed()
    {
        $value = $this->get(self::SEED);
        return $value === null ? (string)$value : $value;
    }

    /**
     * Returns true if 'seed' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasSeed()
    {
        return $this->get(self::SEED) !== null;
    }
}
}