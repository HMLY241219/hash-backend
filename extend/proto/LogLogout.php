<?php
/**
 * Auto generated from poker_msg_log.proto at 2023-06-08 09:49:25
 */

namespace {
/**
 * LogLogout message
 */
class LogLogout extends \ProtobufMessage
{
    /* Field index constants */
    const UID = 1;
    const CHANNEL = 2;
    const PACKAGE_ID = 3;
    const ONLINE_TIME = 4;
    const ACC_TYPE = 5;

    /* @var array Field descriptors */
    protected static $fields = array(
        self::UID => array(
            'name' => 'uid',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_INT,
        ),
        self::CHANNEL => array(
            'name' => 'channel',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_INT,
        ),
        self::PACKAGE_ID => array(
            'name' => 'package_id',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_INT,
        ),
        self::ONLINE_TIME => array(
            'name' => 'online_time',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_INT,
        ),
        self::ACC_TYPE => array(
            'name' => 'acc_type',
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
        $this->values[self::CHANNEL] = null;
        $this->values[self::PACKAGE_ID] = null;
        $this->values[self::ONLINE_TIME] = null;
        $this->values[self::ACC_TYPE] = null;
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
     * Sets value of 'online_time' property
     *
     * @param integer $value Property value
     *
     * @return null
     */
    public function setOnlineTime($value)
    {
        return $this->set(self::ONLINE_TIME, $value);
    }

    /**
     * Returns value of 'online_time' property
     *
     * @return integer
     */
    public function getOnlineTime()
    {
        $value = $this->get(self::ONLINE_TIME);
        return $value === null ? (integer)$value : $value;
    }

    /**
     * Returns true if 'online_time' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasOnlineTime()
    {
        return $this->get(self::ONLINE_TIME) !== null;
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
}
}