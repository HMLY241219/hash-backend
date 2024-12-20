<?php
/**
 * Auto generated from poker_msg_ss.proto at 2023-06-08 09:49:25
 */

namespace {
/**
 * SSReportGameSvrdPlayNum message
 */
class SSReportGameSvrdPlayNum extends \ProtobufMessage
{
    /* Field index constants */
    const GTYPE = 1;
    const GAMEID = 2;
    const LEVEL = 3;
    const PLAY_NUM = 4;

    /* @var array Field descriptors */
    protected static $fields = array(
        self::GTYPE => array(
            'name' => 'gtype',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_INT,
        ),
        self::GAMEID => array(
            'name' => 'gameid',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_INT,
        ),
        self::LEVEL => array(
            'name' => 'level',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_INT,
        ),
        self::PLAY_NUM => array(
            'name' => 'play_num',
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
        $this->values[self::GTYPE] = null;
        $this->values[self::GAMEID] = null;
        $this->values[self::LEVEL] = null;
        $this->values[self::PLAY_NUM] = null;
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
     * Sets value of 'gtype' property
     *
     * @param integer $value Property value
     *
     * @return null
     */
    public function setGtype($value)
    {
        return $this->set(self::GTYPE, $value);
    }

    /**
     * Returns value of 'gtype' property
     *
     * @return integer
     */
    public function getGtype()
    {
        $value = $this->get(self::GTYPE);
        return $value === null ? (integer)$value : $value;
    }

    /**
     * Returns true if 'gtype' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasGtype()
    {
        return $this->get(self::GTYPE) !== null;
    }

    /**
     * Sets value of 'gameid' property
     *
     * @param integer $value Property value
     *
     * @return null
     */
    public function setGameid($value)
    {
        return $this->set(self::GAMEID, $value);
    }

    /**
     * Returns value of 'gameid' property
     *
     * @return integer
     */
    public function getGameid()
    {
        $value = $this->get(self::GAMEID);
        return $value === null ? (integer)$value : $value;
    }

    /**
     * Returns true if 'gameid' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasGameid()
    {
        return $this->get(self::GAMEID) !== null;
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
     * Sets value of 'play_num' property
     *
     * @param integer $value Property value
     *
     * @return null
     */
    public function setPlayNum($value)
    {
        return $this->set(self::PLAY_NUM, $value);
    }

    /**
     * Returns value of 'play_num' property
     *
     * @return integer
     */
    public function getPlayNum()
    {
        $value = $this->get(self::PLAY_NUM);
        return $value === null ? (integer)$value : $value;
    }

    /**
     * Returns true if 'play_num' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasPlayNum()
    {
        return $this->get(self::PLAY_NUM) !== null;
    }
}
}