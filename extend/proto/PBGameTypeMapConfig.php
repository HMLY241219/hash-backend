<?php
/**
 * Auto generated from poker_config.proto at 2023-06-08 09:49:25
 */

namespace {
/**
 * PBGameTypeMapConfig message
 */
class PBGameTypeMapConfig extends \ProtobufMessage
{
    /* Field index constants */
    const GAME_TYPE = 1;

    /* @var array Field descriptors */
    protected static $fields = array(
        self::GAME_TYPE => array(
            'name' => 'game_type',
            'repeated' => true,
            'type' => '\PBTableGameType'
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
        $this->values[self::GAME_TYPE] = array();
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
     * Appends value to 'game_type' list
     *
     * @param \PBTableGameType $value Value to append
     *
     * @return null
     */
    public function appendGameType(\PBTableGameType $value)
    {
        return $this->append(self::GAME_TYPE, $value);
    }

    /**
     * Clears 'game_type' list
     *
     * @return null
     */
    public function clearGameType()
    {
        return $this->clear(self::GAME_TYPE);
    }

    /**
     * Returns 'game_type' list
     *
     * @return \PBTableGameType[]
     */
    public function getGameType()
    {
        return $this->get(self::GAME_TYPE);
    }

    /**
     * Returns true if 'game_type' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasGameType()
    {
        return count($this->get(self::GAME_TYPE)) !== 0;
    }

    /**
     * Returns 'game_type' iterator
     *
     * @return \ArrayIterator
     */
    public function getGameTypeIterator()
    {
        return new \ArrayIterator($this->get(self::GAME_TYPE));
    }

    /**
     * Returns element from 'game_type' list at given offset
     *
     * @param int $offset Position in list
     *
     * @return \PBTableGameType
     */
    public function getGameTypeAt($offset)
    {
        return $this->get(self::GAME_TYPE, $offset);
    }

    /**
     * Returns count of 'game_type' list
     *
     * @return int
     */
    public function getGameTypeCount()
    {
        return $this->count(self::GAME_TYPE);
    }
}
}