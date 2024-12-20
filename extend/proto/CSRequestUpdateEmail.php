<?php
/**
 * Auto generated from poker_msg_cs.proto at 2023-06-08 09:49:25
 */

namespace {
/**
 * CSRequestUpdateEmail message
 */
class CSRequestUpdateEmail extends \ProtobufMessage
{
    /* Field index constants */
    const TYPE = 1;
    const EMAIL_ID = 2;

    /* @var array Field descriptors */
    protected static $fields = array(
        self::TYPE => array(
            'name' => 'type',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_INT,
        ),
        self::EMAIL_ID => array(
            'name' => 'email_id',
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
        $this->values[self::TYPE] = null;
        $this->values[self::EMAIL_ID] = null;
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
     * Sets value of 'type' property
     *
     * @param integer $value Property value
     *
     * @return null
     */
    public function setType($value)
    {
        return $this->set(self::TYPE, $value);
    }

    /**
     * Returns value of 'type' property
     *
     * @return integer
     */
    public function getType()
    {
        $value = $this->get(self::TYPE);
        return $value === null ? (integer)$value : $value;
    }

    /**
     * Returns true if 'type' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasType()
    {
        return $this->get(self::TYPE) !== null;
    }

    /**
     * Sets value of 'email_id' property
     *
     * @param integer $value Property value
     *
     * @return null
     */
    public function setEmailId($value)
    {
        return $this->set(self::EMAIL_ID, $value);
    }

    /**
     * Returns value of 'email_id' property
     *
     * @return integer
     */
    public function getEmailId()
    {
        $value = $this->get(self::EMAIL_ID);
        return $value === null ? (integer)$value : $value;
    }

    /**
     * Returns true if 'email_id' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasEmailId()
    {
        return $this->get(self::EMAIL_ID) !== null;
    }
}
}