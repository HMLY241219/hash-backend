<?php
/**
 * Auto generated from poker_msg_ss.proto at 2023-06-08 09:49:25
 */

namespace {
/**
 * SSRegistInnerServer message
 */
class SSRegistInnerServer extends \ProtobufMessage
{
    /* Field index constants */
    const NTYPE = 1;
    const NVID = 2;
    const GROUP_ID = 3;

    /* @var array Field descriptors */
    protected static $fields = array(
        self::NTYPE => array(
            'name' => 'ntype',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_INT,
        ),
        self::NVID => array(
            'name' => 'nvid',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_INT,
        ),
        self::GROUP_ID => array(
            'name' => 'group_id',
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
        $this->values[self::NTYPE] = null;
        $this->values[self::NVID] = null;
        $this->values[self::GROUP_ID] = null;
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
     * Sets value of 'ntype' property
     *
     * @param integer $value Property value
     *
     * @return null
     */
    public function setNtype($value)
    {
        return $this->set(self::NTYPE, $value);
    }

    /**
     * Returns value of 'ntype' property
     *
     * @return integer
     */
    public function getNtype()
    {
        $value = $this->get(self::NTYPE);
        return $value === null ? (integer)$value : $value;
    }

    /**
     * Returns true if 'ntype' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasNtype()
    {
        return $this->get(self::NTYPE) !== null;
    }

    /**
     * Sets value of 'nvid' property
     *
     * @param integer $value Property value
     *
     * @return null
     */
    public function setNvid($value)
    {
        return $this->set(self::NVID, $value);
    }

    /**
     * Returns value of 'nvid' property
     *
     * @return integer
     */
    public function getNvid()
    {
        $value = $this->get(self::NVID);
        return $value === null ? (integer)$value : $value;
    }

    /**
     * Returns true if 'nvid' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasNvid()
    {
        return $this->get(self::NVID) !== null;
    }

    /**
     * Sets value of 'group_id' property
     *
     * @param integer $value Property value
     *
     * @return null
     */
    public function setGroupId($value)
    {
        return $this->set(self::GROUP_ID, $value);
    }

    /**
     * Returns value of 'group_id' property
     *
     * @return integer
     */
    public function getGroupId()
    {
        $value = $this->get(self::GROUP_ID);
        return $value === null ? (integer)$value : $value;
    }

    /**
     * Returns true if 'group_id' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasGroupId()
    {
        return $this->get(self::GROUP_ID) !== null;
    }
}
}