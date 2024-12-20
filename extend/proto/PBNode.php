<?php
/**
 * Auto generated from poker_config.proto at 2023-06-08 09:49:25
 */

namespace {
/**
 * PBNode message
 */
class PBNode extends \ProtobufMessage
{
    /* Field index constants */
    const NTYPE = 1;
    const NSVID = 2;
    const IP = 3;
    const PORT = 4;

    /* @var array Field descriptors */
    protected static $fields = array(
        self::NTYPE => array(
            'name' => 'ntype',
            'required' => true,
            'type' => \ProtobufMessage::PB_TYPE_INT,
        ),
        self::NSVID => array(
            'name' => 'nsvid',
            'required' => true,
            'type' => \ProtobufMessage::PB_TYPE_INT,
        ),
        self::IP => array(
            'name' => 'ip',
            'required' => true,
            'type' => \ProtobufMessage::PB_TYPE_STRING,
        ),
        self::PORT => array(
            'name' => 'port',
            'required' => true,
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
        $this->values[self::NTYPE] = null;
        $this->values[self::NSVID] = null;
        $this->values[self::IP] = null;
        $this->values[self::PORT] = null;
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
     * Sets value of 'ntype' property
     *
     * @param integer $value Property value
     *
     * @return null
     */
    public function setNtype($value)
    {
        return $this->set(self::NTYPE, $value);
    }

    /**
     * Returns value of 'ntype' property
     *
     * @return integer
     */
    public function getNtype()
    {
        $value = $this->get(self::NTYPE);
        return $value === null ? (integer)$value : $value;
    }

    /**
     * Returns true if 'ntype' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasNtype()
    {
        return $this->get(self::NTYPE) !== null;
    }

    /**
     * Sets value of 'nsvid' property
     *
     * @param integer $value Property value
     *
     * @return null
     */
    public function setNsvid($value)
    {
        return $this->set(self::NSVID, $value);
    }

    /**
     * Returns value of 'nsvid' property
     *
     * @return integer
     */
    public function getNsvid()
    {
        $value = $this->get(self::NSVID);
        return $value === null ? (integer)$value : $value;
    }

    /**
     * Returns true if 'nsvid' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasNsvid()
    {
        return $this->get(self::NSVID) !== null;
    }

    /**
     * Sets value of 'ip' property
     *
     * @param string $value Property value
     *
     * @return null
     */
    public function setIp($value)
    {
        return $this->set(self::IP, $value);
    }

    /**
     * Returns value of 'ip' property
     *
     * @return string
     */
    public function getIp()
    {
        $value = $this->get(self::IP);
        return $value === null ? (string)$value : $value;
    }

    /**
     * Returns true if 'ip' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasIp()
    {
        return $this->get(self::IP) !== null;
    }

    /**
     * Sets value of 'port' property
     *
     * @param integer $value Property value
     *
     * @return null
     */
    public function setPort($value)
    {
        return $this->set(self::PORT, $value);
    }

    /**
     * Returns value of 'port' property
     *
     * @return integer
     */
    public function getPort()
    {
        $value = $this->get(self::PORT);
        return $value === null ? (integer)$value : $value;
    }

    /**
     * Returns true if 'port' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasPort()
    {
        return $this->get(self::PORT) !== null;
    }
}
}