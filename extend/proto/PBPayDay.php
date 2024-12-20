<?php
/**
 * Auto generated from poker_data.proto at 2023-06-08 09:49:25
 */

namespace {
/**
 * PBPayDay message
 */
class PBPayDay extends \ProtobufMessage
{
    /* Field index constants */
    const TYPE = 1;
    const GET_TIME = 2;
    const END_TIME = 3;

    /* @var array Field descriptors */
    protected static $fields = array(
        self::TYPE => array(
            'name' => 'type',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_INT,
        ),
        self::GET_TIME => array(
            'name' => 'get_time',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_INT,
        ),
        self::END_TIME => array(
            'name' => 'end_time',
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
        $this->values[self::TYPE] = null;
        $this->values[self::GET_TIME] = null;
        $this->values[self::END_TIME] = null;
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
     * Sets value of 'type' property
     *
     * @param integer $value Property value
     *
     * @return null
     */
    public function setType($value)
    {
        return $this->set(self::TYPE, $value);
    }

    /**
     * Returns value of 'type' property
     *
     * @return integer
     */
    public function getType()
    {
        $value = $this->get(self::TYPE);
        return $value === null ? (integer)$value : $value;
    }

    /**
     * Returns true if 'type' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasType()
    {
        return $this->get(self::TYPE) !== null;
    }

    /**
     * Sets value of 'get_time' property
     *
     * @param integer $value Property value
     *
     * @return null
     */
    public function setGetTime($value)
    {
        return $this->set(self::GET_TIME, $value);
    }

    /**
     * Returns value of 'get_time' property
     *
     * @return integer
     */
    public function getGetTime()
    {
        $value = $this->get(self::GET_TIME);
        return $value === null ? (integer)$value : $value;
    }

    /**
     * Returns true if 'get_time' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasGetTime()
    {
        return $this->get(self::GET_TIME) !== null;
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
}
}