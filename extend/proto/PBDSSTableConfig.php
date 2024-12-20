<?php
/**
 * Auto generated from poker_data.proto at 2023-06-08 09:49:25
 */

namespace {
/**
 * PBDSSTableConfig message
 */
class PBDSSTableConfig extends \ProtobufMessage
{
    /* Field index constants */
    const TTYPE = 1;
    const SEAT_NUM = 2;
    const LEVEL = 3;
    const BASE_CHIP = 4;
    const MAX_MULTIPLE = 5;

    /* @var array Field descriptors */
    protected static $fields = array(
        self::TTYPE => array(
            'name' => 'ttype',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_INT,
        ),
        self::SEAT_NUM => array(
            'default' => 3,
            'name' => 'seat_num',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_INT,
        ),
        self::LEVEL => array(
            'name' => 'level',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_INT,
        ),
        self::BASE_CHIP => array(
            'name' => 'base_chip',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_INT,
        ),
        self::MAX_MULTIPLE => array(
            'name' => 'max_multiple',
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
        $this->values[self::SEAT_NUM] = self::$fields[self::SEAT_NUM]['default'];
        $this->values[self::LEVEL] = null;
        $this->values[self::BASE_CHIP] = null;
        $this->values[self::MAX_MULTIPLE] = null;
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
     * Sets value of 'seat_num' property
     *
     * @param integer $value Property value
     *
     * @return null
     */
    public function setSeatNum($value)
    {
        return $this->set(self::SEAT_NUM, $value);
    }

    /**
     * Returns value of 'seat_num' property
     *
     * @return integer
     */
    public function getSeatNum()
    {
        $value = $this->get(self::SEAT_NUM);
        return $value === null ? (integer)$value : $value;
    }

    /**
     * Returns true if 'seat_num' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasSeatNum()
    {
        return $this->get(self::SEAT_NUM) !== null;
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
     * Sets value of 'base_chip' property
     *
     * @param integer $value Property value
     *
     * @return null
     */
    public function setBaseChip($value)
    {
        return $this->set(self::BASE_CHIP, $value);
    }

    /**
     * Returns value of 'base_chip' property
     *
     * @return integer
     */
    public function getBaseChip()
    {
        $value = $this->get(self::BASE_CHIP);
        return $value === null ? (integer)$value : $value;
    }

    /**
     * Returns true if 'base_chip' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasBaseChip()
    {
        return $this->get(self::BASE_CHIP) !== null;
    }

    /**
     * Sets value of 'max_multiple' property
     *
     * @param integer $value Property value
     *
     * @return null
     */
    public function setMaxMultiple($value)
    {
        return $this->set(self::MAX_MULTIPLE, $value);
    }

    /**
     * Returns value of 'max_multiple' property
     *
     * @return integer
     */
    public function getMaxMultiple()
    {
        $value = $this->get(self::MAX_MULTIPLE);
        return $value === null ? (integer)$value : $value;
    }

    /**
     * Returns true if 'max_multiple' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasMaxMultiple()
    {
        return $this->get(self::MAX_MULTIPLE) !== null;
    }
}
}