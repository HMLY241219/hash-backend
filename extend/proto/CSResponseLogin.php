<?php
/**
 * Auto generated from poker_msg_cs.proto at 2023-06-08 09:49:25
 */

namespace {
/**
 * CSResponseLogin message
 */
class CSResponseLogin extends \ProtobufMessage
{
    /* Field index constants */
    const RESULT = 1;
    const USER = 2;
    const USE_HEART_BEAT = 3;
    const HEART_BEAT_INTERVAL = 4;
    const IS_CREATED = 5;

    /* @var array Field descriptors */
    protected static $fields = array(
        self::RESULT => array(
            'name' => 'result',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_INT,
        ),
        self::USER => array(
            'name' => 'user',
            'required' => false,
            'type' => '\PBUser'
        ),
        self::USE_HEART_BEAT => array(
            'name' => 'use_heart_beat',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_BOOL,
        ),
        self::HEART_BEAT_INTERVAL => array(
            'name' => 'heart_beat_interval',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_INT,
        ),
        self::IS_CREATED => array(
            'name' => 'is_created',
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
        $this->values[self::RESULT] = null;
        $this->values[self::USER] = null;
        $this->values[self::USE_HEART_BEAT] = null;
        $this->values[self::HEART_BEAT_INTERVAL] = null;
        $this->values[self::IS_CREATED] = null;
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
     * Sets value of 'result' property
     *
     * @param integer $value Property value
     *
     * @return null
     */
    public function setResult($value)
    {
        return $this->set(self::RESULT, $value);
    }

    /**
     * Returns value of 'result' property
     *
     * @return integer
     */
    public function getResult()
    {
        $value = $this->get(self::RESULT);
        return $value === null ? (integer)$value : $value;
    }

    /**
     * Returns true if 'result' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasResult()
    {
        return $this->get(self::RESULT) !== null;
    }

    /**
     * Sets value of 'user' property
     *
     * @param \PBUser $value Property value
     *
     * @return null
     */
    public function setUser(\PBUser $value=null)
    {
        return $this->set(self::USER, $value);
    }

    /**
     * Returns value of 'user' property
     *
     * @return \PBUser
     */
    public function getUser()
    {
        return $this->get(self::USER);
    }

    /**
     * Returns true if 'user' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasUser()
    {
        return $this->get(self::USER) !== null;
    }

    /**
     * Sets value of 'use_heart_beat' property
     *
     * @param boolean $value Property value
     *
     * @return null
     */
    public function setUseHeartBeat($value)
    {
        return $this->set(self::USE_HEART_BEAT, $value);
    }

    /**
     * Returns value of 'use_heart_beat' property
     *
     * @return boolean
     */
    public function getUseHeartBeat()
    {
        $value = $this->get(self::USE_HEART_BEAT);
        return $value === null ? (boolean)$value : $value;
    }

    /**
     * Returns true if 'use_heart_beat' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasUseHeartBeat()
    {
        return $this->get(self::USE_HEART_BEAT) !== null;
    }

    /**
     * Sets value of 'heart_beat_interval' property
     *
     * @param integer $value Property value
     *
     * @return null
     */
    public function setHeartBeatInterval($value)
    {
        return $this->set(self::HEART_BEAT_INTERVAL, $value);
    }

    /**
     * Returns value of 'heart_beat_interval' property
     *
     * @return integer
     */
    public function getHeartBeatInterval()
    {
        $value = $this->get(self::HEART_BEAT_INTERVAL);
        return $value === null ? (integer)$value : $value;
    }

    /**
     * Returns true if 'heart_beat_interval' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasHeartBeatInterval()
    {
        return $this->get(self::HEART_BEAT_INTERVAL) !== null;
    }

    /**
     * Sets value of 'is_created' property
     *
     * @param boolean $value Property value
     *
     * @return null
     */
    public function setIsCreated($value)
    {
        return $this->set(self::IS_CREATED, $value);
    }

    /**
     * Returns value of 'is_created' property
     *
     * @return boolean
     */
    public function getIsCreated()
    {
        $value = $this->get(self::IS_CREATED);
        return $value === null ? (boolean)$value : $value;
    }

    /**
     * Returns true if 'is_created' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasIsCreated()
    {
        return $this->get(self::IS_CREATED) !== null;
    }
}
}