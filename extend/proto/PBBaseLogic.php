<?php
/**
 * Auto generated from poker_config.proto at 2023-06-08 09:49:25
 */

namespace {
/**
 * PBBaseLogic message
 */
class PBBaseLogic extends \ProtobufMessage
{
    /* Field index constants */
    const CARD_TYPE = 1;
    const WIN_MULTIPLE_MIN = 2;
    const WIN_MULTIPLE_MAX = 3;
    const WIN_ADD_RATIO = 5;
    const MULTIPLE_MIN = 6;
    const MULTIPLE_MAX = 7;
    const ADD_RATIO = 9;

    /* @var array Field descriptors */
    protected static $fields = array(
        self::CARD_TYPE => array(
            'name' => 'card_type',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_INT,
        ),
        self::WIN_MULTIPLE_MIN => array(
            'name' => 'win_multiple_min',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_INT,
        ),
        self::WIN_MULTIPLE_MAX => array(
            'name' => 'win_multiple_max',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_INT,
        ),
        self::WIN_ADD_RATIO => array(
            'name' => 'win_add_ratio',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_INT,
        ),
        self::MULTIPLE_MIN => array(
            'name' => 'multiple_min',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_INT,
        ),
        self::MULTIPLE_MAX => array(
            'name' => 'multiple_max',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_INT,
        ),
        self::ADD_RATIO => array(
            'name' => 'add_ratio',
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
        $this->values[self::CARD_TYPE] = null;
        $this->values[self::WIN_MULTIPLE_MIN] = null;
        $this->values[self::WIN_MULTIPLE_MAX] = null;
        $this->values[self::WIN_ADD_RATIO] = null;
        $this->values[self::MULTIPLE_MIN] = null;
        $this->values[self::MULTIPLE_MAX] = null;
        $this->values[self::ADD_RATIO] = null;
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
     * Sets value of 'win_multiple_min' property
     *
     * @param integer $value Property value
     *
     * @return null
     */
    public function setWinMultipleMin($value)
    {
        return $this->set(self::WIN_MULTIPLE_MIN, $value);
    }

    /**
     * Returns value of 'win_multiple_min' property
     *
     * @return integer
     */
    public function getWinMultipleMin()
    {
        $value = $this->get(self::WIN_MULTIPLE_MIN);
        return $value === null ? (integer)$value : $value;
    }

    /**
     * Returns true if 'win_multiple_min' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasWinMultipleMin()
    {
        return $this->get(self::WIN_MULTIPLE_MIN) !== null;
    }

    /**
     * Sets value of 'win_multiple_max' property
     *
     * @param integer $value Property value
     *
     * @return null
     */
    public function setWinMultipleMax($value)
    {
        return $this->set(self::WIN_MULTIPLE_MAX, $value);
    }

    /**
     * Returns value of 'win_multiple_max' property
     *
     * @return integer
     */
    public function getWinMultipleMax()
    {
        $value = $this->get(self::WIN_MULTIPLE_MAX);
        return $value === null ? (integer)$value : $value;
    }

    /**
     * Returns true if 'win_multiple_max' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasWinMultipleMax()
    {
        return $this->get(self::WIN_MULTIPLE_MAX) !== null;
    }

    /**
     * Sets value of 'win_add_ratio' property
     *
     * @param integer $value Property value
     *
     * @return null
     */
    public function setWinAddRatio($value)
    {
        return $this->set(self::WIN_ADD_RATIO, $value);
    }

    /**
     * Returns value of 'win_add_ratio' property
     *
     * @return integer
     */
    public function getWinAddRatio()
    {
        $value = $this->get(self::WIN_ADD_RATIO);
        return $value === null ? (integer)$value : $value;
    }

    /**
     * Returns true if 'win_add_ratio' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasWinAddRatio()
    {
        return $this->get(self::WIN_ADD_RATIO) !== null;
    }

    /**
     * Sets value of 'multiple_min' property
     *
     * @param integer $value Property value
     *
     * @return null
     */
    public function setMultipleMin($value)
    {
        return $this->set(self::MULTIPLE_MIN, $value);
    }

    /**
     * Returns value of 'multiple_min' property
     *
     * @return integer
     */
    public function getMultipleMin()
    {
        $value = $this->get(self::MULTIPLE_MIN);
        return $value === null ? (integer)$value : $value;
    }

    /**
     * Returns true if 'multiple_min' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasMultipleMin()
    {
        return $this->get(self::MULTIPLE_MIN) !== null;
    }

    /**
     * Sets value of 'multiple_max' property
     *
     * @param integer $value Property value
     *
     * @return null
     */
    public function setMultipleMax($value)
    {
        return $this->set(self::MULTIPLE_MAX, $value);
    }

    /**
     * Returns value of 'multiple_max' property
     *
     * @return integer
     */
    public function getMultipleMax()
    {
        $value = $this->get(self::MULTIPLE_MAX);
        return $value === null ? (integer)$value : $value;
    }

    /**
     * Returns true if 'multiple_max' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasMultipleMax()
    {
        return $this->get(self::MULTIPLE_MAX) !== null;
    }

    /**
     * Sets value of 'add_ratio' property
     *
     * @param integer $value Property value
     *
     * @return null
     */
    public function setAddRatio($value)
    {
        return $this->set(self::ADD_RATIO, $value);
    }

    /**
     * Returns value of 'add_ratio' property
     *
     * @return integer
     */
    public function getAddRatio()
    {
        $value = $this->get(self::ADD_RATIO);
        return $value === null ? (integer)$value : $value;
    }

    /**
     * Returns true if 'add_ratio' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasAddRatio()
    {
        return $this->get(self::ADD_RATIO) !== null;
    }
}
}