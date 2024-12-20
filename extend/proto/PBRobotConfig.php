<?php
/**
 * Auto generated from poker_config.proto at 2023-06-08 09:49:25
 */

namespace {
/**
 * PBRobotConfig message
 */
class PBRobotConfig extends \ProtobufMessage
{
    /* Field index constants */
    const CONNECT = 1;
    const ROBOT_NUM = 2;
    const DETAIL = 3;
    const URL = 4;
    const ACCOUNT = 5;
    const USERS = 6;

    /* @var array Field descriptors */
    protected static $fields = array(
        self::CONNECT => array(
            'name' => 'connect',
            'repeated' => true,
            'type' => '\PBSvrdNode'
        ),
        self::ROBOT_NUM => array(
            'name' => 'robot_num',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_INT,
        ),
        self::DETAIL => array(
            'name' => 'detail',
            'repeated' => true,
            'type' => '\PBRobotDetailConfig'
        ),
        self::URL => array(
            'name' => 'url',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_STRING,
        ),
        self::ACCOUNT => array(
            'name' => 'account',
            'required' => false,
            'type' => '\PBSvrdNode'
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
        $this->values[self::CONNECT] = array();
        $this->values[self::ROBOT_NUM] = null;
        $this->values[self::DETAIL] = array();
        $this->values[self::URL] = null;
        $this->values[self::ACCOUNT] = null;
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
     * Appends value to 'connect' list
     *
     * @param \PBSvrdNode $value Value to append
     *
     * @return null
     */
    public function appendConnect(\PBSvrdNode $value)
    {
        return $this->append(self::CONNECT, $value);
    }

    /**
     * Clears 'connect' list
     *
     * @return null
     */
    public function clearConnect()
    {
        return $this->clear(self::CONNECT);
    }

    /**
     * Returns 'connect' list
     *
     * @return \PBSvrdNode[]
     */
    public function getConnect()
    {
        return $this->get(self::CONNECT);
    }

    /**
     * Returns true if 'connect' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasConnect()
    {
        return count($this->get(self::CONNECT)) !== 0;
    }

    /**
     * Returns 'connect' iterator
     *
     * @return \ArrayIterator
     */
    public function getConnectIterator()
    {
        return new \ArrayIterator($this->get(self::CONNECT));
    }

    /**
     * Returns element from 'connect' list at given offset
     *
     * @param int $offset Position in list
     *
     * @return \PBSvrdNode
     */
    public function getConnectAt($offset)
    {
        return $this->get(self::CONNECT, $offset);
    }

    /**
     * Returns count of 'connect' list
     *
     * @return int
     */
    public function getConnectCount()
    {
        return $this->count(self::CONNECT);
    }

    /**
     * Sets value of 'robot_num' property
     *
     * @param integer $value Property value
     *
     * @return null
     */
    public function setRobotNum($value)
    {
        return $this->set(self::ROBOT_NUM, $value);
    }

    /**
     * Returns value of 'robot_num' property
     *
     * @return integer
     */
    public function getRobotNum()
    {
        $value = $this->get(self::ROBOT_NUM);
        return $value === null ? (integer)$value : $value;
    }

    /**
     * Returns true if 'robot_num' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasRobotNum()
    {
        return $this->get(self::ROBOT_NUM) !== null;
    }

    /**
     * Appends value to 'detail' list
     *
     * @param \PBRobotDetailConfig $value Value to append
     *
     * @return null
     */
    public function appendDetail(\PBRobotDetailConfig $value)
    {
        return $this->append(self::DETAIL, $value);
    }

    /**
     * Clears 'detail' list
     *
     * @return null
     */
    public function clearDetail()
    {
        return $this->clear(self::DETAIL);
    }

    /**
     * Returns 'detail' list
     *
     * @return \PBRobotDetailConfig[]
     */
    public function getDetail()
    {
        return $this->get(self::DETAIL);
    }

    /**
     * Returns true if 'detail' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasDetail()
    {
        return count($this->get(self::DETAIL)) !== 0;
    }

    /**
     * Returns 'detail' iterator
     *
     * @return \ArrayIterator
     */
    public function getDetailIterator()
    {
        return new \ArrayIterator($this->get(self::DETAIL));
    }

    /**
     * Returns element from 'detail' list at given offset
     *
     * @param int $offset Position in list
     *
     * @return \PBRobotDetailConfig
     */
    public function getDetailAt($offset)
    {
        return $this->get(self::DETAIL, $offset);
    }

    /**
     * Returns count of 'detail' list
     *
     * @return int
     */
    public function getDetailCount()
    {
        return $this->count(self::DETAIL);
    }

    /**
     * Sets value of 'url' property
     *
     * @param string $value Property value
     *
     * @return null
     */
    public function setUrl($value)
    {
        return $this->set(self::URL, $value);
    }

    /**
     * Returns value of 'url' property
     *
     * @return string
     */
    public function getUrl()
    {
        $value = $this->get(self::URL);
        return $value === null ? (string)$value : $value;
    }

    /**
     * Returns true if 'url' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasUrl()
    {
        return $this->get(self::URL) !== null;
    }

    /**
     * Sets value of 'account' property
     *
     * @param \PBSvrdNode $value Property value
     *
     * @return null
     */
    public function setAccount(\PBSvrdNode $value=null)
    {
        return $this->set(self::ACCOUNT, $value);
    }

    /**
     * Returns value of 'account' property
     *
     * @return \PBSvrdNode
     */
    public function getAccount()
    {
        return $this->get(self::ACCOUNT);
    }

    /**
     * Returns true if 'account' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasAccount()
    {
        return $this->get(self::ACCOUNT) !== null;
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