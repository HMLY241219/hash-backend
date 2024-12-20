<?php
/**
 * Auto generated from poker_config.proto at 2023-06-08 09:49:25
 */

namespace {
/**
 * PBAutoMatchRoomConfig message
 */
class PBAutoMatchRoomConfig extends \ProtobufMessage
{
    /* Field index constants */
    const ITEMS = 1;
    const GAMES = 2;

    /* @var array Field descriptors */
    protected static $fields = array(
        self::ITEMS => array(
            'name' => 'items',
            'repeated' => true,
            'type' => '\PBAutoMatchRoomItem'
        ),
        self::GAMES => array(
            'name' => 'games',
            'repeated' => true,
            'type' => '\PBTableNodePosConfig'
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
        $this->values[self::ITEMS] = array();
        $this->values[self::GAMES] = array();
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
     * Appends value to 'items' list
     *
     * @param \PBAutoMatchRoomItem $value Value to append
     *
     * @return null
     */
    public function appendItems(\PBAutoMatchRoomItem $value)
    {
        return $this->append(self::ITEMS, $value);
    }

    /**
     * Clears 'items' list
     *
     * @return null
     */
    public function clearItems()
    {
        return $this->clear(self::ITEMS);
    }

    /**
     * Returns 'items' list
     *
     * @return \PBAutoMatchRoomItem[]
     */
    public function getItems()
    {
        return $this->get(self::ITEMS);
    }

    /**
     * Returns true if 'items' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasItems()
    {
        return count($this->get(self::ITEMS)) !== 0;
    }

    /**
     * Returns 'items' iterator
     *
     * @return \ArrayIterator
     */
    public function getItemsIterator()
    {
        return new \ArrayIterator($this->get(self::ITEMS));
    }

    /**
     * Returns element from 'items' list at given offset
     *
     * @param int $offset Position in list
     *
     * @return \PBAutoMatchRoomItem
     */
    public function getItemsAt($offset)
    {
        return $this->get(self::ITEMS, $offset);
    }

    /**
     * Returns count of 'items' list
     *
     * @return int
     */
    public function getItemsCount()
    {
        return $this->count(self::ITEMS);
    }

    /**
     * Appends value to 'games' list
     *
     * @param \PBTableNodePosConfig $value Value to append
     *
     * @return null
     */
    public function appendGames(\PBTableNodePosConfig $value)
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
     * @return \PBTableNodePosConfig[]
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
     * @return \PBTableNodePosConfig
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
}
}