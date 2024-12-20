<?php
/**
 * Auto generated from poker_msg_cs.proto at 2023-06-08 09:49:25
 */

namespace {
/**
 * InterEventAutoAction message
 */
class InterEventAutoAction extends \ProtobufMessage
{
    /* Field index constants */
    const TOKEN = 2;
    const DSS_REQUEST_ACTION = 3;

    /* @var array Field descriptors */
    protected static $fields = array(
        self::TOKEN => array(
            'name' => 'token',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_INT,
        ),
        self::DSS_REQUEST_ACTION => array(
            'name' => 'dss_request_action',
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
        $this->values[self::TOKEN] = null;
        $this->values[self::DSS_REQUEST_ACTION] = null;
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
     * Sets value of 'token' property
     *
     * @param integer $value Property value
     *
     * @return null
     */
    public function setToken($value)
    {
        return $this->set(self::TOKEN, $value);
    }

    /**
     * Returns value of 'token' property
     *
     * @return integer
     */
    public function getToken()
    {
        $value = $this->get(self::TOKEN);
        return $value === null ? (integer)$value : $value;
    }

    /**
     * Returns true if 'token' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasToken()
    {
        return $this->get(self::TOKEN) !== null;
    }

    /**
     * Sets value of 'dss_request_action' property
     *
     * @param \PBDSSAction $value Property value
     *
     * @return null
     */
    public function setDssRequestAction(\PBDSSAction $value=null)
    {
        return $this->set(self::DSS_REQUEST_ACTION, $value);
    }

    /**
     * Returns value of 'dss_request_action' property
     *
     * @return \PBDSSAction
     */
    public function getDssRequestAction()
    {
        return $this->get(self::DSS_REQUEST_ACTION);
    }

    /**
     * Returns true if 'dss_request_action' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasDssRequestAction()
    {
        return $this->get(self::DSS_REQUEST_ACTION) !== null;
    }
}
}