<?php
/**
 * Auto generated from poker_data.proto at 2023-06-08 09:49:25
 */

namespace {
/**
 * TaskData message
 */
class TaskData extends \ProtobufMessage
{
    /* Field index constants */
    const TASK_ID = 1;
    const STATE = 2;
    const GAME_ID = 3;
    const TASK_TYPE = 4;
    const TASK_TARGET = 5;
    const TASK_NOW = 6;

    /* @var array Field descriptors */
    protected static $fields = array(
        self::TASK_ID => array(
            'name' => 'task_id',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_INT,
        ),
        self::STATE => array(
            'name' => 'state',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_INT,
        ),
        self::GAME_ID => array(
            'name' => 'game_id',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_INT,
        ),
        self::TASK_TYPE => array(
            'name' => 'task_type',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_INT,
        ),
        self::TASK_TARGET => array(
            'name' => 'task_target',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_INT,
        ),
        self::TASK_NOW => array(
            'name' => 'task_now',
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
        $this->values[self::TASK_ID] = null;
        $this->values[self::STATE] = null;
        $this->values[self::GAME_ID] = null;
        $this->values[self::TASK_TYPE] = null;
        $this->values[self::TASK_TARGET] = null;
        $this->values[self::TASK_NOW] = null;
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
     * Sets value of 'task_id' property
     *
     * @param integer $value Property value
     *
     * @return null
     */
    public function setTaskId($value)
    {
        return $this->set(self::TASK_ID, $value);
    }

    /**
     * Returns value of 'task_id' property
     *
     * @return integer
     */
    public function getTaskId()
    {
        $value = $this->get(self::TASK_ID);
        return $value === null ? (integer)$value : $value;
    }

    /**
     * Returns true if 'task_id' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasTaskId()
    {
        return $this->get(self::TASK_ID) !== null;
    }

    /**
     * Sets value of 'state' property
     *
     * @param integer $value Property value
     *
     * @return null
     */
    public function setState($value)
    {
        return $this->set(self::STATE, $value);
    }

    /**
     * Returns value of 'state' property
     *
     * @return integer
     */
    public function getState()
    {
        $value = $this->get(self::STATE);
        return $value === null ? (integer)$value : $value;
    }

    /**
     * Returns true if 'state' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasState()
    {
        return $this->get(self::STATE) !== null;
    }

    /**
     * Sets value of 'game_id' property
     *
     * @param integer $value Property value
     *
     * @return null
     */
    public function setGameId($value)
    {
        return $this->set(self::GAME_ID, $value);
    }

    /**
     * Returns value of 'game_id' property
     *
     * @return integer
     */
    public function getGameId()
    {
        $value = $this->get(self::GAME_ID);
        return $value === null ? (integer)$value : $value;
    }

    /**
     * Returns true if 'game_id' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasGameId()
    {
        return $this->get(self::GAME_ID) !== null;
    }

    /**
     * Sets value of 'task_type' property
     *
     * @param integer $value Property value
     *
     * @return null
     */
    public function setTaskType($value)
    {
        return $this->set(self::TASK_TYPE, $value);
    }

    /**
     * Returns value of 'task_type' property
     *
     * @return integer
     */
    public function getTaskType()
    {
        $value = $this->get(self::TASK_TYPE);
        return $value === null ? (integer)$value : $value;
    }

    /**
     * Returns true if 'task_type' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasTaskType()
    {
        return $this->get(self::TASK_TYPE) !== null;
    }

    /**
     * Sets value of 'task_target' property
     *
     * @param integer $value Property value
     *
     * @return null
     */
    public function setTaskTarget($value)
    {
        return $this->set(self::TASK_TARGET, $value);
    }

    /**
     * Returns value of 'task_target' property
     *
     * @return integer
     */
    public function getTaskTarget()
    {
        $value = $this->get(self::TASK_TARGET);
        return $value === null ? (integer)$value : $value;
    }

    /**
     * Returns true if 'task_target' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasTaskTarget()
    {
        return $this->get(self::TASK_TARGET) !== null;
    }

    /**
     * Sets value of 'task_now' property
     *
     * @param integer $value Property value
     *
     * @return null
     */
    public function setTaskNow($value)
    {
        return $this->set(self::TASK_NOW, $value);
    }

    /**
     * Returns value of 'task_now' property
     *
     * @return integer
     */
    public function getTaskNow()
    {
        $value = $this->get(self::TASK_NOW);
        return $value === null ? (integer)$value : $value;
    }

    /**
     * Returns true if 'task_now' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasTaskNow()
    {
        return $this->get(self::TASK_NOW) !== null;
    }
}
}