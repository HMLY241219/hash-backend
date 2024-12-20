<?php
/**
 * Auto generated from poker_msg_cs.proto at 2023-06-08 09:49:25
 */

namespace {
/**
 * CSNOtifyPlayerConnectionState message
 */
class CSNOtifyPlayerConnectionState extends \ProtobufMessage
{
    /* Field index constants */
    const SEAT_INDEX = 1;
    const CONNECTION_STATE = 2;
    const OFFLINE_TIMER = 3;

    /* @var array Field descriptors */
    protected static $fields = array(
        self::SEAT_INDEX => array(
            'name' => 'seat_index',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_INT,
        ),
        self::CONNECTION_STATE => array(
            'name' => 'connection_state',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_INT,
        ),
        self::OFFLINE_TIMER => array(
            'name' => 'offline_timer',
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
        $this->values[self::SEAT_INDEX] = null;
        $this->values[self::CONNECTION_STATE] = null;
        $this->values[self::OFFLINE_TIMER] = null;
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
     * Sets value of 'connection_state' property
     *
     * @param integer $value Property value
     *
     * @return null
     */
    public function setConnectionState($value)
    {
        return $this->set(self::CONNECTION_STATE, $value);
    }

    /**
     * Returns value of 'connection_state' property
     *
     * @return integer
     */
    public function getConnectionState()
    {
        $value = $this->get(self::CONNECTION_STATE);
        return $value === null ? (integer)$value : $value;
    }

    /**
     * Returns true if 'connection_state' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasConnectionState()
    {
        return $this->get(self::CONNECTION_STATE) !== null;
    }

    /**
     * Sets value of 'offline_timer' property
     *
     * @param integer $value Property value
     *
     * @return null
     */
    public function setOfflineTimer($value)
    {
        return $this->set(self::OFFLINE_TIMER, $value);
    }

    /**
     * Returns value of 'offline_timer' property
     *
     * @return integer
     */
    public function getOfflineTimer()
    {
        $value = $this->get(self::OFFLINE_TIMER);
        return $value === null ? (integer)$value : $value;
    }

    /**
     * Returns true if 'offline_timer' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasOfflineTimer()
    {
        return $this->get(self::OFFLINE_TIMER) !== null;
    }
}
}