<?php
/**
 * Auto generated from poker_data.proto at 2023-06-08 09:49:25
 */

namespace {
/**
 * PBRotary message
 */
class PBRotary extends \ProtobufMessage
{
    /* Field index constants */
    const ROTARY_NUM = 1;
    const ROTARY_TIME = 2;
    const ROTARY_TPC = 3;
    const ROTARY_WEEK_SCORE = 4;

    /* @var array Field descriptors */
    protected static $fields = array(
        self::ROTARY_NUM => array(
            'name' => 'rotary_num',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_INT,
        ),
        self::ROTARY_TIME => array(
            'name' => 'rotary_time',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_INT,
        ),
        self::ROTARY_TPC => array(
            'name' => 'rotary_tpc',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_INT,
        ),
        self::ROTARY_WEEK_SCORE => array(
            'name' => 'rotary_week_score',
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
        $this->values[self::ROTARY_NUM] = null;
        $this->values[self::ROTARY_TIME] = null;
        $this->values[self::ROTARY_TPC] = null;
        $this->values[self::ROTARY_WEEK_SCORE] = null;
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
     * Sets value of 'rotary_time' property
     *
     * @param integer $value Property value
     *
     * @return null
     */
    public function setRotaryTime($value)
    {
        return $this->set(self::ROTARY_TIME, $value);
    }

    /**
     * Returns value of 'rotary_time' property
     *
     * @return integer
     */
    public function getRotaryTime()
    {
        $value = $this->get(self::ROTARY_TIME);
        return $value === null ? (integer)$value : $value;
    }

    /**
     * Returns true if 'rotary_time' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasRotaryTime()
    {
        return $this->get(self::ROTARY_TIME) !== null;
    }

    /**
     * Sets value of 'rotary_tpc' property
     *
     * @param integer $value Property value
     *
     * @return null
     */
    public function setRotaryTpc($value)
    {
        return $this->set(self::ROTARY_TPC, $value);
    }

    /**
     * Returns value of 'rotary_tpc' property
     *
     * @return integer
     */
    public function getRotaryTpc()
    {
        $value = $this->get(self::ROTARY_TPC);
        return $value === null ? (integer)$value : $value;
    }

    /**
     * Returns true if 'rotary_tpc' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasRotaryTpc()
    {
        return $this->get(self::ROTARY_TPC) !== null;
    }

    /**
     * Sets value of 'rotary_week_score' property
     *
     * @param integer $value Property value
     *
     * @return null
     */
    public function setRotaryWeekScore($value)
    {
        return $this->set(self::ROTARY_WEEK_SCORE, $value);
    }

    /**
     * Returns value of 'rotary_week_score' property
     *
     * @return integer
     */
    public function getRotaryWeekScore()
    {
        $value = $this->get(self::ROTARY_WEEK_SCORE);
        return $value === null ? (integer)$value : $value;
    }

    /**
     * Returns true if 'rotary_week_score' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasRotaryWeekScore()
    {
        return $this->get(self::ROTARY_WEEK_SCORE) !== null;
    }
}
}