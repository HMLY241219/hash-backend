<?php
/**
 * Auto generated from poker_msg_cs.proto at 2023-06-08 09:49:25
 */

namespace {
/**
 * CSNotifyCurrencieChange message
 */
class CSNotifyCurrencieChange extends \ProtobufMessage
{
    /* Field index constants */
    const TYPE = 1;
    const CHANGE_VALUE = 2;
    const REASON = 3;
    const CUR_VALUE = 4;

    /* @var array Field descriptors */
    protected static $fields = array(
        self::TYPE => array(
            'name' => 'type',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_INT,
        ),
        self::CHANGE_VALUE => array(
            'name' => 'change_value',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_INT,
        ),
        self::REASON => array(
            'name' => 'reason',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_INT,
        ),
        self::CUR_VALUE => array(
            'name' => 'cur_value',
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
        $this->values[self::TYPE] = null;
        $this->values[self::CHANGE_VALUE] = null;
        $this->values[self::REASON] = null;
        $this->values[self::CUR_VALUE] = null;
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
     * Sets value of 'type' property
     *
     * @param integer $value Property value
     *
     * @return null
     */
    public function setType($value)
    {
        return $this->set(self::TYPE, $value);
    }

    /**
     * Returns value of 'type' property
     *
     * @return integer
     */
    public function getType()
    {
        $value = $this->get(self::TYPE);
        return $value === null ? (integer)$value : $value;
    }

    /**
     * Returns true if 'type' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasType()
    {
        return $this->get(self::TYPE) !== null;
    }

    /**
     * Sets value of 'change_value' property
     *
     * @param integer $value Property value
     *
     * @return null
     */
    public function setChangeValue($value)
    {
        return $this->set(self::CHANGE_VALUE, $value);
    }

    /**
     * Returns value of 'change_value' property
     *
     * @return integer
     */
    public function getChangeValue()
    {
        $value = $this->get(self::CHANGE_VALUE);
        return $value === null ? (integer)$value : $value;
    }

    /**
     * Returns true if 'change_value' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasChangeValue()
    {
        return $this->get(self::CHANGE_VALUE) !== null;
    }

    /**
     * Sets value of 'reason' property
     *
     * @param integer $value Property value
     *
     * @return null
     */
    public function setReason($value)
    {
        return $this->set(self::REASON, $value);
    }

    /**
     * Returns value of 'reason' property
     *
     * @return integer
     */
    public function getReason()
    {
        $value = $this->get(self::REASON);
        return $value === null ? (integer)$value : $value;
    }

    /**
     * Returns true if 'reason' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasReason()
    {
        return $this->get(self::REASON) !== null;
    }

    /**
     * Sets value of 'cur_value' property
     *
     * @param integer $value Property value
     *
     * @return null
     */
    public function setCurValue($value)
    {
        return $this->set(self::CUR_VALUE, $value);
    }

    /**
     * Returns value of 'cur_value' property
     *
     * @return integer
     */
    public function getCurValue()
    {
        $value = $this->get(self::CUR_VALUE);
        return $value === null ? (integer)$value : $value;
    }

    /**
     * Returns true if 'cur_value' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasCurValue()
    {
        return $this->get(self::CUR_VALUE) !== null;
    }
}
}