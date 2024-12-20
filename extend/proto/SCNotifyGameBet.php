<?php
/**
 * Auto generated from poker_msg_cs.proto at 2023-06-08 09:49:25
 */

namespace {
/**
 * SCNotifyGameBet message
 */
class SCNotifyGameBet extends \ProtobufMessage
{
    /* Field index constants */
    const GAME_TYPE = 1;
    const BET_SCORE = 2;

    /* @var array Field descriptors */
    protected static $fields = array(
        self::GAME_TYPE => array(
            'name' => 'game_type',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_INT,
        ),
        self::BET_SCORE => array(
            'name' => 'bet_score',
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
        $this->values[self::GAME_TYPE] = null;
        $this->values[self::BET_SCORE] = array();
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
     * Sets value of 'game_type' property
     *
     * @param integer $value Property value
     *
     * @return null
     */
    public function setGameType($value)
    {
        return $this->set(self::GAME_TYPE, $value);
    }

    /**
     * Returns value of 'game_type' property
     *
     * @return integer
     */
    public function getGameType()
    {
        $value = $this->get(self::GAME_TYPE);
        return $value === null ? (integer)$value : $value;
    }

    /**
     * Returns true if 'game_type' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasGameType()
    {
        return $this->get(self::GAME_TYPE) !== null;
    }

    /**
     * Appends value to 'bet_score' list
     *
     * @param integer $value Value to append
     *
     * @return null
     */
    public function appendBetScore($value)
    {
        return $this->append(self::BET_SCORE, $value);
    }

    /**
     * Clears 'bet_score' list
     *
     * @return null
     */
    public function clearBetScore()
    {
        return $this->clear(self::BET_SCORE);
    }

    /**
     * Returns 'bet_score' list
     *
     * @return integer[]
     */
    public function getBetScore()
    {
        return $this->get(self::BET_SCORE);
    }

    /**
     * Returns true if 'bet_score' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasBetScore()
    {
        return count($this->get(self::BET_SCORE)) !== 0;
    }

    /**
     * Returns 'bet_score' iterator
     *
     * @return \ArrayIterator
     */
    public function getBetScoreIterator()
    {
        return new \ArrayIterator($this->get(self::BET_SCORE));
    }

    /**
     * Returns element from 'bet_score' list at given offset
     *
     * @param int $offset Position in list
     *
     * @return integer
     */
    public function getBetScoreAt($offset)
    {
        return $this->get(self::BET_SCORE, $offset);
    }

    /**
     * Returns count of 'bet_score' list
     *
     * @return int
     */
    public function getBetScoreCount()
    {
        return $this->count(self::BET_SCORE);
    }
}
}