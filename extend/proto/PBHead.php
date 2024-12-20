<?php
/**
 * Auto generated from poker_msg.proto at 2023-06-08 09:49:25
 */

namespace {
/**
 * PBHead message
 */
class PBHead extends \ProtobufMessage
{
    /* Field index constants */
    const MAIN_VERSION = 1;
    const SUB_VERSION = 2;
    const PROTO_VERSION = 3;
    const CHANNEL_ID = 4;
    const DEVICE_ID = 5;
    const DEVICE_NAME = 6;
    const MAC_ADDR = 7;
    const OS = 8;
    const OSV = 9;
    const BAND = 10;
    const IMEI = 11;
    const CMD = 12;
    const JSON_MSG_ID = 13;
    const JSON_MSG = 14;
    const UID = 15;

    /* @var array Field descriptors */
    protected static $fields = array(
        self::MAIN_VERSION => array(
            'name' => 'main_version',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_INT,
        ),
        self::SUB_VERSION => array(
            'name' => 'sub_version',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_INT,
        ),
        self::PROTO_VERSION => array(
            'name' => 'proto_version',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_INT,
        ),
        self::CHANNEL_ID => array(
            'name' => 'channel_id',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_INT,
        ),
        self::DEVICE_ID => array(
            'name' => 'device_id',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_STRING,
        ),
        self::DEVICE_NAME => array(
            'name' => 'device_name',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_STRING,
        ),
        self::MAC_ADDR => array(
            'name' => 'mac_addr',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_STRING,
        ),
        self::OS => array(
            'name' => 'os',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_STRING,
        ),
        self::OSV => array(
            'name' => 'osv',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_STRING,
        ),
        self::BAND => array(
            'name' => 'band',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_STRING,
        ),
        self::IMEI => array(
            'name' => 'imei',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_STRING,
        ),
        self::CMD => array(
            'name' => 'cmd',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_INT,
        ),
        self::JSON_MSG_ID => array(
            'name' => 'json_msg_id',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_INT,
        ),
        self::JSON_MSG => array(
            'name' => 'json_msg',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_STRING,
        ),
        self::UID => array(
            'name' => 'uid',
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
        $this->values[self::MAIN_VERSION] = null;
        $this->values[self::SUB_VERSION] = null;
        $this->values[self::PROTO_VERSION] = null;
        $this->values[self::CHANNEL_ID] = null;
        $this->values[self::DEVICE_ID] = null;
        $this->values[self::DEVICE_NAME] = null;
        $this->values[self::MAC_ADDR] = null;
        $this->values[self::OS] = null;
        $this->values[self::OSV] = null;
        $this->values[self::BAND] = null;
        $this->values[self::IMEI] = null;
        $this->values[self::CMD] = null;
        $this->values[self::JSON_MSG_ID] = null;
        $this->values[self::JSON_MSG] = null;
        $this->values[self::UID] = null;
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
     * Sets value of 'main_version' property
     *
     * @param integer $value Property value
     *
     * @return null
     */
    public function setMainVersion($value)
    {
        return $this->set(self::MAIN_VERSION, $value);
    }

    /**
     * Returns value of 'main_version' property
     *
     * @return integer
     */
    public function getMainVersion()
    {
        $value = $this->get(self::MAIN_VERSION);
        return $value === null ? (integer)$value : $value;
    }

    /**
     * Returns true if 'main_version' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasMainVersion()
    {
        return $this->get(self::MAIN_VERSION) !== null;
    }

    /**
     * Sets value of 'sub_version' property
     *
     * @param integer $value Property value
     *
     * @return null
     */
    public function setSubVersion($value)
    {
        return $this->set(self::SUB_VERSION, $value);
    }

    /**
     * Returns value of 'sub_version' property
     *
     * @return integer
     */
    public function getSubVersion()
    {
        $value = $this->get(self::SUB_VERSION);
        return $value === null ? (integer)$value : $value;
    }

    /**
     * Returns true if 'sub_version' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasSubVersion()
    {
        return $this->get(self::SUB_VERSION) !== null;
    }

    /**
     * Sets value of 'proto_version' property
     *
     * @param integer $value Property value
     *
     * @return null
     */
    public function setProtoVersion($value)
    {
        return $this->set(self::PROTO_VERSION, $value);
    }

    /**
     * Returns value of 'proto_version' property
     *
     * @return integer
     */
    public function getProtoVersion()
    {
        $value = $this->get(self::PROTO_VERSION);
        return $value === null ? (integer)$value : $value;
    }

    /**
     * Returns true if 'proto_version' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasProtoVersion()
    {
        return $this->get(self::PROTO_VERSION) !== null;
    }

    /**
     * Sets value of 'channel_id' property
     *
     * @param integer $value Property value
     *
     * @return null
     */
    public function setChannelId($value)
    {
        return $this->set(self::CHANNEL_ID, $value);
    }

    /**
     * Returns value of 'channel_id' property
     *
     * @return integer
     */
    public function getChannelId()
    {
        $value = $this->get(self::CHANNEL_ID);
        return $value === null ? (integer)$value : $value;
    }

    /**
     * Returns true if 'channel_id' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasChannelId()
    {
        return $this->get(self::CHANNEL_ID) !== null;
    }

    /**
     * Sets value of 'device_id' property
     *
     * @param string $value Property value
     *
     * @return null
     */
    public function setDeviceId($value)
    {
        return $this->set(self::DEVICE_ID, $value);
    }

    /**
     * Returns value of 'device_id' property
     *
     * @return string
     */
    public function getDeviceId()
    {
        $value = $this->get(self::DEVICE_ID);
        return $value === null ? (string)$value : $value;
    }

    /**
     * Returns true if 'device_id' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasDeviceId()
    {
        return $this->get(self::DEVICE_ID) !== null;
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
     * Sets value of 'mac_addr' property
     *
     * @param string $value Property value
     *
     * @return null
     */
    public function setMacAddr($value)
    {
        return $this->set(self::MAC_ADDR, $value);
    }

    /**
     * Returns value of 'mac_addr' property
     *
     * @return string
     */
    public function getMacAddr()
    {
        $value = $this->get(self::MAC_ADDR);
        return $value === null ? (string)$value : $value;
    }

    /**
     * Returns true if 'mac_addr' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasMacAddr()
    {
        return $this->get(self::MAC_ADDR) !== null;
    }

    /**
     * Sets value of 'os' property
     *
     * @param string $value Property value
     *
     * @return null
     */
    public function setOs($value)
    {
        return $this->set(self::OS, $value);
    }

    /**
     * Returns value of 'os' property
     *
     * @return string
     */
    public function getOs()
    {
        $value = $this->get(self::OS);
        return $value === null ? (string)$value : $value;
    }

    /**
     * Returns true if 'os' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasOs()
    {
        return $this->get(self::OS) !== null;
    }

    /**
     * Sets value of 'osv' property
     *
     * @param string $value Property value
     *
     * @return null
     */
    public function setOsv($value)
    {
        return $this->set(self::OSV, $value);
    }

    /**
     * Returns value of 'osv' property
     *
     * @return string
     */
    public function getOsv()
    {
        $value = $this->get(self::OSV);
        return $value === null ? (string)$value : $value;
    }

    /**
     * Returns true if 'osv' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasOsv()
    {
        return $this->get(self::OSV) !== null;
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
     * Sets value of 'imei' property
     *
     * @param string $value Property value
     *
     * @return null
     */
    public function setImei($value)
    {
        return $this->set(self::IMEI, $value);
    }

    /**
     * Returns value of 'imei' property
     *
     * @return string
     */
    public function getImei()
    {
        $value = $this->get(self::IMEI);
        return $value === null ? (string)$value : $value;
    }

    /**
     * Returns true if 'imei' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasImei()
    {
        return $this->get(self::IMEI) !== null;
    }

    /**
     * Sets value of 'cmd' property
     *
     * @param integer $value Property value
     *
     * @return null
     */
    public function setCmd($value)
    {
        return $this->set(self::CMD, $value);
    }

    /**
     * Returns value of 'cmd' property
     *
     * @return integer
     */
    public function getCmd()
    {
        $value = $this->get(self::CMD);
        return $value === null ? (integer)$value : $value;
    }

    /**
     * Returns true if 'cmd' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasCmd()
    {
        return $this->get(self::CMD) !== null;
    }

    /**
     * Sets value of 'json_msg_id' property
     *
     * @param integer $value Property value
     *
     * @return null
     */
    public function setJsonMsgId($value)
    {
        return $this->set(self::JSON_MSG_ID, $value);
    }

    /**
     * Returns value of 'json_msg_id' property
     *
     * @return integer
     */
    public function getJsonMsgId()
    {
        $value = $this->get(self::JSON_MSG_ID);
        return $value === null ? (integer)$value : $value;
    }

    /**
     * Returns true if 'json_msg_id' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasJsonMsgId()
    {
        return $this->get(self::JSON_MSG_ID) !== null;
    }

    /**
     * Sets value of 'json_msg' property
     *
     * @param string $value Property value
     *
     * @return null
     */
    public function setJsonMsg($value)
    {
        return $this->set(self::JSON_MSG, $value);
    }

    /**
     * Returns value of 'json_msg' property
     *
     * @return string
     */
    public function getJsonMsg()
    {
        $value = $this->get(self::JSON_MSG);
        return $value === null ? (string)$value : $value;
    }

    /**
     * Returns true if 'json_msg' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasJsonMsg()
    {
        return $this->get(self::JSON_MSG) !== null;
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
}
}