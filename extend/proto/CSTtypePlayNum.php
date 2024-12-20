<?php
/**
 * Auto generated from poker_msg_cs.proto at 2023-06-08 09:49:25
 */

namespace {
/**
 * CSTtypePlayNum message
 */
class CSTtypePlayNum extends \ProtobufMessage
{
    /* Field index constants */
    const TTYPE = 1;
    const PLAY_NUM = 2;
    const LEVEL_PLAY_NUM = 3;

    /* @var array Field descriptors */
    protected static $fields = array(
        self::TTYPE => array(
            'name' => 'ttype',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_INT,
        ),
        self::PLAY_NUM => array(
            'name' => 'play_num',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_INT,
        ),
        self::LEVEL_PLAY_NUM => array(
            'name' => 'level_play_num',
            'repeated' => true,
            'type' => '\CSLevelPlayNum'
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
        $this->values[self::TTYPE] = null;
        $this->values[self::PLAY_NUM] = null;
        $this->values[self::LEVEL_PLAY_NUM] = array();
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
     * Sets value of 'ttype' property
     *
     * @param integer $value Property value
     *
     * @return null
     */
    public function setTtype($value)
    {
        return $this->set(self::TTYPE, $value);
    }

    /**
     * Returns value of 'ttype' property
     *
     * @return integer
     */
    public function getTtype()
    {
        $value = $this->get(self::TTYPE);
        return $value === null ? (integer)$value : $value;
    }

    /**
     * Returns true if 'ttype' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasTtype()
    {
        return $this->get(self::TTYPE) !== null;
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
     * Appends value to 'level_play_num' list
     *
     * @param \CSLevelPlayNum $value Value to append
     *
     * @return null
     */
    public function appendLevelPlayNum(\CSLevelPlayNum $value)
    {
        return $this->append(self::LEVEL_PLAY_NUM, $value);
    }

    /**
     * Clears 'level_play_num' list
     *
     * @return null
     */
    public function clearLevelPlayNum()
    {
        return $this->clear(self::LEVEL_PLAY_NUM);
    }

    /**
     * Returns 'level_play_num' list
     *
     * @return \CSLevelPlayNum[]
     */
    public function getLevelPlayNum()
    {
        return $this->get(self::LEVEL_PLAY_NUM);
    }

    /**
     * Returns true if 'level_play_num' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasLevelPlayNum()
    {
        return count($this->get(self::LEVEL_PLAY_NUM)) !== 0;
    }

    /**
     * Returns 'level_play_num' iterator
     *
     * @return \ArrayIterator
     */
    public function getLevelPlayNumIterator()
    {
        return new \ArrayIterator($this->get(self::LEVEL_PLAY_NUM));
    }

    /**
     * Returns element from 'level_play_num' list at given offset
     *
     * @param int $offset Position in list
     *
     * @return \CSLevelPlayNum
     */
    public function getLevelPlayNumAt($offset)
    {
        return $this->get(self::LEVEL_PLAY_NUM, $offset);
    }

    /**
     * Returns count of 'level_play_num' list
     *
     * @return int
     */
    public function getLevelPlayNumCount()
    {
        return $this->count(self::LEVEL_PLAY_NUM);
    }
}
}