<?php
/**
 * Auto generated from poker_data.proto at 2023-06-08 09:49:25
 */

namespace {
/**
 * PBActivity message
 */
class PBActivity extends \ProtobufMessage
{
    /* Field index constants */
    const GOLD_DAY_TIME = 1;
    const ROTARY = 2;
    const DAY_TASK = 3;
    const WEEK_TASK = 4;
    const ACTIVITY_PAY = 5;
    const COINS_DAY_TIME = 6;
    const PAY_DAY = 7;

    /* @var array Field descriptors */
    protected static $fields = array(
        self::GOLD_DAY_TIME => array(
            'name' => 'gold_day_time',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_INT,
        ),
        self::ROTARY => array(
            'name' => 'rotary',
            'required' => false,
            'type' => '\PBRotary'
        ),
        self::DAY_TASK => array(
            'name' => 'day_task',
            'required' => false,
            'type' => '\PBTask'
        ),
        self::WEEK_TASK => array(
            'name' => 'week_task',
            'required' => false,
            'type' => '\PBTask'
        ),
        self::ACTIVITY_PAY => array(
            'name' => 'activity_pay',
            'required' => false,
            'type' => '\PBActivityPay'
        ),
        self::COINS_DAY_TIME => array(
            'name' => 'coins_day_time',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_INT,
        ),
        self::PAY_DAY => array(
            'name' => 'pay_day',
            'required' => false,
            'type' => '\PBPayDay'
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
        $this->values[self::GOLD_DAY_TIME] = null;
        $this->values[self::ROTARY] = null;
        $this->values[self::DAY_TASK] = null;
        $this->values[self::WEEK_TASK] = null;
        $this->values[self::ACTIVITY_PAY] = null;
        $this->values[self::COINS_DAY_TIME] = null;
        $this->values[self::PAY_DAY] = null;
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
     * Sets value of 'gold_day_time' property
     *
     * @param integer $value Property value
     *
     * @return null
     */
    public function setGoldDayTime($value)
    {
        return $this->set(self::GOLD_DAY_TIME, $value);
    }

    /**
     * Returns value of 'gold_day_time' property
     *
     * @return integer
     */
    public function getGoldDayTime()
    {
        $value = $this->get(self::GOLD_DAY_TIME);
        return $value === null ? (integer)$value : $value;
    }

    /**
     * Returns true if 'gold_day_time' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasGoldDayTime()
    {
        return $this->get(self::GOLD_DAY_TIME) !== null;
    }

    /**
     * Sets value of 'rotary' property
     *
     * @param \PBRotary $value Property value
     *
     * @return null
     */
    public function setRotary(\PBRotary $value=null)
    {
        return $this->set(self::ROTARY, $value);
    }

    /**
     * Returns value of 'rotary' property
     *
     * @return \PBRotary
     */
    public function getRotary()
    {
        return $this->get(self::ROTARY);
    }

    /**
     * Returns true if 'rotary' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasRotary()
    {
        return $this->get(self::ROTARY) !== null;
    }

    /**
     * Sets value of 'day_task' property
     *
     * @param \PBTask $value Property value
     *
     * @return null
     */
    public function setDayTask(\PBTask $value=null)
    {
        return $this->set(self::DAY_TASK, $value);
    }

    /**
     * Returns value of 'day_task' property
     *
     * @return \PBTask
     */
    public function getDayTask()
    {
        return $this->get(self::DAY_TASK);
    }

    /**
     * Returns true if 'day_task' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasDayTask()
    {
        return $this->get(self::DAY_TASK) !== null;
    }

    /**
     * Sets value of 'week_task' property
     *
     * @param \PBTask $value Property value
     *
     * @return null
     */
    public function setWeekTask(\PBTask $value=null)
    {
        return $this->set(self::WEEK_TASK, $value);
    }

    /**
     * Returns value of 'week_task' property
     *
     * @return \PBTask
     */
    public function getWeekTask()
    {
        return $this->get(self::WEEK_TASK);
    }

    /**
     * Returns true if 'week_task' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasWeekTask()
    {
        return $this->get(self::WEEK_TASK) !== null;
    }

    /**
     * Sets value of 'activity_pay' property
     *
     * @param \PBActivityPay $value Property value
     *
     * @return null
     */
    public function setActivityPay(\PBActivityPay $value=null)
    {
        return $this->set(self::ACTIVITY_PAY, $value);
    }

    /**
     * Returns value of 'activity_pay' property
     *
     * @return \PBActivityPay
     */
    public function getActivityPay()
    {
        return $this->get(self::ACTIVITY_PAY);
    }

    /**
     * Returns true if 'activity_pay' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasActivityPay()
    {
        return $this->get(self::ACTIVITY_PAY) !== null;
    }

    /**
     * Sets value of 'coins_day_time' property
     *
     * @param integer $value Property value
     *
     * @return null
     */
    public function setCoinsDayTime($value)
    {
        return $this->set(self::COINS_DAY_TIME, $value);
    }

    /**
     * Returns value of 'coins_day_time' property
     *
     * @return integer
     */
    public function getCoinsDayTime()
    {
        $value = $this->get(self::COINS_DAY_TIME);
        return $value === null ? (integer)$value : $value;
    }

    /**
     * Returns true if 'coins_day_time' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasCoinsDayTime()
    {
        return $this->get(self::COINS_DAY_TIME) !== null;
    }

    /**
     * Sets value of 'pay_day' property
     *
     * @param \PBPayDay $value Property value
     *
     * @return null
     */
    public function setPayDay(\PBPayDay $value=null)
    {
        return $this->set(self::PAY_DAY, $value);
    }

    /**
     * Returns value of 'pay_day' property
     *
     * @return \PBPayDay
     */
    public function getPayDay()
    {
        return $this->get(self::PAY_DAY);
    }

    /**
     * Returns true if 'pay_day' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasPayDay()
    {
        return $this->get(self::PAY_DAY) !== null;
    }
}
}