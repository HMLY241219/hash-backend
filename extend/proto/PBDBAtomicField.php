<?php
/**
 * Auto generated from poker_msg_ss.proto at 2023-06-08 09:49:25
 */

namespace {
/**
 * PBDBAtomicField message
 */
class PBDBAtomicField extends \ProtobufMessage
{
    /* Field index constants */
    const FIELD = 1;
    const STRATEGY = 2;
    const STRVALUE = 3;
    const INTVAL = 4;
    const POS = 5;
    const REASON = 6;
    const SESSION_ID = 7;
    const TID = 8;
    const GAME_TYPE = 9;
    const LEVEL = 10;
    const WATER = 11;
    const GAME_NUM = 12;
    const STRVALUE2 = 13;
    const INTVAL2 = 14;

    /* @var array Field descriptors */
    protected static $fields = array(
        self::FIELD => array(
            'name' => 'field',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_INT,
        ),
        self::STRATEGY => array(
            'name' => 'strategy',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_INT,
        ),
        self::STRVALUE => array(
            'name' => 'strvalue',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_STRING,
        ),
        self::INTVAL => array(
            'name' => 'intval',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_INT,
        ),
        self::POS => array(
            'name' => 'pos',
            'required' => false,
            'type' => '\PBBPlayerPositionInfo'
        ),
        self::REASON => array(
            'name' => 'reason',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_INT,
        ),
        self::SESSION_ID => array(
            'name' => 'session_id',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_INT,
        ),
        self::TID => array(
            'name' => 'tid',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_INT,
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
        self::WATER => array(
            'name' => 'water',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_INT,
        ),
        self::GAME_NUM => array(
            'name' => 'game_num',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_INT,
        ),
        self::STRVALUE2 => array(
            'name' => 'strvalue2',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_STRING,
        ),
        self::INTVAL2 => array(
            'name' => 'intval2',
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
        $this->values[self::FIELD] = null;
        $this->values[self::STRATEGY] = null;
        $this->values[self::STRVALUE] = null;
        $this->values[self::INTVAL] = null;
        $this->values[self::POS] = null;
        $this->values[self::REASON] = null;
        $this->values[self::SESSION_ID] = null;
        $this->values[self::TID] = null;
        $this->values[self::GAME_TYPE] = null;
        $this->values[self::LEVEL] = null;
        $this->values[self::WATER] = null;
        $this->values[self::GAME_NUM] = null;
        $this->values[self::STRVALUE2] = null;
        $this->values[self::INTVAL2] = null;
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
     * Sets value of 'field' property
     *
     * @param integer $value Property value
     *
     * @return null
     */
    public function setField($value)
    {
        return $this->set(self::FIELD, $value);
    }

    /**
     * Returns value of 'field' property
     *
     * @return integer
     */
    public function getField()
    {
        $value = $this->get(self::FIELD);
        return $value === null ? (integer)$value : $value;
    }

    /**
     * Returns true if 'field' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasField()
    {
        return $this->get(self::FIELD) !== null;
    }

    /**
     * Sets value of 'strategy' property
     *
     * @param integer $value Property value
     *
     * @return null
     */
    public function setStrategy($value)
    {
        return $this->set(self::STRATEGY, $value);
    }

    /**
     * Returns value of 'strategy' property
     *
     * @return integer
     */
    public function getStrategy()
    {
        $value = $this->get(self::STRATEGY);
        return $value === null ? (integer)$value : $value;
    }

    /**
     * Returns true if 'strategy' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasStrategy()
    {
        return $this->get(self::STRATEGY) !== null;
    }

    /**
     * Sets value of 'strvalue' property
     *
     * @param string $value Property value
     *
     * @return null
     */
    public function setStrvalue($value)
    {
        return $this->set(self::STRVALUE, $value);
    }

    /**
     * Returns value of 'strvalue' property
     *
     * @return string
     */
    public function getStrvalue()
    {
        $value = $this->get(self::STRVALUE);
        return $value === null ? (string)$value : $value;
    }

    /**
     * Returns true if 'strvalue' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasStrvalue()
    {
        return $this->get(self::STRVALUE) !== null;
    }

    /**
     * Sets value of 'intval' property
     *
     * @param integer $value Property value
     *
     * @return null
     */
    public function setIntval($value)
    {
        return $this->set(self::INTVAL, $value);
    }

    /**
     * Returns value of 'intval' property
     *
     * @return integer
     */
    public function getIntval()
    {
        $value = $this->get(self::INTVAL);
        return $value === null ? (integer)$value : $value;
    }

    /**
     * Returns true if 'intval' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasIntval()
    {
        return $this->get(self::INTVAL) !== null;
    }

    /**
     * Sets value of 'pos' property
     *
     * @param \PBBPlayerPositionInfo $value Property value
     *
     * @return null
     */
    public function setPos(\PBBPlayerPositionInfo $value=null)
    {
        return $this->set(self::POS, $value);
    }

    /**
     * Returns value of 'pos' property
     *
     * @return \PBBPlayerPositionInfo
     */
    public function getPos()
    {
        return $this->get(self::POS);
    }

    /**
     * Returns true if 'pos' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasPos()
    {
        return $this->get(self::POS) !== null;
    }

    /**
     * Sets value of 'reason' property
     *
     * @param integer $value Property value
     *
     * @return null
     */
    public function setReason($value)
    {
        return $this->set(self::REASON, $value);
    }

    /**
     * Returns value of 'reason' property
     *
     * @return integer
     */
    public function getReason()
    {
        $value = $this->get(self::REASON);
        return $value === null ? (integer)$value : $value;
    }

    /**
     * Returns true if 'reason' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasReason()
    {
        return $this->get(self::REASON) !== null;
    }

    /**
     * Sets value of 'session_id' property
     *
     * @param integer $value Property value
     *
     * @return null
     */
    public function setSessionId($value)
    {
        return $this->set(self::SESSION_ID, $value);
    }

    /**
     * Returns value of 'session_id' property
     *
     * @return integer
     */
    public function getSessionId()
    {
        $value = $this->get(self::SESSION_ID);
        return $value === null ? (integer)$value : $value;
    }

    /**
     * Returns true if 'session_id' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasSessionId()
    {
        return $this->get(self::SESSION_ID) !== null;
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
     * Sets value of 'water' property
     *
     * @param integer $value Property value
     *
     * @return null
     */
    public function setWater($value)
    {
        return $this->set(self::WATER, $value);
    }

    /**
     * Returns value of 'water' property
     *
     * @return integer
     */
    public function getWater()
    {
        $value = $this->get(self::WATER);
        return $value === null ? (integer)$value : $value;
    }

    /**
     * Returns true if 'water' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasWater()
    {
        return $this->get(self::WATER) !== null;
    }

    /**
     * Sets value of 'game_num' property
     *
     * @param integer $value Property value
     *
     * @return null
     */
    public function setGameNum($value)
    {
        return $this->set(self::GAME_NUM, $value);
    }

    /**
     * Returns value of 'game_num' property
     *
     * @return integer
     */
    public function getGameNum()
    {
        $value = $this->get(self::GAME_NUM);
        return $value === null ? (integer)$value : $value;
    }

    /**
     * Returns true if 'game_num' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasGameNum()
    {
        return $this->get(self::GAME_NUM) !== null;
    }

    /**
     * Sets value of 'strvalue2' property
     *
     * @param string $value Property value
     *
     * @return null
     */
    public function setStrvalue2($value)
    {
        return $this->set(self::STRVALUE2, $value);
    }

    /**
     * Returns value of 'strvalue2' property
     *
     * @return string
     */
    public function getStrvalue2()
    {
        $value = $this->get(self::STRVALUE2);
        return $value === null ? (string)$value : $value;
    }

    /**
     * Returns true if 'strvalue2' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasStrvalue2()
    {
        return $this->get(self::STRVALUE2) !== null;
    }

    /**
     * Sets value of 'intval2' property
     *
     * @param integer $value Property value
     *
     * @return null
     */
    public function setIntval2($value)
    {
        return $this->set(self::INTVAL2, $value);
    }

    /**
     * Returns value of 'intval2' property
     *
     * @return integer
     */
    public function getIntval2()
    {
        $value = $this->get(self::INTVAL2);
        return $value === null ? (integer)$value : $value;
    }

    /**
     * Returns true if 'intval2' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasIntval2()
    {
        return $this->get(self::INTVAL2) !== null;
    }
}
}