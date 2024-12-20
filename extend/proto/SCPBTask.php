<?php
/**
 * Auto generated from poker_data.proto at 2023-06-08 09:49:25
 */

namespace {
/**
 * SCPBTask message
 */
class SCPBTask extends \ProtobufMessage
{
    /* Field index constants */
    const TASK_TIME = 1;
    const TASK_DATA = 2;

    /* @var array Field descriptors */
    protected static $fields = array(
        self::TASK_TIME => array(
            'name' => 'task_time',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_INT,
        ),
        self::TASK_DATA => array(
            'name' => 'task_data',
            'repeated' => true,
            'type' => '\SCTaskData'
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
        $this->values[self::TASK_TIME] = null;
        $this->values[self::TASK_DATA] = array();
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
     * Sets value of 'task_time' property
     *
     * @param integer $value Property value
     *
     * @return null
     */
    public function setTaskTime($value)
    {
        return $this->set(self::TASK_TIME, $value);
    }

    /**
     * Returns value of 'task_time' property
     *
     * @return integer
     */
    public function getTaskTime()
    {
        $value = $this->get(self::TASK_TIME);
        return $value === null ? (integer)$value : $value;
    }

    /**
     * Returns true if 'task_time' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasTaskTime()
    {
        return $this->get(self::TASK_TIME) !== null;
    }

    /**
     * Appends value to 'task_data' list
     *
     * @param \SCTaskData $value Value to append
     *
     * @return null
     */
    public function appendTaskData(\SCTaskData $value)
    {
        return $this->append(self::TASK_DATA, $value);
    }

    /**
     * Clears 'task_data' list
     *
     * @return null
     */
    public function clearTaskData()
    {
        return $this->clear(self::TASK_DATA);
    }

    /**
     * Returns 'task_data' list
     *
     * @return \SCTaskData[]
     */
    public function getTaskData()
    {
        return $this->get(self::TASK_DATA);
    }

    /**
     * Returns true if 'task_data' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasTaskData()
    {
        return count($this->get(self::TASK_DATA)) !== 0;
    }

    /**
     * Returns 'task_data' iterator
     *
     * @return \ArrayIterator
     */
    public function getTaskDataIterator()
    {
        return new \ArrayIterator($this->get(self::TASK_DATA));
    }

    /**
     * Returns element from 'task_data' list at given offset
     *
     * @param int $offset Position in list
     *
     * @return \SCTaskData
     */
    public function getTaskDataAt($offset)
    {
        return $this->get(self::TASK_DATA, $offset);
    }

    /**
     * Returns count of 'task_data' list
     *
     * @return int
     */
    public function getTaskDataCount()
    {
        return $this->count(self::TASK_DATA);
    }
}
}