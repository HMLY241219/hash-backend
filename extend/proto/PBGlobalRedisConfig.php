<?php
/**
 * Auto generated from poker_config.proto at 2023-06-08 09:49:25
 */

namespace {
/**
 * PBGlobalRedisConfig message
 */
class PBGlobalRedisConfig extends \ProtobufMessage
{
    /* Field index constants */
    const IP = 1;
    const PORT = 2;
    const USERS = 3;

    /* @var array Field descriptors */
    protected static $fields = array(
        self::IP => array(
            'name' => 'ip',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_STRING,
        ),
        self::PORT => array(
            'name' => 'port',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_INT,
        ),
        self::USERS => array(
            'name' => 'users',
            'repeated' => true,
            'type' => '\PBSvrdNode'
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
        $this->values[self::IP] = null;
        $this->values[self::PORT] = null;
        $this->values[self::USERS] = array();
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

    /**
     * Appends value to 'users' list
     *
     * @param \PBSvrdNode $value Value to append
     *
     * @return null
     */
    public function appendUsers(\PBSvrdNode $value)
    {
        return $this->append(self::USERS, $value);
    }

    /**
     * Clears 'users' list
     *
     * @return null
     */
    public function clearUsers()
    {
        return $this->clear(self::USERS);
    }

    /**
     * Returns 'users' list
     *
     * @return \PBSvrdNode[]
     */
    public function getUsers()
    {
        return $this->get(self::USERS);
    }

    /**
     * Returns true if 'users' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasUsers()
    {
        return count($this->get(self::USERS)) !== 0;
    }

    /**
     * Returns 'users' iterator
     *
     * @return \ArrayIterator
     */
    public function getUsersIterator()
    {
        return new \ArrayIterator($this->get(self::USERS));
    }

    /**
     * Returns element from 'users' list at given offset
     *
     * @param int $offset Position in list
     *
     * @return \PBSvrdNode
     */
    public function getUsersAt($offset)
    {
        return $this->get(self::USERS, $offset);
    }

    /**
     * Returns count of 'users' list
     *
     * @return int
     */
    public function getUsersCount()
    {
        return $this->count(self::USERS);
    }
}
}