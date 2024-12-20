<?php
/**
 * Auto generated from poker_msg_cs.proto at 2023-06-08 09:49:25
 */

namespace {
/**
 * CSNotifyChat message
 */
class CSNotifyChat extends \ProtobufMessage
{
    /* Field index constants */
    const UID = 1;
    const CTYPE = 2;
    const MESSAGE = 3;
    const BIGFACECHANNEL = 4;
    const BIGFACEID = 5;
    const NICK = 6;
    const TITLE = 7;

    /* @var array Field descriptors */
    protected static $fields = array(
        self::UID => array(
            'name' => 'uid',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_INT,
        ),
        self::CTYPE => array(
            'name' => 'ctype',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_INT,
        ),
        self::MESSAGE => array(
            'name' => 'message',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_STRING,
        ),
        self::BIGFACECHANNEL => array(
            'name' => 'BigFaceChannel',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_INT,
        ),
        self::BIGFACEID => array(
            'name' => 'BigFaceID',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_INT,
        ),
        self::NICK => array(
            'name' => 'nick',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_STRING,
        ),
        self::TITLE => array(
            'name' => 'title',
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
        $this->values[self::CTYPE] = null;
        $this->values[self::MESSAGE] = null;
        $this->values[self::BIGFACECHANNEL] = null;
        $this->values[self::BIGFACEID] = null;
        $this->values[self::NICK] = null;
        $this->values[self::TITLE] = null;
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
     * Sets value of 'ctype' property
     *
     * @param integer $value Property value
     *
     * @return null
     */
    public function setCtype($value)
    {
        return $this->set(self::CTYPE, $value);
    }

    /**
     * Returns value of 'ctype' property
     *
     * @return integer
     */
    public function getCtype()
    {
        $value = $this->get(self::CTYPE);
        return $value === null ? (integer)$value : $value;
    }

    /**
     * Returns true if 'ctype' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasCtype()
    {
        return $this->get(self::CTYPE) !== null;
    }

    /**
     * Sets value of 'message' property
     *
     * @param string $value Property value
     *
     * @return null
     */
    public function setMessage($value)
    {
        return $this->set(self::MESSAGE, $value);
    }

    /**
     * Returns value of 'message' property
     *
     * @return string
     */
    public function getMessage()
    {
        $value = $this->get(self::MESSAGE);
        return $value === null ? (string)$value : $value;
    }

    /**
     * Returns true if 'message' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasMessage()
    {
        return $this->get(self::MESSAGE) !== null;
    }

    /**
     * Sets value of 'BigFaceChannel' property
     *
     * @param integer $value Property value
     *
     * @return null
     */
    public function setBigFaceChannel($value)
    {
        return $this->set(self::BIGFACECHANNEL, $value);
    }

    /**
     * Returns value of 'BigFaceChannel' property
     *
     * @return integer
     */
    public function getBigFaceChannel()
    {
        $value = $this->get(self::BIGFACECHANNEL);
        return $value === null ? (integer)$value : $value;
    }

    /**
     * Returns true if 'BigFaceChannel' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasBigFaceChannel()
    {
        return $this->get(self::BIGFACECHANNEL) !== null;
    }

    /**
     * Sets value of 'BigFaceID' property
     *
     * @param integer $value Property value
     *
     * @return null
     */
    public function setBigFaceID($value)
    {
        return $this->set(self::BIGFACEID, $value);
    }

    /**
     * Returns value of 'BigFaceID' property
     *
     * @return integer
     */
    public function getBigFaceID()
    {
        $value = $this->get(self::BIGFACEID);
        return $value === null ? (integer)$value : $value;
    }

    /**
     * Returns true if 'BigFaceID' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasBigFaceID()
    {
        return $this->get(self::BIGFACEID) !== null;
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
     * Sets value of 'title' property
     *
     * @param integer $value Property value
     *
     * @return null
     */
    public function setTitle($value)
    {
        return $this->set(self::TITLE, $value);
    }

    /**
     * Returns value of 'title' property
     *
     * @return integer
     */
    public function getTitle()
    {
        $value = $this->get(self::TITLE);
        return $value === null ? (integer)$value : $value;
    }

    /**
     * Returns true if 'title' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasTitle()
    {
        return $this->get(self::TITLE) !== null;
    }
}
}