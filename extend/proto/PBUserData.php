<?php
/**
 * Auto generated from poker_data.proto at 2023-06-08 09:49:25
 */

namespace {
/**
 * PBUserData message
 */
class PBUserData extends \ProtobufMessage
{
    /* Field index constants */
    const USER_INFO = 1;
    const ACTIVITY_INFO = 2;
    const EMAIL_INFO = 3;

    /* @var array Field descriptors */
    protected static $fields = array(
        self::USER_INFO => array(
            'name' => 'user_info',
            'required' => false,
            'type' => '\PBUser'
        ),
        self::ACTIVITY_INFO => array(
            'name' => 'activity_info',
            'required' => false,
            'type' => '\PBActivity'
        ),
        self::EMAIL_INFO => array(
            'name' => 'email_info',
            'required' => false,
            'type' => '\PBEmail'
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
        $this->values[self::USER_INFO] = null;
        $this->values[self::ACTIVITY_INFO] = null;
        $this->values[self::EMAIL_INFO] = null;
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
     * Sets value of 'user_info' property
     *
     * @param \PBUser $value Property value
     *
     * @return null
     */
    public function setUserInfo(\PBUser $value=null)
    {
        return $this->set(self::USER_INFO, $value);
    }

    /**
     * Returns value of 'user_info' property
     *
     * @return \PBUser
     */
    public function getUserInfo()
    {
        return $this->get(self::USER_INFO);
    }

    /**
     * Returns true if 'user_info' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasUserInfo()
    {
        return $this->get(self::USER_INFO) !== null;
    }

    /**
     * Sets value of 'activity_info' property
     *
     * @param \PBActivity $value Property value
     *
     * @return null
     */
    public function setActivityInfo(\PBActivity $value=null)
    {
        return $this->set(self::ACTIVITY_INFO, $value);
    }

    /**
     * Returns value of 'activity_info' property
     *
     * @return \PBActivity
     */
    public function getActivityInfo()
    {
        return $this->get(self::ACTIVITY_INFO);
    }

    /**
     * Returns true if 'activity_info' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasActivityInfo()
    {
        return $this->get(self::ACTIVITY_INFO) !== null;
    }

    /**
     * Sets value of 'email_info' property
     *
     * @param \PBEmail $value Property value
     *
     * @return null
     */
    public function setEmailInfo(\PBEmail $value=null)
    {
        return $this->set(self::EMAIL_INFO, $value);
    }

    /**
     * Returns value of 'email_info' property
     *
     * @return \PBEmail
     */
    public function getEmailInfo()
    {
        return $this->get(self::EMAIL_INFO);
    }

    /**
     * Returns true if 'email_info' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasEmailInfo()
    {
        return $this->get(self::EMAIL_INFO) !== null;
    }
}
}