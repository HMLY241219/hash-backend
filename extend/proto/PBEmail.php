<?php
/**
 * Auto generated from poker_data.proto at 2023-06-08 09:49:25
 */

namespace {
/**
 * PBEmail message
 */
class PBEmail extends \ProtobufMessage
{
    /* Field index constants */
    const NOW_EMAIL_ID = 1;
    const EMAIL_DATA = 2;

    /* @var array Field descriptors */
    protected static $fields = array(
        self::NOW_EMAIL_ID => array(
            'name' => 'now_email_id',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_INT,
        ),
        self::EMAIL_DATA => array(
            'name' => 'email_data',
            'repeated' => true,
            'type' => '\EmailData'
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
        $this->values[self::NOW_EMAIL_ID] = null;
        $this->values[self::EMAIL_DATA] = array();
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
     * Sets value of 'now_email_id' property
     *
     * @param integer $value Property value
     *
     * @return null
     */
    public function setNowEmailId($value)
    {
        return $this->set(self::NOW_EMAIL_ID, $value);
    }

    /**
     * Returns value of 'now_email_id' property
     *
     * @return integer
     */
    public function getNowEmailId()
    {
        $value = $this->get(self::NOW_EMAIL_ID);
        return $value === null ? (integer)$value : $value;
    }

    /**
     * Returns true if 'now_email_id' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasNowEmailId()
    {
        return $this->get(self::NOW_EMAIL_ID) !== null;
    }

    /**
     * Appends value to 'email_data' list
     *
     * @param \EmailData $value Value to append
     *
     * @return null
     */
    public function appendEmailData(\EmailData $value)
    {
        return $this->append(self::EMAIL_DATA, $value);
    }

    /**
     * Clears 'email_data' list
     *
     * @return null
     */
    public function clearEmailData()
    {
        return $this->clear(self::EMAIL_DATA);
    }

    /**
     * Returns 'email_data' list
     *
     * @return \EmailData[]
     */
    public function getEmailData()
    {
        return $this->get(self::EMAIL_DATA);
    }

    /**
     * Returns true if 'email_data' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasEmailData()
    {
        return count($this->get(self::EMAIL_DATA)) !== 0;
    }

    /**
     * Returns 'email_data' iterator
     *
     * @return \ArrayIterator
     */
    public function getEmailDataIterator()
    {
        return new \ArrayIterator($this->get(self::EMAIL_DATA));
    }

    /**
     * Returns element from 'email_data' list at given offset
     *
     * @param int $offset Position in list
     *
     * @return \EmailData
     */
    public function getEmailDataAt($offset)
    {
        return $this->get(self::EMAIL_DATA, $offset);
    }

    /**
     * Returns count of 'email_data' list
     *
     * @return int
     */
    public function getEmailDataCount()
    {
        return $this->count(self::EMAIL_DATA);
    }
}
}