<?php
/**
 * Auto generated from poker_msg_ss.proto at 2023-06-08 09:49:25
 */

namespace {
/**
 * SSRequestUpdateUserData message
 */
class SSRequestUpdateUserData extends \ProtobufMessage
{
    /* Field index constants */
    const UID = 1;
    const KEY_LIST = 2;

    /* @var array Field descriptors */
    protected static $fields = array(
        self::UID => array(
            'name' => 'uid',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_INT,
        ),
        self::KEY_LIST => array(
            'name' => 'key_list',
            'repeated' => true,
            'type' => '\PBUpdateData'
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
        $this->values[self::KEY_LIST] = array();
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
     * Appends value to 'key_list' list
     *
     * @param \PBUpdateData $value Value to append
     *
     * @return null
     */
    public function appendKeyList(\PBUpdateData $value)
    {
        return $this->append(self::KEY_LIST, $value);
    }

    /**
     * Clears 'key_list' list
     *
     * @return null
     */
    public function clearKeyList()
    {
        return $this->clear(self::KEY_LIST);
    }

    /**
     * Returns 'key_list' list
     *
     * @return \PBUpdateData[]
     */
    public function getKeyList()
    {
        return $this->get(self::KEY_LIST);
    }

    /**
     * Returns true if 'key_list' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasKeyList()
    {
        return count($this->get(self::KEY_LIST)) !== 0;
    }

    /**
     * Returns 'key_list' iterator
     *
     * @return \ArrayIterator
     */
    public function getKeyListIterator()
    {
        return new \ArrayIterator($this->get(self::KEY_LIST));
    }

    /**
     * Returns element from 'key_list' list at given offset
     *
     * @param int $offset Position in list
     *
     * @return \PBUpdateData
     */
    public function getKeyListAt($offset)
    {
        return $this->get(self::KEY_LIST, $offset);
    }

    /**
     * Returns count of 'key_list' list
     *
     * @return int
     */
    public function getKeyListCount()
    {
        return $this->count(self::KEY_LIST);
    }
}
}