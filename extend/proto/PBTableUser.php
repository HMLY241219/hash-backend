<?php
/**
 * Auto generated from poker_msg_basic.proto at 2023-06-08 09:49:25
 */

namespace {
/**
 * PBTableUser message
 */
class PBTableUser extends \ProtobufMessage
{
    /* Field index constants */
    const UID = 1;
    const NICK = 2;
    const ROLE_PICTURE_URL = 3;
    const GENDER = 4;
    const IS_OFFLINE = 5;
    const OFFLINE_STAMP = 6;
    const ACC_TYPE = 7;
    const VIP_LEVEL = 8;
    const CHANNEL = 9;
    const LAST_LOGIN_IP = 10;
    const CONNECT_ID = 11;
    const IS_BACKEND = 12;
    const TOTAL_PAY_SCORE = 13;
    const BIND_UID = 14;
    const PACKAGE_ID = 15;

    /* @var array Field descriptors */
    protected static $fields = array(
        self::UID => array(
            'name' => 'uid',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_INT,
        ),
        self::NICK => array(
            'name' => 'nick',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_STRING,
        ),
        self::ROLE_PICTURE_URL => array(
            'name' => 'role_picture_url',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_STRING,
        ),
        self::GENDER => array(
            'name' => 'gender',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_INT,
        ),
        self::IS_OFFLINE => array(
            'name' => 'is_offline',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_BOOL,
        ),
        self::OFFLINE_STAMP => array(
            'name' => 'offline_stamp',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_INT,
        ),
        self::ACC_TYPE => array(
            'name' => 'acc_type',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_INT,
        ),
        self::VIP_LEVEL => array(
            'name' => 'vip_level',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_INT,
        ),
        self::CHANNEL => array(
            'name' => 'channel',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_INT,
        ),
        self::LAST_LOGIN_IP => array(
            'name' => 'last_login_ip',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_STRING,
        ),
        self::CONNECT_ID => array(
            'name' => 'connect_id',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_INT,
        ),
        self::IS_BACKEND => array(
            'name' => 'is_backend',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_BOOL,
        ),
        self::TOTAL_PAY_SCORE => array(
            'name' => 'total_pay_score',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_INT,
        ),
        self::BIND_UID => array(
            'name' => 'bind_uid',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_INT,
        ),
        self::PACKAGE_ID => array(
            'name' => 'package_id',
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
        $this->values[self::UID] = null;
        $this->values[self::NICK] = null;
        $this->values[self::ROLE_PICTURE_URL] = null;
        $this->values[self::GENDER] = null;
        $this->values[self::IS_OFFLINE] = null;
        $this->values[self::OFFLINE_STAMP] = null;
        $this->values[self::ACC_TYPE] = null;
        $this->values[self::VIP_LEVEL] = null;
        $this->values[self::CHANNEL] = null;
        $this->values[self::LAST_LOGIN_IP] = null;
        $this->values[self::CONNECT_ID] = null;
        $this->values[self::IS_BACKEND] = null;
        $this->values[self::TOTAL_PAY_SCORE] = null;
        $this->values[self::BIND_UID] = null;
        $this->values[self::PACKAGE_ID] = null;
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

    /**
     * Sets value of 'nick' property
     *
     * @param string $value Property value
     *
     * @return null
     */
    public function setNick($value)
    {
        return $this->set(self::NICK, $value);
    }

    /**
     * Returns value of 'nick' property
     *
     * @return string
     */
    public function getNick()
    {
        $value = $this->get(self::NICK);
        return $value === null ? (string)$value : $value;
    }

    /**
     * Returns true if 'nick' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasNick()
    {
        return $this->get(self::NICK) !== null;
    }

    /**
     * Sets value of 'role_picture_url' property
     *
     * @param string $value Property value
     *
     * @return null
     */
    public function setRolePictureUrl($value)
    {
        return $this->set(self::ROLE_PICTURE_URL, $value);
    }

    /**
     * Returns value of 'role_picture_url' property
     *
     * @return string
     */
    public function getRolePictureUrl()
    {
        $value = $this->get(self::ROLE_PICTURE_URL);
        return $value === null ? (string)$value : $value;
    }

    /**
     * Returns true if 'role_picture_url' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasRolePictureUrl()
    {
        return $this->get(self::ROLE_PICTURE_URL) !== null;
    }

    /**
     * Sets value of 'gender' property
     *
     * @param integer $value Property value
     *
     * @return null
     */
    public function setGender($value)
    {
        return $this->set(self::GENDER, $value);
    }

    /**
     * Returns value of 'gender' property
     *
     * @return integer
     */
    public function getGender()
    {
        $value = $this->get(self::GENDER);
        return $value === null ? (integer)$value : $value;
    }

    /**
     * Returns true if 'gender' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasGender()
    {
        return $this->get(self::GENDER) !== null;
    }

    /**
     * Sets value of 'is_offline' property
     *
     * @param boolean $value Property value
     *
     * @return null
     */
    public function setIsOffline($value)
    {
        return $this->set(self::IS_OFFLINE, $value);
    }

    /**
     * Returns value of 'is_offline' property
     *
     * @return boolean
     */
    public function getIsOffline()
    {
        $value = $this->get(self::IS_OFFLINE);
        return $value === null ? (boolean)$value : $value;
    }

    /**
     * Returns true if 'is_offline' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasIsOffline()
    {
        return $this->get(self::IS_OFFLINE) !== null;
    }

    /**
     * Sets value of 'offline_stamp' property
     *
     * @param integer $value Property value
     *
     * @return null
     */
    public function setOfflineStamp($value)
    {
        return $this->set(self::OFFLINE_STAMP, $value);
    }

    /**
     * Returns value of 'offline_stamp' property
     *
     * @return integer
     */
    public function getOfflineStamp()
    {
        $value = $this->get(self::OFFLINE_STAMP);
        return $value === null ? (integer)$value : $value;
    }

    /**
     * Returns true if 'offline_stamp' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasOfflineStamp()
    {
        return $this->get(self::OFFLINE_STAMP) !== null;
    }

    /**
     * Sets value of 'acc_type' property
     *
     * @param integer $value Property value
     *
     * @return null
     */
    public function setAccType($value)
    {
        return $this->set(self::ACC_TYPE, $value);
    }

    /**
     * Returns value of 'acc_type' property
     *
     * @return integer
     */
    public function getAccType()
    {
        $value = $this->get(self::ACC_TYPE);
        return $value === null ? (integer)$value : $value;
    }

    /**
     * Returns true if 'acc_type' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasAccType()
    {
        return $this->get(self::ACC_TYPE) !== null;
    }

    /**
     * Sets value of 'vip_level' property
     *
     * @param integer $value Property value
     *
     * @return null
     */
    public function setVipLevel($value)
    {
        return $this->set(self::VIP_LEVEL, $value);
    }

    /**
     * Returns value of 'vip_level' property
     *
     * @return integer
     */
    public function getVipLevel()
    {
        $value = $this->get(self::VIP_LEVEL);
        return $value === null ? (integer)$value : $value;
    }

    /**
     * Returns true if 'vip_level' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasVipLevel()
    {
        return $this->get(self::VIP_LEVEL) !== null;
    }

    /**
     * Sets value of 'channel' property
     *
     * @param integer $value Property value
     *
     * @return null
     */
    public function setChannel($value)
    {
        return $this->set(self::CHANNEL, $value);
    }

    /**
     * Returns value of 'channel' property
     *
     * @return integer
     */
    public function getChannel()
    {
        $value = $this->get(self::CHANNEL);
        return $value === null ? (integer)$value : $value;
    }

    /**
     * Returns true if 'channel' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasChannel()
    {
        return $this->get(self::CHANNEL) !== null;
    }

    /**
     * Sets value of 'last_login_ip' property
     *
     * @param string $value Property value
     *
     * @return null
     */
    public function setLastLoginIp($value)
    {
        return $this->set(self::LAST_LOGIN_IP, $value);
    }

    /**
     * Returns value of 'last_login_ip' property
     *
     * @return string
     */
    public function getLastLoginIp()
    {
        $value = $this->get(self::LAST_LOGIN_IP);
        return $value === null ? (string)$value : $value;
    }

    /**
     * Returns true if 'last_login_ip' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasLastLoginIp()
    {
        return $this->get(self::LAST_LOGIN_IP) !== null;
    }

    /**
     * Sets value of 'connect_id' property
     *
     * @param integer $value Property value
     *
     * @return null
     */
    public function setConnectId($value)
    {
        return $this->set(self::CONNECT_ID, $value);
    }

    /**
     * Returns value of 'connect_id' property
     *
     * @return integer
     */
    public function getConnectId()
    {
        $value = $this->get(self::CONNECT_ID);
        return $value === null ? (integer)$value : $value;
    }

    /**
     * Returns true if 'connect_id' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasConnectId()
    {
        return $this->get(self::CONNECT_ID) !== null;
    }

    /**
     * Sets value of 'is_backend' property
     *
     * @param boolean $value Property value
     *
     * @return null
     */
    public function setIsBackend($value)
    {
        return $this->set(self::IS_BACKEND, $value);
    }

    /**
     * Returns value of 'is_backend' property
     *
     * @return boolean
     */
    public function getIsBackend()
    {
        $value = $this->get(self::IS_BACKEND);
        return $value === null ? (boolean)$value : $value;
    }

    /**
     * Returns true if 'is_backend' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasIsBackend()
    {
        return $this->get(self::IS_BACKEND) !== null;
    }

    /**
     * Sets value of 'total_pay_score' property
     *
     * @param integer $value Property value
     *
     * @return null
     */
    public function setTotalPayScore($value)
    {
        return $this->set(self::TOTAL_PAY_SCORE, $value);
    }

    /**
     * Returns value of 'total_pay_score' property
     *
     * @return integer
     */
    public function getTotalPayScore()
    {
        $value = $this->get(self::TOTAL_PAY_SCORE);
        return $value === null ? (integer)$value : $value;
    }

    /**
     * Returns true if 'total_pay_score' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasTotalPayScore()
    {
        return $this->get(self::TOTAL_PAY_SCORE) !== null;
    }

    /**
     * Sets value of 'bind_uid' property
     *
     * @param integer $value Property value
     *
     * @return null
     */
    public function setBindUid($value)
    {
        return $this->set(self::BIND_UID, $value);
    }

    /**
     * Returns value of 'bind_uid' property
     *
     * @return integer
     */
    public function getBindUid()
    {
        $value = $this->get(self::BIND_UID);
        return $value === null ? (integer)$value : $value;
    }

    /**
     * Returns true if 'bind_uid' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasBindUid()
    {
        return $this->get(self::BIND_UID) !== null;
    }

    /**
     * Sets value of 'package_id' property
     *
     * @param integer $value Property value
     *
     * @return null
     */
    public function setPackageId($value)
    {
        return $this->set(self::PACKAGE_ID, $value);
    }

    /**
     * Returns value of 'package_id' property
     *
     * @return integer
     */
    public function getPackageId()
    {
        $value = $this->get(self::PACKAGE_ID);
        return $value === null ? (integer)$value : $value;
    }

    /**
     * Returns true if 'package_id' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasPackageId()
    {
        return $this->get(self::PACKAGE_ID) !== null;
    }
}
}