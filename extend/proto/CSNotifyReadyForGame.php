<?php
/**
 * Auto generated from poker_msg_cs.proto at 2023-06-08 09:49:25
 */

namespace {
/**
 * CSNotifyReadyForGame message
 */
class CSNotifyReadyForGame extends \ProtobufMessage
{
    /* Field index constants */
    const SEAT_INDEX = 1;
    const STATE = 2;

    /* @var array Field descriptors */
    protected static $fields = array(
        self::SEAT_INDEX => array(
            'name' => 'seat_index',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_INT,
        ),
        self::STATE => array(
            'name' => 'state',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_BOOL,
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
        $this->values[self::SEAT_INDEX] = null;
        $this->values[self::STATE] = null;
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
     * Sets value of 'seat_index' property
     *
     * @param integer $value Property value
     *
     * @return null
     */
    public function setSeatIndex($value)
    {
        return $this->set(self::SEAT_INDEX, $value);
    }

    /**
     * Returns value of 'seat_index' property
     *
     * @return integer
     */
    public function getSeatIndex()
    {
        $value = $this->get(self::SEAT_INDEX);
        return $value === null ? (integer)$value : $value;
    }

    /**
     * Returns true if 'seat_index' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasSeatIndex()
    {
        return $this->get(self::SEAT_INDEX) !== null;
    }

    /**
     * Sets value of 'state' property
     *
     * @param boolean $value Property value
     *
     * @return null
     */
    public function setState($value)
    {
        return $this->set(self::STATE, $value);
    }

    /**
     * Returns value of 'state' property
     *
     * @return boolean
     */
    public function getState()
    {
        $value = $this->get(self::STATE);
        return $value === null ? (boolean)$value : $value;
    }

    /**
     * Returns true if 'state' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasState()
    {
        return $this->get(self::STATE) !== null;
    }
}
}