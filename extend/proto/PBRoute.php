<?php
/**
 * Auto generated from poker_msg.proto at 2023-06-08 09:49:25
 */

namespace {
/**
 * PBRoute message
 */
class PBRoute extends \ProtobufMessage
{
    /* Field index constants */
    const SOURCE = 1;
    const SOURCE_ID = 2;
    const DESTINATION = 3;
    const DES_ID = 4;
    const SESSION_ID = 5;
    const MTYPE = 6;
    const UID = 7;
    const ROUTE_TYPE = 8;
    const GROUPID = 9;

    /* @var array Field descriptors */
    protected static $fields = array(
        self::SOURCE => array(
            'name' => 'source',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_INT,
        ),
        self::SOURCE_ID => array(
            'name' => 'source_id',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_INT,
        ),
        self::DESTINATION => array(
            'name' => 'destination',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_INT,
        ),
        self::DES_ID => array(
            'name' => 'des_id',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_INT,
        ),
        self::SESSION_ID => array(
            'name' => 'session_id',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_INT,
        ),
        self::MTYPE => array(
            'name' => 'mtype',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_INT,
        ),
        self::UID => array(
            'name' => 'uid',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_INT,
        ),
        self::ROUTE_TYPE => array(
            'name' => 'route_type',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_INT,
        ),
        self::GROUPID => array(
            'name' => 'groupid',
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
        $this->values[self::SOURCE] = null;
        $this->values[self::SOURCE_ID] = null;
        $this->values[self::DESTINATION] = null;
        $this->values[self::DES_ID] = null;
        $this->values[self::SESSION_ID] = null;
        $this->values[self::MTYPE] = null;
        $this->values[self::UID] = null;
        $this->values[self::ROUTE_TYPE] = null;
        $this->values[self::GROUPID] = null;
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
     * Sets value of 'source' property
     *
     * @param integer $value Property value
     *
     * @return null
     */
    public function setSource($value)
    {
        return $this->set(self::SOURCE, $value);
    }

    /**
     * Returns value of 'source' property
     *
     * @return integer
     */
    public function getSource()
    {
        $value = $this->get(self::SOURCE);
        return $value === null ? (integer)$value : $value;
    }

    /**
     * Returns true if 'source' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasSource()
    {
        return $this->get(self::SOURCE) !== null;
    }

    /**
     * Sets value of 'source_id' property
     *
     * @param integer $value Property value
     *
     * @return null
     */
    public function setSourceId($value)
    {
        return $this->set(self::SOURCE_ID, $value);
    }

    /**
     * Returns value of 'source_id' property
     *
     * @return integer
     */
    public function getSourceId()
    {
        $value = $this->get(self::SOURCE_ID);
        return $value === null ? (integer)$value : $value;
    }

    /**
     * Returns true if 'source_id' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasSourceId()
    {
        return $this->get(self::SOURCE_ID) !== null;
    }

    /**
     * Sets value of 'destination' property
     *
     * @param integer $value Property value
     *
     * @return null
     */
    public function setDestination($value)
    {
        return $this->set(self::DESTINATION, $value);
    }

    /**
     * Returns value of 'destination' property
     *
     * @return integer
     */
    public function getDestination()
    {
        $value = $this->get(self::DESTINATION);
        return $value === null ? (integer)$value : $value;
    }

    /**
     * Returns true if 'destination' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasDestination()
    {
        return $this->get(self::DESTINATION) !== null;
    }

    /**
     * Sets value of 'des_id' property
     *
     * @param integer $value Property value
     *
     * @return null
     */
    public function setDesId($value)
    {
        return $this->set(self::DES_ID, $value);
    }

    /**
     * Returns value of 'des_id' property
     *
     * @return integer
     */
    public function getDesId()
    {
        $value = $this->get(self::DES_ID);
        return $value === null ? (integer)$value : $value;
    }

    /**
     * Returns true if 'des_id' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasDesId()
    {
        return $this->get(self::DES_ID) !== null;
    }

    /**
     * Sets value of 'session_id' property
     *
     * @param integer $value Property value
     *
     * @return null
     */
    public function setSessionId($value)
    {
        return $this->set(self::SESSION_ID, $value);
    }

    /**
     * Returns value of 'session_id' property
     *
     * @return integer
     */
    public function getSessionId()
    {
        $value = $this->get(self::SESSION_ID);
        return $value === null ? (integer)$value : $value;
    }

    /**
     * Returns true if 'session_id' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasSessionId()
    {
        return $this->get(self::SESSION_ID) !== null;
    }

    /**
     * Sets value of 'mtype' property
     *
     * @param integer $value Property value
     *
     * @return null
     */
    public function setMtype($value)
    {
        return $this->set(self::MTYPE, $value);
    }

    /**
     * Returns value of 'mtype' property
     *
     * @return integer
     */
    public function getMtype()
    {
        $value = $this->get(self::MTYPE);
        return $value === null ? (integer)$value : $value;
    }

    /**
     * Returns true if 'mtype' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasMtype()
    {
        return $this->get(self::MTYPE) !== null;
    }

    /**
     * Sets value of 'uid' property
     *
     * @param integer $value Property value
     *
     * @return null
     */
    public function setUid($value)
    {
        return $this->set(self::UID, $value);
    }

    /**
     * Returns value of 'uid' property
     *
     * @return integer
     */
    public function getUid()
    {
        $value = $this->get(self::UID);
        return $value === null ? (integer)$value : $value;
    }

    /**
     * Returns true if 'uid' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasUid()
    {
        return $this->get(self::UID) !== null;
    }

    /**
     * Sets value of 'route_type' property
     *
     * @param integer $value Property value
     *
     * @return null
     */
    public function setRouteType($value)
    {
        return $this->set(self::ROUTE_TYPE, $value);
    }

    /**
     * Returns value of 'route_type' property
     *
     * @return integer
     */
    public function getRouteType()
    {
        $value = $this->get(self::ROUTE_TYPE);
        return $value === null ? (integer)$value : $value;
    }

    /**
     * Returns true if 'route_type' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasRouteType()
    {
        return $this->get(self::ROUTE_TYPE) !== null;
    }

    /**
     * Sets value of 'groupid' property
     *
     * @param integer $value Property value
     *
     * @return null
     */
    public function setGroupid($value)
    {
        return $this->set(self::GROUPID, $value);
    }

    /**
     * Returns value of 'groupid' property
     *
     * @return integer
     */
    public function getGroupid()
    {
        $value = $this->get(self::GROUPID);
        return $value === null ? (integer)$value : $value;
    }

    /**
     * Returns true if 'groupid' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasGroupid()
    {
        return $this->get(self::GROUPID) !== null;
    }
}
}