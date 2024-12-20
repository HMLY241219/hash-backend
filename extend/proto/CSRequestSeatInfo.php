<?php
/**
 * Auto generated from poker_msg_cs.proto at 2023-06-08 09:49:25
 */

namespace {
/**
 * CSRequestSeatInfo message
 */
class CSRequestSeatInfo extends \ProtobufMessage
{
    /* Field index constants */
    const B = 1;
    const INDEX = 2;

    /* @var array Field descriptors */
    protected static $fields = array(
        self::B => array(
            'name' => 'b',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_BOOL,
        ),
        self::INDEX => array(
            'name' => 'index',
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
        $this->values[self::B] = null;
        $this->values[self::INDEX] = null;
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
     * Sets value of 'b' property
     *
     * @param boolean $value Property value
     *
     * @return null
     */
    public function setB($value)
    {
        return $this->set(self::B, $value);
    }

    /**
     * Returns value of 'b' property
     *
     * @return boolean
     */
    public function getB()
    {
        $value = $this->get(self::B);
        return $value === null ? (boolean)$value : $value;
    }

    /**
     * Returns true if 'b' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasB()
    {
        return $this->get(self::B) !== null;
    }

    /**
     * Sets value of 'index' property
     *
     * @param integer $value Property value
     *
     * @return null
     */
    public function setIndex($value)
    {
        return $this->set(self::INDEX, $value);
    }

    /**
     * Returns value of 'index' property
     *
     * @return integer
     */
    public function getIndex()
    {
        $value = $this->get(self::INDEX);
        return $value === null ? (integer)$value : $value;
    }

    /**
     * Returns true if 'index' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasIndex()
    {
        return $this->get(self::INDEX) !== null;
    }
}
}