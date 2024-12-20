<?php
/**
 * Auto generated from poker_msg_cs.proto at 2023-06-08 09:49:25
 */

namespace {
/**
 * CSLevelInfo message
 */
class CSLevelInfo extends \ProtobufMessage
{
    /* Field index constants */
    const SEAT_NUM = 1;
    const LEVEL = 2;
    const BASE_CHIP = 3;
    const PLAYER_NUM = 4;
    const MIN_COIN_LIMIT = 5;
    const MAX_COIN_LIMIT = 6;
    const FEE = 7;
    const IS_OPEN = 8;
    const MIN_RECOMMEND = 9;
    const MAX_RECOMMEND = 10;
    const TIPS_SCORE = 11;

    /* @var array Field descriptors */
    protected static $fields = array(
        self::SEAT_NUM => array(
            'name' => 'seat_num',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_INT,
        ),
        self::LEVEL => array(
            'name' => 'level',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_INT,
        ),
        self::BASE_CHIP => array(
            'name' => 'base_chip',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_INT,
        ),
        self::PLAYER_NUM => array(
            'name' => 'player_num',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_INT,
        ),
        self::MIN_COIN_LIMIT => array(
            'name' => 'min_coin_limit',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_INT,
        ),
        self::MAX_COIN_LIMIT => array(
            'name' => 'max_coin_limit',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_INT,
        ),
        self::FEE => array(
            'name' => 'fee',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_INT,
        ),
        self::IS_OPEN => array(
            'name' => 'is_open',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_INT,
        ),
        self::MIN_RECOMMEND => array(
            'name' => 'min_recommend',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_INT,
        ),
        self::MAX_RECOMMEND => array(
            'name' => 'max_recommend',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_INT,
        ),
        self::TIPS_SCORE => array(
            'name' => 'tips_score',
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
        $this->values[self::SEAT_NUM] = null;
        $this->values[self::LEVEL] = null;
        $this->values[self::BASE_CHIP] = null;
        $this->values[self::PLAYER_NUM] = null;
        $this->values[self::MIN_COIN_LIMIT] = null;
        $this->values[self::MAX_COIN_LIMIT] = null;
        $this->values[self::FEE] = null;
        $this->values[self::IS_OPEN] = null;
        $this->values[self::MIN_RECOMMEND] = null;
        $this->values[self::MAX_RECOMMEND] = null;
        $this->values[self::TIPS_SCORE] = null;
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
     * Sets value of 'seat_num' property
     *
     * @param integer $value Property value
     *
     * @return null
     */
    public function setSeatNum($value)
    {
        return $this->set(self::SEAT_NUM, $value);
    }

    /**
     * Returns value of 'seat_num' property
     *
     * @return integer
     */
    public function getSeatNum()
    {
        $value = $this->get(self::SEAT_NUM);
        return $value === null ? (integer)$value : $value;
    }

    /**
     * Returns true if 'seat_num' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasSeatNum()
    {
        return $this->get(self::SEAT_NUM) !== null;
    }

    /**
     * Sets value of 'level' property
     *
     * @param integer $value Property value
     *
     * @return null
     */
    public function setLevel($value)
    {
        return $this->set(self::LEVEL, $value);
    }

    /**
     * Returns value of 'level' property
     *
     * @return integer
     */
    public function getLevel()
    {
        $value = $this->get(self::LEVEL);
        return $value === null ? (integer)$value : $value;
    }

    /**
     * Returns true if 'level' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasLevel()
    {
        return $this->get(self::LEVEL) !== null;
    }

    /**
     * Sets value of 'base_chip' property
     *
     * @param integer $value Property value
     *
     * @return null
     */
    public function setBaseChip($value)
    {
        return $this->set(self::BASE_CHIP, $value);
    }

    /**
     * Returns value of 'base_chip' property
     *
     * @return integer
     */
    public function getBaseChip()
    {
        $value = $this->get(self::BASE_CHIP);
        return $value === null ? (integer)$value : $value;
    }

    /**
     * Returns true if 'base_chip' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasBaseChip()
    {
        return $this->get(self::BASE_CHIP) !== null;
    }

    /**
     * Sets value of 'player_num' property
     *
     * @param integer $value Property value
     *
     * @return null
     */
    public function setPlayerNum($value)
    {
        return $this->set(self::PLAYER_NUM, $value);
    }

    /**
     * Returns value of 'player_num' property
     *
     * @return integer
     */
    public function getPlayerNum()
    {
        $value = $this->get(self::PLAYER_NUM);
        return $value === null ? (integer)$value : $value;
    }

    /**
     * Returns true if 'player_num' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasPlayerNum()
    {
        return $this->get(self::PLAYER_NUM) !== null;
    }

    /**
     * Sets value of 'min_coin_limit' property
     *
     * @param integer $value Property value
     *
     * @return null
     */
    public function setMinCoinLimit($value)
    {
        return $this->set(self::MIN_COIN_LIMIT, $value);
    }

    /**
     * Returns value of 'min_coin_limit' property
     *
     * @return integer
     */
    public function getMinCoinLimit()
    {
        $value = $this->get(self::MIN_COIN_LIMIT);
        return $value === null ? (integer)$value : $value;
    }

    /**
     * Returns true if 'min_coin_limit' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasMinCoinLimit()
    {
        return $this->get(self::MIN_COIN_LIMIT) !== null;
    }

    /**
     * Sets value of 'max_coin_limit' property
     *
     * @param integer $value Property value
     *
     * @return null
     */
    public function setMaxCoinLimit($value)
    {
        return $this->set(self::MAX_COIN_LIMIT, $value);
    }

    /**
     * Returns value of 'max_coin_limit' property
     *
     * @return integer
     */
    public function getMaxCoinLimit()
    {
        $value = $this->get(self::MAX_COIN_LIMIT);
        return $value === null ? (integer)$value : $value;
    }

    /**
     * Returns true if 'max_coin_limit' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasMaxCoinLimit()
    {
        return $this->get(self::MAX_COIN_LIMIT) !== null;
    }

    /**
     * Sets value of 'fee' property
     *
     * @param integer $value Property value
     *
     * @return null
     */
    public function setFee($value)
    {
        return $this->set(self::FEE, $value);
    }

    /**
     * Returns value of 'fee' property
     *
     * @return integer
     */
    public function getFee()
    {
        $value = $this->get(self::FEE);
        return $value === null ? (integer)$value : $value;
    }

    /**
     * Returns true if 'fee' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasFee()
    {
        return $this->get(self::FEE) !== null;
    }

    /**
     * Sets value of 'is_open' property
     *
     * @param integer $value Property value
     *
     * @return null
     */
    public function setIsOpen($value)
    {
        return $this->set(self::IS_OPEN, $value);
    }

    /**
     * Returns value of 'is_open' property
     *
     * @return integer
     */
    public function getIsOpen()
    {
        $value = $this->get(self::IS_OPEN);
        return $value === null ? (integer)$value : $value;
    }

    /**
     * Returns true if 'is_open' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasIsOpen()
    {
        return $this->get(self::IS_OPEN) !== null;
    }

    /**
     * Sets value of 'min_recommend' property
     *
     * @param integer $value Property value
     *
     * @return null
     */
    public function setMinRecommend($value)
    {
        return $this->set(self::MIN_RECOMMEND, $value);
    }

    /**
     * Returns value of 'min_recommend' property
     *
     * @return integer
     */
    public function getMinRecommend()
    {
        $value = $this->get(self::MIN_RECOMMEND);
        return $value === null ? (integer)$value : $value;
    }

    /**
     * Returns true if 'min_recommend' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasMinRecommend()
    {
        return $this->get(self::MIN_RECOMMEND) !== null;
    }

    /**
     * Sets value of 'max_recommend' property
     *
     * @param integer $value Property value
     *
     * @return null
     */
    public function setMaxRecommend($value)
    {
        return $this->set(self::MAX_RECOMMEND, $value);
    }

    /**
     * Returns value of 'max_recommend' property
     *
     * @return integer
     */
    public function getMaxRecommend()
    {
        $value = $this->get(self::MAX_RECOMMEND);
        return $value === null ? (integer)$value : $value;
    }

    /**
     * Returns true if 'max_recommend' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasMaxRecommend()
    {
        return $this->get(self::MAX_RECOMMEND) !== null;
    }

    /**
     * Sets value of 'tips_score' property
     *
     * @param integer $value Property value
     *
     * @return null
     */
    public function setTipsScore($value)
    {
        return $this->set(self::TIPS_SCORE, $value);
    }

    /**
     * Returns value of 'tips_score' property
     *
     * @return integer
     */
    public function getTipsScore()
    {
        $value = $this->get(self::TIPS_SCORE);
        return $value === null ? (integer)$value : $value;
    }

    /**
     * Returns true if 'tips_score' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasTipsScore()
    {
        return $this->get(self::TIPS_SCORE) !== null;
    }
}
}