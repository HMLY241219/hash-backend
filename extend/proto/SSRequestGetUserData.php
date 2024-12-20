<?php
/**
 * Auto generated from poker_msg_ss.proto at 2023-06-08 09:49:25
 */

namespace {
/**
 * SSRequestGetUserData message
 */
class SSRequestGetUserData extends \ProtobufMessage
{
    /* Field index constants */
    const DATA_SET = 1;

    /* @var array Field descriptors */
    protected static $fields = array(
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