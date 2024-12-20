<?php
/**
 * Auto generated from poker_msg_ss.proto at 2023-06-08 09:49:25
 */

namespace {
/**
 * SSResponseAccountUid message
 */
class SSResponseAccountUid extends \ProtobufMessage
{
    /* Field index constants */
    const RESULT = 1;
    const UID = 2;
    const ISCREATED = 3;
    const CHANNEL = 4;

    /* @var array Field descriptors */
    protected static $fields = array(
        self::RESULT => array(
            'name' => 'result',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_INT,
        ),
        self::UID => array(
            'name' => 'uid',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_INT,
        ),
        self::ISCREATED => array(
            'default' => false,
            'name' => 'iscreated',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_BOOL,
        ),
        self::CHANNEL => array(
            'name' => 'channel',
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
        $this->values[self::RESULT] = null;
        $this->values[self::UID] = null;
        $this->values[self::ISCREATED] = self::$fields[self::ISCREATED]['default'];
        $this->values[self::CHANNEL] = null;
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
     * Sets value of 'result' property
     *
     * @param integer $value Property value
     *
     * @return null
     */
    public function setResult($value)
    {
        return $this->set(self::RESULT, $value);
    }

    /**
     * Returns value of 'result' property
     *
     * @return integer
     */
    public function getResult()
    {
        $value = $this->get(self::RESULT);
        return $value === null ? (integer)$value : $value;
    }

    /**
     * Returns true if 'result' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasResult()
    {
        return $this->get(self::RESULT) !== null;
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
     * Sets value of 'iscreated' property
     *
     * @param boolean $value Property value
     *
     * @return null
     */
    public function setIscreated($value)
    {
        return $this->set(self::ISCREATED, $value);
    }

    /**
     * Returns value of 'iscreated' property
     *
     * @return boolean
     */
    public function getIscreated()
    {
        $value = $this->get(self::ISCREATED);
        return $value === null ? (boolean)$value : $value;
    }

    /**
     * Returns true if 'iscreated' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasIscreated()
    {
        return $this->get(self::ISCREATED) !== null;
    }

    /**
     * Sets value of 'channel' property
     *
     * @param integer $value Property value
     *
     * @return null
     */
    public function setChannel($value)
    {
        return $this->set(self::CHANNEL, $value);
    }

    /**
     * Returns value of 'channel' property
     *
     * @return integer
     */
    public function getChannel()
    {
        $value = $this->get(self::CHANNEL);
        return $value === null ? (integer)$value : $value;
    }

    /**
     * Returns true if 'channel' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasChannel()
    {
        return $this->get(self::CHANNEL) !== null;
    }
}
}