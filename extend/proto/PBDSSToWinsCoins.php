<?php
/**
 * Auto generated from poker_msg_basic.proto at 2023-06-08 09:49:25
 */

namespace {
/**
 * PBDSSToWinsCoins message
 */
class PBDSSToWinsCoins extends \ProtobufMessage
{
    /* Field index constants */
    const BET = 1;
    const MULTIPLE = 2;
    const PORFIT = 3;

    /* @var array Field descriptors */
    protected static $fields = array(
        self::BET => array(
            'name' => 'bet',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_INT,
        ),
        self::MULTIPLE => array(
            'name' => 'multiple',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_FLOAT,
        ),
        self::PORFIT => array(
            'name' => 'porfit',
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
        $this->values[self::BET] = null;
        $this->values[self::MULTIPLE] = null;
        $this->values[self::PORFIT] = null;
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
     * Sets value of 'bet' property
     *
     * @param integer $value Property value
     *
     * @return null
     */
    public function setBet($value)
    {
        return $this->set(self::BET, $value);
    }

    /**
     * Returns value of 'bet' property
     *
     * @return integer
     */
    public function getBet()
    {
        $value = $this->get(self::BET);
        return $value === null ? (integer)$value : $value;
    }

    /**
     * Returns true if 'bet' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasBet()
    {
        return $this->get(self::BET) !== null;
    }

    /**
     * Sets value of 'multiple' property
     *
     * @param double $value Property value
     *
     * @return null
     */
    public function setMultiple($value)
    {
        return $this->set(self::MULTIPLE, $value);
    }

    /**
     * Returns value of 'multiple' property
     *
     * @return double
     */
    public function getMultiple()
    {
        $value = $this->get(self::MULTIPLE);
        return $value === null ? (double)$value : $value;
    }

    /**
     * Returns true if 'multiple' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasMultiple()
    {
        return $this->get(self::MULTIPLE) !== null;
    }

    /**
     * Sets value of 'porfit' property
     *
     * @param integer $value Property value
     *
     * @return null
     */
    public function setPorfit($value)
    {
        return $this->set(self::PORFIT, $value);
    }

    /**
     * Returns value of 'porfit' property
     *
     * @return integer
     */
    public function getPorfit()
    {
        $value = $this->get(self::PORFIT);
        return $value === null ? (integer)$value : $value;
    }

    /**
     * Returns true if 'porfit' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasPorfit()
    {
        return $this->get(self::PORFIT) !== null;
    }
}
}