<?php
/**
 * Auto generated from poker_msg_cs.proto at 2023-06-08 09:49:25
 */

namespace {
/**
 * CSResponseDssEnterTable message
 */
class CSResponseDssEnterTable extends \ProtobufMessage
{
    /* Field index constants */
    const RESULT = 1;
    const TABLE_INFO = 2;
    const GAMESVRD_ID = 3;
    const TTYPE = 4;
    const POS_TYPE = 6;

    /* @var array Field descriptors */
    protected static $fields = array(
        self::RESULT => array(
            'name' => 'result',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_INT,
        ),
        self::TABLE_INFO => array(
            'name' => 'table_info',
            'required' => false,
            'type' => '\CSNotifyTableInfo'
        ),
        self::GAMESVRD_ID => array(
            'name' => 'gamesvrd_id',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_INT,
        ),
        self::TTYPE => array(
            'name' => 'ttype',
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
        $this->values[self::RESULT] = null;
        $this->values[self::TABLE_INFO] = null;
        $this->values[self::GAMESVRD_ID] = null;
        $this->values[self::TTYPE] = null;
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
     * Sets value of 'table_info' property
     *
     * @param \CSNotifyTableInfo $value Property value
     *
     * @return null
     */
    public function setTableInfo(\CSNotifyTableInfo $value=null)
    {
        return $this->set(self::TABLE_INFO, $value);
    }

    /**
     * Returns value of 'table_info' property
     *
     * @return \CSNotifyTableInfo
     */
    public function getTableInfo()
    {
        return $this->get(self::TABLE_INFO);
    }

    /**
     * Returns true if 'table_info' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasTableInfo()
    {
        return $this->get(self::TABLE_INFO) !== null;
    }

    /**
     * Sets value of 'gamesvrd_id' property
     *
     * @param integer $value Property value
     *
     * @return null
     */
    public function setGamesvrdId($value)
    {
        return $this->set(self::GAMESVRD_ID, $value);
    }

    /**
     * Returns value of 'gamesvrd_id' property
     *
     * @return integer
     */
    public function getGamesvrdId()
    {
        $value = $this->get(self::GAMESVRD_ID);
        return $value === null ? (integer)$value : $value;
    }

    /**
     * Returns true if 'gamesvrd_id' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasGamesvrdId()
    {
        return $this->get(self::GAMESVRD_ID) !== null;
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