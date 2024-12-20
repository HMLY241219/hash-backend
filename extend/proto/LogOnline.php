<?php
/**
 * Auto generated from poker_msg_log.proto at 2023-06-08 09:49:25
 */

namespace {
/**
 * LogOnline message
 */
class LogOnline extends \ProtobufMessage
{
    /* Field index constants */
    const SVR_ID = 1;
    const ONLINE = 2;

    /* @var array Field descriptors */
    protected static $fields = array(
        self::SVR_ID => array(
            'name' => 'svr_id',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_INT,
        ),
        self::ONLINE => array(
            'name' => 'online',
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
        $this->values[self::SVR_ID] = null;
        $this->values[self::ONLINE] = null;
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
     * Sets value of 'svr_id' property
     *
     * @param integer $value Property value
     *
     * @return null
     */
    public function setSvrId($value)
    {
        return $this->set(self::SVR_ID, $value);
    }

    /**
     * Returns value of 'svr_id' property
     *
     * @return integer
     */
    public function getSvrId()
    {
        $value = $this->get(self::SVR_ID);
        return $value === null ? (integer)$value : $value;
    }

    /**
     * Returns true if 'svr_id' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasSvrId()
    {
        return $this->get(self::SVR_ID) !== null;
    }

    /**
     * Sets value of 'online' property
     *
     * @param integer $value Property value
     *
     * @return null
     */
    public function setOnline($value)
    {
        return $this->set(self::ONLINE, $value);
    }

    /**
     * Returns value of 'online' property
     *
     * @return integer
     */
    public function getOnline()
    {
        $value = $this->get(self::ONLINE);
        return $value === null ? (integer)$value : $value;
    }

    /**
     * Returns true if 'online' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasOnline()
    {
        return $this->get(self::ONLINE) !== null;
    }
}
}