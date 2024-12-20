<?php
/**
 * Auto generated from poker_msg_cs.proto at 2023-06-08 09:49:25
 */

namespace {
/**
 * CSNotifyNextOperation message
 */
class CSNotifyNextOperation extends \ProtobufMessage
{
    /* Field index constants */
    const OPERATION_INDEX = 1;
    const LEFT_TILE_NUM = 2;
    const LEFT_CARD_NUM = 3;

    /* @var array Field descriptors */
    protected static $fields = array(
        self::OPERATION_INDEX => array(
            'name' => 'operation_index',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_INT,
        ),
        self::LEFT_TILE_NUM => array(
            'name' => 'left_tile_num',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_INT,
        ),
        self::LEFT_CARD_NUM => array(
            'name' => 'left_card_num',
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
        $this->values[self::OPERATION_INDEX] = null;
        $this->values[self::LEFT_TILE_NUM] = null;
        $this->values[self::LEFT_CARD_NUM] = null;
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
     * Sets value of 'operation_index' property
     *
     * @param integer $value Property value
     *
     * @return null
     */
    public function setOperationIndex($value)
    {
        return $this->set(self::OPERATION_INDEX, $value);
    }

    /**
     * Returns value of 'operation_index' property
     *
     * @return integer
     */
    public function getOperationIndex()
    {
        $value = $this->get(self::OPERATION_INDEX);
        return $value === null ? (integer)$value : $value;
    }

    /**
     * Returns true if 'operation_index' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasOperationIndex()
    {
        return $this->get(self::OPERATION_INDEX) !== null;
    }

    /**
     * Sets value of 'left_tile_num' property
     *
     * @param integer $value Property value
     *
     * @return null
     */
    public function setLeftTileNum($value)
    {
        return $this->set(self::LEFT_TILE_NUM, $value);
    }

    /**
     * Returns value of 'left_tile_num' property
     *
     * @return integer
     */
    public function getLeftTileNum()
    {
        $value = $this->get(self::LEFT_TILE_NUM);
        return $value === null ? (integer)$value : $value;
    }

    /**
     * Returns true if 'left_tile_num' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasLeftTileNum()
    {
        return $this->get(self::LEFT_TILE_NUM) !== null;
    }

    /**
     * Sets value of 'left_card_num' property
     *
     * @param integer $value Property value
     *
     * @return null
     */
    public function setLeftCardNum($value)
    {
        return $this->set(self::LEFT_CARD_NUM, $value);
    }

    /**
     * Returns value of 'left_card_num' property
     *
     * @return integer
     */
    public function getLeftCardNum()
    {
        $value = $this->get(self::LEFT_CARD_NUM);
        return $value === null ? (integer)$value : $value;
    }

    /**
     * Returns true if 'left_card_num' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasLeftCardNum()
    {
        return $this->get(self::LEFT_CARD_NUM) !== null;
    }
}
}