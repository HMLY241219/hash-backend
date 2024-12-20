<?php
/**
 * Auto generated from poker_config.proto at 2023-06-08 09:49:25
 */

namespace {
/**
 * PBTableGameType message
 */
class PBTableGameType extends \ProtobufMessage
{
    /* Field index constants */
    const TABLE_TYPE = 1;
    const NODE_TYPE = 2;
    const POS_TYPE = 3;

    /* @var array Field descriptors */
    protected static $fields = array(
        self::TABLE_TYPE => array(
            'name' => 'table_type',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_INT,
        ),
        self::NODE_TYPE => array(
            'name' => 'node_type',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_INT,
        ),
        self::POS_TYPE => array(
            'name' => 'pos_type',
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
        $this->values[self::TABLE_TYPE] = null;
        $this->values[self::NODE_TYPE] = null;
        $this->values[self::POS_TYPE] = null;
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
     * Sets value of 'table_type' property
     *
     * @param integer $value Property value
     *
     * @return null
     */
    public function setTableType($value)
    {
        return $this->set(self::TABLE_TYPE, $value);
    }

    /**
     * Returns value of 'table_type' property
     *
     * @return integer
     */
    public function getTableType()
    {
        $value = $this->get(self::TABLE_TYPE);
        return $value === null ? (integer)$value : $value;
    }

    /**
     * Returns true if 'table_type' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasTableType()
    {
        return $this->get(self::TABLE_TYPE) !== null;
    }

    /**
     * Sets value of 'node_type' property
     *
     * @param integer $value Property value
     *
     * @return null
     */
    public function setNodeType($value)
    {
        return $this->set(self::NODE_TYPE, $value);
    }

    /**
     * Returns value of 'node_type' property
     *
     * @return integer
     */
    public function getNodeType()
    {
        $value = $this->get(self::NODE_TYPE);
        return $value === null ? (integer)$value : $value;
    }

    /**
     * Returns true if 'node_type' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasNodeType()
    {
        return $this->get(self::NODE_TYPE) !== null;
    }

    /**
     * Sets value of 'pos_type' property
     *
     * @param integer $value Property value
     *
     * @return null
     */
    public function setPosType($value)
    {
        return $this->set(self::POS_TYPE, $value);
    }

    /**
     * Returns value of 'pos_type' property
     *
     * @return integer
     */
    public function getPosType()
    {
        $value = $this->get(self::POS_TYPE);
        return $value === null ? (integer)$value : $value;
    }

    /**
     * Returns true if 'pos_type' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasPosType()
    {
        return $this->get(self::POS_TYPE) !== null;
    }
}
}