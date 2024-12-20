<?php
/**
 * Auto generated from poker_msg_cs.proto at 2023-06-08 09:49:25
 */

namespace {
/**
 * CSNotifyEmail message
 */
class CSNotifyEmail extends \ProtobufMessage
{
    /* Field index constants */
    const NUM = 1;

    /* @var array Field descriptors */
    protected static $fields = array(
        self::NUM => array(
            'name' => 'num',
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
        $this->values[self::NUM] = null;
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
     * Sets value of 'num' property
     *
     * @param integer $value Property value
     *
     * @return null
     */
    public function setNum($value)
    {
        return $this->set(self::NUM, $value);
    }

    /**
     * Returns value of 'num' property
     *
     * @return integer
     */
    public function getNum()
    {
        $value = $this->get(self::NUM);
        return $value === null ? (integer)$value : $value;
    }

    /**
     * Returns true if 'num' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasNum()
    {
        return $this->get(self::NUM) !== null;
    }
}
}