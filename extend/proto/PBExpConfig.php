<?php
/**
 * Auto generated from poker_config.proto at 2023-06-08 09:49:25
 */

namespace {
/**
 * PBExpConfig message
 */
class PBExpConfig extends \ProtobufMessage
{
    /* Field index constants */
    const LEVEL_LIST = 1;
    const TYPE_LIST = 2;

    /* @var array Field descriptors */
    protected static $fields = array(
        self::LEVEL_LIST => array(
            'name' => 'level_list',
            'repeated' => true,
            'type' => '\PBLevelItem'
        ),
        self::TYPE_LIST => array(
            'name' => 'type_list',
            'repeated' => true,
            'type' => '\PBTTypeItem'
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
        $this->values[self::LEVEL_LIST] = array();
        $this->values[self::TYPE_LIST] = array();
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
     * Appends value to 'level_list' list
     *
     * @param \PBLevelItem $value Value to append
     *
     * @return null
     */
    public function appendLevelList(\PBLevelItem $value)
    {
        return $this->append(self::LEVEL_LIST, $value);
    }

    /**
     * Clears 'level_list' list
     *
     * @return null
     */
    public function clearLevelList()
    {
        return $this->clear(self::LEVEL_LIST);
    }

    /**
     * Returns 'level_list' list
     *
     * @return \PBLevelItem[]
     */
    public function getLevelList()
    {
        return $this->get(self::LEVEL_LIST);
    }

    /**
     * Returns true if 'level_list' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasLevelList()
    {
        return count($this->get(self::LEVEL_LIST)) !== 0;
    }

    /**
     * Returns 'level_list' iterator
     *
     * @return \ArrayIterator
     */
    public function getLevelListIterator()
    {
        return new \ArrayIterator($this->get(self::LEVEL_LIST));
    }

    /**
     * Returns element from 'level_list' list at given offset
     *
     * @param int $offset Position in list
     *
     * @return \PBLevelItem
     */
    public function getLevelListAt($offset)
    {
        return $this->get(self::LEVEL_LIST, $offset);
    }

    /**
     * Returns count of 'level_list' list
     *
     * @return int
     */
    public function getLevelListCount()
    {
        return $this->count(self::LEVEL_LIST);
    }

    /**
     * Appends value to 'type_list' list
     *
     * @param \PBTTypeItem $value Value to append
     *
     * @return null
     */
    public function appendTypeList(\PBTTypeItem $value)
    {
        return $this->append(self::TYPE_LIST, $value);
    }

    /**
     * Clears 'type_list' list
     *
     * @return null
     */
    public function clearTypeList()
    {
        return $this->clear(self::TYPE_LIST);
    }

    /**
     * Returns 'type_list' list
     *
     * @return \PBTTypeItem[]
     */
    public function getTypeList()
    {
        return $this->get(self::TYPE_LIST);
    }

    /**
     * Returns true if 'type_list' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasTypeList()
    {
        return count($this->get(self::TYPE_LIST)) !== 0;
    }

    /**
     * Returns 'type_list' iterator
     *
     * @return \ArrayIterator
     */
    public function getTypeListIterator()
    {
        return new \ArrayIterator($this->get(self::TYPE_LIST));
    }

    /**
     * Returns element from 'type_list' list at given offset
     *
     * @param int $offset Position in list
     *
     * @return \PBTTypeItem
     */
    public function getTypeListAt($offset)
    {
        return $this->get(self::TYPE_LIST, $offset);
    }

    /**
     * Returns count of 'type_list' list
     *
     * @return int
     */
    public function getTypeListCount()
    {
        return $this->count(self::TYPE_LIST);
    }
}
}