<?php
/**
 * Auto generated from poker_msg_cs.proto at 2023-06-08 09:49:25
 */

namespace {
/**
 * CSResponseTask message
 */
class CSResponseTask extends \ProtobufMessage
{
    /* Field index constants */
    const DAY_TASK = 1;
    const WEEK_TASK = 2;

    /* @var array Field descriptors */
    protected static $fields = array(
        self::DAY_TASK => array(
            'name' => 'day_task',
            'required' => false,
            'type' => '\SCPBTask'
        ),
        self::WEEK_TASK => array(
            'name' => 'week_task',
            'required' => false,
            'type' => '\SCPBTask'
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
        $this->values[self::DAY_TASK] = null;
        $this->values[self::WEEK_TASK] = null;
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
     * Sets value of 'day_task' property
     *
     * @param \SCPBTask $value Property value
     *
     * @return null
     */
    public function setDayTask(\SCPBTask $value=null)
    {
        return $this->set(self::DAY_TASK, $value);
    }

    /**
     * Returns value of 'day_task' property
     *
     * @return \SCPBTask
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
     * @param \SCPBTask $value Property value
     *
     * @return null
     */
    public function setWeekTask(\SCPBTask $value=null)
    {
        return $this->set(self::WEEK_TASK, $value);
    }

    /**
     * Returns value of 'week_task' property
     *
     * @return \SCPBTask
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
}
}