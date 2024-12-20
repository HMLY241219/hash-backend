<?php
/**
 * Auto generated from poker_data.proto at 2023-06-08 09:49:25
 */

namespace {
/**
 * PBBPlayerPositionInfo message
 */
class PBBPlayerPositionInfo extends \ProtobufMessage
{
    /* Field index constants */
    const POS_TYPE = 1;
    const TABLE_ID = 2;
    const GAMESVRD_ID = 4;
    const GAME_LV = 5;

    /* @var array Field descriptors */
    protected static $fields = array(
        self::POS_TYPE => array(
            'name' => 'pos_type',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_INT,
        ),
        self::TABLE_ID => array(
            'name' => 'table_id',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_INT,
        ),
        self::GAMESVRD_ID => array(
            'name' => 'gamesvrd_id',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_INT,
        ),
        self::GAME_LV => array(
            'name' => 'game_lv',
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
        $this->values[self::POS_TYPE] = null;
        $this->values[self::TABLE_ID] = null;
        $this->values[self::GAMESVRD_ID] = null;
        $this->values[self::GAME_LV] = null;
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
     * Sets value of 'game_lv' property
     *
     * @param integer $value Property value
     *
     * @return null
     */
    public function setGameLv($value)
    {
        return $this->set(self::GAME_LV, $value);
    }

    /**
     * Returns value of 'game_lv' property
     *
     * @return integer
     */
    public function getGameLv()
    {
        $value = $this->get(self::GAME_LV);
        return $value === null ? (integer)$value : $value;
    }

    /**
     * Returns true if 'game_lv' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasGameLv()
    {
        return $this->get(self::GAME_LV) !== null;
    }
}
}