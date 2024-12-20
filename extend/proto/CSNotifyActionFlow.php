<?php
/**
 * Auto generated from poker_msg_cs.proto at 2023-06-08 09:49:25
 */

namespace {
/**
 * CSNotifyActionFlow message
 */
class CSNotifyActionFlow extends \ProtobufMessage
{
    /* Field index constants */
    const NEW_DSS_ACTION_FLOW = 4;
    const STATE = 6;

    /* @var array Field descriptors */
    protected static $fields = array(
        self::NEW_DSS_ACTION_FLOW => array(
            'name' => 'new_dss_action_flow',
            'required' => false,
            'type' => '\PBDSSActionFlow'
        ),
        self::STATE => array(
            'name' => 'state',
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
        $this->values[self::NEW_DSS_ACTION_FLOW] = null;
        $this->values[self::STATE] = null;
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
     * Sets value of 'new_dss_action_flow' property
     *
     * @param \PBDSSActionFlow $value Property value
     *
     * @return null
     */
    public function setNewDssActionFlow(\PBDSSActionFlow $value=null)
    {
        return $this->set(self::NEW_DSS_ACTION_FLOW, $value);
    }

    /**
     * Returns value of 'new_dss_action_flow' property
     *
     * @return \PBDSSActionFlow
     */
    public function getNewDssActionFlow()
    {
        return $this->get(self::NEW_DSS_ACTION_FLOW);
    }

    /**
     * Returns true if 'new_dss_action_flow' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasNewDssActionFlow()
    {
        return $this->get(self::NEW_DSS_ACTION_FLOW) !== null;
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
}
}