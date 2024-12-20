<?php
/**
 * Auto generated from poker_msg_cs.proto at 2023-06-08 09:49:25
 */

namespace {
/**
 * CSRequestUpdateUserInfo message
 */
class CSRequestUpdateUserInfo extends \ProtobufMessage
{
    /* Field index constants */
    const NICK_NAME = 1;
    const PIC_URL = 2;
    const GENDER = 3;

    /* @var array Field descriptors */
    protected static $fields = array(
        self::NICK_NAME => array(
            'name' => 'nick_name',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_STRING,
        ),
        self::PIC_URL => array(
            'name' => 'pic_url',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_STRING,
        ),
        self::GENDER => array(
            'name' => 'gender',
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
        $this->values[self::NICK_NAME] = null;
        $this->values[self::PIC_URL] = null;
        $this->values[self::GENDER] = null;
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
     * Sets value of 'nick_name' property
     *
     * @param string $value Property value
     *
     * @return null
     */
    public function setNickName($value)
    {
        return $this->set(self::NICK_NAME, $value);
    }

    /**
     * Returns value of 'nick_name' property
     *
     * @return string
     */
    public function getNickName()
    {
        $value = $this->get(self::NICK_NAME);
        return $value === null ? (string)$value : $value;
    }

    /**
     * Returns true if 'nick_name' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasNickName()
    {
        return $this->get(self::NICK_NAME) !== null;
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
}
}