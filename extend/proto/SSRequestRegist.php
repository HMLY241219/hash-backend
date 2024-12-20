<?php
/**
 * Auto generated from poker_msg_ss.proto at 2023-06-08 09:49:25
 */

namespace {
/**
 * SSRequestRegist message
 */
class SSRequestRegist extends \ProtobufMessage
{
    /* Field index constants */
    const ACC_TYPE = 1;
    const ACCOUNT = 2;
    const INIT_MONEY = 3;
    const INIT_GOLD = 4;
    const GENDER = 5;
    const PIC_URL = 6;
    const NICK = 7;
    const CHANNEL = 8;

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
        self::INIT_MONEY => array(
            'name' => 'init_money',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_INT,
        ),
        self::INIT_GOLD => array(
            'name' => 'init_gold',
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
        self::CHANNEL => array(
            'name' => 'channel',
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
        $this->values[self::INIT_MONEY] = null;
        $this->values[self::INIT_GOLD] = null;
        $this->values[self::GENDER] = null;
        $this->values[self::PIC_URL] = null;
        $this->values[self::NICK] = null;
        $this->values[self::CHANNEL] = null;
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
     * Sets value of 'init_money' property
     *
     * @param integer $value Property value
     *
     * @return null
     */
    public function setInitMoney($value)
    {
        return $this->set(self::INIT_MONEY, $value);
    }

    /**
     * Returns value of 'init_money' property
     *
     * @return integer
     */
    public function getInitMoney()
    {
        $value = $this->get(self::INIT_MONEY);
        return $value === null ? (integer)$value : $value;
    }

    /**
     * Returns true if 'init_money' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasInitMoney()
    {
        return $this->get(self::INIT_MONEY) !== null;
    }

    /**
     * Sets value of 'init_gold' property
     *
     * @param integer $value Property value
     *
     * @return null
     */
    public function setInitGold($value)
    {
        return $this->set(self::INIT_GOLD, $value);
    }

    /**
     * Returns value of 'init_gold' property
     *
     * @return integer
     */
    public function getInitGold()
    {
        $value = $this->get(self::INIT_GOLD);
        return $value === null ? (integer)$value : $value;
    }

    /**
     * Returns true if 'init_gold' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasInitGold()
    {
        return $this->get(self::INIT_GOLD) !== null;
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
}
}