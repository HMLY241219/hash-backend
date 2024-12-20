<?php
/**
 * Auto generated from poker_config.proto at 2023-06-08 09:49:25
 */

namespace {
/**
 * PBRouteSvrdConfig message
 */
class PBRouteSvrdConfig extends \ProtobufMessage
{
    /* Field index constants */
    const ROUTES = 1;
    const CONNECTS = 2;

    /* @var array Field descriptors */
    protected static $fields = array(
        self::ROUTES => array(
            'name' => 'routes',
            'repeated' => true,
            'type' => '\PBSvrdNode'
        ),
        self::CONNECTS => array(
            'name' => 'connects',
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
        $this->values[self::ROUTES] = array();
        $this->values[self::CONNECTS] = array();
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
     * Appends value to 'routes' list
     *
     * @param \PBSvrdNode $value Value to append
     *
     * @return null
     */
    public function appendRoutes(\PBSvrdNode $value)
    {
        return $this->append(self::ROUTES, $value);
    }

    /**
     * Clears 'routes' list
     *
     * @return null
     */
    public function clearRoutes()
    {
        return $this->clear(self::ROUTES);
    }

    /**
     * Returns 'routes' list
     *
     * @return \PBSvrdNode[]
     */
    public function getRoutes()
    {
        return $this->get(self::ROUTES);
    }

    /**
     * Returns true if 'routes' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasRoutes()
    {
        return count($this->get(self::ROUTES)) !== 0;
    }

    /**
     * Returns 'routes' iterator
     *
     * @return \ArrayIterator
     */
    public function getRoutesIterator()
    {
        return new \ArrayIterator($this->get(self::ROUTES));
    }

    /**
     * Returns element from 'routes' list at given offset
     *
     * @param int $offset Position in list
     *
     * @return \PBSvrdNode
     */
    public function getRoutesAt($offset)
    {
        return $this->get(self::ROUTES, $offset);
    }

    /**
     * Returns count of 'routes' list
     *
     * @return int
     */
    public function getRoutesCount()
    {
        return $this->count(self::ROUTES);
    }

    /**
     * Appends value to 'connects' list
     *
     * @param \PBSvrdNode $value Value to append
     *
     * @return null
     */
    public function appendConnects(\PBSvrdNode $value)
    {
        return $this->append(self::CONNECTS, $value);
    }

    /**
     * Clears 'connects' list
     *
     * @return null
     */
    public function clearConnects()
    {
        return $this->clear(self::CONNECTS);
    }

    /**
     * Returns 'connects' list
     *
     * @return \PBSvrdNode[]
     */
    public function getConnects()
    {
        return $this->get(self::CONNECTS);
    }

    /**
     * Returns true if 'connects' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasConnects()
    {
        return count($this->get(self::CONNECTS)) !== 0;
    }

    /**
     * Returns 'connects' iterator
     *
     * @return \ArrayIterator
     */
    public function getConnectsIterator()
    {
        return new \ArrayIterator($this->get(self::CONNECTS));
    }

    /**
     * Returns element from 'connects' list at given offset
     *
     * @param int $offset Position in list
     *
     * @return \PBSvrdNode
     */
    public function getConnectsAt($offset)
    {
        return $this->get(self::CONNECTS, $offset);
    }

    /**
     * Returns count of 'connects' list
     *
     * @return int
     */
    public function getConnectsCount()
    {
        return $this->count(self::CONNECTS);
    }
}
}