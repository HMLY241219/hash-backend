<?php
/**
 * Auto generated from poker_msg_ss.proto at 2023-06-08 09:49:25
 */

namespace {
/**
 * SSRequestLogin message
 */
class SSRequestLogin extends \ProtobufMessage
{
    /* Field index constants */
    const ACC_TYPE = 1;
    const ACCOUNT = 2;
    const TOKEN = 3;

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
}
}