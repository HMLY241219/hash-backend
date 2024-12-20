<?php
/**
 * Auto generated from poker_msg_ss.proto at 2023-06-08 09:49:25
 */

namespace {
/**
 * SSNotifyInnerServer message
 */
class SSNotifyInnerServer extends \ProtobufMessage
{
    /* Field index constants */
    const ROUTEID = 1;

    /* @var array Field descriptors */
    protected static $fields = array(
        self::ROUTEID => array(
            'name' => 'routeid',
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
        $this->values[self::ROUTEID] = null;
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
     * Sets value of 'routeid' property
     *
     * @param integer $value Property value
     *
     * @return null
     */
    public function setRouteid($value)
    {
        return $this->set(self::ROUTEID, $value);
    }

    /**
     * Returns value of 'routeid' property
     *
     * @return integer
     */
    public function getRouteid()
    {
        $value = $this->get(self::ROUTEID);
        return $value === null ? (integer)$value : $value;
    }

    /**
     * Returns true if 'routeid' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasRouteid()
    {
        return $this->get(self::ROUTEID) !== null;
    }
}
}