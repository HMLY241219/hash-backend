<?php
/**
 * Auto generated from poker_msg_cs.proto at 2023-06-08 09:49:25
 */

namespace {
/**
 * CSResponseHeartBeat message
 */
class CSResponseHeartBeat extends \ProtobufMessage
{
    /* Field index constants */
    const TIME = 1;

    /* @var array Field descriptors */
    protected static $fields = array(
        self::TIME => array(
            'name' => 'time',
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
        $this->values[self::TIME] = null;
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
     * Sets value of 'time' property
     *
     * @param integer $value Property value
     *
     * @return null
     */
    public function setTime($value)
    {
        return $this->set(self::TIME, $value);
    }

    /**
     * Returns value of 'time' property
     *
     * @return integer
     */
    public function getTime()
    {
        $value = $this->get(self::TIME);
        return $value === null ? (integer)$value : $value;
    }

    /**
     * Returns true if 'time' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasTime()
    {
        return $this->get(self::TIME) !== null;
    }
}
}