<?php
/**
 * Auto generated from poker_msg_basic.proto at 2023-06-08 09:49:25
 */

namespace {
/**
 * CSHandCardsInfo message
 */
class CSHandCardsInfo extends \ProtobufMessage
{
    /* Field index constants */
    const UID = 1;
    const HAND_CARDS = 2;
    const REAL_HAND_CARDS = 3;
    const STYLE_TYPE = 4;

    /* @var array Field descriptors */
    protected static $fields = array(
        self::UID => array(
            'name' => 'uid',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_INT,
        ),
        self::HAND_CARDS => array(
            'name' => 'hand_cards',
            'repeated' => true,
            'type' => \ProtobufMessage::PB_TYPE_INT,
        ),
        self::REAL_HAND_CARDS => array(
            'name' => 'real_hand_cards',
            'repeated' => true,
            'type' => \ProtobufMessage::PB_TYPE_INT,
        ),
        self::STYLE_TYPE => array(
            'name' => 'style_type',
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
        $this->values[self::UID] = null;
        $this->values[self::HAND_CARDS] = array();
        $this->values[self::REAL_HAND_CARDS] = array();
        $this->values[self::STYLE_TYPE] = null;
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
     * Sets value of 'uid' property
     *
     * @param integer $value Property value
     *
     * @return null
     */
    public function setUid($value)
    {
        return $this->set(self::UID, $value);
    }

    /**
     * Returns value of 'uid' property
     *
     * @return integer
     */
    public function getUid()
    {
        $value = $this->get(self::UID);
        return $value === null ? (integer)$value : $value;
    }

    /**
     * Returns true if 'uid' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasUid()
    {
        return $this->get(self::UID) !== null;
    }

    /**
     * Appends value to 'hand_cards' list
     *
     * @param integer $value Value to append
     *
     * @return null
     */
    public function appendHandCards($value)
    {
        return $this->append(self::HAND_CARDS, $value);
    }

    /**
     * Clears 'hand_cards' list
     *
     * @return null
     */
    public function clearHandCards()
    {
        return $this->clear(self::HAND_CARDS);
    }

    /**
     * Returns 'hand_cards' list
     *
     * @return integer[]
     */
    public function getHandCards()
    {
        return $this->get(self::HAND_CARDS);
    }

    /**
     * Returns true if 'hand_cards' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasHandCards()
    {
        return count($this->get(self::HAND_CARDS)) !== 0;
    }

    /**
     * Returns 'hand_cards' iterator
     *
     * @return \ArrayIterator
     */
    public function getHandCardsIterator()
    {
        return new \ArrayIterator($this->get(self::HAND_CARDS));
    }

    /**
     * Returns element from 'hand_cards' list at given offset
     *
     * @param int $offset Position in list
     *
     * @return integer
     */
    public function getHandCardsAt($offset)
    {
        return $this->get(self::HAND_CARDS, $offset);
    }

    /**
     * Returns count of 'hand_cards' list
     *
     * @return int
     */
    public function getHandCardsCount()
    {
        return $this->count(self::HAND_CARDS);
    }

    /**
     * Appends value to 'real_hand_cards' list
     *
     * @param integer $value Value to append
     *
     * @return null
     */
    public function appendRealHandCards($value)
    {
        return $this->append(self::REAL_HAND_CARDS, $value);
    }

    /**
     * Clears 'real_hand_cards' list
     *
     * @return null
     */
    public function clearRealHandCards()
    {
        return $this->clear(self::REAL_HAND_CARDS);
    }

    /**
     * Returns 'real_hand_cards' list
     *
     * @return integer[]
     */
    public function getRealHandCards()
    {
        return $this->get(self::REAL_HAND_CARDS);
    }

    /**
     * Returns true if 'real_hand_cards' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasRealHandCards()
    {
        return count($this->get(self::REAL_HAND_CARDS)) !== 0;
    }

    /**
     * Returns 'real_hand_cards' iterator
     *
     * @return \ArrayIterator
     */
    public function getRealHandCardsIterator()
    {
        return new \ArrayIterator($this->get(self::REAL_HAND_CARDS));
    }

    /**
     * Returns element from 'real_hand_cards' list at given offset
     *
     * @param int $offset Position in list
     *
     * @return integer
     */
    public function getRealHandCardsAt($offset)
    {
        return $this->get(self::REAL_HAND_CARDS, $offset);
    }

    /**
     * Returns count of 'real_hand_cards' list
     *
     * @return int
     */
    public function getRealHandCardsCount()
    {
        return $this->count(self::REAL_HAND_CARDS);
    }

    /**
     * Sets value of 'style_type' property
     *
     * @param integer $value Property value
     *
     * @return null
     */
    public function setStyleType($value)
    {
        return $this->set(self::STYLE_TYPE, $value);
    }

    /**
     * Returns value of 'style_type' property
     *
     * @return integer
     */
    public function getStyleType()
    {
        $value = $this->get(self::STYLE_TYPE);
        return $value === null ? (integer)$value : $value;
    }

    /**
     * Returns true if 'style_type' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasStyleType()
    {
        return $this->get(self::STYLE_TYPE) !== null;
    }
}
}