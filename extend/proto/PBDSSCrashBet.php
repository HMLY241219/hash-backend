<?php
/**
 * Auto generated from poker_msg_basic.proto at 2023-06-08 09:49:25
 */

namespace {
/**
 * PBDSSCrashBet message
 */
class PBDSSCrashBet extends \ProtobufMessage
{
    /* Field index constants */
    const BET_SCORE = 1;
    const CASH_OUT_MUP = 2;

    /* @var array Field descriptors */
    protected static $fields = array(
        self::BET_SCORE => array(
            'name' => 'bet_score',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_INT,
        ),
        self::CASH_OUT_MUP => array(
            'name' => 'cash_out_mup',
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
        $this->values[self::BET_SCORE] = null;
        $this->values[self::CASH_OUT_MUP] = null;
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
     * Sets value of 'bet_score' property
     *
     * @param integer $value Property value
     *
     * @return null
     */
    public function setBetScore($value)
    {
        return $this->set(self::BET_SCORE, $value);
    }

    /**
     * Returns value of 'bet_score' property
     *
     * @return integer
     */
    public function getBetScore()
    {
        $value = $this->get(self::BET_SCORE);
        return $value === null ? (integer)$value : $value;
    }

    /**
     * Returns true if 'bet_score' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasBetScore()
    {
        return $this->get(self::BET_SCORE) !== null;
    }

    /**
     * Sets value of 'cash_out_mup' property
     *
     * @param integer $value Property value
     *
     * @return null
     */
    public function setCashOutMup($value)
    {
        return $this->set(self::CASH_OUT_MUP, $value);
    }

    /**
     * Returns value of 'cash_out_mup' property
     *
     * @return integer
     */
    public function getCashOutMup()
    {
        $value = $this->get(self::CASH_OUT_MUP);
        return $value === null ? (integer)$value : $value;
    }

    /**
     * Returns true if 'cash_out_mup' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasCashOutMup()
    {
        return $this->get(self::CASH_OUT_MUP) !== null;
    }
}
}