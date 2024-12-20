<?php
/**
 * Auto generated from poker_data.proto at 2023-06-08 09:49:25
 */

namespace {
/**
 * PBItem message
 */
class PBItem extends \ProtobufMessage
{
    /* Field index constants */
    const ITEM_TYPE = 1;
    const ITEM_VALUE = 2;

    /* @var array Field descriptors */
    protected static $fields = array(
        self::ITEM_TYPE => array(
            'name' => 'item_type',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_INT,
        ),
        self::ITEM_VALUE => array(
            'name' => 'item_value',
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
        $this->values[self::ITEM_TYPE] = null;
        $this->values[self::ITEM_VALUE] = null;
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
     * Sets value of 'item_type' property
     *
     * @param integer $value Property value
     *
     * @return null
     */
    public function setItemType($value)
    {
        return $this->set(self::ITEM_TYPE, $value);
    }

    /**
     * Returns value of 'item_type' property
     *
     * @return integer
     */
    public function getItemType()
    {
        $value = $this->get(self::ITEM_TYPE);
        return $value === null ? (integer)$value : $value;
    }

    /**
     * Returns true if 'item_type' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasItemType()
    {
        return $this->get(self::ITEM_TYPE) !== null;
    }

    /**
     * Sets value of 'item_value' property
     *
     * @param integer $value Property value
     *
     * @return null
     */
    public function setItemValue($value)
    {
        return $this->set(self::ITEM_VALUE, $value);
    }

    /**
     * Returns value of 'item_value' property
     *
     * @return integer
     */
    public function getItemValue()
    {
        $value = $this->get(self::ITEM_VALUE);
        return $value === null ? (integer)$value : $value;
    }

    /**
     * Returns true if 'item_value' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasItemValue()
    {
        return $this->get(self::ITEM_VALUE) !== null;
    }
}
}