<?php
/**
 * Auto generated from poker_msg_log.proto at 2023-06-08 09:49:25
 */

namespace {
/**
 * LogWaterFlow message
 */
class LogWaterFlow extends \ProtobufMessage
{
    /* Field index constants */
    const UID = 1;
    const CHANNEL = 2;
    const PACKAGE_ID = 3;
    const COINS = 4;
    const GIVE_SCORE = 5;
    const WATER = 6;
    const NOW_WATER = 7;
    const NEED_WATER = 8;
    const REASON = 9;
    const OPERATE = 10;

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
        self::COINS => array(
            'name' => 'coins',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_INT,
        ),
        self::GIVE_SCORE => array(
            'name' => 'give_score',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_INT,
        ),
        self::WATER => array(
            'name' => 'water',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_INT,
        ),
        self::NOW_WATER => array(
            'name' => 'now_water',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_INT,
        ),
        self::NEED_WATER => array(
            'name' => 'need_water',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_INT,
        ),
        self::REASON => array(
            'name' => 'reason',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_INT,
        ),
        self::OPERATE => array(
            'name' => 'operate',
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
        $this->values[self::COINS] = null;
        $this->values[self::GIVE_SCORE] = null;
        $this->values[self::WATER] = null;
        $this->values[self::NOW_WATER] = null;
        $this->values[self::NEED_WATER] = null;
        $this->values[self::REASON] = null;
        $this->values[self::OPERATE] = null;
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
     * Sets value of 'coins' property
     *
     * @param integer $value Property value
     *
     * @return null
     */
    public function setCoins($value)
    {
        return $this->set(self::COINS, $value);
    }

    /**
     * Returns value of 'coins' property
     *
     * @return integer
     */
    public function getCoins()
    {
        $value = $this->get(self::COINS);
        return $value === null ? (integer)$value : $value;
    }

    /**
     * Returns true if 'coins' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasCoins()
    {
        return $this->get(self::COINS) !== null;
    }

    /**
     * Sets value of 'give_score' property
     *
     * @param integer $value Property value
     *
     * @return null
     */
    public function setGiveScore($value)
    {
        return $this->set(self::GIVE_SCORE, $value);
    }

    /**
     * Returns value of 'give_score' property
     *
     * @return integer
     */
    public function getGiveScore()
    {
        $value = $this->get(self::GIVE_SCORE);
        return $value === null ? (integer)$value : $value;
    }

    /**
     * Returns true if 'give_score' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasGiveScore()
    {
        return $this->get(self::GIVE_SCORE) !== null;
    }

    /**
     * Sets value of 'water' property
     *
     * @param integer $value Property value
     *
     * @return null
     */
    public function setWater($value)
    {
        return $this->set(self::WATER, $value);
    }

    /**
     * Returns value of 'water' property
     *
     * @return integer
     */
    public function getWater()
    {
        $value = $this->get(self::WATER);
        return $value === null ? (integer)$value : $value;
    }

    /**
     * Returns true if 'water' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasWater()
    {
        return $this->get(self::WATER) !== null;
    }

    /**
     * Sets value of 'now_water' property
     *
     * @param integer $value Property value
     *
     * @return null
     */
    public function setNowWater($value)
    {
        return $this->set(self::NOW_WATER, $value);
    }

    /**
     * Returns value of 'now_water' property
     *
     * @return integer
     */
    public function getNowWater()
    {
        $value = $this->get(self::NOW_WATER);
        return $value === null ? (integer)$value : $value;
    }

    /**
     * Returns true if 'now_water' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasNowWater()
    {
        return $this->get(self::NOW_WATER) !== null;
    }

    /**
     * Sets value of 'need_water' property
     *
     * @param integer $value Property value
     *
     * @return null
     */
    public function setNeedWater($value)
    {
        return $this->set(self::NEED_WATER, $value);
    }

    /**
     * Returns value of 'need_water' property
     *
     * @return integer
     */
    public function getNeedWater()
    {
        $value = $this->get(self::NEED_WATER);
        return $value === null ? (integer)$value : $value;
    }

    /**
     * Returns true if 'need_water' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasNeedWater()
    {
        return $this->get(self::NEED_WATER) !== null;
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
     * Sets value of 'operate' property
     *
     * @param integer $value Property value
     *
     * @return null
     */
    public function setOperate($value)
    {
        return $this->set(self::OPERATE, $value);
    }

    /**
     * Returns value of 'operate' property
     *
     * @return integer
     */
    public function getOperate()
    {
        $value = $this->get(self::OPERATE);
        return $value === null ? (integer)$value : $value;
    }

    /**
     * Returns true if 'operate' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasOperate()
    {
        return $this->get(self::OPERATE) !== null;
    }
}
}