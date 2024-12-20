<?php
/**
 * Auto generated from poker_msg_log.proto at 2023-06-08 09:49:25
 */

namespace {
/**
 * LogAtPlay message
 */
class LogAtPlay extends \ProtobufMessage
{
    /* Field index constants */
    const PALY = 1;
    const GAME_TYPE = 2;
    const SVR_ID = 3;
    const LV = 4;

    /* @var array Field descriptors */
    protected static $fields = array(
        self::PALY => array(
            'name' => 'paly',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_INT,
        ),
        self::GAME_TYPE => array(
            'name' => 'game_type',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_INT,
        ),
        self::SVR_ID => array(
            'name' => 'svr_id',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_INT,
        ),
        self::LV => array(
            'name' => 'lv',
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
        $this->values[self::PALY] = null;
        $this->values[self::GAME_TYPE] = null;
        $this->values[self::SVR_ID] = null;
        $this->values[self::LV] = null;
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
     * Sets value of 'paly' property
     *
     * @param integer $value Property value
     *
     * @return null
     */
    public function setPaly($value)
    {
        return $this->set(self::PALY, $value);
    }

    /**
     * Returns value of 'paly' property
     *
     * @return integer
     */
    public function getPaly()
    {
        $value = $this->get(self::PALY);
        return $value === null ? (integer)$value : $value;
    }

    /**
     * Returns true if 'paly' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasPaly()
    {
        return $this->get(self::PALY) !== null;
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
     * Sets value of 'svr_id' property
     *
     * @param integer $value Property value
     *
     * @return null
     */
    public function setSvrId($value)
    {
        return $this->set(self::SVR_ID, $value);
    }

    /**
     * Returns value of 'svr_id' property
     *
     * @return integer
     */
    public function getSvrId()
    {
        $value = $this->get(self::SVR_ID);
        return $value === null ? (integer)$value : $value;
    }

    /**
     * Returns true if 'svr_id' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasSvrId()
    {
        return $this->get(self::SVR_ID) !== null;
    }

    /**
     * Sets value of 'lv' property
     *
     * @param integer $value Property value
     *
     * @return null
     */
    public function setLv($value)
    {
        return $this->set(self::LV, $value);
    }

    /**
     * Returns value of 'lv' property
     *
     * @return integer
     */
    public function getLv()
    {
        $value = $this->get(self::LV);
        return $value === null ? (integer)$value : $value;
    }

    /**
     * Returns true if 'lv' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasLv()
    {
        return $this->get(self::LV) !== null;
    }
}
}