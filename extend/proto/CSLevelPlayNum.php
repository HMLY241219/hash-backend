<?php
/**
 * Auto generated from poker_msg_cs.proto at 2023-06-08 09:49:25
 */

namespace {
/**
 * CSLevelPlayNum message
 */
class CSLevelPlayNum extends \ProtobufMessage
{
    /* Field index constants */
    const LEVEL = 1;
    const PLAY_NUM = 2;

    /* @var array Field descriptors */
    protected static $fields = array(
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