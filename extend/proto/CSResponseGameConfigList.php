<?php
/**
 * Auto generated from poker_msg_cs.proto at 2023-06-08 09:49:25
 */

namespace {
/**
 * CSResponseGameConfigList message
 */
class CSResponseGameConfigList extends \ProtobufMessage
{
    /* Field index constants */
    const TABLE_POS_CONFIG = 1;

    /* @var array Field descriptors */
    protected static $fields = array(
        self::TABLE_POS_CONFIG => array(
            'name' => 'table_pos_config',
            'repeated' => true,
            'type' => '\PBTableNodePosConfig'
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
        $this->values[self::TABLE_POS_CONFIG] = array();
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
     * Appends value to 'table_pos_config' list
     *
     * @param \PBTableNodePosConfig $value Value to append
     *
     * @return null
     */
    public function appendTablePosConfig(\PBTableNodePosConfig $value)
    {
        return $this->append(self::TABLE_POS_CONFIG, $value);
    }

    /**
     * Clears 'table_pos_config' list
     *
     * @return null
     */
    public function clearTablePosConfig()
    {
        return $this->clear(self::TABLE_POS_CONFIG);
    }

    /**
     * Returns 'table_pos_config' list
     *
     * @return \PBTableNodePosConfig[]
     */
    public function getTablePosConfig()
    {
        return $this->get(self::TABLE_POS_CONFIG);
    }

    /**
     * Returns true if 'table_pos_config' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasTablePosConfig()
    {
        return count($this->get(self::TABLE_POS_CONFIG)) !== 0;
    }

    /**
     * Returns 'table_pos_config' iterator
     *
     * @return \ArrayIterator
     */
    public function getTablePosConfigIterator()
    {
        return new \ArrayIterator($this->get(self::TABLE_POS_CONFIG));
    }

    /**
     * Returns element from 'table_pos_config' list at given offset
     *
     * @param int $offset Position in list
     *
     * @return \PBTableNodePosConfig
     */
    public function getTablePosConfigAt($offset)
    {
        return $this->get(self::TABLE_POS_CONFIG, $offset);
    }

    /**
     * Returns count of 'table_pos_config' list
     *
     * @return int
     */
    public function getTablePosConfigCount()
    {
        return $this->count(self::TABLE_POS_CONFIG);
    }
}
}