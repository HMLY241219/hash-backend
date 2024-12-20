<?php
/**
 * Auto generated from poker_config.proto at 2023-06-08 09:49:25
 */

namespace {
/**
 * PBControlConfig message
 */
class PBControlConfig extends \ProtobufMessage
{
    /* Field index constants */
    const SERVICE_RATIO = 1;
    const BASE_LOGIC = 22;
    const ROUND_LOGIC = 23;
    const COMPARE_LOGIC = 24;

    /* @var array Field descriptors */
    protected static $fields = array(
        self::SERVICE_RATIO => array(
            'name' => 'service_ratio',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_INT,
        ),
        self::BASE_LOGIC => array(
            'name' => 'base_logic',
            'repeated' => true,
            'type' => '\PBBaseLogic'
        ),
        self::ROUND_LOGIC => array(
            'name' => 'round_logic',
            'repeated' => true,
            'type' => '\PBRoundLogic'
        ),
        self::COMPARE_LOGIC => array(
            'name' => 'compare_logic',
            'repeated' => true,
            'type' => '\PBCompareLogic'
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
        $this->values[self::SERVICE_RATIO] = null;
        $this->values[self::BASE_LOGIC] = array();
        $this->values[self::ROUND_LOGIC] = array();
        $this->values[self::COMPARE_LOGIC] = array();
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
     * Sets value of 'service_ratio' property
     *
     * @param integer $value Property value
     *
     * @return null
     */
    public function setServiceRatio($value)
    {
        return $this->set(self::SERVICE_RATIO, $value);
    }

    /**
     * Returns value of 'service_ratio' property
     *
     * @return integer
     */
    public function getServiceRatio()
    {
        $value = $this->get(self::SERVICE_RATIO);
        return $value === null ? (integer)$value : $value;
    }

    /**
     * Returns true if 'service_ratio' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasServiceRatio()
    {
        return $this->get(self::SERVICE_RATIO) !== null;
    }

    /**
     * Appends value to 'base_logic' list
     *
     * @param \PBBaseLogic $value Value to append
     *
     * @return null
     */
    public function appendBaseLogic(\PBBaseLogic $value)
    {
        return $this->append(self::BASE_LOGIC, $value);
    }

    /**
     * Clears 'base_logic' list
     *
     * @return null
     */
    public function clearBaseLogic()
    {
        return $this->clear(self::BASE_LOGIC);
    }

    /**
     * Returns 'base_logic' list
     *
     * @return \PBBaseLogic[]
     */
    public function getBaseLogic()
    {
        return $this->get(self::BASE_LOGIC);
    }

    /**
     * Returns true if 'base_logic' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasBaseLogic()
    {
        return count($this->get(self::BASE_LOGIC)) !== 0;
    }

    /**
     * Returns 'base_logic' iterator
     *
     * @return \ArrayIterator
     */
    public function getBaseLogicIterator()
    {
        return new \ArrayIterator($this->get(self::BASE_LOGIC));
    }

    /**
     * Returns element from 'base_logic' list at given offset
     *
     * @param int $offset Position in list
     *
     * @return \PBBaseLogic
     */
    public function getBaseLogicAt($offset)
    {
        return $this->get(self::BASE_LOGIC, $offset);
    }

    /**
     * Returns count of 'base_logic' list
     *
     * @return int
     */
    public function getBaseLogicCount()
    {
        return $this->count(self::BASE_LOGIC);
    }

    /**
     * Appends value to 'round_logic' list
     *
     * @param \PBRoundLogic $value Value to append
     *
     * @return null
     */
    public function appendRoundLogic(\PBRoundLogic $value)
    {
        return $this->append(self::ROUND_LOGIC, $value);
    }

    /**
     * Clears 'round_logic' list
     *
     * @return null
     */
    public function clearRoundLogic()
    {
        return $this->clear(self::ROUND_LOGIC);
    }

    /**
     * Returns 'round_logic' list
     *
     * @return \PBRoundLogic[]
     */
    public function getRoundLogic()
    {
        return $this->get(self::ROUND_LOGIC);
    }

    /**
     * Returns true if 'round_logic' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasRoundLogic()
    {
        return count($this->get(self::ROUND_LOGIC)) !== 0;
    }

    /**
     * Returns 'round_logic' iterator
     *
     * @return \ArrayIterator
     */
    public function getRoundLogicIterator()
    {
        return new \ArrayIterator($this->get(self::ROUND_LOGIC));
    }

    /**
     * Returns element from 'round_logic' list at given offset
     *
     * @param int $offset Position in list
     *
     * @return \PBRoundLogic
     */
    public function getRoundLogicAt($offset)
    {
        return $this->get(self::ROUND_LOGIC, $offset);
    }

    /**
     * Returns count of 'round_logic' list
     *
     * @return int
     */
    public function getRoundLogicCount()
    {
        return $this->count(self::ROUND_LOGIC);
    }

    /**
     * Appends value to 'compare_logic' list
     *
     * @param \PBCompareLogic $value Value to append
     *
     * @return null
     */
    public function appendCompareLogic(\PBCompareLogic $value)
    {
        return $this->append(self::COMPARE_LOGIC, $value);
    }

    /**
     * Clears 'compare_logic' list
     *
     * @return null
     */
    public function clearCompareLogic()
    {
        return $this->clear(self::COMPARE_LOGIC);
    }

    /**
     * Returns 'compare_logic' list
     *
     * @return \PBCompareLogic[]
     */
    public function getCompareLogic()
    {
        return $this->get(self::COMPARE_LOGIC);
    }

    /**
     * Returns true if 'compare_logic' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasCompareLogic()
    {
        return count($this->get(self::COMPARE_LOGIC)) !== 0;
    }

    /**
     * Returns 'compare_logic' iterator
     *
     * @return \ArrayIterator
     */
    public function getCompareLogicIterator()
    {
        return new \ArrayIterator($this->get(self::COMPARE_LOGIC));
    }

    /**
     * Returns element from 'compare_logic' list at given offset
     *
     * @param int $offset Position in list
     *
     * @return \PBCompareLogic
     */
    public function getCompareLogicAt($offset)
    {
        return $this->get(self::COMPARE_LOGIC, $offset);
    }

    /**
     * Returns count of 'compare_logic' list
     *
     * @return int
     */
    public function getCompareLogicCount()
    {
        return $this->count(self::COMPARE_LOGIC);
    }
}
}