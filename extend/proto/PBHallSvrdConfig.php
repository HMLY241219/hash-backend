<?php
/**
 * Auto generated from poker_config.proto at 2023-06-08 09:49:25
 */

namespace {
/**
 * PBHallSvrdConfig message
 */
class PBHallSvrdConfig extends \ProtobufMessage
{
    /* Field index constants */
    const RECORDS = 1;
    const INIT_MONEY = 2;
    const CONFIG_REDIS = 3;

    /* @var array Field descriptors */
    protected static $fields = array(
        self::RECORDS => array(
            'name' => 'records',
            'repeated' => true,
            'type' => '\PBSvrdNode'
        ),
        self::INIT_MONEY => array(
            'default' => 100,
            'name' => 'init_money',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_INT,
        ),
        self::CONFIG_REDIS => array(
            'name' => 'config_redis',
            'required' => false,
            'type' => '\PBSvrdNode'
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
        $this->values[self::RECORDS] = array();
        $this->values[self::INIT_MONEY] = self::$fields[self::INIT_MONEY]['default'];
        $this->values[self::CONFIG_REDIS] = null;
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
     * Appends value to 'records' list
     *
     * @param \PBSvrdNode $value Value to append
     *
     * @return null
     */
    public function appendRecords(\PBSvrdNode $value)
    {
        return $this->append(self::RECORDS, $value);
    }

    /**
     * Clears 'records' list
     *
     * @return null
     */
    public function clearRecords()
    {
        return $this->clear(self::RECORDS);
    }

    /**
     * Returns 'records' list
     *
     * @return \PBSvrdNode[]
     */
    public function getRecords()
    {
        return $this->get(self::RECORDS);
    }

    /**
     * Returns true if 'records' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasRecords()
    {
        return count($this->get(self::RECORDS)) !== 0;
    }

    /**
     * Returns 'records' iterator
     *
     * @return \ArrayIterator
     */
    public function getRecordsIterator()
    {
        return new \ArrayIterator($this->get(self::RECORDS));
    }

    /**
     * Returns element from 'records' list at given offset
     *
     * @param int $offset Position in list
     *
     * @return \PBSvrdNode
     */
    public function getRecordsAt($offset)
    {
        return $this->get(self::RECORDS, $offset);
    }

    /**
     * Returns count of 'records' list
     *
     * @return int
     */
    public function getRecordsCount()
    {
        return $this->count(self::RECORDS);
    }

    /**
     * Sets value of 'init_money' property
     *
     * @param integer $value Property value
     *
     * @return null
     */
    public function setInitMoney($value)
    {
        return $this->set(self::INIT_MONEY, $value);
    }

    /**
     * Returns value of 'init_money' property
     *
     * @return integer
     */
    public function getInitMoney()
    {
        $value = $this->get(self::INIT_MONEY);
        return $value === null ? (integer)$value : $value;
    }

    /**
     * Returns true if 'init_money' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasInitMoney()
    {
        return $this->get(self::INIT_MONEY) !== null;
    }

    /**
     * Sets value of 'config_redis' property
     *
     * @param \PBSvrdNode $value Property value
     *
     * @return null
     */
    public function setConfigRedis(\PBSvrdNode $value=null)
    {
        return $this->set(self::CONFIG_REDIS, $value);
    }

    /**
     * Returns value of 'config_redis' property
     *
     * @return \PBSvrdNode
     */
    public function getConfigRedis()
    {
        return $this->get(self::CONFIG_REDIS);
    }

    /**
     * Returns true if 'config_redis' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasConfigRedis()
    {
        return $this->get(self::CONFIG_REDIS) !== null;
    }
}
}