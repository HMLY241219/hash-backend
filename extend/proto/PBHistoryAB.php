<?php
/**
 * Auto generated from poker_msg_basic.proto at 2023-06-08 09:49:25
 */

namespace {
/**
 * PBHistoryAB message
 */
class PBHistoryAB extends \ProtobufMessage
{
    /* Field index constants */
    const CARD = 1;
    const TYPE = 2;

    /* @var array Field descriptors */
    protected static $fields = array(
        self::CARD => array(
            'name' => 'card',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_INT,
        ),
        self::TYPE => array(
            'name' => 'type',
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
        $this->values[self::CARD] = null;
        $this->values[self::TYPE] = null;
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
     * Sets value of 'card' property
     *
     * @param integer $value Property value
     *
     * @return null
     */
    public function setCard($value)
    {
        return $this->set(self::CARD, $value);
    }

    /**
     * Returns value of 'card' property
     *
     * @return integer
     */
    public function getCard()
    {
        $value = $this->get(self::CARD);
        return $value === null ? (integer)$value : $value;
    }

    /**
     * Returns true if 'card' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasCard()
    {
        return $this->get(self::CARD) !== null;
    }

    /**
     * Sets value of 'type' property
     *
     * @param integer $value Property value
     *
     * @return null
     */
    public function setType($value)
    {
        return $this->set(self::TYPE, $value);
    }

    /**
     * Returns value of 'type' property
     *
     * @return integer
     */
    public function getType()
    {
        $value = $this->get(self::TYPE);
        return $value === null ? (integer)$value : $value;
    }

    /**
     * Returns true if 'type' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasType()
    {
        return $this->get(self::TYPE) !== null;
    }
}
}