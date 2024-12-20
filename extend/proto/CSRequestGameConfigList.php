<?php
/**
 * Auto generated from poker_msg_cs.proto at 2023-06-08 09:49:25
 */

namespace {
/**
 * CSRequestGameConfigList message
 */
class CSRequestGameConfigList extends \ProtobufMessage
{
    /* Field index constants */
    const IS_COINS = 1;
    const POS_TYPE = 2;

    /* @var array Field descriptors */
    protected static $fields = array(
        self::IS_COINS => array(
            'name' => 'is_coins',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_BOOL,
        ),
        self::POS_TYPE => array(
            'name' => 'pos_type',
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
        $this->values[self::IS_COINS] = null;
        $this->values[self::POS_TYPE] = null;
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
     * Sets value of 'is_coins' property
     *
     * @param boolean $value Property value
     *
     * @return null
     */
    public function setIsCoins($value)
    {
        return $this->set(self::IS_COINS, $value);
    }

    /**
     * Returns value of 'is_coins' property
     *
     * @return boolean
     */
    public function getIsCoins()
    {
        $value = $this->get(self::IS_COINS);
        return $value === null ? (boolean)$value : $value;
    }

    /**
     * Returns true if 'is_coins' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasIsCoins()
    {
        return $this->get(self::IS_COINS) !== null;
    }

    /**
     * Sets value of 'pos_type' property
     *
     * @param integer $value Property value
     *
     * @return null
     */
    public function setPosType($value)
    {
        return $this->set(self::POS_TYPE, $value);
    }

    /**
     * Returns value of 'pos_type' property
     *
     * @return integer
     */
    public function getPosType()
    {
        $value = $this->get(self::POS_TYPE);
        return $value === null ? (integer)$value : $value;
    }

    /**
     * Returns true if 'pos_type' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasPosType()
    {
        return $this->get(self::POS_TYPE) !== null;
    }
}
}