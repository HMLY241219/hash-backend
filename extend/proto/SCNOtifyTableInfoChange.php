<?php
/**
 * Auto generated from poker_msg_cs.proto at 2023-06-08 09:49:25
 */

namespace {
/**
 * SCNOtifyTableInfoChange message
 */
class SCNOtifyTableInfoChange extends \ProtobufMessage
{
    /* Field index constants */
    const MULTIPLE = 1;

    /* @var array Field descriptors */
    protected static $fields = array(
        self::MULTIPLE => array(
            'name' => 'multiple',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_FLOAT,
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
        $this->values[self::MULTIPLE] = null;
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
     * Sets value of 'multiple' property
     *
     * @param double $value Property value
     *
     * @return null
     */
    public function setMultiple($value)
    {
        return $this->set(self::MULTIPLE, $value);
    }

    /**
     * Returns value of 'multiple' property
     *
     * @return double
     */
    public function getMultiple()
    {
        $value = $this->get(self::MULTIPLE);
        return $value === null ? (double)$value : $value;
    }

    /**
     * Returns true if 'multiple' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasMultiple()
    {
        return $this->get(self::MULTIPLE) !== null;
    }
}
}