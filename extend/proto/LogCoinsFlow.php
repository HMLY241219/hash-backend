<?php
/**
 * Auto generated from poker_msg_log.proto at 2023-06-08 09:49:25
 */

namespace {
/**
 * LogCoinsFlow message
 */
class LogCoinsFlow extends \ProtobufMessage
{
    /* Field index constants */
    const UID = 1;
    const PACKAGE_ID = 2;
    const CHANNEL = 3;
    const ACT_NUM = 4;
    const TOTAL_NUM = 5;
    const REASON = 6;
    const TIME_STAMP = 7;
    const ACC_TYPE = 8;
    const SESSION_ID = 9;
    const GAME_TYPE = 10;
    const BEFORE_TOTAL_NUM = 11;

    /* @var array Field descriptors */
    protected static $fields = array(
        self::UID => array(
            'name' => 'uid',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_INT,
        ),
        self::PACKAGE_ID => array(
            'name' => 'package_id',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_INT,
        ),
        self::CHANNEL => array(
            'name' => 'channel',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_INT,
        ),
        self::ACT_NUM => array(
            'name' => 'act_num',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_INT,
        ),
        self::TOTAL_NUM => array(
            'name' => 'total_num',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_INT,
        ),
        self::REASON => array(
            'name' => 'reason',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_INT,
        ),
        self::TIME_STAMP => array(
            'name' => 'time_stamp',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_INT,
        ),
        self::ACC_TYPE => array(
            'name' => 'acc_type',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_INT,
        ),
        self::SESSION_ID => array(
            'name' => 'session_id',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_INT,
        ),
        self::GAME_TYPE => array(
            'name' => 'game_type',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_INT,
        ),
        self::BEFORE_TOTAL_NUM => array(
            'name' => 'before_total_num',
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
        $this->values[self::PACKAGE_ID] = null;
        $this->values[self::CHANNEL] = null;
        $this->values[self::ACT_NUM] = null;
        $this->values[self::TOTAL_NUM] = null;
        $this->values[self::REASON] = null;
        $this->values[self::TIME_STAMP] = null;
        $this->values[self::ACC_TYPE] = null;
        $this->values[self::SESSION_ID] = null;
        $this->values[self::GAME_TYPE] = null;
        $this->values[self::BEFORE_TOTAL_NUM] = null;
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
     * Sets value of 'act_num' property
     *
     * @param integer $value Property value
     *
     * @return null
     */
    public function setActNum($value)
    {
        return $this->set(self::ACT_NUM, $value);
    }

    /**
     * Returns value of 'act_num' property
     *
     * @return integer
     */
    public function getActNum()
    {
        $value = $this->get(self::ACT_NUM);
        return $value === null ? (integer)$value : $value;
    }

    /**
     * Returns true if 'act_num' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasActNum()
    {
        return $this->get(self::ACT_NUM) !== null;
    }

    /**
     * Sets value of 'total_num' property
     *
     * @param integer $value Property value
     *
     * @return null
     */
    public function setTotalNum($value)
    {
        return $this->set(self::TOTAL_NUM, $value);
    }

    /**
     * Returns value of 'total_num' property
     *
     * @return integer
     */
    public function getTotalNum()
    {
        $value = $this->get(self::TOTAL_NUM);
        return $value === null ? (integer)$value : $value;
    }

    /**
     * Returns true if 'total_num' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasTotalNum()
    {
        return $this->get(self::TOTAL_NUM) !== null;
    }

    /**
     * Sets value of 'reason' property
     *
     * @param integer $value Property value
     *
     * @return null
     */
    public function setReason($value)
    {
        return $this->set(self::REASON, $value);
    }

    /**
     * Returns value of 'reason' property
     *
     * @return integer
     */
    public function getReason()
    {
        $value = $this->get(self::REASON);
        return $value === null ? (integer)$value : $value;
    }

    /**
     * Returns true if 'reason' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasReason()
    {
        return $this->get(self::REASON) !== null;
    }

    /**
     * Sets value of 'time_stamp' property
     *
     * @param integer $value Property value
     *
     * @return null
     */
    public function setTimeStamp($value)
    {
        return $this->set(self::TIME_STAMP, $value);
    }

    /**
     * Returns value of 'time_stamp' property
     *
     * @return integer
     */
    public function getTimeStamp()
    {
        $value = $this->get(self::TIME_STAMP);
        return $value === null ? (integer)$value : $value;
    }

    /**
     * Returns true if 'time_stamp' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasTimeStamp()
    {
        return $this->get(self::TIME_STAMP) !== null;
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
     * Sets value of 'session_id' property
     *
     * @param integer $value Property value
     *
     * @return null
     */
    public function setSessionId($value)
    {
        return $this->set(self::SESSION_ID, $value);
    }

    /**
     * Returns value of 'session_id' property
     *
     * @return integer
     */
    public function getSessionId()
    {
        $value = $this->get(self::SESSION_ID);
        return $value === null ? (integer)$value : $value;
    }

    /**
     * Returns true if 'session_id' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasSessionId()
    {
        return $this->get(self::SESSION_ID) !== null;
    }

    /**
     * Sets value of 'game_type' property
     *
     * @param integer $value Property value
     *
     * @return null
     */
    public function setGameType($value)
    {
        return $this->set(self::GAME_TYPE, $value);
    }

    /**
     * Returns value of 'game_type' property
     *
     * @return integer
     */
    public function getGameType()
    {
        $value = $this->get(self::GAME_TYPE);
        return $value === null ? (integer)$value : $value;
    }

    /**
     * Returns true if 'game_type' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasGameType()
    {
        return $this->get(self::GAME_TYPE) !== null;
    }

    /**
     * Sets value of 'before_total_num' property
     *
     * @param integer $value Property value
     *
     * @return null
     */
    public function setBeforeTotalNum($value)
    {
        return $this->set(self::BEFORE_TOTAL_NUM, $value);
    }

    /**
     * Returns value of 'before_total_num' property
     *
     * @return integer
     */
    public function getBeforeTotalNum()
    {
        $value = $this->get(self::BEFORE_TOTAL_NUM);
        return $value === null ? (integer)$value : $value;
    }

    /**
     * Returns true if 'before_total_num' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasBeforeTotalNum()
    {
        return $this->get(self::BEFORE_TOTAL_NUM) !== null;
    }
}
}