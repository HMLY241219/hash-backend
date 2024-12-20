<?php
/**
 * Auto generated from poker_msg_ss.proto at 2023-06-08 09:49:25
 */

namespace {
/**
 * SSRequestRobotRandomOper message
 */
class SSRequestRobotRandomOper extends \ProtobufMessage
{
    /* Field index constants */
    const USERINFO = 1;

    /* @var array Field descriptors */
    protected static $fields = array(
        self::USERINFO => array(
            'name' => 'userInfo',
            'required' => false,
            'type' => '\PBUser'
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
        $this->values[self::USERINFO] = null;
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
     * Sets value of 'userInfo' property
     *
     * @param \PBUser $value Property value
     *
     * @return null
     */
    public function setUserInfo(\PBUser $value=null)
    {
        return $this->set(self::USERINFO, $value);
    }

    /**
     * Returns value of 'userInfo' property
     *
     * @return \PBUser
     */
    public function getUserInfo()
    {
        return $this->get(self::USERINFO);
    }

    /**
     * Returns true if 'userInfo' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasUserInfo()
    {
        return $this->get(self::USERINFO) !== null;
    }
}
}