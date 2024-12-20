<?php
/**
 * Auto generated from poker_msg_basic.proto at 2023-06-08 09:49:25
 */

namespace {
/**
 * PBDSSMinesDesktopInfo message
 */
class PBDSSMinesDesktopInfo extends \ProtobufMessage
{
    /* Field index constants */
    const INDEX = 1;
    const STATUS = 2;
    const MINES = 3;

    /* @var array Field descriptors */
    protected static $fields = array(
        self::INDEX => array(
            'name' => 'index',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_INT,
        ),
        self::STATUS => array(
            'name' => 'status',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_INT,
        ),
        self::MINES => array(
            'name' => 'mines',
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
        $this->values[self::INDEX] = null;
        $this->values[self::STATUS] = null;
        $this->values[self::MINES] = null;
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

    /**
     * Sets value of 'status' property
     *
     * @param integer $value Property value
     *
     * @return null
     */
    public function setStatus($value)
    {
        return $this->set(self::STATUS, $value);
    }

    /**
     * Returns value of 'status' property
     *
     * @return integer
     */
    public function getStatus()
    {
        $value = $this->get(self::STATUS);
        return $value === null ? (integer)$value : $value;
    }

    /**
     * Returns true if 'status' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasStatus()
    {
        return $this->get(self::STATUS) !== null;
    }

    /**
     * Sets value of 'mines' property
     *
     * @param boolean $value Property value
     *
     * @return null
     */
    public function setMines($value)
    {
        return $this->set(self::MINES, $value);
    }

    /**
     * Returns value of 'mines' property
     *
     * @return boolean
     */
    public function getMines()
    {
        $value = $this->get(self::MINES);
        return $value === null ? (boolean)$value : $value;
    }

    /**
     * Returns true if 'mines' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasMines()
    {
        return $this->get(self::MINES) !== null;
    }
}
}