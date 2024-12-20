<?php
/**
 * Auto generated from poker_msg_cs.proto at 2023-06-08 09:49:25
 */

namespace {
/**
 * CSNotifyTrusteeship message
 */
class CSNotifyTrusteeship extends \ProtobufMessage
{
    /* Field index constants */
    const SEAT_INDEX = 1;
    const IS_TRUSTEESHIP = 2;
    const IS_LEAVE_ROOM = 3;

    /* @var array Field descriptors */
    protected static $fields = array(
        self::SEAT_INDEX => array(
            'name' => 'seat_index',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_INT,
        ),
        self::IS_TRUSTEESHIP => array(
            'name' => 'is_trusteeship',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_BOOL,
        ),
        self::IS_LEAVE_ROOM => array(
            'name' => 'is_leave_room',
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
        $this->values[self::IS_TRUSTEESHIP] = null;
        $this->values[self::IS_LEAVE_ROOM] = null;
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
     * Sets value of 'is_trusteeship' property
     *
     * @param boolean $value Property value
     *
     * @return null
     */
    public function setIsTrusteeship($value)
    {
        return $this->set(self::IS_TRUSTEESHIP, $value);
    }

    /**
     * Returns value of 'is_trusteeship' property
     *
     * @return boolean
     */
    public function getIsTrusteeship()
    {
        $value = $this->get(self::IS_TRUSTEESHIP);
        return $value === null ? (boolean)$value : $value;
    }

    /**
     * Returns true if 'is_trusteeship' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasIsTrusteeship()
    {
        return $this->get(self::IS_TRUSTEESHIP) !== null;
    }

    /**
     * Sets value of 'is_leave_room' property
     *
     * @param boolean $value Property value
     *
     * @return null
     */
    public function setIsLeaveRoom($value)
    {
        return $this->set(self::IS_LEAVE_ROOM, $value);
    }

    /**
     * Returns value of 'is_leave_room' property
     *
     * @return boolean
     */
    public function getIsLeaveRoom()
    {
        $value = $this->get(self::IS_LEAVE_ROOM);
        return $value === null ? (boolean)$value : $value;
    }

    /**
     * Returns true if 'is_leave_room' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasIsLeaveRoom()
    {
        return $this->get(self::IS_LEAVE_ROOM) !== null;
    }
}
}