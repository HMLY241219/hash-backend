<?php
/**
 * Auto generated from poker_msg_ss.proto at 2023-06-08 09:49:25
 */

namespace {
/**
 * SSInnerNotifyChipNotEnough message
 */
class SSInnerNotifyChipNotEnough extends \ProtobufMessage
{
    /* Field index constants */
    const TID = 1;
    const SEATS = 2;

    /* @var array Field descriptors */
    protected static $fields = array(
        self::TID => array(
            'name' => 'tid',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_INT,
        ),
        self::SEATS => array(
            'name' => 'seats',
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
        $this->values[self::TID] = null;
        $this->values[self::SEATS] = array();
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
     * Sets value of 'tid' property
     *
     * @param integer $value Property value
     *
     * @return null
     */
    public function setTid($value)
    {
        return $this->set(self::TID, $value);
    }

    /**
     * Returns value of 'tid' property
     *
     * @return integer
     */
    public function getTid()
    {
        $value = $this->get(self::TID);
        return $value === null ? (integer)$value : $value;
    }

    /**
     * Returns true if 'tid' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasTid()
    {
        return $this->get(self::TID) !== null;
    }

    /**
     * Appends value to 'seats' list
     *
     * @param \PBDSSTableSeat $value Value to append
     *
     * @return null
     */
    public function appendSeats(\PBDSSTableSeat $value)
    {
        return $this->append(self::SEATS, $value);
    }

    /**
     * Clears 'seats' list
     *
     * @return null
     */
    public function clearSeats()
    {
        return $this->clear(self::SEATS);
    }

    /**
     * Returns 'seats' list
     *
     * @return \PBDSSTableSeat[]
     */
    public function getSeats()
    {
        return $this->get(self::SEATS);
    }

    /**
     * Returns true if 'seats' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasSeats()
    {
        return count($this->get(self::SEATS)) !== 0;
    }

    /**
     * Returns 'seats' iterator
     *
     * @return \ArrayIterator
     */
    public function getSeatsIterator()
    {
        return new \ArrayIterator($this->get(self::SEATS));
    }

    /**
     * Returns element from 'seats' list at given offset
     *
     * @param int $offset Position in list
     *
     * @return \PBDSSTableSeat
     */
    public function getSeatsAt($offset)
    {
        return $this->get(self::SEATS, $offset);
    }

    /**
     * Returns count of 'seats' list
     *
     * @return int
     */
    public function getSeatsCount()
    {
        return $this->count(self::SEATS);
    }
}
}