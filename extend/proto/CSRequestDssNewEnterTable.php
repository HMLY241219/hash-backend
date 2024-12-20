<?php
/**
 * Auto generated from poker_msg_cs.proto at 2023-06-08 09:49:25
 */

namespace {
/**
 * CSRequestDssNewEnterTable message
 */
class CSRequestDssNewEnterTable extends \ProtobufMessage
{
    /* Field index constants */
    const TID = 1;
    const CONNECT_ID = 2;
    const ZTYPE = 3;
    const GAME_SVID = 4;
    const POS_TYPE = 5;
    const POSTYPE = 6;
    const USERINFO = 7;
    const TBID = 8;

    /* @var array Field descriptors */
    protected static $fields = array(
        self::TID => array(
            'name' => 'tid',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_INT,
        ),
        self::CONNECT_ID => array(
            'name' => 'connect_id',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_INT,
        ),
        self::ZTYPE => array(
            'default' => \ENZoneType::EN_Zone_SiChuan,
            'name' => 'ztype',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_INT,
        ),
        self::GAME_SVID => array(
            'name' => 'game_svid',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_INT,
        ),
        self::POS_TYPE => array(
            'name' => 'pos_type',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_INT,
        ),
        self::POSTYPE => array(
            'name' => 'postype',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_INT,
        ),
        self::USERINFO => array(
            'name' => 'userInfo',
            'required' => false,
            'type' => '\PBUser'
        ),
        self::TBID => array(
            'name' => 'tbid',
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
        $this->values[self::TID] = null;
        $this->values[self::CONNECT_ID] = null;
        $this->values[self::ZTYPE] = self::$fields[self::ZTYPE]['default'];
        $this->values[self::GAME_SVID] = null;
        $this->values[self::POS_TYPE] = null;
        $this->values[self::POSTYPE] = null;
        $this->values[self::USERINFO] = null;
        $this->values[self::TBID] = null;
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
     * Sets value of 'connect_id' property
     *
     * @param integer $value Property value
     *
     * @return null
     */
    public function setConnectId($value)
    {
        return $this->set(self::CONNECT_ID, $value);
    }

    /**
     * Returns value of 'connect_id' property
     *
     * @return integer
     */
    public function getConnectId()
    {
        $value = $this->get(self::CONNECT_ID);
        return $value === null ? (integer)$value : $value;
    }

    /**
     * Returns true if 'connect_id' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasConnectId()
    {
        return $this->get(self::CONNECT_ID) !== null;
    }

    /**
     * Sets value of 'ztype' property
     *
     * @param integer $value Property value
     *
     * @return null
     */
    public function setZtype($value)
    {
        return $this->set(self::ZTYPE, $value);
    }

    /**
     * Returns value of 'ztype' property
     *
     * @return integer
     */
    public function getZtype()
    {
        $value = $this->get(self::ZTYPE);
        return $value === null ? (integer)$value : $value;
    }

    /**
     * Returns true if 'ztype' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasZtype()
    {
        return $this->get(self::ZTYPE) !== null;
    }

    /**
     * Sets value of 'game_svid' property
     *
     * @param integer $value Property value
     *
     * @return null
     */
    public function setGameSvid($value)
    {
        return $this->set(self::GAME_SVID, $value);
    }

    /**
     * Returns value of 'game_svid' property
     *
     * @return integer
     */
    public function getGameSvid()
    {
        $value = $this->get(self::GAME_SVID);
        return $value === null ? (integer)$value : $value;
    }

    /**
     * Returns true if 'game_svid' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasGameSvid()
    {
        return $this->get(self::GAME_SVID) !== null;
    }

    /**
     * Sets value of 'pos_type' property
     *
     * @param integer $value Property value
     *
     * @return null
     */
    public function setPosType($value)
    {
        return $this->set(self::POS_TYPE, $value);
    }

    /**
     * Returns value of 'pos_type' property
     *
     * @return integer
     */
    public function getPosType()
    {
        $value = $this->get(self::POS_TYPE);
        return $value === null ? (integer)$value : $value;
    }

    /**
     * Returns true if 'pos_type' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasPosType()
    {
        return $this->get(self::POS_TYPE) !== null;
    }

    /**
     * Sets value of 'postype' property
     *
     * @param integer $value Property value
     *
     * @return null
     */
    public function setPostype($value)
    {
        return $this->set(self::POSTYPE, $value);
    }

    /**
     * Returns value of 'postype' property
     *
     * @return integer
     */
    public function getPostype()
    {
        $value = $this->get(self::POSTYPE);
        return $value === null ? (integer)$value : $value;
    }

    /**
     * Returns true if 'postype' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasPostype()
    {
        return $this->get(self::POSTYPE) !== null;
    }

    /**
     * Sets value of 'userInfo' property
     *
     * @param \PBUser $value Property value
     *
     * @return null
     */
    public function setUserInfo(\PBUser $value=null)
    {
        return $this->set(self::USERINFO, $value);
    }

    /**
     * Returns value of 'userInfo' property
     *
     * @return \PBUser
     */
    public function getUserInfo()
    {
        return $this->get(self::USERINFO);
    }

    /**
     * Returns true if 'userInfo' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasUserInfo()
    {
        return $this->get(self::USERINFO) !== null;
    }

    /**
     * Sets value of 'tbid' property
     *
     * @param integer $value Property value
     *
     * @return null
     */
    public function setTbid($value)
    {
        return $this->set(self::TBID, $value);
    }

    /**
     * Returns value of 'tbid' property
     *
     * @return integer
     */
    public function getTbid()
    {
        $value = $this->get(self::TBID);
        return $value === null ? (integer)$value : $value;
    }

    /**
     * Returns true if 'tbid' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasTbid()
    {
        return $this->get(self::TBID) !== null;
    }
}
}