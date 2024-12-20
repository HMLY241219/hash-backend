<?php
/**
 * Auto generated from poker_msg_basic.proto at 2023-06-08 09:49:25
 */

namespace {
/**
 * PBEndVerify message
 */
class PBEndVerify extends \ProtobufMessage
{
    /* Field index constants */
    const GAME_ID = 1;
    const SEED = 2;
    const VERIFY_DATA_1 = 3;
    const VERIFY_DATA_2 = 4;
    const ROUND_HASH = 5;
    const RESULT_SZ = 6;

    /* @var array Field descriptors */
    protected static $fields = array(
        self::GAME_ID => array(
            'name' => 'game_id',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_INT,
        ),
        self::SEED => array(
            'name' => 'seed',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_STRING,
        ),
        self::VERIFY_DATA_1 => array(
            'name' => 'verify_data_1',
            'required' => false,
            'type' => '\VerifyData'
        ),
        self::VERIFY_DATA_2 => array(
            'name' => 'verify_data_2',
            'required' => false,
            'type' => '\VerifyData'
        ),
        self::ROUND_HASH => array(
            'name' => 'round_hash',
            'repeated' => true,
            'type' => \ProtobufMessage::PB_TYPE_STRING,
        ),
        self::RESULT_SZ => array(
            'name' => 'result_sz',
            'repeated' => true,
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
        $this->values[self::GAME_ID] = null;
        $this->values[self::SEED] = null;
        $this->values[self::VERIFY_DATA_1] = null;
        $this->values[self::VERIFY_DATA_2] = null;
        $this->values[self::ROUND_HASH] = array();
        $this->values[self::RESULT_SZ] = array();
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
     * Sets value of 'verify_data_1' property
     *
     * @param \VerifyData $value Property value
     *
     * @return null
     */
    public function setVerifyData1(\VerifyData $value=null)
    {
        return $this->set(self::VERIFY_DATA_1, $value);
    }

    /**
     * Returns value of 'verify_data_1' property
     *
     * @return \VerifyData
     */
    public function getVerifyData1()
    {
        return $this->get(self::VERIFY_DATA_1);
    }

    /**
     * Returns true if 'verify_data_1' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasVerifyData1()
    {
        return $this->get(self::VERIFY_DATA_1) !== null;
    }

    /**
     * Sets value of 'verify_data_2' property
     *
     * @param \VerifyData $value Property value
     *
     * @return null
     */
    public function setVerifyData2(\VerifyData $value=null)
    {
        return $this->set(self::VERIFY_DATA_2, $value);
    }

    /**
     * Returns value of 'verify_data_2' property
     *
     * @return \VerifyData
     */
    public function getVerifyData2()
    {
        return $this->get(self::VERIFY_DATA_2);
    }

    /**
     * Returns true if 'verify_data_2' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasVerifyData2()
    {
        return $this->get(self::VERIFY_DATA_2) !== null;
    }

    /**
     * Appends value to 'round_hash' list
     *
     * @param string $value Value to append
     *
     * @return null
     */
    public function appendRoundHash($value)
    {
        return $this->append(self::ROUND_HASH, $value);
    }

    /**
     * Clears 'round_hash' list
     *
     * @return null
     */
    public function clearRoundHash()
    {
        return $this->clear(self::ROUND_HASH);
    }

    /**
     * Returns 'round_hash' list
     *
     * @return string[]
     */
    public function getRoundHash()
    {
        return $this->get(self::ROUND_HASH);
    }

    /**
     * Returns true if 'round_hash' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasRoundHash()
    {
        return count($this->get(self::ROUND_HASH)) !== 0;
    }

    /**
     * Returns 'round_hash' iterator
     *
     * @return \ArrayIterator
     */
    public function getRoundHashIterator()
    {
        return new \ArrayIterator($this->get(self::ROUND_HASH));
    }

    /**
     * Returns element from 'round_hash' list at given offset
     *
     * @param int $offset Position in list
     *
     * @return string
     */
    public function getRoundHashAt($offset)
    {
        return $this->get(self::ROUND_HASH, $offset);
    }

    /**
     * Returns count of 'round_hash' list
     *
     * @return int
     */
    public function getRoundHashCount()
    {
        return $this->count(self::ROUND_HASH);
    }

    /**
     * Appends value to 'result_sz' list
     *
     * @param integer $value Value to append
     *
     * @return null
     */
    public function appendResultSz($value)
    {
        return $this->append(self::RESULT_SZ, $value);
    }

    /**
     * Clears 'result_sz' list
     *
     * @return null
     */
    public function clearResultSz()
    {
        return $this->clear(self::RESULT_SZ);
    }

    /**
     * Returns 'result_sz' list
     *
     * @return integer[]
     */
    public function getResultSz()
    {
        return $this->get(self::RESULT_SZ);
    }

    /**
     * Returns true if 'result_sz' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasResultSz()
    {
        return count($this->get(self::RESULT_SZ)) !== 0;
    }

    /**
     * Returns 'result_sz' iterator
     *
     * @return \ArrayIterator
     */
    public function getResultSzIterator()
    {
        return new \ArrayIterator($this->get(self::RESULT_SZ));
    }

    /**
     * Returns element from 'result_sz' list at given offset
     *
     * @param int $offset Position in list
     *
     * @return integer
     */
    public function getResultSzAt($offset)
    {
        return $this->get(self::RESULT_SZ, $offset);
    }

    /**
     * Returns count of 'result_sz' list
     *
     * @return int
     */
    public function getResultSzCount()
    {
        return $this->count(self::RESULT_SZ);
    }
}
}