<?php
/**
 * Auto generated from poker_msg_basic.proto at 2023-06-08 09:49:25
 */

namespace {
/**
 * PBDSSColumnInfo message
 */
class PBDSSColumnInfo extends \ProtobufMessage
{
    /* Field index constants */
    const CARDS = 1;
    const COL_TYPE = 2;
    const START_VALUE = 3;

    /* @var array Field descriptors */
    protected static $fields = array(
        self::CARDS => array(
            'name' => 'cards',
            'repeated' => true,
            'type' => \ProtobufMessage::PB_TYPE_INT,
        ),
        self::COL_TYPE => array(
            'name' => 'col_type',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_INT,
        ),
        self::START_VALUE => array(
            'name' => 'start_value',
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
        $this->values[self::CARDS] = array();
        $this->values[self::COL_TYPE] = null;
        $this->values[self::START_VALUE] = null;
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
     * Appends value to 'cards' list
     *
     * @param integer $value Value to append
     *
     * @return null
     */
    public function appendCards($value)
    {
        return $this->append(self::CARDS, $value);
    }

    /**
     * Clears 'cards' list
     *
     * @return null
     */
    public function clearCards()
    {
        return $this->clear(self::CARDS);
    }

    /**
     * Returns 'cards' list
     *
     * @return integer[]
     */
    public function getCards()
    {
        return $this->get(self::CARDS);
    }

    /**
     * Returns true if 'cards' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasCards()
    {
        return count($this->get(self::CARDS)) !== 0;
    }

    /**
     * Returns 'cards' iterator
     *
     * @return \ArrayIterator
     */
    public function getCardsIterator()
    {
        return new \ArrayIterator($this->get(self::CARDS));
    }

    /**
     * Returns element from 'cards' list at given offset
     *
     * @param int $offset Position in list
     *
     * @return integer
     */
    public function getCardsAt($offset)
    {
        return $this->get(self::CARDS, $offset);
    }

    /**
     * Returns count of 'cards' list
     *
     * @return int
     */
    public function getCardsCount()
    {
        return $this->count(self::CARDS);
    }

    /**
     * Sets value of 'col_type' property
     *
     * @param integer $value Property value
     *
     * @return null
     */
    public function setColType($value)
    {
        return $this->set(self::COL_TYPE, $value);
    }

    /**
     * Returns value of 'col_type' property
     *
     * @return integer
     */
    public function getColType()
    {
        $value = $this->get(self::COL_TYPE);
        return $value === null ? (integer)$value : $value;
    }

    /**
     * Returns true if 'col_type' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasColType()
    {
        return $this->get(self::COL_TYPE) !== null;
    }

    /**
     * Sets value of 'start_value' property
     *
     * @param integer $value Property value
     *
     * @return null
     */
    public function setStartValue($value)
    {
        return $this->set(self::START_VALUE, $value);
    }

    /**
     * Returns value of 'start_value' property
     *
     * @return integer
     */
    public function getStartValue()
    {
        $value = $this->get(self::START_VALUE);
        return $value === null ? (integer)$value : $value;
    }

    /**
     * Returns true if 'start_value' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasStartValue()
    {
        return $this->get(self::START_VALUE) !== null;
    }
}
}