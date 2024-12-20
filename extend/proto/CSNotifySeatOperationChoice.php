<?php
/**
 * Auto generated from poker_msg_cs.proto at 2023-06-08 09:49:25
 */

namespace {
/**
 * CSNotifySeatOperationChoice message
 */
class CSNotifySeatOperationChoice extends \ProtobufMessage
{
    /* Field index constants */
    const ACTION_TOKEN = 2;
    const DSS_CHOICES = 4;

    /* @var array Field descriptors */
    protected static $fields = array(
        self::ACTION_TOKEN => array(
            'name' => 'action_token',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_INT,
        ),
        self::DSS_CHOICES => array(
            'name' => 'dss_choices',
            'repeated' => true,
            'type' => '\PBDSSAction'
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
        $this->values[self::ACTION_TOKEN] = null;
        $this->values[self::DSS_CHOICES] = array();
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
     * Sets value of 'action_token' property
     *
     * @param integer $value Property value
     *
     * @return null
     */
    public function setActionToken($value)
    {
        return $this->set(self::ACTION_TOKEN, $value);
    }

    /**
     * Returns value of 'action_token' property
     *
     * @return integer
     */
    public function getActionToken()
    {
        $value = $this->get(self::ACTION_TOKEN);
        return $value === null ? (integer)$value : $value;
    }

    /**
     * Returns true if 'action_token' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasActionToken()
    {
        return $this->get(self::ACTION_TOKEN) !== null;
    }

    /**
     * Appends value to 'dss_choices' list
     *
     * @param \PBDSSAction $value Value to append
     *
     * @return null
     */
    public function appendDssChoices(\PBDSSAction $value)
    {
        return $this->append(self::DSS_CHOICES, $value);
    }

    /**
     * Clears 'dss_choices' list
     *
     * @return null
     */
    public function clearDssChoices()
    {
        return $this->clear(self::DSS_CHOICES);
    }

    /**
     * Returns 'dss_choices' list
     *
     * @return \PBDSSAction[]
     */
    public function getDssChoices()
    {
        return $this->get(self::DSS_CHOICES);
    }

    /**
     * Returns true if 'dss_choices' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasDssChoices()
    {
        return count($this->get(self::DSS_CHOICES)) !== 0;
    }

    /**
     * Returns 'dss_choices' iterator
     *
     * @return \ArrayIterator
     */
    public function getDssChoicesIterator()
    {
        return new \ArrayIterator($this->get(self::DSS_CHOICES));
    }

    /**
     * Returns element from 'dss_choices' list at given offset
     *
     * @param int $offset Position in list
     *
     * @return \PBDSSAction
     */
    public function getDssChoicesAt($offset)
    {
        return $this->get(self::DSS_CHOICES, $offset);
    }

    /**
     * Returns count of 'dss_choices' list
     *
     * @return int
     */
    public function getDssChoicesCount()
    {
        return $this->count(self::DSS_CHOICES);
    }
}
}