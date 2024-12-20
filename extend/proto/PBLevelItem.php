<?php
/**
 * Auto generated from poker_config.proto at 2023-06-08 09:49:25
 */

namespace {
/**
 * PBLevelItem message
 */
class PBLevelItem extends \ProtobufMessage
{
    /* Field index constants */
    const LEVEL = 1;
    const MIN_EXP = 2;

    /* @var array Field descriptors */
    protected static $fields = array(
        self::LEVEL => array(
            'name' => 'level',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_INT,
        ),
        self::MIN_EXP => array(
            'name' => 'min_exp',
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
        $this->values[self::LEVEL] = null;
        $this->values[self::MIN_EXP] = null;
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
     * Sets value of 'min_exp' property
     *
     * @param integer $value Property value
     *
     * @return null
     */
    public function setMinExp($value)
    {
        return $this->set(self::MIN_EXP, $value);
    }

    /**
     * Returns value of 'min_exp' property
     *
     * @return integer
     */
    public function getMinExp()
    {
        $value = $this->get(self::MIN_EXP);
        return $value === null ? (integer)$value : $value;
    }

    /**
     * Returns true if 'min_exp' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasMinExp()
    {
        return $this->get(self::MIN_EXP) !== null;
    }
}
}