<?php
/**
 * Auto generated from poker_msg_ss.proto at 2023-06-08 09:49:25
 */

namespace {
/**
 * PBRedisData message
 */
class PBRedisData extends \ProtobufMessage
{
    /* Field index constants */
    const KEY = 1;
    const BUFF = 2;
    const RESULT = 3;

    /* @var array Field descriptors */
    protected static $fields = array(
        self::KEY => array(
            'name' => 'key',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_INT,
        ),
        self::BUFF => array(
            'name' => 'buff',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_STRING,
        ),
        self::RESULT => array(
            'name' => 'result',
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
        $this->values[self::KEY] = null;
        $this->values[self::BUFF] = null;
        $this->values[self::RESULT] = null;
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
     * Sets value of 'key' property
     *
     * @param integer $value Property value
     *
     * @return null
     */
    public function setKey($value)
    {
        return $this->set(self::KEY, $value);
    }

    /**
     * Returns value of 'key' property
     *
     * @return integer
     */
    public function getKey()
    {
        $value = $this->get(self::KEY);
        return $value === null ? (integer)$value : $value;
    }

    /**
     * Returns true if 'key' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasKey()
    {
        return $this->get(self::KEY) !== null;
    }

    /**
     * Sets value of 'buff' property
     *
     * @param string $value Property value
     *
     * @return null
     */
    public function setBuff($value)
    {
        return $this->set(self::BUFF, $value);
    }

    /**
     * Returns value of 'buff' property
     *
     * @return string
     */
    public function getBuff()
    {
        $value = $this->get(self::BUFF);
        return $value === null ? (string)$value : $value;
    }

    /**
     * Returns true if 'buff' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasBuff()
    {
        return $this->get(self::BUFF) !== null;
    }

    /**
     * Sets value of 'result' property
     *
     * @param boolean $value Property value
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
     * @return boolean
     */
    public function getResult()
    {
        $value = $this->get(self::RESULT);
        return $value === null ? (boolean)$value : $value;
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
}
}