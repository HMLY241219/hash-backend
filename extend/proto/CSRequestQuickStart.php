<?php
/**
 * Auto generated from poker_msg_cs.proto at 2023-06-08 09:49:25
 */

namespace {
/**
 * CSRequestQuickStart message
 */
class CSRequestQuickStart extends \ProtobufMessage
{
    /* Field index constants */
    const TTYPE = 1;
    const LEVEL = 2;
    const TID = 3;

    /* @var array Field descriptors */
    protected static $fields = array(
        self::TTYPE => array(
            'name' => 'ttype',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_INT,
        ),
        self::LEVEL => array(
            'name' => 'level',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_INT,
        ),
        self::TID => array(
            'name' => 'tid',
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
        $this->values[self::TTYPE] = null;
        $this->values[self::LEVEL] = null;
        $this->values[self::TID] = null;
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
     * Sets value of 'ttype' property
     *
     * @param integer $value Property value
     *
     * @return null
     */
    public function setTtype($value)
    {
        return $this->set(self::TTYPE, $value);
    }

    /**
     * Returns value of 'ttype' property
     *
     * @return integer
     */
    public function getTtype()
    {
        $value = $this->get(self::TTYPE);
        return $value === null ? (integer)$value : $value;
    }

    /**
     * Returns true if 'ttype' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasTtype()
    {
        return $this->get(self::TTYPE) !== null;
    }

    /**
     * Sets value of 'level' property
     *
     * @param integer $value Property value
     *
     * @return null
     */
    public function setLevel($value)
    {
        return $this->set(self::LEVEL, $value);
    }

    /**
     * Returns value of 'level' property
     *
     * @return integer
     */
    public function getLevel()
    {
        $value = $this->get(self::LEVEL);
        return $value === null ? (integer)$value : $value;
    }

    /**
     * Returns true if 'level' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasLevel()
    {
        return $this->get(self::LEVEL) !== null;
    }

    /**
     * Sets value of 'tid' property
     *
     * @param integer $value Property value
     *
     * @return null
     */
    public function setTid($value)
    {
        return $this->set(self::TID, $value);
    }

    /**
     * Returns value of 'tid' property
     *
     * @return integer
     */
    public function getTid()
    {
        $value = $this->get(self::TID);
        return $value === null ? (integer)$value : $value;
    }

    /**
     * Returns true if 'tid' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasTid()
    {
        return $this->get(self::TID) !== null;
    }
}
}