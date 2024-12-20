<?php
/**
 * Auto generated from poker_msg_cs.proto at 2023-06-08 09:49:25
 */

namespace {
/**
 * CSRequestVerify message
 */
class CSRequestVerify extends \ProtobufMessage
{
    /* Field index constants */
    const GAME_ID = 1;
    const ISSUE = 2;
    const SEED = 3;
    const RESULT = 4;

    /* @var array Field descriptors */
    protected static $fields = array(
        self::GAME_ID => array(
            'name' => 'game_id',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_INT,
        ),
        self::ISSUE => array(
            'name' => 'issue',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_STRING,
        ),
        self::SEED => array(
            'name' => 'seed',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_STRING,
        ),
        self::RESULT => array(
            'name' => 'result',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_STRING,
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
        $this->values[self::GAME_ID] = null;
        $this->values[self::ISSUE] = null;
        $this->values[self::SEED] = null;
        $this->values[self::RESULT] = null;
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
     * Sets value of 'issue' property
     *
     * @param string $value Property value
     *
     * @return null
     */
    public function setIssue($value)
    {
        return $this->set(self::ISSUE, $value);
    }

    /**
     * Returns value of 'issue' property
     *
     * @return string
     */
    public function getIssue()
    {
        $value = $this->get(self::ISSUE);
        return $value === null ? (string)$value : $value;
    }

    /**
     * Returns true if 'issue' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasIssue()
    {
        return $this->get(self::ISSUE) !== null;
    }

    /**
     * Sets value of 'seed' property
     *
     * @param string $value Property value
     *
     * @return null
     */
    public function setSeed($value)
    {
        return $this->set(self::SEED, $value);
    }

    /**
     * Returns value of 'seed' property
     *
     * @return string
     */
    public function getSeed()
    {
        $value = $this->get(self::SEED);
        return $value === null ? (string)$value : $value;
    }

    /**
     * Returns true if 'seed' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasSeed()
    {
        return $this->get(self::SEED) !== null;
    }

    /**
     * Sets value of 'result' property
     *
     * @param string $value Property value
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
     * @return string
     */
    public function getResult()
    {
        $value = $this->get(self::RESULT);
        return $value === null ? (string)$value : $value;
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
}
}