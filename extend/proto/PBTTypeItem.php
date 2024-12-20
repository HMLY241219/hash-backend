<?php
/**
 * Auto generated from poker_config.proto at 2023-06-08 09:49:25
 */

namespace {
/**
 * PBTTypeItem message
 */
class PBTTypeItem extends \ProtobufMessage
{
    /* Field index constants */
    const TABLE_TYPE = 1;
    const MAX_EXP = 2;
    const WIN_MAIN_MULTI = 3;
    const WIN_OTHER_MULTI = 4;

    /* @var array Field descriptors */
    protected static $fields = array(
        self::TABLE_TYPE => array(
            'name' => 'table_type',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_INT,
        ),
        self::MAX_EXP => array(
            'name' => 'max_exp',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_INT,
        ),
        self::WIN_MAIN_MULTI => array(
            'name' => 'win_main_multi',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_INT,
        ),
        self::WIN_OTHER_MULTI => array(
            'name' => 'win_other_multi',
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
        $this->values[self::TABLE_TYPE] = null;
        $this->values[self::MAX_EXP] = null;
        $this->values[self::WIN_MAIN_MULTI] = null;
        $this->values[self::WIN_OTHER_MULTI] = null;
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
     * Sets value of 'table_type' property
     *
     * @param integer $value Property value
     *
     * @return null
     */
    public function setTableType($value)
    {
        return $this->set(self::TABLE_TYPE, $value);
    }

    /**
     * Returns value of 'table_type' property
     *
     * @return integer
     */
    public function getTableType()
    {
        $value = $this->get(self::TABLE_TYPE);
        return $value === null ? (integer)$value : $value;
    }

    /**
     * Returns true if 'table_type' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasTableType()
    {
        return $this->get(self::TABLE_TYPE) !== null;
    }

    /**
     * Sets value of 'max_exp' property
     *
     * @param integer $value Property value
     *
     * @return null
     */
    public function setMaxExp($value)
    {
        return $this->set(self::MAX_EXP, $value);
    }

    /**
     * Returns value of 'max_exp' property
     *
     * @return integer
     */
    public function getMaxExp()
    {
        $value = $this->get(self::MAX_EXP);
        return $value === null ? (integer)$value : $value;
    }

    /**
     * Returns true if 'max_exp' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasMaxExp()
    {
        return $this->get(self::MAX_EXP) !== null;
    }

    /**
     * Sets value of 'win_main_multi' property
     *
     * @param integer $value Property value
     *
     * @return null
     */
    public function setWinMainMulti($value)
    {
        return $this->set(self::WIN_MAIN_MULTI, $value);
    }

    /**
     * Returns value of 'win_main_multi' property
     *
     * @return integer
     */
    public function getWinMainMulti()
    {
        $value = $this->get(self::WIN_MAIN_MULTI);
        return $value === null ? (integer)$value : $value;
    }

    /**
     * Returns true if 'win_main_multi' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasWinMainMulti()
    {
        return $this->get(self::WIN_MAIN_MULTI) !== null;
    }

    /**
     * Sets value of 'win_other_multi' property
     *
     * @param integer $value Property value
     *
     * @return null
     */
    public function setWinOtherMulti($value)
    {
        return $this->set(self::WIN_OTHER_MULTI, $value);
    }

    /**
     * Returns value of 'win_other_multi' property
     *
     * @return integer
     */
    public function getWinOtherMulti()
    {
        $value = $this->get(self::WIN_OTHER_MULTI);
        return $value === null ? (integer)$value : $value;
    }

    /**
     * Returns true if 'win_other_multi' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasWinOtherMulti()
    {
        return $this->get(self::WIN_OTHER_MULTI) !== null;
    }
}
}