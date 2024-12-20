<?php
/**
 * Auto generated from poker_msg_ss.proto at 2023-06-08 09:49:25
 */

namespace {
/**
 * SSResponseGetUserData message
 */
class SSResponseGetUserData extends \ProtobufMessage
{
    /* Field index constants */
    const RESULT = 1;
    const DATA_SET = 2;

    /* @var array Field descriptors */
    protected static $fields = array(
        self::RESULT => array(
            'name' => 'result',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_INT,
        ),
        self::DATA_SET => array(
            'name' => 'data_set',
            'required' => false,
            'type' => '\PBDataSet'
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
        $this->values[self::DATA_SET] = null;
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
     * Sets value of 'data_set' property
     *
     * @param \PBDataSet $value Property value
     *
     * @return null
     */
    public function setDataSet(\PBDataSet $value=null)
    {
        return $this->set(self::DATA_SET, $value);
    }

    /**
     * Returns value of 'data_set' property
     *
     * @return \PBDataSet
     */
    public function getDataSet()
    {
        return $this->get(self::DATA_SET);
    }

    /**
     * Returns true if 'data_set' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasDataSet()
    {
        return $this->get(self::DATA_SET) !== null;
    }
}
}