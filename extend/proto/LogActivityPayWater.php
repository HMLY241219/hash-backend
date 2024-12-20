<?php
/**
 * Auto generated from poker_msg_log.proto at 2023-06-08 09:49:25
 */

namespace {
/**
 * LogActivityPayWater message
 */
class LogActivityPayWater extends \ProtobufMessage
{
    /* Field index constants */
    const ID = 1;
    const NOW_WATER = 2;
    const TYPE = 3;

    /* @var array Field descriptors */
    protected static $fields = array(
        self::ID => array(
            'name' => 'id',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_INT,
        ),
        self::NOW_WATER => array(
            'name' => 'now_water',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_INT,
        ),
        self::TYPE => array(
            'name' => 'type',
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
        $this->values[self::ID] = null;
        $this->values[self::NOW_WATER] = null;
        $this->values[self::TYPE] = null;
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
     * Sets value of 'id' property
     *
     * @param integer $value Property value
     *
     * @return null
     */
    public function setId($value)
    {
        return $this->set(self::ID, $value);
    }

    /**
     * Returns value of 'id' property
     *
     * @return integer
     */
    public function getId()
    {
        $value = $this->get(self::ID);
        return $value === null ? (integer)$value : $value;
    }

    /**
     * Returns true if 'id' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasId()
    {
        return $this->get(self::ID) !== null;
    }

    /**
     * Sets value of 'now_water' property
     *
     * @param integer $value Property value
     *
     * @return null
     */
    public function setNowWater($value)
    {
        return $this->set(self::NOW_WATER, $value);
    }

    /**
     * Returns value of 'now_water' property
     *
     * @return integer
     */
    public function getNowWater()
    {
        $value = $this->get(self::NOW_WATER);
        return $value === null ? (integer)$value : $value;
    }

    /**
     * Returns true if 'now_water' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasNowWater()
    {
        return $this->get(self::NOW_WATER) !== null;
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
}
}