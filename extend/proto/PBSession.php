<?php
/**
 * Auto generated from poker_msg_basic.proto at 2023-06-08 09:49:25
 */

namespace {
/**
 * PBSession message
 */
class PBSession extends \ProtobufMessage
{
    /* Field index constants */
    const SESSIONID = 1;
    const MSGTYPE = 2;
    const MAGIC = 3;
    const CREATE_STAMP = 4;
    const REQUEST_SESSIONID = 5;
    const SINGLE_UID = 6;
    const REQUEST_CMD = 8;
    const NEED_UNLOCK = 9;

    /* @var array Field descriptors */
    protected static $fields = array(
        self::SESSIONID => array(
            'name' => 'sessionid',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_INT,
        ),
        self::MSGTYPE => array(
            'name' => 'msgtype',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_INT,
        ),
        self::MAGIC => array(
            'name' => 'magic',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_INT,
        ),
        self::CREATE_STAMP => array(
            'name' => 'create_stamp',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_INT,
        ),
        self::REQUEST_SESSIONID => array(
            'name' => 'request_sessionid',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_INT,
        ),
        self::SINGLE_UID => array(
            'name' => 'single_uid',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_INT,
        ),
        self::REQUEST_CMD => array(
            'name' => 'request_cmd',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_INT,
        ),
        self::NEED_UNLOCK => array(
            'name' => 'need_unlock',
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
        $this->values[self::SESSIONID] = null;
        $this->values[self::MSGTYPE] = null;
        $this->values[self::MAGIC] = null;
        $this->values[self::CREATE_STAMP] = null;
        $this->values[self::REQUEST_SESSIONID] = null;
        $this->values[self::SINGLE_UID] = null;
        $this->values[self::REQUEST_CMD] = null;
        $this->values[self::NEED_UNLOCK] = null;
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
     * Sets value of 'sessionid' property
     *
     * @param integer $value Property value
     *
     * @return null
     */
    public function setSessionid($value)
    {
        return $this->set(self::SESSIONID, $value);
    }

    /**
     * Returns value of 'sessionid' property
     *
     * @return integer
     */
    public function getSessionid()
    {
        $value = $this->get(self::SESSIONID);
        return $value === null ? (integer)$value : $value;
    }

    /**
     * Returns true if 'sessionid' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasSessionid()
    {
        return $this->get(self::SESSIONID) !== null;
    }

    /**
     * Sets value of 'msgtype' property
     *
     * @param integer $value Property value
     *
     * @return null
     */
    public function setMsgtype($value)
    {
        return $this->set(self::MSGTYPE, $value);
    }

    /**
     * Returns value of 'msgtype' property
     *
     * @return integer
     */
    public function getMsgtype()
    {
        $value = $this->get(self::MSGTYPE);
        return $value === null ? (integer)$value : $value;
    }

    /**
     * Returns true if 'msgtype' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasMsgtype()
    {
        return $this->get(self::MSGTYPE) !== null;
    }

    /**
     * Sets value of 'magic' property
     *
     * @param integer $value Property value
     *
     * @return null
     */
    public function setMagic($value)
    {
        return $this->set(self::MAGIC, $value);
    }

    /**
     * Returns value of 'magic' property
     *
     * @return integer
     */
    public function getMagic()
    {
        $value = $this->get(self::MAGIC);
        return $value === null ? (integer)$value : $value;
    }

    /**
     * Returns true if 'magic' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasMagic()
    {
        return $this->get(self::MAGIC) !== null;
    }

    /**
     * Sets value of 'create_stamp' property
     *
     * @param integer $value Property value
     *
     * @return null
     */
    public function setCreateStamp($value)
    {
        return $this->set(self::CREATE_STAMP, $value);
    }

    /**
     * Returns value of 'create_stamp' property
     *
     * @return integer
     */
    public function getCreateStamp()
    {
        $value = $this->get(self::CREATE_STAMP);
        return $value === null ? (integer)$value : $value;
    }

    /**
     * Returns true if 'create_stamp' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasCreateStamp()
    {
        return $this->get(self::CREATE_STAMP) !== null;
    }

    /**
     * Sets value of 'request_sessionid' property
     *
     * @param integer $value Property value
     *
     * @return null
     */
    public function setRequestSessionid($value)
    {
        return $this->set(self::REQUEST_SESSIONID, $value);
    }

    /**
     * Returns value of 'request_sessionid' property
     *
     * @return integer
     */
    public function getRequestSessionid()
    {
        $value = $this->get(self::REQUEST_SESSIONID);
        return $value === null ? (integer)$value : $value;
    }

    /**
     * Returns true if 'request_sessionid' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasRequestSessionid()
    {
        return $this->get(self::REQUEST_SESSIONID) !== null;
    }

    /**
     * Sets value of 'single_uid' property
     *
     * @param integer $value Property value
     *
     * @return null
     */
    public function setSingleUid($value)
    {
        return $this->set(self::SINGLE_UID, $value);
    }

    /**
     * Returns value of 'single_uid' property
     *
     * @return integer
     */
    public function getSingleUid()
    {
        $value = $this->get(self::SINGLE_UID);
        return $value === null ? (integer)$value : $value;
    }

    /**
     * Returns true if 'single_uid' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasSingleUid()
    {
        return $this->get(self::SINGLE_UID) !== null;
    }

    /**
     * Sets value of 'request_cmd' property
     *
     * @param integer $value Property value
     *
     * @return null
     */
    public function setRequestCmd($value)
    {
        return $this->set(self::REQUEST_CMD, $value);
    }

    /**
     * Returns value of 'request_cmd' property
     *
     * @return integer
     */
    public function getRequestCmd()
    {
        $value = $this->get(self::REQUEST_CMD);
        return $value === null ? (integer)$value : $value;
    }

    /**
     * Returns true if 'request_cmd' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasRequestCmd()
    {
        return $this->get(self::REQUEST_CMD) !== null;
    }

    /**
     * Sets value of 'need_unlock' property
     *
     * @param boolean $value Property value
     *
     * @return null
     */
    public function setNeedUnlock($value)
    {
        return $this->set(self::NEED_UNLOCK, $value);
    }

    /**
     * Returns value of 'need_unlock' property
     *
     * @return boolean
     */
    public function getNeedUnlock()
    {
        $value = $this->get(self::NEED_UNLOCK);
        return $value === null ? (boolean)$value : $value;
    }

    /**
     * Returns true if 'need_unlock' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasNeedUnlock()
    {
        return $this->get(self::NEED_UNLOCK) !== null;
    }
}
}