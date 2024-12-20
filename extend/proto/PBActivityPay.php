<?php
/**
 * Auto generated from poker_data.proto at 2023-06-08 09:49:25
 */

namespace {
/**
 * PBActivityPay message
 */
class PBActivityPay extends \ProtobufMessage
{
    /* Field index constants */
    const ID = 1;
    const NEED_SCORE_WATER = 2;
    const NOW_SCORE_WATER = 3;

    /* @var array Field descriptors */
    protected static $fields = array(
        self::ID => array(
            'name' => 'id',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_INT,
        ),
        self::NEED_SCORE_WATER => array(
            'name' => 'need_score_water',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_INT,
        ),
        self::NOW_SCORE_WATER => array(
            'name' => 'now_score_water',
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
        $this->values[self::ID] = null;
        $this->values[self::NEED_SCORE_WATER] = null;
        $this->values[self::NOW_SCORE_WATER] = null;
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
     * Sets value of 'id' property
     *
     * @param integer $value Property value
     *
     * @return null
     */
    public function setId($value)
    {
        return $this->set(self::ID, $value);
    }

    /**
     * Returns value of 'id' property
     *
     * @return integer
     */
    public function getId()
    {
        $value = $this->get(self::ID);
        return $value === null ? (integer)$value : $value;
    }

    /**
     * Returns true if 'id' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasId()
    {
        return $this->get(self::ID) !== null;
    }

    /**
     * Sets value of 'need_score_water' property
     *
     * @param integer $value Property value
     *
     * @return null
     */
    public function setNeedScoreWater($value)
    {
        return $this->set(self::NEED_SCORE_WATER, $value);
    }

    /**
     * Returns value of 'need_score_water' property
     *
     * @return integer
     */
    public function getNeedScoreWater()
    {
        $value = $this->get(self::NEED_SCORE_WATER);
        return $value === null ? (integer)$value : $value;
    }

    /**
     * Returns true if 'need_score_water' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasNeedScoreWater()
    {
        return $this->get(self::NEED_SCORE_WATER) !== null;
    }

    /**
     * Sets value of 'now_score_water' property
     *
     * @param integer $value Property value
     *
     * @return null
     */
    public function setNowScoreWater($value)
    {
        return $this->set(self::NOW_SCORE_WATER, $value);
    }

    /**
     * Returns value of 'now_score_water' property
     *
     * @return integer
     */
    public function getNowScoreWater()
    {
        $value = $this->get(self::NOW_SCORE_WATER);
        return $value === null ? (integer)$value : $value;
    }

    /**
     * Returns true if 'now_score_water' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasNowScoreWater()
    {
        return $this->get(self::NOW_SCORE_WATER) !== null;
    }
}
}