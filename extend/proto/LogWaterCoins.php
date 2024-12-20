<?php
/**
 * Auto generated from poker_msg_log.proto at 2023-06-08 09:49:25
 */

namespace {
/**
 * LogWaterCoins message
 */
class LogWaterCoins extends \ProtobufMessage
{
    /* Field index constants */
    const UID = 1;
    const CHANNEL = 2;
    const PACKAGE_ID = 3;
    const BIND_UID = 4;
    const VIP = 5;
    const WATER_TO_COINS = 6;
    const OUTSIDE_WATER_TO_COINS = 7;

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
        self::BIND_UID => array(
            'name' => 'bind_uid',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_INT,
        ),
        self::VIP => array(
            'name' => 'vip',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_INT,
        ),
        self::WATER_TO_COINS => array(
            'name' => 'water_to_coins',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_INT,
        ),
        self::OUTSIDE_WATER_TO_COINS => array(
            'name' => 'outside_water_to_coins',
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
        $this->values[self::BIND_UID] = null;
        $this->values[self::VIP] = null;
        $this->values[self::WATER_TO_COINS] = null;
        $this->values[self::OUTSIDE_WATER_TO_COINS] = null;
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
     * Sets value of 'bind_uid' property
     *
     * @param integer $value Property value
     *
     * @return null
     */
    public function setBindUid($value)
    {
        return $this->set(self::BIND_UID, $value);
    }

    /**
     * Returns value of 'bind_uid' property
     *
     * @return integer
     */
    public function getBindUid()
    {
        $value = $this->get(self::BIND_UID);
        return $value === null ? (integer)$value : $value;
    }

    /**
     * Returns true if 'bind_uid' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasBindUid()
    {
        return $this->get(self::BIND_UID) !== null;
    }

    /**
     * Sets value of 'vip' property
     *
     * @param integer $value Property value
     *
     * @return null
     */
    public function setVip($value)
    {
        return $this->set(self::VIP, $value);
    }

    /**
     * Returns value of 'vip' property
     *
     * @return integer
     */
    public function getVip()
    {
        $value = $this->get(self::VIP);
        return $value === null ? (integer)$value : $value;
    }

    /**
     * Returns true if 'vip' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasVip()
    {
        return $this->get(self::VIP) !== null;
    }

    /**
     * Sets value of 'water_to_coins' property
     *
     * @param integer $value Property value
     *
     * @return null
     */
    public function setWaterToCoins($value)
    {
        return $this->set(self::WATER_TO_COINS, $value);
    }

    /**
     * Returns value of 'water_to_coins' property
     *
     * @return integer
     */
    public function getWaterToCoins()
    {
        $value = $this->get(self::WATER_TO_COINS);
        return $value === null ? (integer)$value : $value;
    }

    /**
     * Returns true if 'water_to_coins' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasWaterToCoins()
    {
        return $this->get(self::WATER_TO_COINS) !== null;
    }

    /**
     * Sets value of 'outside_water_to_coins' property
     *
     * @param integer $value Property value
     *
     * @return null
     */
    public function setOutsideWaterToCoins($value)
    {
        return $this->set(self::OUTSIDE_WATER_TO_COINS, $value);
    }

    /**
     * Returns value of 'outside_water_to_coins' property
     *
     * @return integer
     */
    public function getOutsideWaterToCoins()
    {
        $value = $this->get(self::OUTSIDE_WATER_TO_COINS);
        return $value === null ? (integer)$value : $value;
    }

    /**
     * Returns true if 'outside_water_to_coins' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasOutsideWaterToCoins()
    {
        return $this->get(self::OUTSIDE_WATER_TO_COINS) !== null;
    }
}
}