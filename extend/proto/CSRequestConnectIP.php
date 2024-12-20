<?php
/**
 * Auto generated from poker_msg_cs.proto at 2023-06-08 09:49:25
 */

namespace {
/**
 * CSRequestConnectIP message
 */
class CSRequestConnectIP extends \ProtobufMessage
{
    /* Field index constants */
    const UID = 1;
    const REQUEST_CONNECT_IP = 2;

    /* @var array Field descriptors */
    protected static $fields = array(
        self::UID => array(
            'name' => 'uid',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_INT,
        ),
        self::REQUEST_CONNECT_IP => array(
            'name' => 'request_connect_ip',
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
        $this->values[self::UID] = null;
        $this->values[self::REQUEST_CONNECT_IP] = null;
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
     * Sets value of 'uid' property
     *
     * @param integer $value Property value
     *
     * @return null
     */
    public function setUid($value)
    {
        return $this->set(self::UID, $value);
    }

    /**
     * Returns value of 'uid' property
     *
     * @return integer
     */
    public function getUid()
    {
        $value = $this->get(self::UID);
        return $value === null ? (integer)$value : $value;
    }

    /**
     * Returns true if 'uid' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasUid()
    {
        return $this->get(self::UID) !== null;
    }

    /**
     * Sets value of 'request_connect_ip' property
     *
     * @param string $value Property value
     *
     * @return null
     */
    public function setRequestConnectIp($value)
    {
        return $this->set(self::REQUEST_CONNECT_IP, $value);
    }

    /**
     * Returns value of 'request_connect_ip' property
     *
     * @return string
     */
    public function getRequestConnectIp()
    {
        $value = $this->get(self::REQUEST_CONNECT_IP);
        return $value === null ? (string)$value : $value;
    }

    /**
     * Returns true if 'request_connect_ip' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasRequestConnectIp()
    {
        return $this->get(self::REQUEST_CONNECT_IP) !== null;
    }
}
}