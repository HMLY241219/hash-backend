<?php
/**
 * Auto generated from poker_data.proto at 2023-06-08 09:49:25
 */

namespace {
/**
 * PBAndroid message
 */
class PBAndroid extends \ProtobufMessage
{
    /* Field index constants */
    const WEIGHT_RATIO = 1;
    const GAME_NUM = 2;
    const GAME_TIME = 3;
    const MIN_SCORE = 4;
    const MAX_SCORE = 5;
    const ANDROID_LOOK = 6;
    const ANDROID_GIVE_UP = 7;
    const ANDROID_PAY = 8;
    const MEN_NUM = 9;
    const COMPARE_CARD = 10;
    const OPEN_MULTIPLE = 11;
    const COMPARE_MULTIPLE = 12;
    const COMPARE_NO_NUM = 13;
    const ADD_RATIO = 14;
    const COMPARE_OK_RATIO = 15;
    const MEN_ADD_RATIO = 16;
    const CHANGE_CARD = 17;
    const GIVE_UP = 18;

    /* @var array Field descriptors */
    protected static $fields = array(
        self::WEIGHT_RATIO => array(
            'name' => 'weight_ratio',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_INT,
        ),
        self::GAME_NUM => array(
            'name' => 'game_num',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_INT,
        ),
        self::GAME_TIME => array(
            'name' => 'game_time',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_INT,
        ),
        self::MIN_SCORE => array(
            'name' => 'min_score',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_INT,
        ),
        self::MAX_SCORE => array(
            'name' => 'max_score',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_INT,
        ),
        self::ANDROID_LOOK => array(
            'name' => 'android_look',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_INT,
        ),
        self::ANDROID_GIVE_UP => array(
            'name' => 'android_give_up',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_INT,
        ),
        self::ANDROID_PAY => array(
            'name' => 'android_pay',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_BOOL,
        ),
        self::MEN_NUM => array(
            'name' => 'men_num',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_INT,
        ),
        self::COMPARE_CARD => array(
            'name' => 'compare_card',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_BOOL,
        ),
        self::OPEN_MULTIPLE => array(
            'name' => 'open_multiple',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_INT,
        ),
        self::COMPARE_MULTIPLE => array(
            'name' => 'compare_multiple',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_INT,
        ),
        self::COMPARE_NO_NUM => array(
            'name' => 'compare_no_num',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_INT,
        ),
        self::ADD_RATIO => array(
            'name' => 'add_ratio',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_INT,
        ),
        self::COMPARE_OK_RATIO => array(
            'name' => 'compare_ok_ratio',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_INT,
        ),
        self::MEN_ADD_RATIO => array(
            'name' => 'men_add_ratio',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_INT,
        ),
        self::CHANGE_CARD => array(
            'name' => 'change_card',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_BOOL,
        ),
        self::GIVE_UP => array(
            'name' => 'give_up',
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
        $this->values[self::WEIGHT_RATIO] = null;
        $this->values[self::GAME_NUM] = null;
        $this->values[self::GAME_TIME] = null;
        $this->values[self::MIN_SCORE] = null;
        $this->values[self::MAX_SCORE] = null;
        $this->values[self::ANDROID_LOOK] = null;
        $this->values[self::ANDROID_GIVE_UP] = null;
        $this->values[self::ANDROID_PAY] = null;
        $this->values[self::MEN_NUM] = null;
        $this->values[self::COMPARE_CARD] = null;
        $this->values[self::OPEN_MULTIPLE] = null;
        $this->values[self::COMPARE_MULTIPLE] = null;
        $this->values[self::COMPARE_NO_NUM] = null;
        $this->values[self::ADD_RATIO] = null;
        $this->values[self::COMPARE_OK_RATIO] = null;
        $this->values[self::MEN_ADD_RATIO] = null;
        $this->values[self::CHANGE_CARD] = null;
        $this->values[self::GIVE_UP] = null;
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
     * Sets value of 'weight_ratio' property
     *
     * @param integer $value Property value
     *
     * @return null
     */
    public function setWeightRatio($value)
    {
        return $this->set(self::WEIGHT_RATIO, $value);
    }

    /**
     * Returns value of 'weight_ratio' property
     *
     * @return integer
     */
    public function getWeightRatio()
    {
        $value = $this->get(self::WEIGHT_RATIO);
        return $value === null ? (integer)$value : $value;
    }

    /**
     * Returns true if 'weight_ratio' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasWeightRatio()
    {
        return $this->get(self::WEIGHT_RATIO) !== null;
    }

    /**
     * Sets value of 'game_num' property
     *
     * @param integer $value Property value
     *
     * @return null
     */
    public function setGameNum($value)
    {
        return $this->set(self::GAME_NUM, $value);
    }

    /**
     * Returns value of 'game_num' property
     *
     * @return integer
     */
    public function getGameNum()
    {
        $value = $this->get(self::GAME_NUM);
        return $value === null ? (integer)$value : $value;
    }

    /**
     * Returns true if 'game_num' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasGameNum()
    {
        return $this->get(self::GAME_NUM) !== null;
    }

    /**
     * Sets value of 'game_time' property
     *
     * @param integer $value Property value
     *
     * @return null
     */
    public function setGameTime($value)
    {
        return $this->set(self::GAME_TIME, $value);
    }

    /**
     * Returns value of 'game_time' property
     *
     * @return integer
     */
    public function getGameTime()
    {
        $value = $this->get(self::GAME_TIME);
        return $value === null ? (integer)$value : $value;
    }

    /**
     * Returns true if 'game_time' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasGameTime()
    {
        return $this->get(self::GAME_TIME) !== null;
    }

    /**
     * Sets value of 'min_score' property
     *
     * @param integer $value Property value
     *
     * @return null
     */
    public function setMinScore($value)
    {
        return $this->set(self::MIN_SCORE, $value);
    }

    /**
     * Returns value of 'min_score' property
     *
     * @return integer
     */
    public function getMinScore()
    {
        $value = $this->get(self::MIN_SCORE);
        return $value === null ? (integer)$value : $value;
    }

    /**
     * Returns true if 'min_score' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasMinScore()
    {
        return $this->get(self::MIN_SCORE) !== null;
    }

    /**
     * Sets value of 'max_score' property
     *
     * @param integer $value Property value
     *
     * @return null
     */
    public function setMaxScore($value)
    {
        return $this->set(self::MAX_SCORE, $value);
    }

    /**
     * Returns value of 'max_score' property
     *
     * @return integer
     */
    public function getMaxScore()
    {
        $value = $this->get(self::MAX_SCORE);
        return $value === null ? (integer)$value : $value;
    }

    /**
     * Returns true if 'max_score' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasMaxScore()
    {
        return $this->get(self::MAX_SCORE) !== null;
    }

    /**
     * Sets value of 'android_look' property
     *
     * @param integer $value Property value
     *
     * @return null
     */
    public function setAndroidLook($value)
    {
        return $this->set(self::ANDROID_LOOK, $value);
    }

    /**
     * Returns value of 'android_look' property
     *
     * @return integer
     */
    public function getAndroidLook()
    {
        $value = $this->get(self::ANDROID_LOOK);
        return $value === null ? (integer)$value : $value;
    }

    /**
     * Returns true if 'android_look' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasAndroidLook()
    {
        return $this->get(self::ANDROID_LOOK) !== null;
    }

    /**
     * Sets value of 'android_give_up' property
     *
     * @param integer $value Property value
     *
     * @return null
     */
    public function setAndroidGiveUp($value)
    {
        return $this->set(self::ANDROID_GIVE_UP, $value);
    }

    /**
     * Returns value of 'android_give_up' property
     *
     * @return integer
     */
    public function getAndroidGiveUp()
    {
        $value = $this->get(self::ANDROID_GIVE_UP);
        return $value === null ? (integer)$value : $value;
    }

    /**
     * Returns true if 'android_give_up' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasAndroidGiveUp()
    {
        return $this->get(self::ANDROID_GIVE_UP) !== null;
    }

    /**
     * Sets value of 'android_pay' property
     *
     * @param boolean $value Property value
     *
     * @return null
     */
    public function setAndroidPay($value)
    {
        return $this->set(self::ANDROID_PAY, $value);
    }

    /**
     * Returns value of 'android_pay' property
     *
     * @return boolean
     */
    public function getAndroidPay()
    {
        $value = $this->get(self::ANDROID_PAY);
        return $value === null ? (boolean)$value : $value;
    }

    /**
     * Returns true if 'android_pay' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasAndroidPay()
    {
        return $this->get(self::ANDROID_PAY) !== null;
    }

    /**
     * Sets value of 'men_num' property
     *
     * @param integer $value Property value
     *
     * @return null
     */
    public function setMenNum($value)
    {
        return $this->set(self::MEN_NUM, $value);
    }

    /**
     * Returns value of 'men_num' property
     *
     * @return integer
     */
    public function getMenNum()
    {
        $value = $this->get(self::MEN_NUM);
        return $value === null ? (integer)$value : $value;
    }

    /**
     * Returns true if 'men_num' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasMenNum()
    {
        return $this->get(self::MEN_NUM) !== null;
    }

    /**
     * Sets value of 'compare_card' property
     *
     * @param boolean $value Property value
     *
     * @return null
     */
    public function setCompareCard($value)
    {
        return $this->set(self::COMPARE_CARD, $value);
    }

    /**
     * Returns value of 'compare_card' property
     *
     * @return boolean
     */
    public function getCompareCard()
    {
        $value = $this->get(self::COMPARE_CARD);
        return $value === null ? (boolean)$value : $value;
    }

    /**
     * Returns true if 'compare_card' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasCompareCard()
    {
        return $this->get(self::COMPARE_CARD) !== null;
    }

    /**
     * Sets value of 'open_multiple' property
     *
     * @param integer $value Property value
     *
     * @return null
     */
    public function setOpenMultiple($value)
    {
        return $this->set(self::OPEN_MULTIPLE, $value);
    }

    /**
     * Returns value of 'open_multiple' property
     *
     * @return integer
     */
    public function getOpenMultiple()
    {
        $value = $this->get(self::OPEN_MULTIPLE);
        return $value === null ? (integer)$value : $value;
    }

    /**
     * Returns true if 'open_multiple' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasOpenMultiple()
    {
        return $this->get(self::OPEN_MULTIPLE) !== null;
    }

    /**
     * Sets value of 'compare_multiple' property
     *
     * @param integer $value Property value
     *
     * @return null
     */
    public function setCompareMultiple($value)
    {
        return $this->set(self::COMPARE_MULTIPLE, $value);
    }

    /**
     * Returns value of 'compare_multiple' property
     *
     * @return integer
     */
    public function getCompareMultiple()
    {
        $value = $this->get(self::COMPARE_MULTIPLE);
        return $value === null ? (integer)$value : $value;
    }

    /**
     * Returns true if 'compare_multiple' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasCompareMultiple()
    {
        return $this->get(self::COMPARE_MULTIPLE) !== null;
    }

    /**
     * Sets value of 'compare_no_num' property
     *
     * @param integer $value Property value
     *
     * @return null
     */
    public function setCompareNoNum($value)
    {
        return $this->set(self::COMPARE_NO_NUM, $value);
    }

    /**
     * Returns value of 'compare_no_num' property
     *
     * @return integer
     */
    public function getCompareNoNum()
    {
        $value = $this->get(self::COMPARE_NO_NUM);
        return $value === null ? (integer)$value : $value;
    }

    /**
     * Returns true if 'compare_no_num' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasCompareNoNum()
    {
        return $this->get(self::COMPARE_NO_NUM) !== null;
    }

    /**
     * Sets value of 'add_ratio' property
     *
     * @param integer $value Property value
     *
     * @return null
     */
    public function setAddRatio($value)
    {
        return $this->set(self::ADD_RATIO, $value);
    }

    /**
     * Returns value of 'add_ratio' property
     *
     * @return integer
     */
    public function getAddRatio()
    {
        $value = $this->get(self::ADD_RATIO);
        return $value === null ? (integer)$value : $value;
    }

    /**
     * Returns true if 'add_ratio' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasAddRatio()
    {
        return $this->get(self::ADD_RATIO) !== null;
    }

    /**
     * Sets value of 'compare_ok_ratio' property
     *
     * @param integer $value Property value
     *
     * @return null
     */
    public function setCompareOkRatio($value)
    {
        return $this->set(self::COMPARE_OK_RATIO, $value);
    }

    /**
     * Returns value of 'compare_ok_ratio' property
     *
     * @return integer
     */
    public function getCompareOkRatio()
    {
        $value = $this->get(self::COMPARE_OK_RATIO);
        return $value === null ? (integer)$value : $value;
    }

    /**
     * Returns true if 'compare_ok_ratio' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasCompareOkRatio()
    {
        return $this->get(self::COMPARE_OK_RATIO) !== null;
    }

    /**
     * Sets value of 'men_add_ratio' property
     *
     * @param integer $value Property value
     *
     * @return null
     */
    public function setMenAddRatio($value)
    {
        return $this->set(self::MEN_ADD_RATIO, $value);
    }

    /**
     * Returns value of 'men_add_ratio' property
     *
     * @return integer
     */
    public function getMenAddRatio()
    {
        $value = $this->get(self::MEN_ADD_RATIO);
        return $value === null ? (integer)$value : $value;
    }

    /**
     * Returns true if 'men_add_ratio' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasMenAddRatio()
    {
        return $this->get(self::MEN_ADD_RATIO) !== null;
    }

    /**
     * Sets value of 'change_card' property
     *
     * @param boolean $value Property value
     *
     * @return null
     */
    public function setChangeCard($value)
    {
        return $this->set(self::CHANGE_CARD, $value);
    }

    /**
     * Returns value of 'change_card' property
     *
     * @return boolean
     */
    public function getChangeCard()
    {
        $value = $this->get(self::CHANGE_CARD);
        return $value === null ? (boolean)$value : $value;
    }

    /**
     * Returns true if 'change_card' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasChangeCard()
    {
        return $this->get(self::CHANGE_CARD) !== null;
    }

    /**
     * Sets value of 'give_up' property
     *
     * @param boolean $value Property value
     *
     * @return null
     */
    public function setGiveUp($value)
    {
        return $this->set(self::GIVE_UP, $value);
    }

    /**
     * Returns value of 'give_up' property
     *
     * @return boolean
     */
    public function getGiveUp()
    {
        $value = $this->get(self::GIVE_UP);
        return $value === null ? (boolean)$value : $value;
    }

    /**
     * Returns true if 'give_up' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasGiveUp()
    {
        return $this->get(self::GIVE_UP) !== null;
    }
}
}