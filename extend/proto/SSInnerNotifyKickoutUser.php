<?php
/**
 * Auto generated from poker_msg_ss.proto at 2023-06-08 09:49:25
 */

namespace {
/**
 * SSInnerNotifyKickoutUser message
 */
class SSInnerNotifyKickoutUser extends \ProtobufMessage
{
    /* Field index constants */
    const TID = 1;
    const INDEXS = 2;
    const REASON = 3;

    /* @var array Field descriptors */
    protected static $fields = array(
        self::TID => array(
            'name' => 'tid',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_INT,
        ),
        self::INDEXS => array(
            'name' => 'indexs',
            'repeated' => true,
            'type' => \ProtobufMessage::PB_TYPE_INT,
        ),
        self::REASON => array(
            'name' => 'reason',
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
        $this->values[self::TID] = null;
        $this->values[self::INDEXS] = array();
        $this->values[self::REASON] = null;
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
     * Sets value of 'tid' property
     *
     * @param integer $value Property value
     *
     * @return null
     */
    public function setTid($value)
    {
        return $this->set(self::TID, $value);
    }

    /**
     * Returns value of 'tid' property
     *
     * @return integer
     */
    public function getTid()
    {
        $value = $this->get(self::TID);
        return $value === null ? (integer)$value : $value;
    }

    /**
     * Returns true if 'tid' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasTid()
    {
        return $this->get(self::TID) !== null;
    }

    /**
     * Appends value to 'indexs' list
     *
     * @param integer $value Value to append
     *
     * @return null
     */
    public function appendIndexs($value)
    {
        return $this->append(self::INDEXS, $value);
    }

    /**
     * Clears 'indexs' list
     *
     * @return null
     */
    public function clearIndexs()
    {
        return $this->clear(self::INDEXS);
    }

    /**
     * Returns 'indexs' list
     *
     * @return integer[]
     */
    public function getIndexs()
    {
        return $this->get(self::INDEXS);
    }

    /**
     * Returns true if 'indexs' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasIndexs()
    {
        return count($this->get(self::INDEXS)) !== 0;
    }

    /**
     * Returns 'indexs' iterator
     *
     * @return \ArrayIterator
     */
    public function getIndexsIterator()
    {
        return new \ArrayIterator($this->get(self::INDEXS));
    }

    /**
     * Returns element from 'indexs' list at given offset
     *
     * @param int $offset Position in list
     *
     * @return integer
     */
    public function getIndexsAt($offset)
    {
        return $this->get(self::INDEXS, $offset);
    }

    /**
     * Returns count of 'indexs' list
     *
     * @return int
     */
    public function getIndexsCount()
    {
        return $this->count(self::INDEXS);
    }

    /**
     * Sets value of 'reason' property
     *
     * @param integer $value Property value
     *
     * @return null
     */
    public function setReason($value)
    {
        return $this->set(self::REASON, $value);
    }

    /**
     * Returns value of 'reason' property
     *
     * @return integer
     */
    public function getReason()
    {
        $value = $this->get(self::REASON);
        return $value === null ? (integer)$value : $value;
    }

    /**
     * Returns true if 'reason' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasReason()
    {
        return $this->get(self::REASON) !== null;
    }
}
}