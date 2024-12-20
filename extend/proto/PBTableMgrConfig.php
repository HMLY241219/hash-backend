<?php
/**
 * Auto generated from poker_config.proto at 2023-06-08 09:49:25
 */

namespace {
/**
 * PBTableMgrConfig message
 */
class PBTableMgrConfig extends \ProtobufMessage
{
    /* Field index constants */
    const ZONES = 1;
    const NEED_ZONE_MANAGER = 2;
    const NEED_COMMON_MANAGER = 3;

    /* @var array Field descriptors */
    protected static $fields = array(
        self::ZONES => array(
            'name' => 'zones',
            'repeated' => true,
            'type' => '\PBTableZone'
        ),
        self::NEED_ZONE_MANAGER => array(
            'name' => 'need_zone_manager',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_BOOL,
        ),
        self::NEED_COMMON_MANAGER => array(
            'default' => true,
            'name' => 'need_common_manager',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_BOOL,
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
        $this->values[self::ZONES] = array();
        $this->values[self::NEED_ZONE_MANAGER] = null;
        $this->values[self::NEED_COMMON_MANAGER] = self::$fields[self::NEED_COMMON_MANAGER]['default'];
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
     * Appends value to 'zones' list
     *
     * @param \PBTableZone $value Value to append
     *
     * @return null
     */
    public function appendZones(\PBTableZone $value)
    {
        return $this->append(self::ZONES, $value);
    }

    /**
     * Clears 'zones' list
     *
     * @return null
     */
    public function clearZones()
    {
        return $this->clear(self::ZONES);
    }

    /**
     * Returns 'zones' list
     *
     * @return \PBTableZone[]
     */
    public function getZones()
    {
        return $this->get(self::ZONES);
    }

    /**
     * Returns true if 'zones' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasZones()
    {
        return count($this->get(self::ZONES)) !== 0;
    }

    /**
     * Returns 'zones' iterator
     *
     * @return \ArrayIterator
     */
    public function getZonesIterator()
    {
        return new \ArrayIterator($this->get(self::ZONES));
    }

    /**
     * Returns element from 'zones' list at given offset
     *
     * @param int $offset Position in list
     *
     * @return \PBTableZone
     */
    public function getZonesAt($offset)
    {
        return $this->get(self::ZONES, $offset);
    }

    /**
     * Returns count of 'zones' list
     *
     * @return int
     */
    public function getZonesCount()
    {
        return $this->count(self::ZONES);
    }

    /**
     * Sets value of 'need_zone_manager' property
     *
     * @param boolean $value Property value
     *
     * @return null
     */
    public function setNeedZoneManager($value)
    {
        return $this->set(self::NEED_ZONE_MANAGER, $value);
    }

    /**
     * Returns value of 'need_zone_manager' property
     *
     * @return boolean
     */
    public function getNeedZoneManager()
    {
        $value = $this->get(self::NEED_ZONE_MANAGER);
        return $value === null ? (boolean)$value : $value;
    }

    /**
     * Returns true if 'need_zone_manager' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasNeedZoneManager()
    {
        return $this->get(self::NEED_ZONE_MANAGER) !== null;
    }

    /**
     * Sets value of 'need_common_manager' property
     *
     * @param boolean $value Property value
     *
     * @return null
     */
    public function setNeedCommonManager($value)
    {
        return $this->set(self::NEED_COMMON_MANAGER, $value);
    }

    /**
     * Returns value of 'need_common_manager' property
     *
     * @return boolean
     */
    public function getNeedCommonManager()
    {
        $value = $this->get(self::NEED_COMMON_MANAGER);
        return $value === null ? (boolean)$value : $value;
    }

    /**
     * Returns true if 'need_common_manager' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasNeedCommonManager()
    {
        return $this->get(self::NEED_COMMON_MANAGER) !== null;
    }
}
}