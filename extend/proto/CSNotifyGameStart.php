<?php
/**
 * Auto generated from poker_msg_cs.proto at 2023-06-08 09:49:25
 */

namespace {
/**
 * CSNotifyGameStart message
 */
class CSNotifyGameStart extends \ProtobufMessage
{
    /* Field index constants */
    const LEFT_TILE_NUM = 2;
    const DEALER = 3;
    const ROUND = 4;
    const LEFT_CARD_NUM = 5;
    const DSS_SEATS = 6;
    const NOW_MULTIPLE = 7;
    const TABLE_NOW_MULTIPLE = 8;
    const QUAN_CARD = 9;
    const FAN_CARD = 10;
    const ALL_REWARD = 11;
    const OUT_CARDS = 12;
    const SEED_HASH = 13;
    const DAY_NUM = 14;
    const ROUND_HASH = 15;
    const PAY_OUT_0 = 16;
    const PAY_OUT_1 = 17;

    /* @var array Field descriptors */
    protected static $fields = array(
        self::LEFT_TILE_NUM => array(
            'name' => 'left_tile_num',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_INT,
        ),
        self::DEALER => array(
            'name' => 'dealer',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_INT,
        ),
        self::ROUND => array(
            'name' => 'round',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_INT,
        ),
        self::LEFT_CARD_NUM => array(
            'name' => 'left_card_num',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_INT,
        ),
        self::DSS_SEATS => array(
            'name' => 'dss_seats',
            'repeated' => true,
            'type' => '\PBDSSTableSeat'
        ),
        self::NOW_MULTIPLE => array(
            'name' => 'now_multiple',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_INT,
        ),
        self::TABLE_NOW_MULTIPLE => array(
            'name' => 'table_now_multiple',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_INT,
        ),
        self::QUAN_CARD => array(
            'name' => 'quan_card',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_INT,
        ),
        self::FAN_CARD => array(
            'name' => 'fan_card',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_INT,
        ),
        self::ALL_REWARD => array(
            'name' => 'all_reward',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_INT,
        ),
        self::OUT_CARDS => array(
            'name' => 'out_cards',
            'repeated' => true,
            'type' => \ProtobufMessage::PB_TYPE_INT,
        ),
        self::SEED_HASH => array(
            'name' => 'seed_hash',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_STRING,
        ),
        self::DAY_NUM => array(
            'name' => 'day_num',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_STRING,
        ),
        self::ROUND_HASH => array(
            'name' => 'round_hash',
            'repeated' => true,
            'type' => \ProtobufMessage::PB_TYPE_STRING,
        ),
        self::PAY_OUT_0 => array(
            'name' => 'pay_out_0',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_FLOAT,
        ),
        self::PAY_OUT_1 => array(
            'name' => 'pay_out_1',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_FLOAT,
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
        $this->values[self::LEFT_TILE_NUM] = null;
        $this->values[self::DEALER] = null;
        $this->values[self::ROUND] = null;
        $this->values[self::LEFT_CARD_NUM] = null;
        $this->values[self::DSS_SEATS] = array();
        $this->values[self::NOW_MULTIPLE] = null;
        $this->values[self::TABLE_NOW_MULTIPLE] = null;
        $this->values[self::QUAN_CARD] = null;
        $this->values[self::FAN_CARD] = null;
        $this->values[self::ALL_REWARD] = null;
        $this->values[self::OUT_CARDS] = array();
        $this->values[self::SEED_HASH] = null;
        $this->values[self::DAY_NUM] = null;
        $this->values[self::ROUND_HASH] = array();
        $this->values[self::PAY_OUT_0] = null;
        $this->values[self::PAY_OUT_1] = null;
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
     * Sets value of 'left_tile_num' property
     *
     * @param integer $value Property value
     *
     * @return null
     */
    public function setLeftTileNum($value)
    {
        return $this->set(self::LEFT_TILE_NUM, $value);
    }

    /**
     * Returns value of 'left_tile_num' property
     *
     * @return integer
     */
    public function getLeftTileNum()
    {
        $value = $this->get(self::LEFT_TILE_NUM);
        return $value === null ? (integer)$value : $value;
    }

    /**
     * Returns true if 'left_tile_num' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasLeftTileNum()
    {
        return $this->get(self::LEFT_TILE_NUM) !== null;
    }

    /**
     * Sets value of 'dealer' property
     *
     * @param integer $value Property value
     *
     * @return null
     */
    public function setDealer($value)
    {
        return $this->set(self::DEALER, $value);
    }

    /**
     * Returns value of 'dealer' property
     *
     * @return integer
     */
    public function getDealer()
    {
        $value = $this->get(self::DEALER);
        return $value === null ? (integer)$value : $value;
    }

    /**
     * Returns true if 'dealer' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasDealer()
    {
        return $this->get(self::DEALER) !== null;
    }

    /**
     * Sets value of 'round' property
     *
     * @param integer $value Property value
     *
     * @return null
     */
    public function setRound($value)
    {
        return $this->set(self::ROUND, $value);
    }

    /**
     * Returns value of 'round' property
     *
     * @return integer
     */
    public function getRound()
    {
        $value = $this->get(self::ROUND);
        return $value === null ? (integer)$value : $value;
    }

    /**
     * Returns true if 'round' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasRound()
    {
        return $this->get(self::ROUND) !== null;
    }

    /**
     * Sets value of 'left_card_num' property
     *
     * @param integer $value Property value
     *
     * @return null
     */
    public function setLeftCardNum($value)
    {
        return $this->set(self::LEFT_CARD_NUM, $value);
    }

    /**
     * Returns value of 'left_card_num' property
     *
     * @return integer
     */
    public function getLeftCardNum()
    {
        $value = $this->get(self::LEFT_CARD_NUM);
        return $value === null ? (integer)$value : $value;
    }

    /**
     * Returns true if 'left_card_num' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasLeftCardNum()
    {
        return $this->get(self::LEFT_CARD_NUM) !== null;
    }

    /**
     * Appends value to 'dss_seats' list
     *
     * @param \PBDSSTableSeat $value Value to append
     *
     * @return null
     */
    public function appendDssSeats(\PBDSSTableSeat $value)
    {
        return $this->append(self::DSS_SEATS, $value);
    }

    /**
     * Clears 'dss_seats' list
     *
     * @return null
     */
    public function clearDssSeats()
    {
        return $this->clear(self::DSS_SEATS);
    }

    /**
     * Returns 'dss_seats' list
     *
     * @return \PBDSSTableSeat[]
     */
    public function getDssSeats()
    {
        return $this->get(self::DSS_SEATS);
    }

    /**
     * Returns true if 'dss_seats' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasDssSeats()
    {
        return count($this->get(self::DSS_SEATS)) !== 0;
    }

    /**
     * Returns 'dss_seats' iterator
     *
     * @return \ArrayIterator
     */
    public function getDssSeatsIterator()
    {
        return new \ArrayIterator($this->get(self::DSS_SEATS));
    }

    /**
     * Returns element from 'dss_seats' list at given offset
     *
     * @param int $offset Position in list
     *
     * @return \PBDSSTableSeat
     */
    public function getDssSeatsAt($offset)
    {
        return $this->get(self::DSS_SEATS, $offset);
    }

    /**
     * Returns count of 'dss_seats' list
     *
     * @return int
     */
    public function getDssSeatsCount()
    {
        return $this->count(self::DSS_SEATS);
    }

    /**
     * Sets value of 'now_multiple' property
     *
     * @param integer $value Property value
     *
     * @return null
     */
    public function setNowMultiple($value)
    {
        return $this->set(self::NOW_MULTIPLE, $value);
    }

    /**
     * Returns value of 'now_multiple' property
     *
     * @return integer
     */
    public function getNowMultiple()
    {
        $value = $this->get(self::NOW_MULTIPLE);
        return $value === null ? (integer)$value : $value;
    }

    /**
     * Returns true if 'now_multiple' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasNowMultiple()
    {
        return $this->get(self::NOW_MULTIPLE) !== null;
    }

    /**
     * Sets value of 'table_now_multiple' property
     *
     * @param integer $value Property value
     *
     * @return null
     */
    public function setTableNowMultiple($value)
    {
        return $this->set(self::TABLE_NOW_MULTIPLE, $value);
    }

    /**
     * Returns value of 'table_now_multiple' property
     *
     * @return integer
     */
    public function getTableNowMultiple()
    {
        $value = $this->get(self::TABLE_NOW_MULTIPLE);
        return $value === null ? (integer)$value : $value;
    }

    /**
     * Returns true if 'table_now_multiple' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasTableNowMultiple()
    {
        return $this->get(self::TABLE_NOW_MULTIPLE) !== null;
    }

    /**
     * Sets value of 'quan_card' property
     *
     * @param integer $value Property value
     *
     * @return null
     */
    public function setQuanCard($value)
    {
        return $this->set(self::QUAN_CARD, $value);
    }

    /**
     * Returns value of 'quan_card' property
     *
     * @return integer
     */
    public function getQuanCard()
    {
        $value = $this->get(self::QUAN_CARD);
        return $value === null ? (integer)$value : $value;
    }

    /**
     * Returns true if 'quan_card' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasQuanCard()
    {
        return $this->get(self::QUAN_CARD) !== null;
    }

    /**
     * Sets value of 'fan_card' property
     *
     * @param integer $value Property value
     *
     * @return null
     */
    public function setFanCard($value)
    {
        return $this->set(self::FAN_CARD, $value);
    }

    /**
     * Returns value of 'fan_card' property
     *
     * @return integer
     */
    public function getFanCard()
    {
        $value = $this->get(self::FAN_CARD);
        return $value === null ? (integer)$value : $value;
    }

    /**
     * Returns true if 'fan_card' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasFanCard()
    {
        return $this->get(self::FAN_CARD) !== null;
    }

    /**
     * Sets value of 'all_reward' property
     *
     * @param integer $value Property value
     *
     * @return null
     */
    public function setAllReward($value)
    {
        return $this->set(self::ALL_REWARD, $value);
    }

    /**
     * Returns value of 'all_reward' property
     *
     * @return integer
     */
    public function getAllReward()
    {
        $value = $this->get(self::ALL_REWARD);
        return $value === null ? (integer)$value : $value;
    }

    /**
     * Returns true if 'all_reward' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasAllReward()
    {
        return $this->get(self::ALL_REWARD) !== null;
    }

    /**
     * Appends value to 'out_cards' list
     *
     * @param integer $value Value to append
     *
     * @return null
     */
    public function appendOutCards($value)
    {
        return $this->append(self::OUT_CARDS, $value);
    }

    /**
     * Clears 'out_cards' list
     *
     * @return null
     */
    public function clearOutCards()
    {
        return $this->clear(self::OUT_CARDS);
    }

    /**
     * Returns 'out_cards' list
     *
     * @return integer[]
     */
    public function getOutCards()
    {
        return $this->get(self::OUT_CARDS);
    }

    /**
     * Returns true if 'out_cards' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasOutCards()
    {
        return count($this->get(self::OUT_CARDS)) !== 0;
    }

    /**
     * Returns 'out_cards' iterator
     *
     * @return \ArrayIterator
     */
    public function getOutCardsIterator()
    {
        return new \ArrayIterator($this->get(self::OUT_CARDS));
    }

    /**
     * Returns element from 'out_cards' list at given offset
     *
     * @param int $offset Position in list
     *
     * @return integer
     */
    public function getOutCardsAt($offset)
    {
        return $this->get(self::OUT_CARDS, $offset);
    }

    /**
     * Returns count of 'out_cards' list
     *
     * @return int
     */
    public function getOutCardsCount()
    {
        return $this->count(self::OUT_CARDS);
    }

    /**
     * Sets value of 'seed_hash' property
     *
     * @param string $value Property value
     *
     * @return null
     */
    public function setSeedHash($value)
    {
        return $this->set(self::SEED_HASH, $value);
    }

    /**
     * Returns value of 'seed_hash' property
     *
     * @return string
     */
    public function getSeedHash()
    {
        $value = $this->get(self::SEED_HASH);
        return $value === null ? (string)$value : $value;
    }

    /**
     * Returns true if 'seed_hash' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasSeedHash()
    {
        return $this->get(self::SEED_HASH) !== null;
    }

    /**
     * Sets value of 'day_num' property
     *
     * @param string $value Property value
     *
     * @return null
     */
    public function setDayNum($value)
    {
        return $this->set(self::DAY_NUM, $value);
    }

    /**
     * Returns value of 'day_num' property
     *
     * @return string
     */
    public function getDayNum()
    {
        $value = $this->get(self::DAY_NUM);
        return $value === null ? (string)$value : $value;
    }

    /**
     * Returns true if 'day_num' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasDayNum()
    {
        return $this->get(self::DAY_NUM) !== null;
    }

    /**
     * Appends value to 'round_hash' list
     *
     * @param string $value Value to append
     *
     * @return null
     */
    public function appendRoundHash($value)
    {
        return $this->append(self::ROUND_HASH, $value);
    }

    /**
     * Clears 'round_hash' list
     *
     * @return null
     */
    public function clearRoundHash()
    {
        return $this->clear(self::ROUND_HASH);
    }

    /**
     * Returns 'round_hash' list
     *
     * @return string[]
     */
    public function getRoundHash()
    {
        return $this->get(self::ROUND_HASH);
    }

    /**
     * Returns true if 'round_hash' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasRoundHash()
    {
        return count($this->get(self::ROUND_HASH)) !== 0;
    }

    /**
     * Returns 'round_hash' iterator
     *
     * @return \ArrayIterator
     */
    public function getRoundHashIterator()
    {
        return new \ArrayIterator($this->get(self::ROUND_HASH));
    }

    /**
     * Returns element from 'round_hash' list at given offset
     *
     * @param int $offset Position in list
     *
     * @return string
     */
    public function getRoundHashAt($offset)
    {
        return $this->get(self::ROUND_HASH, $offset);
    }

    /**
     * Returns count of 'round_hash' list
     *
     * @return int
     */
    public function getRoundHashCount()
    {
        return $this->count(self::ROUND_HASH);
    }

    /**
     * Sets value of 'pay_out_0' property
     *
     * @param double $value Property value
     *
     * @return null
     */
    public function setPayOut0($value)
    {
        return $this->set(self::PAY_OUT_0, $value);
    }

    /**
     * Returns value of 'pay_out_0' property
     *
     * @return double
     */
    public function getPayOut0()
    {
        $value = $this->get(self::PAY_OUT_0);
        return $value === null ? (double)$value : $value;
    }

    /**
     * Returns true if 'pay_out_0' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasPayOut0()
    {
        return $this->get(self::PAY_OUT_0) !== null;
    }

    /**
     * Sets value of 'pay_out_1' property
     *
     * @param double $value Property value
     *
     * @return null
     */
    public function setPayOut1($value)
    {
        return $this->set(self::PAY_OUT_1, $value);
    }

    /**
     * Returns value of 'pay_out_1' property
     *
     * @return double
     */
    public function getPayOut1()
    {
        $value = $this->get(self::PAY_OUT_1);
        return $value === null ? (double)$value : $value;
    }

    /**
     * Returns true if 'pay_out_1' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasPayOut1()
    {
        return $this->get(self::PAY_OUT_1) !== null;
    }
}
}