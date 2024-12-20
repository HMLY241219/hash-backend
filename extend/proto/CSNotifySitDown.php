<?php
/**
 * Auto generated from poker_msg_cs.proto at 2023-06-08 09:49:25
 */

namespace {
/**
 * CSNotifySitDown message
 */
class CSNotifySitDown extends \ProtobufMessage
{
    /* Field index constants */
    const DSS_SEAT = 3;

    /* @var array Field descriptors */
    protected static $fields = array(
        self::DSS_SEAT => array(
            'name' => 'dss_seat',
            'required' => false,
            'type' => '\PBDSSTableSeat'
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
        $this->values[self::DSS_SEAT] = null;
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
     * Sets value of 'dss_seat' property
     *
     * @param \PBDSSTableSeat $value Property value
     *
     * @return null
     */
    public function setDssSeat(\PBDSSTableSeat $value=null)
    {
        return $this->set(self::DSS_SEAT, $value);
    }

    /**
     * Returns value of 'dss_seat' property
     *
     * @return \PBDSSTableSeat
     */
    public function getDssSeat()
    {
        return $this->get(self::DSS_SEAT);
    }

    /**
     * Returns true if 'dss_seat' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasDssSeat()
    {
        return $this->get(self::DSS_SEAT) !== null;
    }
}
}