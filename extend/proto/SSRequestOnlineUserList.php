<?php
/**
 * Auto generated from poker_msg_ss.proto at 2023-06-08 09:49:25
 */

namespace {
/**
 * SSRequestOnlineUserList message
 */
class SSRequestOnlineUserList extends \ProtobufMessage
{
    /* Field index constants */
    const ROOM_LV = 1;
    const USER_KEY = 2;
    const IS_ONLINE = 3;

    /* @var array Field descriptors */
    protected static $fields = array(
        self::ROOM_LV => array(
            'name' => 'room_lv',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_INT,
        ),
        self::USER_KEY => array(
            'name' => 'user_key',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_INT,
        ),
        self::IS_ONLINE => array(
            'name' => 'is_online',
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
        $this->values[self::ROOM_LV] = null;
        $this->values[self::USER_KEY] = null;
        $this->values[self::IS_ONLINE] = null;
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
     * Sets value of 'room_lv' property
     *
     * @param integer $value Property value
     *
     * @return null
     */
    public function setRoomLv($value)
    {
        return $this->set(self::ROOM_LV, $value);
    }

    /**
     * Returns value of 'room_lv' property
     *
     * @return integer
     */
    public function getRoomLv()
    {
        $value = $this->get(self::ROOM_LV);
        return $value === null ? (integer)$value : $value;
    }

    /**
     * Returns true if 'room_lv' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasRoomLv()
    {
        return $this->get(self::ROOM_LV) !== null;
    }

    /**
     * Sets value of 'user_key' property
     *
     * @param integer $value Property value
     *
     * @return null
     */
    public function setUserKey($value)
    {
        return $this->set(self::USER_KEY, $value);
    }

    /**
     * Returns value of 'user_key' property
     *
     * @return integer
     */
    public function getUserKey()
    {
        $value = $this->get(self::USER_KEY);
        return $value === null ? (integer)$value : $value;
    }

    /**
     * Returns true if 'user_key' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasUserKey()
    {
        return $this->get(self::USER_KEY) !== null;
    }

    /**
     * Sets value of 'is_online' property
     *
     * @param boolean $value Property value
     *
     * @return null
     */
    public function setIsOnline($value)
    {
        return $this->set(self::IS_ONLINE, $value);
    }

    /**
     * Returns value of 'is_online' property
     *
     * @return boolean
     */
    public function getIsOnline()
    {
        $value = $this->get(self::IS_ONLINE);
        return $value === null ? (boolean)$value : $value;
    }

    /**
     * Returns true if 'is_online' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasIsOnline()
    {
        return $this->get(self::IS_ONLINE) !== null;
    }
}
}