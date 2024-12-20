<?php
/**
 * Auto generated from poker_msg_log.proto at 2023-06-08 09:49:25
 */

namespace {
/**
 * LogRotaryLog message
 */
class LogRotaryLog extends \ProtobufMessage
{
    /* Field index constants */
    const UID = 1;
    const CHANNEL = 2;
    const PACKAGE_ID = 3;
    const NICK_NAME = 4;
    const ROTARY_TYPE = 5;
    const TYPE = 6;
    const SCORE = 7;
    const IS_BIG = 8;

    /* @var array Field descriptors */
    protected static $fields = array(
        self::UID => array(
            'name' => 'uid',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_INT,
        ),
        self::CHANNEL => array(
            'name' => 'channel',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_INT,
        ),
        self::PACKAGE_ID => array(
            'name' => 'package_id',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_INT,
        ),
        self::NICK_NAME => array(
            'name' => 'nick_name',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_STRING,
        ),
        self::ROTARY_TYPE => array(
            'name' => 'rotary_type',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_INT,
        ),
        self::TYPE => array(
            'name' => 'type',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_INT,
        ),
        self::SCORE => array(
            'name' => 'score',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_INT,
        ),
        self::IS_BIG => array(
            'name' => 'is_big',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_BOOL,
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
        $this->values[self::CHANNEL] = null;
        $this->values[self::PACKAGE_ID] = null;
        $this->values[self::NICK_NAME] = null;
        $this->values[self::ROTARY_TYPE] = null;
        $this->values[self::TYPE] = null;
        $this->values[self::SCORE] = null;
        $this->values[self::IS_BIG] = null;
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
     * Sets value of 'channel' property
     *
     * @param integer $value Property value
     *
     * @return null
     */
    public function setChannel($value)
    {
        return $this->set(self::CHANNEL, $value);
    }

    /**
     * Returns value of 'channel' property
     *
     * @return integer
     */
    public function getChannel()
    {
        $value = $this->get(self::CHANNEL);
        return $value === null ? (integer)$value : $value;
    }

    /**
     * Returns true if 'channel' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasChannel()
    {
        return $this->get(self::CHANNEL) !== null;
    }

    /**
     * Sets value of 'package_id' property
     *
     * @param integer $value Property value
     *
     * @return null
     */
    public function setPackageId($value)
    {
        return $this->set(self::PACKAGE_ID, $value);
    }

    /**
     * Returns value of 'package_id' property
     *
     * @return integer
     */
    public function getPackageId()
    {
        $value = $this->get(self::PACKAGE_ID);
        return $value === null ? (integer)$value : $value;
    }

    /**
     * Returns true if 'package_id' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasPackageId()
    {
        return $this->get(self::PACKAGE_ID) !== null;
    }

    /**
     * Sets value of 'nick_name' property
     *
     * @param string $value Property value
     *
     * @return null
     */
    public function setNickName($value)
    {
        return $this->set(self::NICK_NAME, $value);
    }

    /**
     * Returns value of 'nick_name' property
     *
     * @return string
     */
    public function getNickName()
    {
        $value = $this->get(self::NICK_NAME);
        return $value === null ? (string)$value : $value;
    }

    /**
     * Returns true if 'nick_name' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasNickName()
    {
        return $this->get(self::NICK_NAME) !== null;
    }

    /**
     * Sets value of 'rotary_type' property
     *
     * @param integer $value Property value
     *
     * @return null
     */
    public function setRotaryType($value)
    {
        return $this->set(self::ROTARY_TYPE, $value);
    }

    /**
     * Returns value of 'rotary_type' property
     *
     * @return integer
     */
    public function getRotaryType()
    {
        $value = $this->get(self::ROTARY_TYPE);
        return $value === null ? (integer)$value : $value;
    }

    /**
     * Returns true if 'rotary_type' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasRotaryType()
    {
        return $this->get(self::ROTARY_TYPE) !== null;
    }

    /**
     * Sets value of 'type' property
     *
     * @param integer $value Property value
     *
     * @return null
     */
    public function setType($value)
    {
        return $this->set(self::TYPE, $value);
    }

    /**
     * Returns value of 'type' property
     *
     * @return integer
     */
    public function getType()
    {
        $value = $this->get(self::TYPE);
        return $value === null ? (integer)$value : $value;
    }

    /**
     * Returns true if 'type' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasType()
    {
        return $this->get(self::TYPE) !== null;
    }

    /**
     * Sets value of 'score' property
     *
     * @param integer $value Property value
     *
     * @return null
     */
    public function setScore($value)
    {
        return $this->set(self::SCORE, $value);
    }

    /**
     * Returns value of 'score' property
     *
     * @return integer
     */
    public function getScore()
    {
        $value = $this->get(self::SCORE);
        return $value === null ? (integer)$value : $value;
    }

    /**
     * Returns true if 'score' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasScore()
    {
        return $this->get(self::SCORE) !== null;
    }

    /**
     * Sets value of 'is_big' property
     *
     * @param boolean $value Property value
     *
     * @return null
     */
    public function setIsBig($value)
    {
        return $this->set(self::IS_BIG, $value);
    }

    /**
     * Returns value of 'is_big' property
     *
     * @return boolean
     */
    public function getIsBig()
    {
        $value = $this->get(self::IS_BIG);
        return $value === null ? (boolean)$value : $value;
    }

    /**
     * Returns true if 'is_big' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasIsBig()
    {
        return $this->get(self::IS_BIG) !== null;
    }
}
}