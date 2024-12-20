<?php
/**
 * Auto generated from poker_msg_cs.proto at 2023-06-08 09:49:25
 */

namespace {
/**
 * CSRequestLogin message
 */
class CSRequestLogin extends \ProtobufMessage
{
    /* Field index constants */
    const ACC_TYPE = 1;
    const ACCOUNT = 2;
    const PWD = 3;
    const TOKEN = 4;
    const HSVID = 5;
    const GENDER = 6;
    const PIC_URL = 7;
    const NICK = 8;
    const UID = 9;
    const REQUEST_LIST_IP = 10;
    const CHANNEL = 11;
    const PACKAGEID = 12;
    const PHONE_TYPE = 13;
    const BIND_UID = 14;
    const IS_SPECIAL = 15;

    /* @var array Field descriptors */
    protected static $fields = array(
        self::ACC_TYPE => array(
            'name' => 'acc_type',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_INT,
        ),
        self::ACCOUNT => array(
            'name' => 'account',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_STRING,
        ),
        self::PWD => array(
            'name' => 'pwd',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_STRING,
        ),
        self::TOKEN => array(
            'name' => 'token',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_STRING,
        ),
        self::HSVID => array(
            'name' => 'hsvid',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_INT,
        ),
        self::GENDER => array(
            'name' => 'gender',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_INT,
        ),
        self::PIC_URL => array(
            'name' => 'pic_url',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_STRING,
        ),
        self::NICK => array(
            'name' => 'nick',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_STRING,
        ),
        self::UID => array(
            'name' => 'uid',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_INT,
        ),
        self::REQUEST_LIST_IP => array(
            'name' => 'request_list_ip',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_STRING,
        ),
        self::CHANNEL => array(
            'name' => 'channel',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_INT,
        ),
        self::PACKAGEID => array(
            'name' => 'packageid',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_INT,
        ),
        self::PHONE_TYPE => array(
            'name' => 'phone_type',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_INT,
        ),
        self::BIND_UID => array(
            'name' => 'bind_uid',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_INT,
        ),
        self::IS_SPECIAL => array(
            'name' => 'is_special',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_BOOL,
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
        $this->values[self::ACC_TYPE] = null;
        $this->values[self::ACCOUNT] = null;
        $this->values[self::PWD] = null;
        $this->values[self::TOKEN] = null;
        $this->values[self::HSVID] = null;
        $this->values[self::GENDER] = null;
        $this->values[self::PIC_URL] = null;
        $this->values[self::NICK] = null;
        $this->values[self::UID] = null;
        $this->values[self::REQUEST_LIST_IP] = null;
        $this->values[self::CHANNEL] = null;
        $this->values[self::PACKAGEID] = null;
        $this->values[self::PHONE_TYPE] = null;
        $this->values[self::BIND_UID] = null;
        $this->values[self::IS_SPECIAL] = null;
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
     * Sets value of 'account' property
     *
     * @param string $value Property value
     *
     * @return null
     */
    public function setAccount($value)
    {
        return $this->set(self::ACCOUNT, $value);
    }

    /**
     * Returns value of 'account' property
     *
     * @return string
     */
    public function getAccount()
    {
        $value = $this->get(self::ACCOUNT);
        return $value === null ? (string)$value : $value;
    }

    /**
     * Returns true if 'account' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasAccount()
    {
        return $this->get(self::ACCOUNT) !== null;
    }

    /**
     * Sets value of 'pwd' property
     *
     * @param string $value Property value
     *
     * @return null
     */
    public function setPwd($value)
    {
        return $this->set(self::PWD, $value);
    }

    /**
     * Returns value of 'pwd' property
     *
     * @return string
     */
    public function getPwd()
    {
        $value = $this->get(self::PWD);
        return $value === null ? (string)$value : $value;
    }

    /**
     * Returns true if 'pwd' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasPwd()
    {
        return $this->get(self::PWD) !== null;
    }

    /**
     * Sets value of 'token' property
     *
     * @param string $value Property value
     *
     * @return null
     */
    public function setToken($value)
    {
        return $this->set(self::TOKEN, $value);
    }

    /**
     * Returns value of 'token' property
     *
     * @return string
     */
    public function getToken()
    {
        $value = $this->get(self::TOKEN);
        return $value === null ? (string)$value : $value;
    }

    /**
     * Returns true if 'token' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasToken()
    {
        return $this->get(self::TOKEN) !== null;
    }

    /**
     * Sets value of 'hsvid' property
     *
     * @param integer $value Property value
     *
     * @return null
     */
    public function setHsvid($value)
    {
        return $this->set(self::HSVID, $value);
    }

    /**
     * Returns value of 'hsvid' property
     *
     * @return integer
     */
    public function getHsvid()
    {
        $value = $this->get(self::HSVID);
        return $value === null ? (integer)$value : $value;
    }

    /**
     * Returns true if 'hsvid' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasHsvid()
    {
        return $this->get(self::HSVID) !== null;
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
     * Sets value of 'pic_url' property
     *
     * @param string $value Property value
     *
     * @return null
     */
    public function setPicUrl($value)
    {
        return $this->set(self::PIC_URL, $value);
    }

    /**
     * Returns value of 'pic_url' property
     *
     * @return string
     */
    public function getPicUrl()
    {
        $value = $this->get(self::PIC_URL);
        return $value === null ? (string)$value : $value;
    }

    /**
     * Returns true if 'pic_url' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasPicUrl()
    {
        return $this->get(self::PIC_URL) !== null;
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
     * Sets value of 'request_list_ip' property
     *
     * @param string $value Property value
     *
     * @return null
     */
    public function setRequestListIp($value)
    {
        return $this->set(self::REQUEST_LIST_IP, $value);
    }

    /**
     * Returns value of 'request_list_ip' property
     *
     * @return string
     */
    public function getRequestListIp()
    {
        $value = $this->get(self::REQUEST_LIST_IP);
        return $value === null ? (string)$value : $value;
    }

    /**
     * Returns true if 'request_list_ip' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasRequestListIp()
    {
        return $this->get(self::REQUEST_LIST_IP) !== null;
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
     * Sets value of 'packageid' property
     *
     * @param integer $value Property value
     *
     * @return null
     */
    public function setPackageid($value)
    {
        return $this->set(self::PACKAGEID, $value);
    }

    /**
     * Returns value of 'packageid' property
     *
     * @return integer
     */
    public function getPackageid()
    {
        $value = $this->get(self::PACKAGEID);
        return $value === null ? (integer)$value : $value;
    }

    /**
     * Returns true if 'packageid' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasPackageid()
    {
        return $this->get(self::PACKAGEID) !== null;
    }

    /**
     * Sets value of 'phone_type' property
     *
     * @param integer $value Property value
     *
     * @return null
     */
    public function setPhoneType($value)
    {
        return $this->set(self::PHONE_TYPE, $value);
    }

    /**
     * Returns value of 'phone_type' property
     *
     * @return integer
     */
    public function getPhoneType()
    {
        $value = $this->get(self::PHONE_TYPE);
        return $value === null ? (integer)$value : $value;
    }

    /**
     * Returns true if 'phone_type' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasPhoneType()
    {
        return $this->get(self::PHONE_TYPE) !== null;
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
     * Sets value of 'is_special' property
     *
     * @param boolean $value Property value
     *
     * @return null
     */
    public function setIsSpecial($value)
    {
        return $this->set(self::IS_SPECIAL, $value);
    }

    /**
     * Returns value of 'is_special' property
     *
     * @return boolean
     */
    public function getIsSpecial()
    {
        $value = $this->get(self::IS_SPECIAL);
        return $value === null ? (boolean)$value : $value;
    }

    /**
     * Returns true if 'is_special' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasIsSpecial()
    {
        return $this->get(self::IS_SPECIAL) !== null;
    }
}
}