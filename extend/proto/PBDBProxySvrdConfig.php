<?php
/**
 * Auto generated from poker_config.proto at 2023-06-08 09:49:25
 */

namespace {
/**
 * PBDBProxySvrdConfig message
 */
class PBDBProxySvrdConfig extends \ProtobufMessage
{
    /* Field index constants */
    const RANK = 1;
    const ACCOUNT = 2;
    const USERS = 3;
    const SSDB = 4;

    /* @var array Field descriptors */
    protected static $fields = array(
        self::RANK => array(
            'name' => 'rank',
            'required' => false,
            'type' => '\PBSvrdNode'
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
        self::SSDB => array(
            'name' => 'ssdb',
            'required' => false,
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
        $this->values[self::RANK] = null;
        $this->values[self::ACCOUNT] = null;
        $this->values[self::USERS] = array();
        $this->values[self::SSDB] = null;
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
     * Sets value of 'rank' property
     *
     * @param \PBSvrdNode $value Property value
     *
     * @return null
     */
    public function setRank(\PBSvrdNode $value=null)
    {
        return $this->set(self::RANK, $value);
    }

    /**
     * Returns value of 'rank' property
     *
     * @return \PBSvrdNode
     */
    public function getRank()
    {
        return $this->get(self::RANK);
    }

    /**
     * Returns true if 'rank' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasRank()
    {
        return $this->get(self::RANK) !== null;
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

    /**
     * Sets value of 'ssdb' property
     *
     * @param \PBSvrdNode $value Property value
     *
     * @return null
     */
    public function setSsdb(\PBSvrdNode $value=null)
    {
        return $this->set(self::SSDB, $value);
    }

    /**
     * Returns value of 'ssdb' property
     *
     * @return \PBSvrdNode
     */
    public function getSsdb()
    {
        return $this->get(self::SSDB);
    }

    /**
     * Returns true if 'ssdb' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasSsdb()
    {
        return $this->get(self::SSDB) !== null;
    }
}
}