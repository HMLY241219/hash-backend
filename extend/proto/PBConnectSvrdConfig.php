<?php
/**
 * Auto generated from poker_config.proto at 2023-06-08 09:49:25
 */

namespace {
/**
 * PBConnectSvrdConfig message
 */
class PBConnectSvrdConfig extends \ProtobufMessage
{
    /* Field index constants */
    const GAMES = 1;
    const ZONE_TYPE = 2;

    /* @var array Field descriptors */
    protected static $fields = array(
        self::GAMES => array(
            'name' => 'games',
            'repeated' => true,
            'type' => '\PBConnectGames'
        ),
        self::ZONE_TYPE => array(
            'name' => 'zone_type',
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
        $this->values[self::GAMES] = array();
        $this->values[self::ZONE_TYPE] = null;
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
     * Appends value to 'games' list
     *
     * @param \PBConnectGames $value Value to append
     *
     * @return null
     */
    public function appendGames(\PBConnectGames $value)
    {
        return $this->append(self::GAMES, $value);
    }

    /**
     * Clears 'games' list
     *
     * @return null
     */
    public function clearGames()
    {
        return $this->clear(self::GAMES);
    }

    /**
     * Returns 'games' list
     *
     * @return \PBConnectGames[]
     */
    public function getGames()
    {
        return $this->get(self::GAMES);
    }

    /**
     * Returns true if 'games' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasGames()
    {
        return count($this->get(self::GAMES)) !== 0;
    }

    /**
     * Returns 'games' iterator
     *
     * @return \ArrayIterator
     */
    public function getGamesIterator()
    {
        return new \ArrayIterator($this->get(self::GAMES));
    }

    /**
     * Returns element from 'games' list at given offset
     *
     * @param int $offset Position in list
     *
     * @return \PBConnectGames
     */
    public function getGamesAt($offset)
    {
        return $this->get(self::GAMES, $offset);
    }

    /**
     * Returns count of 'games' list
     *
     * @return int
     */
    public function getGamesCount()
    {
        return $this->count(self::GAMES);
    }

    /**
     * Sets value of 'zone_type' property
     *
     * @param integer $value Property value
     *
     * @return null
     */
    public function setZoneType($value)
    {
        return $this->set(self::ZONE_TYPE, $value);
    }

    /**
     * Returns value of 'zone_type' property
     *
     * @return integer
     */
    public function getZoneType()
    {
        $value = $this->get(self::ZONE_TYPE);
        return $value === null ? (integer)$value : $value;
    }

    /**
     * Returns true if 'zone_type' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasZoneType()
    {
        return $this->get(self::ZONE_TYPE) !== null;
    }
}
}