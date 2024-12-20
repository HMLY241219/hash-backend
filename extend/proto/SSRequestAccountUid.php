<?php
/**
 * Auto generated from poker_msg_ss.proto at 2023-06-08 09:49:25
 */

namespace {
/**
 * SSRequestAccountUid message
 */
class SSRequestAccountUid extends \ProtobufMessage
{
    /* Field index constants */
    const ACC_TYPE = 1;
    const ACCOUNT = 2;
    const TOKEN = 3;
    const AUTO_CREATE = 4;
    const CHANNEL = 5;
    const PACKAGEID = 6;

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
        self::TOKEN => array(
            'name' => 'token',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_STRING,
        ),
        self::AUTO_CREATE => array(
            'default' => true,
            'name' => 'auto_create',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_BOOL,
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
        $this->values[self::TOKEN] = null;
        $this->values[self::AUTO_CREATE] = self::$fields[self::AUTO_CREATE]['default'];
        $this->values[self::CHANNEL] = null;
        $this->values[self::PACKAGEID] = null;
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
     * Sets value of 'auto_create' property
     *
     * @param boolean $value Property value
     *
     * @return null
     */
    public function setAutoCreate($value)
    {
        return $this->set(self::AUTO_CREATE, $value);
    }

    /**
     * Returns value of 'auto_create' property
     *
     * @return boolean
     */
    public function getAutoCreate()
    {
        $value = $this->get(self::AUTO_CREATE);
        return $value === null ? (boolean)$value : $value;
    }

    /**
     * Returns true if 'auto_create' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasAutoCreate()
    {
        return $this->get(self::AUTO_CREATE) !== null;
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
}
}