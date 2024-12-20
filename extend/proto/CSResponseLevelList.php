<?php
/**
 * Auto generated from poker_msg_cs.proto at 2023-06-08 09:49:25
 */

namespace {
/**
 * CSResponseLevelList message
 */
class CSResponseLevelList extends \ProtobufMessage
{
    /* Field index constants */
    const RESULT = 1;
    const TTYPE_LEVEL_INFO_LIST = 2;

    /* @var array Field descriptors */
    protected static $fields = array(
        self::RESULT => array(
            'name' => 'result',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_INT,
        ),
        self::TTYPE_LEVEL_INFO_LIST => array(
            'name' => 'ttype_level_info_list',
            'repeated' => true,
            'type' => '\CSTtypeLevelInfo'
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
        $this->values[self::RESULT] = null;
        $this->values[self::TTYPE_LEVEL_INFO_LIST] = array();
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
     * Sets value of 'result' property
     *
     * @param integer $value Property value
     *
     * @return null
     */
    public function setResult($value)
    {
        return $this->set(self::RESULT, $value);
    }

    /**
     * Returns value of 'result' property
     *
     * @return integer
     */
    public function getResult()
    {
        $value = $this->get(self::RESULT);
        return $value === null ? (integer)$value : $value;
    }

    /**
     * Returns true if 'result' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasResult()
    {
        return $this->get(self::RESULT) !== null;
    }

    /**
     * Appends value to 'ttype_level_info_list' list
     *
     * @param \CSTtypeLevelInfo $value Value to append
     *
     * @return null
     */
    public function appendTtypeLevelInfoList(\CSTtypeLevelInfo $value)
    {
        return $this->append(self::TTYPE_LEVEL_INFO_LIST, $value);
    }

    /**
     * Clears 'ttype_level_info_list' list
     *
     * @return null
     */
    public function clearTtypeLevelInfoList()
    {
        return $this->clear(self::TTYPE_LEVEL_INFO_LIST);
    }

    /**
     * Returns 'ttype_level_info_list' list
     *
     * @return \CSTtypeLevelInfo[]
     */
    public function getTtypeLevelInfoList()
    {
        return $this->get(self::TTYPE_LEVEL_INFO_LIST);
    }

    /**
     * Returns true if 'ttype_level_info_list' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasTtypeLevelInfoList()
    {
        return count($this->get(self::TTYPE_LEVEL_INFO_LIST)) !== 0;
    }

    /**
     * Returns 'ttype_level_info_list' iterator
     *
     * @return \ArrayIterator
     */
    public function getTtypeLevelInfoListIterator()
    {
        return new \ArrayIterator($this->get(self::TTYPE_LEVEL_INFO_LIST));
    }

    /**
     * Returns element from 'ttype_level_info_list' list at given offset
     *
     * @param int $offset Position in list
     *
     * @return \CSTtypeLevelInfo
     */
    public function getTtypeLevelInfoListAt($offset)
    {
        return $this->get(self::TTYPE_LEVEL_INFO_LIST, $offset);
    }

    /**
     * Returns count of 'ttype_level_info_list' list
     *
     * @return int
     */
    public function getTtypeLevelInfoListCount()
    {
        return $this->count(self::TTYPE_LEVEL_INFO_LIST);
    }
}
}