<?php
/**
 * Auto generated from poker_msg_log.proto at 2023-06-08 09:49:25
 */

namespace {
/**
 * LogUserInfo message
 */
class LogUserInfo extends \ProtobufMessage
{
    /* Field index constants */
    const USER = 1;

    /* @var array Field descriptors */
    protected static $fields = array(
        self::USER => array(
            'name' => 'user',
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
        $this->values[self::USER] = null;
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
     * Sets value of 'user' property
     *
     * @param \PBUser $value Property value
     *
     * @return null
     */
    public function setUser(\PBUser $value=null)
    {
        return $this->set(self::USER, $value);
    }

    /**
     * Returns value of 'user' property
     *
     * @return \PBUser
     */
    public function getUser()
    {
        return $this->get(self::USER);
    }

    /**
     * Returns true if 'user' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasUser()
    {
        return $this->get(self::USER) !== null;
    }
}
}