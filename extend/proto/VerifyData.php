<?php
/**
 * Auto generated from poker_msg_basic.proto at 2023-06-08 09:49:25
 */

namespace {
/**
 * VerifyData message
 */
class VerifyData extends \ProtobufMessage
{
    /* Field index constants */
    const CARDS = 1;
    const SPLIT_HASH = 2;
    const VALUE = 3;

    /* @var array Field descriptors */
    protected static $fields = array(
        self::CARDS => array(
            'name' => 'cards',
            'repeated' => true,
            'type' => \ProtobufMessage::PB_TYPE_INT,
        ),
        self::SPLIT_HASH => array(
            'name' => 'split_hash',
            'repeated' => true,
            'type' => \ProtobufMessage::PB_TYPE_STRING,
        ),
        self::VALUE => array(
            'name' => 'value',
            'repeated' => true,
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
        $this->values[self::SPLIT_HASH] = array();
        $this->values[self::VALUE] = array();
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
     * Appends value to 'split_hash' list
     *
     * @param string $value Value to append
     *
     * @return null
     */
    public function appendSplitHash($value)
    {
        return $this->append(self::SPLIT_HASH, $value);
    }

    /**
     * Clears 'split_hash' list
     *
     * @return null
     */
    public function clearSplitHash()
    {
        return $this->clear(self::SPLIT_HASH);
    }

    /**
     * Returns 'split_hash' list
     *
     * @return string[]
     */
    public function getSplitHash()
    {
        return $this->get(self::SPLIT_HASH);
    }

    /**
     * Returns true if 'split_hash' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasSplitHash()
    {
        return count($this->get(self::SPLIT_HASH)) !== 0;
    }

    /**
     * Returns 'split_hash' iterator
     *
     * @return \ArrayIterator
     */
    public function getSplitHashIterator()
    {
        return new \ArrayIterator($this->get(self::SPLIT_HASH));
    }

    /**
     * Returns element from 'split_hash' list at given offset
     *
     * @param int $offset Position in list
     *
     * @return string
     */
    public function getSplitHashAt($offset)
    {
        return $this->get(self::SPLIT_HASH, $offset);
    }

    /**
     * Returns count of 'split_hash' list
     *
     * @return int
     */
    public function getSplitHashCount()
    {
        return $this->count(self::SPLIT_HASH);
    }

    /**
     * Appends value to 'value' list
     *
     * @param integer $value Value to append
     *
     * @return null
     */
    public function appendValue($value)
    {
        return $this->append(self::VALUE, $value);
    }

    /**
     * Clears 'value' list
     *
     * @return null
     */
    public function clearValue()
    {
        return $this->clear(self::VALUE);
    }

    /**
     * Returns 'value' list
     *
     * @return integer[]
     */
    public function getValue()
    {
        return $this->get(self::VALUE);
    }

    /**
     * Returns true if 'value' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasValue()
    {
        return count($this->get(self::VALUE)) !== 0;
    }

    /**
     * Returns 'value' iterator
     *
     * @return \ArrayIterator
     */
    public function getValueIterator()
    {
        return new \ArrayIterator($this->get(self::VALUE));
    }

    /**
     * Returns element from 'value' list at given offset
     *
     * @param int $offset Position in list
     *
     * @return integer
     */
    public function getValueAt($offset)
    {
        return $this->get(self::VALUE, $offset);
    }

    /**
     * Returns count of 'value' list
     *
     * @return int
     */
    public function getValueCount()
    {
        return $this->count(self::VALUE);
    }
}
}