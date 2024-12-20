<?php
/**
 * Auto generated from poker_msg_cs.proto at 2023-06-08 09:49:25
 */

namespace {
/**
 * CSRequestDSSDoAction message
 */
class CSRequestDSSDoAction extends \ProtobufMessage
{
    /* Field index constants */
    const SEAT_INDEX = 1;
    const ACT_TYPE = 2;
    const DEST_CARD = 3;
    const CARDS = 4;
    const TOKEN = 5;
    const ADD_MULTIPLE = 6;
    const COMPARE_INDEX = 7;
    const IS_NA_PAI_OUT_CARD = 8;
    const HAND_GROUP_INFO = 9;
    const ADD_TYPE = 10;

    /* @var array Field descriptors */
    protected static $fields = array(
        self::SEAT_INDEX => array(
            'name' => 'seat_index',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_INT,
        ),
        self::ACT_TYPE => array(
            'name' => 'act_type',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_INT,
        ),
        self::DEST_CARD => array(
            'name' => 'dest_card',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_INT,
        ),
        self::CARDS => array(
            'name' => 'cards',
            'repeated' => true,
            'type' => \ProtobufMessage::PB_TYPE_INT,
        ),
        self::TOKEN => array(
            'name' => 'token',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_INT,
        ),
        self::ADD_MULTIPLE => array(
            'name' => 'add_multiple',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_INT,
        ),
        self::COMPARE_INDEX => array(
            'name' => 'compare_index',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_INT,
        ),
        self::IS_NA_PAI_OUT_CARD => array(
            'name' => 'is_na_pai_out_card',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_BOOL,
        ),
        self::HAND_GROUP_INFO => array(
            'name' => 'hand_group_info',
            'repeated' => true,
            'type' => '\PBDSSColumnInfo'
        ),
        self::ADD_TYPE => array(
            'name' => 'add_type',
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
        $this->values[self::SEAT_INDEX] = null;
        $this->values[self::ACT_TYPE] = null;
        $this->values[self::DEST_CARD] = null;
        $this->values[self::CARDS] = array();
        $this->values[self::TOKEN] = null;
        $this->values[self::ADD_MULTIPLE] = null;
        $this->values[self::COMPARE_INDEX] = null;
        $this->values[self::IS_NA_PAI_OUT_CARD] = null;
        $this->values[self::HAND_GROUP_INFO] = array();
        $this->values[self::ADD_TYPE] = null;
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
     * Sets value of 'seat_index' property
     *
     * @param integer $value Property value
     *
     * @return null
     */
    public function setSeatIndex($value)
    {
        return $this->set(self::SEAT_INDEX, $value);
    }

    /**
     * Returns value of 'seat_index' property
     *
     * @return integer
     */
    public function getSeatIndex()
    {
        $value = $this->get(self::SEAT_INDEX);
        return $value === null ? (integer)$value : $value;
    }

    /**
     * Returns true if 'seat_index' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasSeatIndex()
    {
        return $this->get(self::SEAT_INDEX) !== null;
    }

    /**
     * Sets value of 'act_type' property
     *
     * @param integer $value Property value
     *
     * @return null
     */
    public function setActType($value)
    {
        return $this->set(self::ACT_TYPE, $value);
    }

    /**
     * Returns value of 'act_type' property
     *
     * @return integer
     */
    public function getActType()
    {
        $value = $this->get(self::ACT_TYPE);
        return $value === null ? (integer)$value : $value;
    }

    /**
     * Returns true if 'act_type' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasActType()
    {
        return $this->get(self::ACT_TYPE) !== null;
    }

    /**
     * Sets value of 'dest_card' property
     *
     * @param integer $value Property value
     *
     * @return null
     */
    public function setDestCard($value)
    {
        return $this->set(self::DEST_CARD, $value);
    }

    /**
     * Returns value of 'dest_card' property
     *
     * @return integer
     */
    public function getDestCard()
    {
        $value = $this->get(self::DEST_CARD);
        return $value === null ? (integer)$value : $value;
    }

    /**
     * Returns true if 'dest_card' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasDestCard()
    {
        return $this->get(self::DEST_CARD) !== null;
    }

    /**
     * Appends value to 'cards' list
     *
     * @param integer $value Value to append
     *
     * @return null
     */
    public function appendCards($value)
    {
        return $this->append(self::CARDS, $value);
    }

    /**
     * Clears 'cards' list
     *
     * @return null
     */
    public function clearCards()
    {
        return $this->clear(self::CARDS);
    }

    /**
     * Returns 'cards' list
     *
     * @return integer[]
     */
    public function getCards()
    {
        return $this->get(self::CARDS);
    }

    /**
     * Returns true if 'cards' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasCards()
    {
        return count($this->get(self::CARDS)) !== 0;
    }

    /**
     * Returns 'cards' iterator
     *
     * @return \ArrayIterator
     */
    public function getCardsIterator()
    {
        return new \ArrayIterator($this->get(self::CARDS));
    }

    /**
     * Returns element from 'cards' list at given offset
     *
     * @param int $offset Position in list
     *
     * @return integer
     */
    public function getCardsAt($offset)
    {
        return $this->get(self::CARDS, $offset);
    }

    /**
     * Returns count of 'cards' list
     *
     * @return int
     */
    public function getCardsCount()
    {
        return $this->count(self::CARDS);
    }

    /**
     * Sets value of 'token' property
     *
     * @param integer $value Property value
     *
     * @return null
     */
    public function setToken($value)
    {
        return $this->set(self::TOKEN, $value);
    }

    /**
     * Returns value of 'token' property
     *
     * @return integer
     */
    public function getToken()
    {
        $value = $this->get(self::TOKEN);
        return $value === null ? (integer)$value : $value;
    }

    /**
     * Returns true if 'token' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasToken()
    {
        return $this->get(self::TOKEN) !== null;
    }

    /**
     * Sets value of 'add_multiple' property
     *
     * @param integer $value Property value
     *
     * @return null
     */
    public function setAddMultiple($value)
    {
        return $this->set(self::ADD_MULTIPLE, $value);
    }

    /**
     * Returns value of 'add_multiple' property
     *
     * @return integer
     */
    public function getAddMultiple()
    {
        $value = $this->get(self::ADD_MULTIPLE);
        return $value === null ? (integer)$value : $value;
    }

    /**
     * Returns true if 'add_multiple' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasAddMultiple()
    {
        return $this->get(self::ADD_MULTIPLE) !== null;
    }

    /**
     * Sets value of 'compare_index' property
     *
     * @param integer $value Property value
     *
     * @return null
     */
    public function setCompareIndex($value)
    {
        return $this->set(self::COMPARE_INDEX, $value);
    }

    /**
     * Returns value of 'compare_index' property
     *
     * @return integer
     */
    public function getCompareIndex()
    {
        $value = $this->get(self::COMPARE_INDEX);
        return $value === null ? (integer)$value : $value;
    }

    /**
     * Returns true if 'compare_index' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasCompareIndex()
    {
        return $this->get(self::COMPARE_INDEX) !== null;
    }

    /**
     * Sets value of 'is_na_pai_out_card' property
     *
     * @param boolean $value Property value
     *
     * @return null
     */
    public function setIsNaPaiOutCard($value)
    {
        return $this->set(self::IS_NA_PAI_OUT_CARD, $value);
    }

    /**
     * Returns value of 'is_na_pai_out_card' property
     *
     * @return boolean
     */
    public function getIsNaPaiOutCard()
    {
        $value = $this->get(self::IS_NA_PAI_OUT_CARD);
        return $value === null ? (boolean)$value : $value;
    }

    /**
     * Returns true if 'is_na_pai_out_card' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasIsNaPaiOutCard()
    {
        return $this->get(self::IS_NA_PAI_OUT_CARD) !== null;
    }

    /**
     * Appends value to 'hand_group_info' list
     *
     * @param \PBDSSColumnInfo $value Value to append
     *
     * @return null
     */
    public function appendHandGroupInfo(\PBDSSColumnInfo $value)
    {
        return $this->append(self::HAND_GROUP_INFO, $value);
    }

    /**
     * Clears 'hand_group_info' list
     *
     * @return null
     */
    public function clearHandGroupInfo()
    {
        return $this->clear(self::HAND_GROUP_INFO);
    }

    /**
     * Returns 'hand_group_info' list
     *
     * @return \PBDSSColumnInfo[]
     */
    public function getHandGroupInfo()
    {
        return $this->get(self::HAND_GROUP_INFO);
    }

    /**
     * Returns true if 'hand_group_info' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasHandGroupInfo()
    {
        return count($this->get(self::HAND_GROUP_INFO)) !== 0;
    }

    /**
     * Returns 'hand_group_info' iterator
     *
     * @return \ArrayIterator
     */
    public function getHandGroupInfoIterator()
    {
        return new \ArrayIterator($this->get(self::HAND_GROUP_INFO));
    }

    /**
     * Returns element from 'hand_group_info' list at given offset
     *
     * @param int $offset Position in list
     *
     * @return \PBDSSColumnInfo
     */
    public function getHandGroupInfoAt($offset)
    {
        return $this->get(self::HAND_GROUP_INFO, $offset);
    }

    /**
     * Returns count of 'hand_group_info' list
     *
     * @return int
     */
    public function getHandGroupInfoCount()
    {
        return $this->count(self::HAND_GROUP_INFO);
    }

    /**
     * Sets value of 'add_type' property
     *
     * @param integer $value Property value
     *
     * @return null
     */
    public function setAddType($value)
    {
        return $this->set(self::ADD_TYPE, $value);
    }

    /**
     * Returns value of 'add_type' property
     *
     * @return integer
     */
    public function getAddType()
    {
        $value = $this->get(self::ADD_TYPE);
        return $value === null ? (integer)$value : $value;
    }

    /**
     * Returns true if 'add_type' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasAddType()
    {
        return $this->get(self::ADD_TYPE) !== null;
    }
}
}