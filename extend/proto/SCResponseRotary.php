<?php
/**
 * Auto generated from poker_msg_cs.proto at 2023-06-08 09:49:25
 */

namespace {
/**
 * SCResponseRotary message
 */
class SCResponseRotary extends \ProtobufMessage
{
    /* Field index constants */
    const RESULT = 1;
    const INFO = 2;
    const ROTARY_NUM = 3;

    /* @var array Field descriptors */
    protected static $fields = array(
        self::RESULT => array(
            'name' => 'result',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_INT,
        ),
        self::INFO => array(
            'name' => 'info',
            'required' => false,
            'type' => '\CSRotaryConfiginfo'
        ),
        self::ROTARY_NUM => array(
            'name' => 'rotary_num',
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
        $this->values[self::INFO] = null;
        $this->values[self::ROTARY_NUM] = null;
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
     * Sets value of 'info' property
     *
     * @param \CSRotaryConfiginfo $value Property value
     *
     * @return null
     */
    public function setInfo(\CSRotaryConfiginfo $value=null)
    {
        return $this->set(self::INFO, $value);
    }

    /**
     * Returns value of 'info' property
     *
     * @return \CSRotaryConfiginfo
     */
    public function getInfo()
    {
        return $this->get(self::INFO);
    }

    /**
     * Returns true if 'info' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasInfo()
    {
        return $this->get(self::INFO) !== null;
    }

    /**
     * Sets value of 'rotary_num' property
     *
     * @param integer $value Property value
     *
     * @return null
     */
    public function setRotaryNum($value)
    {
        return $this->set(self::ROTARY_NUM, $value);
    }

    /**
     * Returns value of 'rotary_num' property
     *
     * @return integer
     */
    public function getRotaryNum()
    {
        $value = $this->get(self::ROTARY_NUM);
        return $value === null ? (integer)$value : $value;
    }

    /**
     * Returns true if 'rotary_num' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasRotaryNum()
    {
        return $this->get(self::ROTARY_NUM) !== null;
    }
}
}