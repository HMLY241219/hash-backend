<?php
/**
 * Auto generated from poker_msg_basic.proto at 2023-06-08 09:49:25
 */

namespace {
/**
 * CSDssPlayerInfo message
 */
class CSDssPlayerInfo extends \ProtobufMessage
{
    /* Field index constants */
    const UID = 1;
    const INDEX = 2;
    const NICK = 3;
    const MULTIPLE = 4;
    const DEST_CARD = 5;
    const SCORE = 6;
    const HAND_CARDS_INFO = 7;
    const OUT_COLS = 8;
    const BASIC_SCORE = 9;
    const COINS = 10;
    const TOTAL_SCORE = 11;
    const WIN_TYPE = 12;

    /* @var array Field descriptors */
    protected static $fields = array(
        self::UID => array(
            'name' => 'uid',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_INT,
        ),
        self::INDEX => array(
            'name' => 'index',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_INT,
        ),
        self::NICK => array(
            'name' => 'nick',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_STRING,
        ),
        self::MULTIPLE => array(
            'name' => 'multiple',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_INT,
        ),
        self::DEST_CARD => array(
            'name' => 'dest_card',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_INT,
        ),
        self::SCORE => array(
            'name' => 'score',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_INT,
        ),
        self::HAND_CARDS_INFO => array(
            'name' => 'hand_cards_info',
            'required' => false,
            'type' => '\CSHandCardsInfo'
        ),
        self::OUT_COLS => array(
            'name' => 'out_cols',
            'repeated' => true,
            'type' => '\PBDSSColumnInfo'
        ),
        self::BASIC_SCORE => array(
            'name' => 'basic_score',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_INT,
        ),
        self::COINS => array(
            'name' => 'coins',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_INT,
        ),
        self::TOTAL_SCORE => array(
            'name' => 'total_score',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_INT,
        ),
        self::WIN_TYPE => array(
            'name' => 'win_type',
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
        $this->values[self::UID] = null;
        $this->values[self::INDEX] = null;
        $this->values[self::NICK] = null;
        $this->values[self::MULTIPLE] = null;
        $this->values[self::DEST_CARD] = null;
        $this->values[self::SCORE] = null;
        $this->values[self::HAND_CARDS_INFO] = null;
        $this->values[self::OUT_COLS] = array();
        $this->values[self::BASIC_SCORE] = null;
        $this->values[self::COINS] = null;
        $this->values[self::TOTAL_SCORE] = null;
        $this->values[self::WIN_TYPE] = null;
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
     * Sets value of 'index' property
     *
     * @param integer $value Property value
     *
     * @return null
     */
    public function setIndex($value)
    {
        return $this->set(self::INDEX, $value);
    }

    /**
     * Returns value of 'index' property
     *
     * @return integer
     */
    public function getIndex()
    {
        $value = $this->get(self::INDEX);
        return $value === null ? (integer)$value : $value;
    }

    /**
     * Returns true if 'index' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasIndex()
    {
        return $this->get(self::INDEX) !== null;
    }

    /**
     * Sets value of 'nick' property
     *
     * @param string $value Property value
     *
     * @return null
     */
    public function setNick($value)
    {
        return $this->set(self::NICK, $value);
    }

    /**
     * Returns value of 'nick' property
     *
     * @return string
     */
    public function getNick()
    {
        $value = $this->get(self::NICK);
        return $value === null ? (string)$value : $value;
    }

    /**
     * Returns true if 'nick' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasNick()
    {
        return $this->get(self::NICK) !== null;
    }

    /**
     * Sets value of 'multiple' property
     *
     * @param integer $value Property value
     *
     * @return null
     */
    public function setMultiple($value)
    {
        return $this->set(self::MULTIPLE, $value);
    }

    /**
     * Returns value of 'multiple' property
     *
     * @return integer
     */
    public function getMultiple()
    {
        $value = $this->get(self::MULTIPLE);
        return $value === null ? (integer)$value : $value;
    }

    /**
     * Returns true if 'multiple' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasMultiple()
    {
        return $this->get(self::MULTIPLE) !== null;
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
     * Sets value of 'score' property
     *
     * @param integer $value Property value
     *
     * @return null
     */
    public function setScore($value)
    {
        return $this->set(self::SCORE, $value);
    }

    /**
     * Returns value of 'score' property
     *
     * @return integer
     */
    public function getScore()
    {
        $value = $this->get(self::SCORE);
        return $value === null ? (integer)$value : $value;
    }

    /**
     * Returns true if 'score' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasScore()
    {
        return $this->get(self::SCORE) !== null;
    }

    /**
     * Sets value of 'hand_cards_info' property
     *
     * @param \CSHandCardsInfo $value Property value
     *
     * @return null
     */
    public function setHandCardsInfo(\CSHandCardsInfo $value=null)
    {
        return $this->set(self::HAND_CARDS_INFO, $value);
    }

    /**
     * Returns value of 'hand_cards_info' property
     *
     * @return \CSHandCardsInfo
     */
    public function getHandCardsInfo()
    {
        return $this->get(self::HAND_CARDS_INFO);
    }

    /**
     * Returns true if 'hand_cards_info' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasHandCardsInfo()
    {
        return $this->get(self::HAND_CARDS_INFO) !== null;
    }

    /**
     * Appends value to 'out_cols' list
     *
     * @param \PBDSSColumnInfo $value Value to append
     *
     * @return null
     */
    public function appendOutCols(\PBDSSColumnInfo $value)
    {
        return $this->append(self::OUT_COLS, $value);
    }

    /**
     * Clears 'out_cols' list
     *
     * @return null
     */
    public function clearOutCols()
    {
        return $this->clear(self::OUT_COLS);
    }

    /**
     * Returns 'out_cols' list
     *
     * @return \PBDSSColumnInfo[]
     */
    public function getOutCols()
    {
        return $this->get(self::OUT_COLS);
    }

    /**
     * Returns true if 'out_cols' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasOutCols()
    {
        return count($this->get(self::OUT_COLS)) !== 0;
    }

    /**
     * Returns 'out_cols' iterator
     *
     * @return \ArrayIterator
     */
    public function getOutColsIterator()
    {
        return new \ArrayIterator($this->get(self::OUT_COLS));
    }

    /**
     * Returns element from 'out_cols' list at given offset
     *
     * @param int $offset Position in list
     *
     * @return \PBDSSColumnInfo
     */
    public function getOutColsAt($offset)
    {
        return $this->get(self::OUT_COLS, $offset);
    }

    /**
     * Returns count of 'out_cols' list
     *
     * @return int
     */
    public function getOutColsCount()
    {
        return $this->count(self::OUT_COLS);
    }

    /**
     * Sets value of 'basic_score' property
     *
     * @param integer $value Property value
     *
     * @return null
     */
    public function setBasicScore($value)
    {
        return $this->set(self::BASIC_SCORE, $value);
    }

    /**
     * Returns value of 'basic_score' property
     *
     * @return integer
     */
    public function getBasicScore()
    {
        $value = $this->get(self::BASIC_SCORE);
        return $value === null ? (integer)$value : $value;
    }

    /**
     * Returns true if 'basic_score' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasBasicScore()
    {
        return $this->get(self::BASIC_SCORE) !== null;
    }

    /**
     * Sets value of 'coins' property
     *
     * @param integer $value Property value
     *
     * @return null
     */
    public function setCoins($value)
    {
        return $this->set(self::COINS, $value);
    }

    /**
     * Returns value of 'coins' property
     *
     * @return integer
     */
    public function getCoins()
    {
        $value = $this->get(self::COINS);
        return $value === null ? (integer)$value : $value;
    }

    /**
     * Returns true if 'coins' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasCoins()
    {
        return $this->get(self::COINS) !== null;
    }

    /**
     * Sets value of 'total_score' property
     *
     * @param integer $value Property value
     *
     * @return null
     */
    public function setTotalScore($value)
    {
        return $this->set(self::TOTAL_SCORE, $value);
    }

    /**
     * Returns value of 'total_score' property
     *
     * @return integer
     */
    public function getTotalScore()
    {
        $value = $this->get(self::TOTAL_SCORE);
        return $value === null ? (integer)$value : $value;
    }

    /**
     * Returns true if 'total_score' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasTotalScore()
    {
        return $this->get(self::TOTAL_SCORE) !== null;
    }

    /**
     * Sets value of 'win_type' property
     *
     * @param integer $value Property value
     *
     * @return null
     */
    public function setWinType($value)
    {
        return $this->set(self::WIN_TYPE, $value);
    }

    /**
     * Returns value of 'win_type' property
     *
     * @return integer
     */
    public function getWinType()
    {
        $value = $this->get(self::WIN_TYPE);
        return $value === null ? (integer)$value : $value;
    }

    /**
     * Returns true if 'win_type' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasWinType()
    {
        return $this->get(self::WIN_TYPE) !== null;
    }
}
}