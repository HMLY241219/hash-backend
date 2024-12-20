<?php
/**
 * Auto generated from poker_msg_cs.proto at 2023-06-08 09:49:25
 */

namespace {
/**
 * InterEventOnGameStart message
 */
class InterEventOnGameStart extends \ProtobufMessage
{
    /* Field index constants */
    const UID = 1;
    const TABLE_ID = 2;

    /* @var array Field descriptors */
    protected static $fields = array(
        self::UID => array(
            'name' => 'uid',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_INT,
        ),
        self::TABLE_ID => array(
            'name' => 'table_id',
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
        $this->values[self::UID] = null;
        $this->values[self::TABLE_ID] = null;
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
     * Sets value of 'table_id' property
     *
     * @param integer $value Property value
     *
     * @return null
     */
    public function setTableId($value)
    {
        return $this->set(self::TABLE_ID, $value);
    }

    /**
     * Returns value of 'table_id' property
     *
     * @return integer
     */
    public function getTableId()
    {
        $value = $this->get(self::TABLE_ID);
        return $value === null ? (integer)$value : $value;
    }

    /**
     * Returns true if 'table_id' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasTableId()
    {
        return $this->get(self::TABLE_ID) !== null;
    }
}
}