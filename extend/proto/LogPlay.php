<?php
/**
 * Auto generated from poker_msg_log.proto at 2023-06-08 09:49:25
 */

namespace {
/**
 * LogPlay message
 */
class LogPlay extends \ProtobufMessage
{
    /* Field index constants */
    const PLAY = 1;

    /* @var array Field descriptors */
    protected static $fields = array(
        self::PLAY => array(
            'name' => 'play',
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
        $this->values[self::PLAY] = null;
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
     * Sets value of 'play' property
     *
     * @param integer $value Property value
     *
     * @return null
     */
    public function setPlay($value)
    {
        return $this->set(self::PLAY, $value);
    }

    /**
     * Returns value of 'play' property
     *
     * @return integer
     */
    public function getPlay()
    {
        $value = $this->get(self::PLAY);
        return $value === null ? (integer)$value : $value;
    }

    /**
     * Returns true if 'play' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasPlay()
    {
        return $this->get(self::PLAY) !== null;
    }
}
}