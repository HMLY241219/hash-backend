<?php
/**
 * Auto generated from poker_msg_ss.proto at 2023-06-08 09:49:25
 */

namespace {
/**
 * SSNotifyGameSvrdRetire message
 */
class SSNotifyGameSvrdRetire extends \ProtobufMessage
{
    /* Field index constants */
    const GTYPE = 1;
    const GAMEID = 2;

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
}
}