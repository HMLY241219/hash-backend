<?php
/**
 * Auto generated from poker_config.proto at 2023-06-08 09:49:25
 */

namespace {
/**
 * PBAutoMatchRoomItem message
 */
class PBAutoMatchRoomItem extends \ProtobufMessage
{
    /* Field index constants */
    const TTYPE = 1;
    const LEVEL = 2;
    const BASE_CHIP = 3;
    const FEE = 4;
    const CHIP_FLOOR_LIMIT = 5;
    const CHIP_UPPER_LIMIT = 6;
    const SEAT_NUM = 7;
    const CALCULATE_SCORE_CHIP = 8;
    const ROBOT_MIN_CHIP = 9;
    const ROBOT_MAX_CHIP = 10;
    const SHOW_NUM = 11;
    const SHOW_CHANGE = 12;
    const MIN_RECOMMEND = 13;
    const MAX_RECOMMEND = 14;
    const TIPS_SCORE = 15;

    /* @var array Field descriptors */
    protected static $fields = array(
        self::TTYPE => array(
            'name' => 'ttype',
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
        self::FEE => array(
            'name' => 'fee',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_INT,
        ),
        self::CHIP_FLOOR_LIMIT => array(
            'name' => 'chip_floor_limit',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_INT,
        ),
        self::CHIP_UPPER_LIMIT => array(
            'name' => 'chip_upper_limit',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_INT,
        ),
        self::SEAT_NUM => array(
            'name' => 'seat_num',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_INT,
        ),
        self::CALCULATE_SCORE_CHIP => array(
            'name' => 'calculate_score_chip',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_INT,
        ),
        self::ROBOT_MIN_CHIP => array(
            'name' => 'robot_min_chip',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_INT,
        ),
        self::ROBOT_MAX_CHIP => array(
            'name' => 'robot_max_chip',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_INT,
        ),
        self::SHOW_NUM => array(
            'name' => 'show_num',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_INT,
        ),
        self::SHOW_CHANGE => array(
            'name' => 'show_change',
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
        $this->values[self::TTYPE] = null;
        $this->values[self::LEVEL] = null;
        $this->values[self::BASE_CHIP] = null;
        $this->values[self::FEE] = null;
        $this->values[self::CHIP_FLOOR_LIMIT] = null;
        $this->values[self::CHIP_UPPER_LIMIT] = null;
        $this->values[self::SEAT_NUM] = null;
        $this->values[self::CALCULATE_SCORE_CHIP] = null;
        $this->values[self::ROBOT_MIN_CHIP] = null;
        $this->values[self::ROBOT_MAX_CHIP] = null;
        $this->values[self::SHOW_NUM] = null;
        $this->values[self::SHOW_CHANGE] = null;
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
     * Sets value of 'ttype' property
     *
     * @param integer $value Property value
     *
     * @return null
     */
    public function setTtype($value)
    {
        return $this->set(self::TTYPE, $value);
    }

    /**
     * Returns value of 'ttype' property
     *
     * @return integer
     */
    public function getTtype()
    {
        $value = $this->get(self::TTYPE);
        return $value === null ? (integer)$value : $value;
    }

    /**
     * Returns true if 'ttype' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasTtype()
    {
        return $this->get(self::TTYPE) !== null;
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
     * Sets value of 'chip_floor_limit' property
     *
     * @param integer $value Property value
     *
     * @return null
     */
    public function setChipFloorLimit($value)
    {
        return $this->set(self::CHIP_FLOOR_LIMIT, $value);
    }

    /**
     * Returns value of 'chip_floor_limit' property
     *
     * @return integer
     */
    public function getChipFloorLimit()
    {
        $value = $this->get(self::CHIP_FLOOR_LIMIT);
        return $value === null ? (integer)$value : $value;
    }

    /**
     * Returns true if 'chip_floor_limit' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasChipFloorLimit()
    {
        return $this->get(self::CHIP_FLOOR_LIMIT) !== null;
    }

    /**
     * Sets value of 'chip_upper_limit' property
     *
     * @param integer $value Property value
     *
     * @return null
     */
    public function setChipUpperLimit($value)
    {
        return $this->set(self::CHIP_UPPER_LIMIT, $value);
    }

    /**
     * Returns value of 'chip_upper_limit' property
     *
     * @return integer
     */
    public function getChipUpperLimit()
    {
        $value = $this->get(self::CHIP_UPPER_LIMIT);
        return $value === null ? (integer)$value : $value;
    }

    /**
     * Returns true if 'chip_upper_limit' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasChipUpperLimit()
    {
        return $this->get(self::CHIP_UPPER_LIMIT) !== null;
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
     * Sets value of 'calculate_score_chip' property
     *
     * @param integer $value Property value
     *
     * @return null
     */
    public function setCalculateScoreChip($value)
    {
        return $this->set(self::CALCULATE_SCORE_CHIP, $value);
    }

    /**
     * Returns value of 'calculate_score_chip' property
     *
     * @return integer
     */
    public function getCalculateScoreChip()
    {
        $value = $this->get(self::CALCULATE_SCORE_CHIP);
        return $value === null ? (integer)$value : $value;
    }

    /**
     * Returns true if 'calculate_score_chip' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasCalculateScoreChip()
    {
        return $this->get(self::CALCULATE_SCORE_CHIP) !== null;
    }

    /**
     * Sets value of 'robot_min_chip' property
     *
     * @param integer $value Property value
     *
     * @return null
     */
    public function setRobotMinChip($value)
    {
        return $this->set(self::ROBOT_MIN_CHIP, $value);
    }

    /**
     * Returns value of 'robot_min_chip' property
     *
     * @return integer
     */
    public function getRobotMinChip()
    {
        $value = $this->get(self::ROBOT_MIN_CHIP);
        return $value === null ? (integer)$value : $value;
    }

    /**
     * Returns true if 'robot_min_chip' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasRobotMinChip()
    {
        return $this->get(self::ROBOT_MIN_CHIP) !== null;
    }

    /**
     * Sets value of 'robot_max_chip' property
     *
     * @param integer $value Property value
     *
     * @return null
     */
    public function setRobotMaxChip($value)
    {
        return $this->set(self::ROBOT_MAX_CHIP, $value);
    }

    /**
     * Returns value of 'robot_max_chip' property
     *
     * @return integer
     */
    public function getRobotMaxChip()
    {
        $value = $this->get(self::ROBOT_MAX_CHIP);
        return $value === null ? (integer)$value : $value;
    }

    /**
     * Returns true if 'robot_max_chip' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasRobotMaxChip()
    {
        return $this->get(self::ROBOT_MAX_CHIP) !== null;
    }

    /**
     * Sets value of 'show_num' property
     *
     * @param integer $value Property value
     *
     * @return null
     */
    public function setShowNum($value)
    {
        return $this->set(self::SHOW_NUM, $value);
    }

    /**
     * Returns value of 'show_num' property
     *
     * @return integer
     */
    public function getShowNum()
    {
        $value = $this->get(self::SHOW_NUM);
        return $value === null ? (integer)$value : $value;
    }

    /**
     * Returns true if 'show_num' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasShowNum()
    {
        return $this->get(self::SHOW_NUM) !== null;
    }

    /**
     * Sets value of 'show_change' property
     *
     * @param integer $value Property value
     *
     * @return null
     */
    public function setShowChange($value)
    {
        return $this->set(self::SHOW_CHANGE, $value);
    }

    /**
     * Returns value of 'show_change' property
     *
     * @return integer
     */
    public function getShowChange()
    {
        $value = $this->get(self::SHOW_CHANGE);
        return $value === null ? (integer)$value : $value;
    }

    /**
     * Returns true if 'show_change' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasShowChange()
    {
        return $this->get(self::SHOW_CHANGE) !== null;
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