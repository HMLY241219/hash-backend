<?php
/**
 * Auto generated from poker_msg_cs.proto at 2023-06-08 09:49:25
 */

namespace {
/**
 * CSTtypeLevelInfo message
 */
class CSTtypeLevelInfo extends \ProtobufMessage
{
    /* Field index constants */
    const TTYPE = 1;
    const LEVEL_INFO_LIST = 2;

    /* @var array Field descriptors */
    protected static $fields = array(
        self::TTYPE => array(
            'name' => 'ttype',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_INT,
        ),
        self::LEVEL_INFO_LIST => array(
            'name' => 'level_info_list',
            'repeated' => true,
            'type' => '\CSLevelInfo'
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
        $this->values[self::TTYPE] = null;
        $this->values[self::LEVEL_INFO_LIST] = array();
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
     * Sets value of 'ttype' property
     *
     * @param integer $value Property value
     *
     * @return null
     */
    public function setTtype($value)
    {
        return $this->set(self::TTYPE, $value);
    }

    /**
     * Returns value of 'ttype' property
     *
     * @return integer
     */
    public function getTtype()
    {
        $value = $this->get(self::TTYPE);
        return $value === null ? (integer)$value : $value;
    }

    /**
     * Returns true if 'ttype' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasTtype()
    {
        return $this->get(self::TTYPE) !== null;
    }

    /**
     * Appends value to 'level_info_list' list
     *
     * @param \CSLevelInfo $value Value to append
     *
     * @return null
     */
    public function appendLevelInfoList(\CSLevelInfo $value)
    {
        return $this->append(self::LEVEL_INFO_LIST, $value);
    }

    /**
     * Clears 'level_info_list' list
     *
     * @return null
     */
    public function clearLevelInfoList()
    {
        return $this->clear(self::LEVEL_INFO_LIST);
    }

    /**
     * Returns 'level_info_list' list
     *
     * @return \CSLevelInfo[]
     */
    public function getLevelInfoList()
    {
        return $this->get(self::LEVEL_INFO_LIST);
    }

    /**
     * Returns true if 'level_info_list' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasLevelInfoList()
    {
        return count($this->get(self::LEVEL_INFO_LIST)) !== 0;
    }

    /**
     * Returns 'level_info_list' iterator
     *
     * @return \ArrayIterator
     */
    public function getLevelInfoListIterator()
    {
        return new \ArrayIterator($this->get(self::LEVEL_INFO_LIST));
    }

    /**
     * Returns element from 'level_info_list' list at given offset
     *
     * @param int $offset Position in list
     *
     * @return \CSLevelInfo
     */
    public function getLevelInfoListAt($offset)
    {
        return $this->get(self::LEVEL_INFO_LIST, $offset);
    }

    /**
     * Returns count of 'level_info_list' list
     *
     * @return int
     */
    public function getLevelInfoListCount()
    {
        return $this->count(self::LEVEL_INFO_LIST);
    }
}
}