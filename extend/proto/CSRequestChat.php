<?php
/**
 * Auto generated from poker_msg_cs.proto at 2023-06-08 09:49:25
 */

namespace {
/**
 * CSRequestChat message
 */
class CSRequestChat extends \ProtobufMessage
{
    /* Field index constants */
    const CTYPE = 1;
    const MESSAGE = 2;
    const BIGFACECHANNEL = 3;
    const BIGFACEID = 4;

    /* @var array Field descriptors */
    protected static $fields = array(
        self::CTYPE => array(
            'name' => 'ctype',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_INT,
        ),
        self::MESSAGE => array(
            'name' => 'message',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_STRING,
        ),
        self::BIGFACECHANNEL => array(
            'name' => 'BigFaceChannel',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_INT,
        ),
        self::BIGFACEID => array(
            'name' => 'BigFaceID',
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
        $this->values[self::CTYPE] = null;
        $this->values[self::MESSAGE] = null;
        $this->values[self::BIGFACECHANNEL] = null;
        $this->values[self::BIGFACEID] = null;
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
     * Sets value of 'ctype' property
     *
     * @param integer $value Property value
     *
     * @return null
     */
    public function setCtype($value)
    {
        return $this->set(self::CTYPE, $value);
    }

    /**
     * Returns value of 'ctype' property
     *
     * @return integer
     */
    public function getCtype()
    {
        $value = $this->get(self::CTYPE);
        return $value === null ? (integer)$value : $value;
    }

    /**
     * Returns true if 'ctype' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasCtype()
    {
        return $this->get(self::CTYPE) !== null;
    }

    /**
     * Sets value of 'message' property
     *
     * @param string $value Property value
     *
     * @return null
     */
    public function setMessage($value)
    {
        return $this->set(self::MESSAGE, $value);
    }

    /**
     * Returns value of 'message' property
     *
     * @return string
     */
    public function getMessage()
    {
        $value = $this->get(self::MESSAGE);
        return $value === null ? (string)$value : $value;
    }

    /**
     * Returns true if 'message' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasMessage()
    {
        return $this->get(self::MESSAGE) !== null;
    }

    /**
     * Sets value of 'BigFaceChannel' property
     *
     * @param integer $value Property value
     *
     * @return null
     */
    public function setBigFaceChannel($value)
    {
        return $this->set(self::BIGFACECHANNEL, $value);
    }

    /**
     * Returns value of 'BigFaceChannel' property
     *
     * @return integer
     */
    public function getBigFaceChannel()
    {
        $value = $this->get(self::BIGFACECHANNEL);
        return $value === null ? (integer)$value : $value;
    }

    /**
     * Returns true if 'BigFaceChannel' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasBigFaceChannel()
    {
        return $this->get(self::BIGFACECHANNEL) !== null;
    }

    /**
     * Sets value of 'BigFaceID' property
     *
     * @param integer $value Property value
     *
     * @return null
     */
    public function setBigFaceID($value)
    {
        return $this->set(self::BIGFACEID, $value);
    }

    /**
     * Returns value of 'BigFaceID' property
     *
     * @return integer
     */
    public function getBigFaceID()
    {
        $value = $this->get(self::BIGFACEID);
        return $value === null ? (integer)$value : $value;
    }

    /**
     * Returns true if 'BigFaceID' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasBigFaceID()
    {
        return $this->get(self::BIGFACEID) !== null;
    }
}
}