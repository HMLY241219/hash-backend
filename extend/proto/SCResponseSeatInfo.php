<?php
/**
 * Auto generated from poker_msg_cs.proto at 2023-06-08 09:49:25
 */

namespace {
/**
 * SCResponseSeatInfo message
 */
class SCResponseSeatInfo extends \ProtobufMessage
{
    /* Field index constants */
    const RESULT = 1;
    const DSS_SEATS = 2;
    const LEN = 3;

    /* @var array Field descriptors */
    protected static $fields = array(
        self::RESULT => array(
            'name' => 'result',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_INT,
        ),
        self::DSS_SEATS => array(
            'name' => 'dss_seats',
            'repeated' => true,
            'type' => '\PBDSSTableSeat'
        ),
        self::LEN => array(
            'name' => 'len',
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
        $this->values[self::RESULT] = null;
        $this->values[self::DSS_SEATS] = array();
        $this->values[self::LEN] = null;
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

    /**
     * Sets value of 'len' property
     *
     * @param integer $value Property value
     *
     * @return null
     */
    public function setLen($value)
    {
        return $this->set(self::LEN, $value);
    }

    /**
     * Returns value of 'len' property
     *
     * @return integer
     */
    public function getLen()
    {
        $value = $this->get(self::LEN);
        return $value === null ? (integer)$value : $value;
    }

    /**
     * Returns true if 'len' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasLen()
    {
        return $this->get(self::LEN) !== null;
    }
}
}