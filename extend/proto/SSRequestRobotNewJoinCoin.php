<?php
/**
 * Auto generated from poker_msg_ss.proto at 2023-06-08 09:49:25
 */

namespace {
/**
 * SSRequestRobotNewJoinCoin message
 */
class SSRequestRobotNewJoinCoin extends \ProtobufMessage
{
    /* Field index constants */
    const ROBOT_NUM = 1;
    const SOURCE_INFO = 2;

    /* @var array Field descriptors */
    protected static $fields = array(
        self::ROBOT_NUM => array(
            'name' => 'robot_num',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_INT,
        ),
        self::SOURCE_INFO => array(
            'name' => 'source_info',
            'required' => false,
            'type' => '\PBSourceInfoRequestingRobot'
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
        $this->values[self::ROBOT_NUM] = null;
        $this->values[self::SOURCE_INFO] = null;
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
     * Sets value of 'robot_num' property
     *
     * @param integer $value Property value
     *
     * @return null
     */
    public function setRobotNum($value)
    {
        return $this->set(self::ROBOT_NUM, $value);
    }

    /**
     * Returns value of 'robot_num' property
     *
     * @return integer
     */
    public function getRobotNum()
    {
        $value = $this->get(self::ROBOT_NUM);
        return $value === null ? (integer)$value : $value;
    }

    /**
     * Returns true if 'robot_num' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasRobotNum()
    {
        return $this->get(self::ROBOT_NUM) !== null;
    }

    /**
     * Sets value of 'source_info' property
     *
     * @param \PBSourceInfoRequestingRobot $value Property value
     *
     * @return null
     */
    public function setSourceInfo(\PBSourceInfoRequestingRobot $value=null)
    {
        return $this->set(self::SOURCE_INFO, $value);
    }

    /**
     * Returns value of 'source_info' property
     *
     * @return \PBSourceInfoRequestingRobot
     */
    public function getSourceInfo()
    {
        return $this->get(self::SOURCE_INFO);
    }

    /**
     * Returns true if 'source_info' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasSourceInfo()
    {
        return $this->get(self::SOURCE_INFO) !== null;
    }
}
}