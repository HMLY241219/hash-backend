<?php
/**
 * Auto generated from poker_msg_cs.proto at 2023-06-08 09:49:25
 */

namespace {
/**
 * CSResponseUpdateUserInfo message
 */
class CSResponseUpdateUserInfo extends \ProtobufMessage
{
    /* Field index constants */
    const RESULT = 1;
    const USER_DATA = 2;
    const ACTIVITY_INFO = 3;

    /* @var array Field descriptors */
    protected static $fields = array(
        self::RESULT => array(
            'name' => 'result',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_INT,
        ),
        self::USER_DATA => array(
            'name' => 'user_data',
            'required' => false,
            'type' => '\PBUser'
        ),
        self::ACTIVITY_INFO => array(
            'name' => 'activity_info',
            'required' => false,
            'type' => '\PBActivity'
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
        $this->values[self::RESULT] = null;
        $this->values[self::USER_DATA] = null;
        $this->values[self::ACTIVITY_INFO] = null;
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
     * Sets value of 'result' property
     *
     * @param integer $value Property value
     *
     * @return null
     */
    public function setResult($value)
    {
        return $this->set(self::RESULT, $value);
    }

    /**
     * Returns value of 'result' property
     *
     * @return integer
     */
    public function getResult()
    {
        $value = $this->get(self::RESULT);
        return $value === null ? (integer)$value : $value;
    }

    /**
     * Returns true if 'result' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasResult()
    {
        return $this->get(self::RESULT) !== null;
    }

    /**
     * Sets value of 'user_data' property
     *
     * @param \PBUser $value Property value
     *
     * @return null
     */
    public function setUserData(\PBUser $value=null)
    {
        return $this->set(self::USER_DATA, $value);
    }

    /**
     * Returns value of 'user_data' property
     *
     * @return \PBUser
     */
    public function getUserData()
    {
        return $this->get(self::USER_DATA);
    }

    /**
     * Returns true if 'user_data' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasUserData()
    {
        return $this->get(self::USER_DATA) !== null;
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
}
}