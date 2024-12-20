<?php
/**
 * Auto generated from poker_msg_cs.proto at 2023-06-08 09:49:25
 */

namespace {
/**
 * CSResponseConnectIP message
 */
class CSResponseConnectIP extends \ProtobufMessage
{
    /* Field index constants */
    const CONN_IP = 1;

    /* @var array Field descriptors */
    protected static $fields = array(
        self::CONN_IP => array(
            'name' => 'conn_ip',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_STRING,
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
        $this->values[self::CONN_IP] = null;
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
     * Sets value of 'conn_ip' property
     *
     * @param string $value Property value
     *
     * @return null
     */
    public function setConnIp($value)
    {
        return $this->set(self::CONN_IP, $value);
    }

    /**
     * Returns value of 'conn_ip' property
     *
     * @return string
     */
    public function getConnIp()
    {
        $value = $this->get(self::CONN_IP);
        return $value === null ? (string)$value : $value;
    }

    /**
     * Returns true if 'conn_ip' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasConnIp()
    {
        return $this->get(self::CONN_IP) !== null;
    }
}
}