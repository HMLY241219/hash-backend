<?php
/**
 * Auto generated from poker_msg_cs.proto at 2023-06-08 09:49:25
 */

namespace {
/**
 * CSResponseDSSDoAction message
 */
class CSResponseDSSDoAction extends \ProtobufMessage
{
    /* Field index constants */
    const RESULT = 1;
    const ACTION = 2;

    /* @var array Field descriptors */
    protected static $fields = array(
        self::RESULT => array(
            'name' => 'result',
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
        $this->values[self::RESULT] = null;
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