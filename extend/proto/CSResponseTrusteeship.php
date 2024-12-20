<?php
/**
 * Auto generated from poker_msg_cs.proto at 2023-06-08 09:49:25
 */

namespace {
/**
 * CSResponseTrusteeship message
 */
class CSResponseTrusteeship extends \ProtobufMessage
{
    /* Field index constants */
    const RESULT = 1;
    const IS_TRUSTEESHIP = 2;

    /* @var array Field descriptors */
    protected static $fields = array(
        self::RESULT => array(
            'name' => 'result',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_INT,
        ),
        self::IS_TRUSTEESHIP => array(
            'name' => 'is_trusteeship',
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
        $this->values[self::RESULT] = null;
        $this->values[self::IS_TRUSTEESHIP] = null;
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
     * Sets value of 'is_trusteeship' property
     *
     * @param boolean $value Property value
     *
     * @return null
     */
    public function setIsTrusteeship($value)
    {
        return $this->set(self::IS_TRUSTEESHIP, $value);
    }

    /**
     * Returns value of 'is_trusteeship' property
     *
     * @return boolean
     */
    public function getIsTrusteeship()
    {
        $value = $this->get(self::IS_TRUSTEESHIP);
        return $value === null ? (boolean)$value : $value;
    }

    /**
     * Returns true if 'is_trusteeship' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasIsTrusteeship()
    {
        return $this->get(self::IS_TRUSTEESHIP) !== null;
    }
}
}