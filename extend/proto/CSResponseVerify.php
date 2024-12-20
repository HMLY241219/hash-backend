<?php
/**
 * Auto generated from poker_msg_cs.proto at 2023-06-08 09:49:25
 */

namespace {
/**
 * CSResponseVerify message
 */
class CSResponseVerify extends \ProtobufMessage
{
    /* Field index constants */
    const RESULT = 1;
    const END_VERIFY = 2;

    /* @var array Field descriptors */
    protected static $fields = array(
        self::RESULT => array(
            'name' => 'result',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_INT,
        ),
        self::END_VERIFY => array(
            'name' => 'end_verify',
            'required' => false,
            'type' => '\PBEndVerify'
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
        $this->values[self::END_VERIFY] = null;
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
     * Sets value of 'end_verify' property
     *
     * @param \PBEndVerify $value Property value
     *
     * @return null
     */
    public function setEndVerify(\PBEndVerify $value=null)
    {
        return $this->set(self::END_VERIFY, $value);
    }

    /**
     * Returns value of 'end_verify' property
     *
     * @return \PBEndVerify
     */
    public function getEndVerify()
    {
        return $this->get(self::END_VERIFY);
    }

    /**
     * Returns true if 'end_verify' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasEndVerify()
    {
        return $this->get(self::END_VERIFY) !== null;
    }
}
}