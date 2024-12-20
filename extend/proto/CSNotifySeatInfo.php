<?php
/**
 * Auto generated from poker_msg_cs.proto at 2023-06-08 09:49:25
 */

namespace {
/**
 * CSNotifySeatInfo message
 */
class CSNotifySeatInfo extends \ProtobufMessage
{
    /* Field index constants */
    const DSS_SEATS = 2;

    /* @var array Field descriptors */
    protected static $fields = array(
        self::DSS_SEATS => array(
            'name' => 'dss_seats',
            'repeated' => true,
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
        $this->values[self::DSS_SEATS] = array();
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
     * Appends value to 'dss_seats' list
     *
     * @param \PBDSSTableSeat $value Value to append
     *
     * @return null
     */
    public function appendDssSeats(\PBDSSTableSeat $value)
    {
        return $this->append(self::DSS_SEATS, $value);
    }

    /**
     * Clears 'dss_seats' list
     *
     * @return null
     */
    public function clearDssSeats()
    {
        return $this->clear(self::DSS_SEATS);
    }

    /**
     * Returns 'dss_seats' list
     *
     * @return \PBDSSTableSeat[]
     */
    public function getDssSeats()
    {
        return $this->get(self::DSS_SEATS);
    }

    /**
     * Returns true if 'dss_seats' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasDssSeats()
    {
        return count($this->get(self::DSS_SEATS)) !== 0;
    }

    /**
     * Returns 'dss_seats' iterator
     *
     * @return \ArrayIterator
     */
    public function getDssSeatsIterator()
    {
        return new \ArrayIterator($this->get(self::DSS_SEATS));
    }

    /**
     * Returns element from 'dss_seats' list at given offset
     *
     * @param int $offset Position in list
     *
     * @return \PBDSSTableSeat
     */
    public function getDssSeatsAt($offset)
    {
        return $this->get(self::DSS_SEATS, $offset);
    }

    /**
     * Returns count of 'dss_seats' list
     *
     * @return int
     */
    public function getDssSeatsCount()
    {
        return $this->count(self::DSS_SEATS);
    }
}
}