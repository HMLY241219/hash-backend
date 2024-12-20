<?php
/**
 * Auto generated from poker_msg_ss.proto at 2023-06-08 09:49:25
 */

namespace {
/**
 * SSReportGameSvrdInfo message
 */
class SSReportGameSvrdInfo extends \ProtobufMessage
{
    /* Field index constants */
    const GTYPE = 1;
    const GAMEID = 2;
    const TABLELIST = 3;
    const LEVEL = 4;

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
        self::TABLELIST => array(
            'name' => 'tablelist',
            'repeated' => true,
            'type' => \ProtobufMessage::PB_TYPE_INT,
        ),
        self::LEVEL => array(
            'name' => 'level',
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
        $this->values[self::TABLELIST] = array();
        $this->values[self::LEVEL] = null;
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
     * Appends value to 'tablelist' list
     *
     * @param integer $value Value to append
     *
     * @return null
     */
    public function appendTablelist($value)
    {
        return $this->append(self::TABLELIST, $value);
    }

    /**
     * Clears 'tablelist' list
     *
     * @return null
     */
    public function clearTablelist()
    {
        return $this->clear(self::TABLELIST);
    }

    /**
     * Returns 'tablelist' list
     *
     * @return integer[]
     */
    public function getTablelist()
    {
        return $this->get(self::TABLELIST);
    }

    /**
     * Returns true if 'tablelist' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasTablelist()
    {
        return count($this->get(self::TABLELIST)) !== 0;
    }

    /**
     * Returns 'tablelist' iterator
     *
     * @return \ArrayIterator
     */
    public function getTablelistIterator()
    {
        return new \ArrayIterator($this->get(self::TABLELIST));
    }

    /**
     * Returns element from 'tablelist' list at given offset
     *
     * @param int $offset Position in list
     *
     * @return integer
     */
    public function getTablelistAt($offset)
    {
        return $this->get(self::TABLELIST, $offset);
    }

    /**
     * Returns count of 'tablelist' list
     *
     * @return int
     */
    public function getTablelistCount()
    {
        return $this->count(self::TABLELIST);
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
}
}