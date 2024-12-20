<?php
/**
 * Auto generated from poker_msg_ss.proto at 2023-06-08 09:49:25
 */

namespace {
/**
 * PBUpdateData message
 */
class PBUpdateData extends \ProtobufMessage
{
    /* Field index constants */
    const KEY = 1;
    const FIELD_LIST = 2;

    /* @var array Field descriptors */
    protected static $fields = array(
        self::KEY => array(
            'name' => 'key',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_INT,
        ),
        self::FIELD_LIST => array(
            'name' => 'field_list',
            'repeated' => true,
            'type' => '\PBDBAtomicField'
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
        $this->values[self::KEY] = null;
        $this->values[self::FIELD_LIST] = array();
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
     * Sets value of 'key' property
     *
     * @param integer $value Property value
     *
     * @return null
     */
    public function setKey($value)
    {
        return $this->set(self::KEY, $value);
    }

    /**
     * Returns value of 'key' property
     *
     * @return integer
     */
    public function getKey()
    {
        $value = $this->get(self::KEY);
        return $value === null ? (integer)$value : $value;
    }

    /**
     * Returns true if 'key' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasKey()
    {
        return $this->get(self::KEY) !== null;
    }

    /**
     * Appends value to 'field_list' list
     *
     * @param \PBDBAtomicField $value Value to append
     *
     * @return null
     */
    public function appendFieldList(\PBDBAtomicField $value)
    {
        return $this->append(self::FIELD_LIST, $value);
    }

    /**
     * Clears 'field_list' list
     *
     * @return null
     */
    public function clearFieldList()
    {
        return $this->clear(self::FIELD_LIST);
    }

    /**
     * Returns 'field_list' list
     *
     * @return \PBDBAtomicField[]
     */
    public function getFieldList()
    {
        return $this->get(self::FIELD_LIST);
    }

    /**
     * Returns true if 'field_list' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasFieldList()
    {
        return count($this->get(self::FIELD_LIST)) !== 0;
    }

    /**
     * Returns 'field_list' iterator
     *
     * @return \ArrayIterator
     */
    public function getFieldListIterator()
    {
        return new \ArrayIterator($this->get(self::FIELD_LIST));
    }

    /**
     * Returns element from 'field_list' list at given offset
     *
     * @param int $offset Position in list
     *
     * @return \PBDBAtomicField
     */
    public function getFieldListAt($offset)
    {
        return $this->get(self::FIELD_LIST, $offset);
    }

    /**
     * Returns count of 'field_list' list
     *
     * @return int
     */
    public function getFieldListCount()
    {
        return $this->count(self::FIELD_LIST);
    }
}
}