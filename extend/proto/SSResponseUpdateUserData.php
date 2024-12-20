<?php
/**
 * Auto generated from poker_msg_ss.proto at 2023-06-08 09:49:25
 */

namespace {
/**
 * SSResponseUpdateUserData message
 */
class SSResponseUpdateUserData extends \ProtobufMessage
{
    /* Field index constants */
    const RESULT = 1;
    const USER_DATA = 2;
    const UID = 3;

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
            'type' => '\PBUserData'
        ),
        self::UID => array(
            'name' => 'uid',
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
        $this->values[self::RESULT] = null;
        $this->values[self::USER_DATA] = null;
        $this->values[self::UID] = null;
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
     * @param \PBUserData $value Property value
     *
     * @return null
     */
    public function setUserData(\PBUserData $value=null)
    {
        return $this->set(self::USER_DATA, $value);
    }

    /**
     * Returns value of 'user_data' property
     *
     * @return \PBUserData
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
     * Sets value of 'uid' property
     *
     * @param integer $value Property value
     *
     * @return null
     */
    public function setUid($value)
    {
        return $this->set(self::UID, $value);
    }

    /**
     * Returns value of 'uid' property
     *
     * @return integer
     */
    public function getUid()
    {
        $value = $this->get(self::UID);
        return $value === null ? (integer)$value : $value;
    }

    /**
     * Returns true if 'uid' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasUid()
    {
        return $this->get(self::UID) !== null;
    }
}
}