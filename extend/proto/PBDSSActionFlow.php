<?php
/**
 * Auto generated from poker_msg_basic.proto at 2023-06-08 09:49:25
 */

namespace {
/**
 * PBDSSActionFlow message
 */
class PBDSSActionFlow extends \ProtobufMessage
{
    /* Field index constants */
    const FLOW_TOKEN = 1;
    const ACTION = 2;

    /* @var array Field descriptors */
    protected static $fields = array(
        self::FLOW_TOKEN => array(
            'name' => 'flow_token',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_INT,
        ),
        self::ACTION => array(
            'name' => 'action',
            'required' => false,
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
        $this->values[self::FLOW_TOKEN] = null;
        $this->values[self::ACTION] = null;
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
     * Sets value of 'flow_token' property
     *
     * @param integer $value Property value
     *
     * @return null
     */
    public function setFlowToken($value)
    {
        return $this->set(self::FLOW_TOKEN, $value);
    }

    /**
     * Returns value of 'flow_token' property
     *
     * @return integer
     */
    public function getFlowToken()
    {
        $value = $this->get(self::FLOW_TOKEN);
        return $value === null ? (integer)$value : $value;
    }

    /**
     * Returns true if 'flow_token' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasFlowToken()
    {
        return $this->get(self::FLOW_TOKEN) !== null;
    }

    /**
     * Sets value of 'action' property
     *
     * @param \PBDSSAction $value Property value
     *
     * @return null
     */
    public function setAction(\PBDSSAction $value=null)
    {
        return $this->set(self::ACTION, $value);
    }

    /**
     * Returns value of 'action' property
     *
     * @return \PBDSSAction
     */
    public function getAction()
    {
        return $this->get(self::ACTION);
    }

    /**
     * Returns true if 'action' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasAction()
    {
        return $this->get(self::ACTION) !== null;
    }
}
}