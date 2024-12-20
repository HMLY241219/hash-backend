<?php
/**
 * Auto generated from poker_msg_basic.proto at 2023-06-08 09:49:25
 */

namespace {
/**
 * CSNotifyGameOver message
 */
class CSNotifyGameOver extends \ProtobufMessage
{
    /* Field index constants */
    const DSS_RESULT = 1;

    /* @var array Field descriptors */
    protected static $fields = array(
        self::DSS_RESULT => array(
            'name' => 'dss_result',
            'required' => false,
            'type' => '\CSDssResult'
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
        $this->values[self::DSS_RESULT] = null;
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
     * Sets value of 'dss_result' property
     *
     * @param \CSDssResult $value Property value
     *
     * @return null
     */
    public function setDssResult(\CSDssResult $value=null)
    {
        return $this->set(self::DSS_RESULT, $value);
    }

    /**
     * Returns value of 'dss_result' property
     *
     * @return \CSDssResult
     */
    public function getDssResult()
    {
        return $this->get(self::DSS_RESULT);
    }

    /**
     * Returns true if 'dss_result' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasDssResult()
    {
        return $this->get(self::DSS_RESULT) !== null;
    }
}
}