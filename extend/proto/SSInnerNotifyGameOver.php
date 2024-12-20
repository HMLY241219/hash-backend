<?php
/**
 * Auto generated from poker_msg_ss.proto at 2023-06-08 09:49:25
 */

namespace {
/**
 * SSInnerNotifyGameOver message
 */
class SSInnerNotifyGameOver extends \ProtobufMessage
{
    /* Field index constants */
    const TID = 1;
    const SEATS = 2;
    const GAME_TYPE = 3;
    const LEVEL = 4;
    const IS_PIAO = 5;
    const ZHUANG_INDEX = 6;

    /* @var array Field descriptors */
    protected static $fields = array(
        self::TID => array(
            'name' => 'tid',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_INT,
        ),
        self::SEATS => array(
            'name' => 'seats',
            'repeated' => true,
            'type' => '\PBDSSTableSeat'
        ),
        self::GAME_TYPE => array(
            'name' => 'game_type',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_INT,
        ),
        self::LEVEL => array(
            'name' => 'level',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_INT,
        ),
        self::IS_PIAO => array(
            'name' => 'is_piao',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_BOOL,
        ),
        self::ZHUANG_INDEX => array(
            'name' => 'zhuang_index',
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
        $this->values[self::TID] = null;
        $this->values[self::SEATS] = array();
        $this->values[self::GAME_TYPE] = null;
        $this->values[self::LEVEL] = null;
        $this->values[self::IS_PIAO] = null;
        $this->values[self::ZHUANG_INDEX] = null;
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
     * Sets value of 'tid' property
     *
     * @param integer $value Property value
     *
     * @return null
     */
    public function setTid($value)
    {
        return $this->set(self::TID, $value);
    }

    /**
     * Returns value of 'tid' property
     *
     * @return integer
     */
    public function getTid()
    {
        $value = $this->get(self::TID);
        return $value === null ? (integer)$value : $value;
    }

    /**
     * Returns true if 'tid' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasTid()
    {
        return $this->get(self::TID) !== null;
    }

    /**
     * Appends value to 'seats' list
     *
     * @param \PBDSSTableSeat $value Value to append
     *
     * @return null
     */
    public function appendSeats(\PBDSSTableSeat $value)
    {
        return $this->append(self::SEATS, $value);
    }

    /**
     * Clears 'seats' list
     *
     * @return null
     */
    public function clearSeats()
    {
        return $this->clear(self::SEATS);
    }

    /**
     * Returns 'seats' list
     *
     * @return \PBDSSTableSeat[]
     */
    public function getSeats()
    {
        return $this->get(self::SEATS);
    }

    /**
     * Returns true if 'seats' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasSeats()
    {
        return count($this->get(self::SEATS)) !== 0;
    }

    /**
     * Returns 'seats' iterator
     *
     * @return \ArrayIterator
     */
    public function getSeatsIterator()
    {
        return new \ArrayIterator($this->get(self::SEATS));
    }

    /**
     * Returns element from 'seats' list at given offset
     *
     * @param int $offset Position in list
     *
     * @return \PBDSSTableSeat
     */
    public function getSeatsAt($offset)
    {
        return $this->get(self::SEATS, $offset);
    }

    /**
     * Returns count of 'seats' list
     *
     * @return int
     */
    public function getSeatsCount()
    {
        return $this->count(self::SEATS);
    }

    /**
     * Sets value of 'game_type' property
     *
     * @param integer $value Property value
     *
     * @return null
     */
    public function setGameType($value)
    {
        return $this->set(self::GAME_TYPE, $value);
    }

    /**
     * Returns value of 'game_type' property
     *
     * @return integer
     */
    public function getGameType()
    {
        $value = $this->get(self::GAME_TYPE);
        return $value === null ? (integer)$value : $value;
    }

    /**
     * Returns true if 'game_type' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasGameType()
    {
        return $this->get(self::GAME_TYPE) !== null;
    }

    /**
     * Sets value of 'level' property
     *
     * @param integer $value Property value
     *
     * @return null
     */
    public function setLevel($value)
    {
        return $this->set(self::LEVEL, $value);
    }

    /**
     * Returns value of 'level' property
     *
     * @return integer
     */
    public function getLevel()
    {
        $value = $this->get(self::LEVEL);
        return $value === null ? (integer)$value : $value;
    }

    /**
     * Returns true if 'level' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasLevel()
    {
        return $this->get(self::LEVEL) !== null;
    }

    /**
     * Sets value of 'is_piao' property
     *
     * @param boolean $value Property value
     *
     * @return null
     */
    public function setIsPiao($value)
    {
        return $this->set(self::IS_PIAO, $value);
    }

    /**
     * Returns value of 'is_piao' property
     *
     * @return boolean
     */
    public function getIsPiao()
    {
        $value = $this->get(self::IS_PIAO);
        return $value === null ? (boolean)$value : $value;
    }

    /**
     * Returns true if 'is_piao' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasIsPiao()
    {
        return $this->get(self::IS_PIAO) !== null;
    }

    /**
     * Sets value of 'zhuang_index' property
     *
     * @param integer $value Property value
     *
     * @return null
     */
    public function setZhuangIndex($value)
    {
        return $this->set(self::ZHUANG_INDEX, $value);
    }

    /**
     * Returns value of 'zhuang_index' property
     *
     * @return integer
     */
    public function getZhuangIndex()
    {
        $value = $this->get(self::ZHUANG_INDEX);
        return $value === null ? (integer)$value : $value;
    }

    /**
     * Returns true if 'zhuang_index' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasZhuangIndex()
    {
        return $this->get(self::ZHUANG_INDEX) !== null;
    }
}
}