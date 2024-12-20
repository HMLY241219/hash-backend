<?php
/**
 * Auto generated from poker_config.proto at 2023-06-08 09:49:25
 */

namespace {
/**
 * PBCompareLogic message
 */
class PBCompareLogic extends \ProtobufMessage
{
    /* Field index constants */
    const CARD_TYPE = 1;
    const WIN = 2;
    const MULTIPLE_MIN = 3;
    const COMPARE_OK_RATIO = 4;
    const GIVE_UP_RATIO = 6;
    const INCREASING_GIVE_UP_RATIO = 7;
    const GIVE_UP_2_RATIO = 8;
    const GIVE_UP_MULTIPLE_RATIO = 9;

    /* @var array Field descriptors */
    protected static $fields = array(
        self::CARD_TYPE => array(
            'name' => 'card_type',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_INT,
        ),
        self::WIN => array(
            'name' => 'win',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_INT,
        ),
        self::MULTIPLE_MIN => array(
            'name' => 'multiple_min',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_INT,
        ),
        self::COMPARE_OK_RATIO => array(
            'name' => 'compare_ok_ratio',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_INT,
        ),
        self::GIVE_UP_RATIO => array(
            'name' => 'give_up_ratio',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_INT,
        ),
        self::INCREASING_GIVE_UP_RATIO => array(
            'name' => 'increasing_give_up_ratio',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_INT,
        ),
        self::GIVE_UP_2_RATIO => array(
            'name' => 'give_up_2_ratio',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_INT,
        ),
        self::GIVE_UP_MULTIPLE_RATIO => array(
            'name' => 'give_up_multiple_ratio',
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
        $this->values[self::WIN] = null;
        $this->values[self::MULTIPLE_MIN] = null;
        $this->values[self::COMPARE_OK_RATIO] = null;
        $this->values[self::GIVE_UP_RATIO] = null;
        $this->values[self::INCREASING_GIVE_UP_RATIO] = null;
        $this->values[self::GIVE_UP_2_RATIO] = null;
        $this->values[self::GIVE_UP_MULTIPLE_RATIO] = null;
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
     * Sets value of 'win' property
     *
     * @param integer $value Property value
     *
     * @return null
     */
    public function setWin($value)
    {
        return $this->set(self::WIN, $value);
    }

    /**
     * Returns value of 'win' property
     *
     * @return integer
     */
    public function getWin()
    {
        $value = $this->get(self::WIN);
        return $value === null ? (integer)$value : $value;
    }

    /**
     * Returns true if 'win' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasWin()
    {
        return $this->get(self::WIN) !== null;
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
     * Sets value of 'compare_ok_ratio' property
     *
     * @param integer $value Property value
     *
     * @return null
     */
    public function setCompareOkRatio($value)
    {
        return $this->set(self::COMPARE_OK_RATIO, $value);
    }

    /**
     * Returns value of 'compare_ok_ratio' property
     *
     * @return integer
     */
    public function getCompareOkRatio()
    {
        $value = $this->get(self::COMPARE_OK_RATIO);
        return $value === null ? (integer)$value : $value;
    }

    /**
     * Returns true if 'compare_ok_ratio' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasCompareOkRatio()
    {
        return $this->get(self::COMPARE_OK_RATIO) !== null;
    }

    /**
     * Sets value of 'give_up_ratio' property
     *
     * @param integer $value Property value
     *
     * @return null
     */
    public function setGiveUpRatio($value)
    {
        return $this->set(self::GIVE_UP_RATIO, $value);
    }

    /**
     * Returns value of 'give_up_ratio' property
     *
     * @return integer
     */
    public function getGiveUpRatio()
    {
        $value = $this->get(self::GIVE_UP_RATIO);
        return $value === null ? (integer)$value : $value;
    }

    /**
     * Returns true if 'give_up_ratio' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasGiveUpRatio()
    {
        return $this->get(self::GIVE_UP_RATIO) !== null;
    }

    /**
     * Sets value of 'increasing_give_up_ratio' property
     *
     * @param integer $value Property value
     *
     * @return null
     */
    public function setIncreasingGiveUpRatio($value)
    {
        return $this->set(self::INCREASING_GIVE_UP_RATIO, $value);
    }

    /**
     * Returns value of 'increasing_give_up_ratio' property
     *
     * @return integer
     */
    public function getIncreasingGiveUpRatio()
    {
        $value = $this->get(self::INCREASING_GIVE_UP_RATIO);
        return $value === null ? (integer)$value : $value;
    }

    /**
     * Returns true if 'increasing_give_up_ratio' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasIncreasingGiveUpRatio()
    {
        return $this->get(self::INCREASING_GIVE_UP_RATIO) !== null;
    }

    /**
     * Sets value of 'give_up_2_ratio' property
     *
     * @param integer $value Property value
     *
     * @return null
     */
    public function setGiveUp2Ratio($value)
    {
        return $this->set(self::GIVE_UP_2_RATIO, $value);
    }

    /**
     * Returns value of 'give_up_2_ratio' property
     *
     * @return integer
     */
    public function getGiveUp2Ratio()
    {
        $value = $this->get(self::GIVE_UP_2_RATIO);
        return $value === null ? (integer)$value : $value;
    }

    /**
     * Returns true if 'give_up_2_ratio' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasGiveUp2Ratio()
    {
        return $this->get(self::GIVE_UP_2_RATIO) !== null;
    }

    /**
     * Sets value of 'give_up_multiple_ratio' property
     *
     * @param integer $value Property value
     *
     * @return null
     */
    public function setGiveUpMultipleRatio($value)
    {
        return $this->set(self::GIVE_UP_MULTIPLE_RATIO, $value);
    }

    /**
     * Returns value of 'give_up_multiple_ratio' property
     *
     * @return integer
     */
    public function getGiveUpMultipleRatio()
    {
        $value = $this->get(self::GIVE_UP_MULTIPLE_RATIO);
        return $value === null ? (integer)$value : $value;
    }

    /**
     * Returns true if 'give_up_multiple_ratio' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasGiveUpMultipleRatio()
    {
        return $this->get(self::GIVE_UP_MULTIPLE_RATIO) !== null;
    }
}
}