<?php
/**
 * Auto generated from poker_config.proto at 2023-06-08 09:49:25
 */

namespace {
/**
 * PBUserSvrdConfig message
 */
class PBUserSvrdConfig extends \ProtobufMessage
{
    /* Field index constants */
    const REDIS_SVRD_CONFIG = 1;

    /* @var array Field descriptors */
    protected static $fields = array(
        self::REDIS_SVRD_CONFIG => array(
            'name' => 'redis_svrd_config',
            'required' => false,
            'type' => '\PBNode'
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
        $this->values[self::REDIS_SVRD_CONFIG] = null;
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
     * Sets value of 'redis_svrd_config' property
     *
     * @param \PBNode $value Property value
     *
     * @return null
     */
    public function setRedisSvrdConfig(\PBNode $value=null)
    {
        return $this->set(self::REDIS_SVRD_CONFIG, $value);
    }

    /**
     * Returns value of 'redis_svrd_config' property
     *
     * @return \PBNode
     */
    public function getRedisSvrdConfig()
    {
        return $this->get(self::REDIS_SVRD_CONFIG);
    }

    /**
     * Returns true if 'redis_svrd_config' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasRedisSvrdConfig()
    {
        return $this->get(self::REDIS_SVRD_CONFIG) !== null;
    }
}
}