<?php
/**
 * Auto generated from poker_msg_ss.proto at 2023-06-08 09:49:25
 */

namespace {
/**
 * SSNotifyPlayerPosChange message
 */
class SSNotifyPlayerPosChange extends \ProtobufMessage
{
    /* Field index constants */
    const POS = 1;

    /* @var array Field descriptors */
    protected static $fields = array(
        self::POS => array(
            'name' => 'pos',
            'required' => false,
            'type' => '\PBBPlayerPositionInfo'
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
        $this->values[self::POS] = null;
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
     * Sets value of 'pos' property
     *
     * @param \PBBPlayerPositionInfo $value Property value
     *
     * @return null
     */
    public function setPos(\PBBPlayerPositionInfo $value=null)
    {
        return $this->set(self::POS, $value);
    }

    /**
     * Returns value of 'pos' property
     *
     * @return \PBBPlayerPositionInfo
     */
    public function getPos()
    {
        return $this->get(self::POS);
    }

    /**
     * Returns true if 'pos' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasPos()
    {
        return $this->get(self::POS) !== null;
    }
}
}