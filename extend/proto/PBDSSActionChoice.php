<?php
/**
 * Auto generated from poker_msg_basic.proto at 2023-06-08 09:49:25
 */

namespace {
/**
 * PBDSSActionChoice message
 */
class PBDSSActionChoice extends \ProtobufMessage
{
    /* Field index constants */
    const MAX_LEVEL = 1;
    const IS_DETERMINE = 2;
    const DETERMINED_ACTION = 3;
    const CHOICES = 4;
    const DETERMINED_LEVEL = 5;
    const CHOICE_TOKEN = 6;

    /* @var array Field descriptors */
    protected static $fields = array(
        self::MAX_LEVEL => array(
            'name' => 'max_level',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_INT,
        ),
        self::IS_DETERMINE => array(
            'name' => 'is_determine',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_BOOL,
        ),
        self::DETERMINED_ACTION => array(
            'name' => 'determined_action',
            'required' => false,
            'type' => '\PBDSSAction'
        ),
        self::CHOICES => array(
            'name' => 'choices',
            'repeated' => true,
            'type' => '\PBDSSAction'
        ),
        self::DETERMINED_LEVEL => array(
            'name' => 'determined_level',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_INT,
        ),
        self::CHOICE_TOKEN => array(
            'name' => 'choice_token',
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
        $this->values[self::MAX_LEVEL] = null;
        $this->values[self::IS_DETERMINE] = null;
        $this->values[self::DETERMINED_ACTION] = null;
        $this->values[self::CHOICES] = array();
        $this->values[self::DETERMINED_LEVEL] = null;
        $this->values[self::CHOICE_TOKEN] = null;
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
     * Sets value of 'max_level' property
     *
     * @param integer $value Property value
     *
     * @return null
     */
    public function setMaxLevel($value)
    {
        return $this->set(self::MAX_LEVEL, $value);
    }

    /**
     * Returns value of 'max_level' property
     *
     * @return integer
     */
    public function getMaxLevel()
    {
        $value = $this->get(self::MAX_LEVEL);
        return $value === null ? (integer)$value : $value;
    }

    /**
     * Returns true if 'max_level' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasMaxLevel()
    {
        return $this->get(self::MAX_LEVEL) !== null;
    }

    /**
     * Sets value of 'is_determine' property
     *
     * @param boolean $value Property value
     *
     * @return null
     */
    public function setIsDetermine($value)
    {
        return $this->set(self::IS_DETERMINE, $value);
    }

    /**
     * Returns value of 'is_determine' property
     *
     * @return boolean
     */
    public function getIsDetermine()
    {
        $value = $this->get(self::IS_DETERMINE);
        return $value === null ? (boolean)$value : $value;
    }

    /**
     * Returns true if 'is_determine' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasIsDetermine()
    {
        return $this->get(self::IS_DETERMINE) !== null;
    }

    /**
     * Sets value of 'determined_action' property
     *
     * @param \PBDSSAction $value Property value
     *
     * @return null
     */
    public function setDeterminedAction(\PBDSSAction $value=null)
    {
        return $this->set(self::DETERMINED_ACTION, $value);
    }

    /**
     * Returns value of 'determined_action' property
     *
     * @return \PBDSSAction
     */
    public function getDeterminedAction()
    {
        return $this->get(self::DETERMINED_ACTION);
    }

    /**
     * Returns true if 'determined_action' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasDeterminedAction()
    {
        return $this->get(self::DETERMINED_ACTION) !== null;
    }

    /**
     * Appends value to 'choices' list
     *
     * @param \PBDSSAction $value Value to append
     *
     * @return null
     */
    public function appendChoices(\PBDSSAction $value)
    {
        return $this->append(self::CHOICES, $value);
    }

    /**
     * Clears 'choices' list
     *
     * @return null
     */
    public function clearChoices()
    {
        return $this->clear(self::CHOICES);
    }

    /**
     * Returns 'choices' list
     *
     * @return \PBDSSAction[]
     */
    public function getChoices()
    {
        return $this->get(self::CHOICES);
    }

    /**
     * Returns true if 'choices' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasChoices()
    {
        return count($this->get(self::CHOICES)) !== 0;
    }

    /**
     * Returns 'choices' iterator
     *
     * @return \ArrayIterator
     */
    public function getChoicesIterator()
    {
        return new \ArrayIterator($this->get(self::CHOICES));
    }

    /**
     * Returns element from 'choices' list at given offset
     *
     * @param int $offset Position in list
     *
     * @return \PBDSSAction
     */
    public function getChoicesAt($offset)
    {
        return $this->get(self::CHOICES, $offset);
    }

    /**
     * Returns count of 'choices' list
     *
     * @return int
     */
    public function getChoicesCount()
    {
        return $this->count(self::CHOICES);
    }

    /**
     * Sets value of 'determined_level' property
     *
     * @param integer $value Property value
     *
     * @return null
     */
    public function setDeterminedLevel($value)
    {
        return $this->set(self::DETERMINED_LEVEL, $value);
    }

    /**
     * Returns value of 'determined_level' property
     *
     * @return integer
     */
    public function getDeterminedLevel()
    {
        $value = $this->get(self::DETERMINED_LEVEL);
        return $value === null ? (integer)$value : $value;
    }

    /**
     * Returns true if 'determined_level' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasDeterminedLevel()
    {
        return $this->get(self::DETERMINED_LEVEL) !== null;
    }

    /**
     * Sets value of 'choice_token' property
     *
     * @param integer $value Property value
     *
     * @return null
     */
    public function setChoiceToken($value)
    {
        return $this->set(self::CHOICE_TOKEN, $value);
    }

    /**
     * Returns value of 'choice_token' property
     *
     * @return integer
     */
    public function getChoiceToken()
    {
        $value = $this->get(self::CHOICE_TOKEN);
        return $value === null ? (integer)$value : $value;
    }

    /**
     * Returns true if 'choice_token' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasChoiceToken()
    {
        return $this->get(self::CHOICE_TOKEN) !== null;
    }
}
}