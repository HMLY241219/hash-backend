<?php
/**
 * Auto generated from poker_config.proto at 2023-06-08 09:49:25
 */

namespace {
/**
 * PBRobotDetailConfig message
 */
class PBRobotDetailConfig extends \ProtobufMessage
{
    /* Field index constants */
    const NICK = 1;
    const PIC = 2;
    const PLAY_NUM = 3;
    const WIN_NUM = 4;
    const ID = 5;

    /* @var array Field descriptors */
    protected static $fields = array(
        self::NICK => array(
            'name' => 'nick',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_STRING,
        ),
        self::PIC => array(
            'name' => 'pic',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_STRING,
        ),
        self::PLAY_NUM => array(
            'name' => 'play_num',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_INT,
        ),
        self::WIN_NUM => array(
            'name' => 'win_num',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_INT,
        ),
        self::ID => array(
            'name' => 'id',
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
        $this->values[self::NICK] = null;
        $this->values[self::PIC] = null;
        $this->values[self::PLAY_NUM] = null;
        $this->values[self::WIN_NUM] = null;
        $this->values[self::ID] = null;
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
     * Sets value of 'nick' property
     *
     * @param string $value Property value
     *
     * @return null
     */
    public function setNick($value)
    {
        return $this->set(self::NICK, $value);
    }

    /**
     * Returns value of 'nick' property
     *
     * @return string
     */
    public function getNick()
    {
        $value = $this->get(self::NICK);
        return $value === null ? (string)$value : $value;
    }

    /**
     * Returns true if 'nick' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasNick()
    {
        return $this->get(self::NICK) !== null;
    }

    /**
     * Sets value of 'pic' property
     *
     * @param string $value Property value
     *
     * @return null
     */
    public function setPic($value)
    {
        return $this->set(self::PIC, $value);
    }

    /**
     * Returns value of 'pic' property
     *
     * @return string
     */
    public function getPic()
    {
        $value = $this->get(self::PIC);
        return $value === null ? (string)$value : $value;
    }

    /**
     * Returns true if 'pic' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasPic()
    {
        return $this->get(self::PIC) !== null;
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

    /**
     * Sets value of 'win_num' property
     *
     * @param integer $value Property value
     *
     * @return null
     */
    public function setWinNum($value)
    {
        return $this->set(self::WIN_NUM, $value);
    }

    /**
     * Returns value of 'win_num' property
     *
     * @return integer
     */
    public function getWinNum()
    {
        $value = $this->get(self::WIN_NUM);
        return $value === null ? (integer)$value : $value;
    }

    /**
     * Returns true if 'win_num' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasWinNum()
    {
        return $this->get(self::WIN_NUM) !== null;
    }

    /**
     * Sets value of 'id' property
     *
     * @param integer $value Property value
     *
     * @return null
     */
    public function setId($value)
    {
        return $this->set(self::ID, $value);
    }

    /**
     * Returns value of 'id' property
     *
     * @return integer
     */
    public function getId()
    {
        $value = $this->get(self::ID);
        return $value === null ? (integer)$value : $value;
    }

    /**
     * Returns true if 'id' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasId()
    {
        return $this->get(self::ID) !== null;
    }
}
}