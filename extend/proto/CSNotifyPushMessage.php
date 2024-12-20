<?php
/**
 * Auto generated from poker_msg_cs.proto at 2023-06-08 09:49:25
 */

namespace {
/**
 * CSNotifyPushMessage message
 */
class CSNotifyPushMessage extends \ProtobufMessage
{
    /* Field index constants */
    const STAMP = 1;
    const MESSAGE = 2;

    /* @var array Field descriptors */
    protected static $fields = array(
        self::STAMP => array(
            'name' => 'stamp',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_INT,
        ),
        self::MESSAGE => array(
            'name' => 'message',
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
        $this->values[self::STAMP] = null;
        $this->values[self::MESSAGE] = null;
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
     * Sets value of 'stamp' property
     *
     * @param integer $value Property value
     *
     * @return null
     */
    public function setStamp($value)
    {
        return $this->set(self::STAMP, $value);
    }

    /**
     * Returns value of 'stamp' property
     *
     * @return integer
     */
    public function getStamp()
    {
        $value = $this->get(self::STAMP);
        return $value === null ? (integer)$value : $value;
    }

    /**
     * Returns true if 'stamp' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasStamp()
    {
        return $this->get(self::STAMP) !== null;
    }

    /**
     * Sets value of 'message' property
     *
     * @param string $value Property value
     *
     * @return null
     */
    public function setMessage($value)
    {
        return $this->set(self::MESSAGE, $value);
    }

    /**
     * Returns value of 'message' property
     *
     * @return string
     */
    public function getMessage()
    {
        $value = $this->get(self::MESSAGE);
        return $value === null ? (string)$value : $value;
    }

    /**
     * Returns true if 'message' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasMessage()
    {
        return $this->get(self::MESSAGE) !== null;
    }
}
}