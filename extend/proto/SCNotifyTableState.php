<?php
/**
 * Auto generated from poker_msg_cs.proto at 2023-06-08 09:49:25
 */

namespace {
/**
 * SCNotifyTableState message
 */
class SCNotifyTableState extends \ProtobufMessage
{
    /* Field index constants */
    const TABLE_STATE = 1;

    /* @var array Field descriptors */
    protected static $fields = array(
        self::TABLE_STATE => array(
            'name' => 'table_state',
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
        $this->values[self::TABLE_STATE] = null;
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
     * Sets value of 'table_state' property
     *
     * @param integer $value Property value
     *
     * @return null
     */
    public function setTableState($value)
    {
        return $this->set(self::TABLE_STATE, $value);
    }

    /**
     * Returns value of 'table_state' property
     *
     * @return integer
     */
    public function getTableState()
    {
        $value = $this->get(self::TABLE_STATE);
        return $value === null ? (integer)$value : $value;
    }

    /**
     * Returns true if 'table_state' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasTableState()
    {
        return $this->get(self::TABLE_STATE) !== null;
    }
}
}