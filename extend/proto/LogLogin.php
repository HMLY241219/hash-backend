<?php
/**
 * Auto generated from poker_msg_log.proto at 2023-06-08 09:49:25
 */

namespace {
/**
 * LogLogin message
 */
class LogLogin extends \ProtobufMessage
{
    /* Field index constants */
    const UID = 1;
    const CHANNEL = 2;
    const PACKAGE_ID = 3;
    const TIME_STAMP = 4;
    const ACC_TYPE = 5;
    const DEVICE_NAME = 6;
    const BAND = 7;
    const IP = 8;

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
        self::DEVICE_NAME => array(
            'name' => 'device_name',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_STRING,
        ),
        self::BAND => array(
            'name' => 'band',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_STRING,
        ),
        self::IP => array(
            'name' => 'ip',
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
        $this->values[self::UID] = null;
        $this->values[self::CHANNEL] = null;
        $this->values[self::PACKAGE_ID] = null;
        $this->values[self::TIME_STAMP] = null;
        $this->values[self::ACC_TYPE] = null;
        $this->values[self::DEVICE_NAME] = null;
        $this->values[self::BAND] = null;
        $this->values[self::IP] = null;
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
     * Sets value of 'device_name' property
     *
     * @param string $value Property value
     *
     * @return null
     */
    public function setDeviceName($value)
    {
        return $this->set(self::DEVICE_NAME, $value);
    }

    /**
     * Returns value of 'device_name' property
     *
     * @return string
     */
    public function getDeviceName()
    {
        $value = $this->get(self::DEVICE_NAME);
        return $value === null ? (string)$value : $value;
    }

    /**
     * Returns true if 'device_name' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasDeviceName()
    {
        return $this->get(self::DEVICE_NAME) !== null;
    }

    /**
     * Sets value of 'band' property
     *
     * @param string $value Property value
     *
     * @return null
     */
    public function setBand($value)
    {
        return $this->set(self::BAND, $value);
    }

    /**
     * Returns value of 'band' property
     *
     * @return string
     */
    public function getBand()
    {
        $value = $this->get(self::BAND);
        return $value === null ? (string)$value : $value;
    }

    /**
     * Returns true if 'band' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasBand()
    {
        return $this->get(self::BAND) !== null;
    }

    /**
     * Sets value of 'ip' property
     *
     * @param string $value Property value
     *
     * @return null
     */
    public function setIp($value)
    {
        return $this->set(self::IP, $value);
    }

    /**
     * Returns value of 'ip' property
     *
     * @return string
     */
    public function getIp()
    {
        $value = $this->get(self::IP);
        return $value === null ? (string)$value : $value;
    }

    /**
     * Returns true if 'ip' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasIp()
    {
        return $this->get(self::IP) !== null;
    }
}
}