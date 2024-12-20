<?php
/**
 * Auto generated from poker_msg_cs.proto at 2023-06-08 09:49:25
 */

namespace {
/**
 * CSNotifyLogoutTable message
 */
class CSNotifyLogoutTable extends \ProtobufMessage
{
    /* Field index constants */
    const SEAT_INDEX = 1;
    const REASON = 2;

    /* @var array Field descriptors */
    protected static $fields = array(
        self::SEAT_INDEX => array(
            'name' => 'seat_index',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_INT,
        ),
        self::REASON => array(
            'name' => 'reason',
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
        $this->values[self::REASON] = null;
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
     * Sets value of 'reason' property
     *
     * @param integer $value Property value
     *
     * @return null
     */
    public function setReason($value)
    {
        return $this->set(self::REASON, $value);
    }

    /**
     * Returns value of 'reason' property
     *
     * @return integer
     */
    public function getReason()
    {
        $value = $this->get(self::REASON);
        return $value === null ? (integer)$value : $value;
    }

    /**
     * Returns true if 'reason' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasReason()
    {
        return $this->get(self::REASON) !== null;
    }
}
}