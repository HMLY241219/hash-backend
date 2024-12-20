<?php
/**
 * Auto generated from poker_msg_cs.proto at 2023-06-08 09:49:25
 */

namespace {
/**
 * CSRequestOffLine message
 */
class CSRequestOffLine extends \ProtobufMessage
{
    /* Field index constants */
    const IS_OFFLINE = 1;

    /* @var array Field descriptors */
    protected static $fields = array(
        self::IS_OFFLINE => array(
            'name' => 'is_offline',
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
        $this->values[self::IS_OFFLINE] = null;
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
     * Sets value of 'is_offline' property
     *
     * @param boolean $value Property value
     *
     * @return null
     */
    public function setIsOffline($value)
    {
        return $this->set(self::IS_OFFLINE, $value);
    }

    /**
     * Returns value of 'is_offline' property
     *
     * @return boolean
     */
    public function getIsOffline()
    {
        $value = $this->get(self::IS_OFFLINE);
        return $value === null ? (boolean)$value : $value;
    }

    /**
     * Returns true if 'is_offline' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasIsOffline()
    {
        return $this->get(self::IS_OFFLINE) !== null;
    }
}
}