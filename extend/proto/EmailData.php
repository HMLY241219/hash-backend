<?php
/**
 * Auto generated from poker_data.proto at 2023-06-08 09:49:25
 */

namespace {
/**
 * EmailData message
 */
class EmailData extends \ProtobufMessage
{
    /* Field index constants */
    const EMAIL_ID = 1;
    const EMAIL_TYPE = 2;
    const TITLE = 3;
    const TEXT = 4;
    const STATE = 5;
    const ITEM_STATE = 6;
    const ITEM = 7;
    const REASON = 8;
    const TIME_STAMP = 9;

    /* @var array Field descriptors */
    protected static $fields = array(
        self::EMAIL_ID => array(
            'name' => 'email_id',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_INT,
        ),
        self::EMAIL_TYPE => array(
            'name' => 'email_type',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_INT,
        ),
        self::TITLE => array(
            'name' => 'title',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_STRING,
        ),
        self::TEXT => array(
            'name' => 'text',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_STRING,
        ),
        self::STATE => array(
            'name' => 'state',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_BOOL,
        ),
        self::ITEM_STATE => array(
            'name' => 'item_state',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_BOOL,
        ),
        self::ITEM => array(
            'name' => 'item',
            'repeated' => true,
            'type' => '\PBItem'
        ),
        self::REASON => array(
            'name' => 'reason',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_INT,
        ),
        self::TIME_STAMP => array(
            'name' => 'time_stamp',
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
        $this->values[self::EMAIL_ID] = null;
        $this->values[self::EMAIL_TYPE] = null;
        $this->values[self::TITLE] = null;
        $this->values[self::TEXT] = null;
        $this->values[self::STATE] = null;
        $this->values[self::ITEM_STATE] = null;
        $this->values[self::ITEM] = array();
        $this->values[self::REASON] = null;
        $this->values[self::TIME_STAMP] = null;
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

    /**
     * Sets value of 'email_type' property
     *
     * @param integer $value Property value
     *
     * @return null
     */
    public function setEmailType($value)
    {
        return $this->set(self::EMAIL_TYPE, $value);
    }

    /**
     * Returns value of 'email_type' property
     *
     * @return integer
     */
    public function getEmailType()
    {
        $value = $this->get(self::EMAIL_TYPE);
        return $value === null ? (integer)$value : $value;
    }

    /**
     * Returns true if 'email_type' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasEmailType()
    {
        return $this->get(self::EMAIL_TYPE) !== null;
    }

    /**
     * Sets value of 'title' property
     *
     * @param string $value Property value
     *
     * @return null
     */
    public function setTitle($value)
    {
        return $this->set(self::TITLE, $value);
    }

    /**
     * Returns value of 'title' property
     *
     * @return string
     */
    public function getTitle()
    {
        $value = $this->get(self::TITLE);
        return $value === null ? (string)$value : $value;
    }

    /**
     * Returns true if 'title' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasTitle()
    {
        return $this->get(self::TITLE) !== null;
    }

    /**
     * Sets value of 'text' property
     *
     * @param string $value Property value
     *
     * @return null
     */
    public function setText($value)
    {
        return $this->set(self::TEXT, $value);
    }

    /**
     * Returns value of 'text' property
     *
     * @return string
     */
    public function getText()
    {
        $value = $this->get(self::TEXT);
        return $value === null ? (string)$value : $value;
    }

    /**
     * Returns true if 'text' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasText()
    {
        return $this->get(self::TEXT) !== null;
    }

    /**
     * Sets value of 'state' property
     *
     * @param boolean $value Property value
     *
     * @return null
     */
    public function setState($value)
    {
        return $this->set(self::STATE, $value);
    }

    /**
     * Returns value of 'state' property
     *
     * @return boolean
     */
    public function getState()
    {
        $value = $this->get(self::STATE);
        return $value === null ? (boolean)$value : $value;
    }

    /**
     * Returns true if 'state' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasState()
    {
        return $this->get(self::STATE) !== null;
    }

    /**
     * Sets value of 'item_state' property
     *
     * @param boolean $value Property value
     *
     * @return null
     */
    public function setItemState($value)
    {
        return $this->set(self::ITEM_STATE, $value);
    }

    /**
     * Returns value of 'item_state' property
     *
     * @return boolean
     */
    public function getItemState()
    {
        $value = $this->get(self::ITEM_STATE);
        return $value === null ? (boolean)$value : $value;
    }

    /**
     * Returns true if 'item_state' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasItemState()
    {
        return $this->get(self::ITEM_STATE) !== null;
    }

    /**
     * Appends value to 'item' list
     *
     * @param \PBItem $value Value to append
     *
     * @return null
     */
    public function appendItem(\PBItem $value)
    {
        return $this->append(self::ITEM, $value);
    }

    /**
     * Clears 'item' list
     *
     * @return null
     */
    public function clearItem()
    {
        return $this->clear(self::ITEM);
    }

    /**
     * Returns 'item' list
     *
     * @return \PBItem[]
     */
    public function getItem()
    {
        return $this->get(self::ITEM);
    }

    /**
     * Returns true if 'item' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasItem()
    {
        return count($this->get(self::ITEM)) !== 0;
    }

    /**
     * Returns 'item' iterator
     *
     * @return \ArrayIterator
     */
    public function getItemIterator()
    {
        return new \ArrayIterator($this->get(self::ITEM));
    }

    /**
     * Returns element from 'item' list at given offset
     *
     * @param int $offset Position in list
     *
     * @return \PBItem
     */
    public function getItemAt($offset)
    {
        return $this->get(self::ITEM, $offset);
    }

    /**
     * Returns count of 'item' list
     *
     * @return int
     */
    public function getItemCount()
    {
        return $this->count(self::ITEM);
    }

    /**
     * Sets value of 'reason' property
     *
     * @param integer $value Property value
     *
     * @return null
     */
    public function setReason($value)
    {
        return $this->set(self::REASON, $value);
    }

    /**
     * Returns value of 'reason' property
     *
     * @return integer
     */
    public function getReason()
    {
        $value = $this->get(self::REASON);
        return $value === null ? (integer)$value : $value;
    }

    /**
     * Returns true if 'reason' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasReason()
    {
        return $this->get(self::REASON) !== null;
    }

    /**
     * Sets value of 'time_stamp' property
     *
     * @param integer $value Property value
     *
     * @return null
     */
    public function setTimeStamp($value)
    {
        return $this->set(self::TIME_STAMP, $value);
    }

    /**
     * Returns value of 'time_stamp' property
     *
     * @return integer
     */
    public function getTimeStamp()
    {
        $value = $this->get(self::TIME_STAMP);
        return $value === null ? (integer)$value : $value;
    }

    /**
     * Returns true if 'time_stamp' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasTimeStamp()
    {
        return $this->get(self::TIME_STAMP) !== null;
    }
}
}