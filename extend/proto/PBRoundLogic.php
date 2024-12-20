<?php
/**
 * Auto generated from poker_config.proto at 2023-06-08 09:49:25
 */

namespace {
/**
 * PBRoundLogic message
 */
class PBRoundLogic extends \ProtobufMessage
{
    /* Field index constants */
    const INDEX = 1;
    const CARD_TYPE = 2;
    const ROUND = 3;
    const POS = 4;
    const WIN = 5;
    const MEN = 6;
    const FOLLOW_MEN = 7;
    const ADD_MEN = 8;
    const FOLLOW_BET = 9;
    const ADD_BET = 10;
    const FOLLOW_MEN_RATIO = 11;
    const LOOK_RATIO = 12;
    const ADD_MEN_RATIO = 13;
    const FOLLOW_BET_RATIO = 14;
    const ADD_BET_RATIO = 15;
    const COMPARE_RATIO = 16;
    const GIVE_UP_RATIO = 17;

    /* @var array Field descriptors */
    protected static $fields = array(
        self::INDEX => array(
            'name' => 'index',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_INT,
        ),
        self::CARD_TYPE => array(
            'name' => 'card_type',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_INT,
        ),
        self::ROUND => array(
            'name' => 'round',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_INT,
        ),
        self::POS => array(
            'name' => 'pos',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_INT,
        ),
        self::WIN => array(
            'name' => 'win',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_INT,
        ),
        self::MEN => array(
            'name' => 'men',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_INT,
        ),
        self::FOLLOW_MEN => array(
            'name' => 'follow_men',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_INT,
        ),
        self::ADD_MEN => array(
            'name' => 'add_men',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_INT,
        ),
        self::FOLLOW_BET => array(
            'name' => 'follow_bet',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_INT,
        ),
        self::ADD_BET => array(
            'name' => 'add_bet',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_INT,
        ),
        self::FOLLOW_MEN_RATIO => array(
            'name' => 'follow_men_ratio',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_INT,
        ),
        self::LOOK_RATIO => array(
            'name' => 'look_ratio',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_INT,
        ),
        self::ADD_MEN_RATIO => array(
            'name' => 'add_men_ratio',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_INT,
        ),
        self::FOLLOW_BET_RATIO => array(
            'name' => 'follow_bet_ratio',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_INT,
        ),
        self::ADD_BET_RATIO => array(
            'name' => 'add_bet_ratio',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_INT,
        ),
        self::COMPARE_RATIO => array(
            'name' => 'compare_ratio',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_INT,
        ),
        self::GIVE_UP_RATIO => array(
            'name' => 'give_up_ratio',
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
        $this->values[self::INDEX] = null;
        $this->values[self::CARD_TYPE] = null;
        $this->values[self::ROUND] = null;
        $this->values[self::POS] = null;
        $this->values[self::WIN] = null;
        $this->values[self::MEN] = null;
        $this->values[self::FOLLOW_MEN] = null;
        $this->values[self::ADD_MEN] = null;
        $this->values[self::FOLLOW_BET] = null;
        $this->values[self::ADD_BET] = null;
        $this->values[self::FOLLOW_MEN_RATIO] = null;
        $this->values[self::LOOK_RATIO] = null;
        $this->values[self::ADD_MEN_RATIO] = null;
        $this->values[self::FOLLOW_BET_RATIO] = null;
        $this->values[self::ADD_BET_RATIO] = null;
        $this->values[self::COMPARE_RATIO] = null;
        $this->values[self::GIVE_UP_RATIO] = null;
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
     * Sets value of 'card_type' property
     *
     * @param integer $value Property value
     *
     * @return null
     */
    public function setCardType($value)
    {
        return $this->set(self::CARD_TYPE, $value);
    }

    /**
     * Returns value of 'card_type' property
     *
     * @return integer
     */
    public function getCardType()
    {
        $value = $this->get(self::CARD_TYPE);
        return $value === null ? (integer)$value : $value;
    }

    /**
     * Returns true if 'card_type' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasCardType()
    {
        return $this->get(self::CARD_TYPE) !== null;
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
     * Sets value of 'pos' property
     *
     * @param integer $value Property value
     *
     * @return null
     */
    public function setPos($value)
    {
        return $this->set(self::POS, $value);
    }

    /**
     * Returns value of 'pos' property
     *
     * @return integer
     */
    public function getPos()
    {
        $value = $this->get(self::POS);
        return $value === null ? (integer)$value : $value;
    }

    /**
     * Returns true if 'pos' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasPos()
    {
        return $this->get(self::POS) !== null;
    }

    /**
     * Sets value of 'win' property
     *
     * @param integer $value Property value
     *
     * @return null
     */
    public function setWin($value)
    {
        return $this->set(self::WIN, $value);
    }

    /**
     * Returns value of 'win' property
     *
     * @return integer
     */
    public function getWin()
    {
        $value = $this->get(self::WIN);
        return $value === null ? (integer)$value : $value;
    }

    /**
     * Returns true if 'win' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasWin()
    {
        return $this->get(self::WIN) !== null;
    }

    /**
     * Sets value of 'men' property
     *
     * @param integer $value Property value
     *
     * @return null
     */
    public function setMen($value)
    {
        return $this->set(self::MEN, $value);
    }

    /**
     * Returns value of 'men' property
     *
     * @return integer
     */
    public function getMen()
    {
        $value = $this->get(self::MEN);
        return $value === null ? (integer)$value : $value;
    }

    /**
     * Returns true if 'men' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasMen()
    {
        return $this->get(self::MEN) !== null;
    }

    /**
     * Sets value of 'follow_men' property
     *
     * @param integer $value Property value
     *
     * @return null
     */
    public function setFollowMen($value)
    {
        return $this->set(self::FOLLOW_MEN, $value);
    }

    /**
     * Returns value of 'follow_men' property
     *
     * @return integer
     */
    public function getFollowMen()
    {
        $value = $this->get(self::FOLLOW_MEN);
        return $value === null ? (integer)$value : $value;
    }

    /**
     * Returns true if 'follow_men' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasFollowMen()
    {
        return $this->get(self::FOLLOW_MEN) !== null;
    }

    /**
     * Sets value of 'add_men' property
     *
     * @param integer $value Property value
     *
     * @return null
     */
    public function setAddMen($value)
    {
        return $this->set(self::ADD_MEN, $value);
    }

    /**
     * Returns value of 'add_men' property
     *
     * @return integer
     */
    public function getAddMen()
    {
        $value = $this->get(self::ADD_MEN);
        return $value === null ? (integer)$value : $value;
    }

    /**
     * Returns true if 'add_men' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasAddMen()
    {
        return $this->get(self::ADD_MEN) !== null;
    }

    /**
     * Sets value of 'follow_bet' property
     *
     * @param integer $value Property value
     *
     * @return null
     */
    public function setFollowBet($value)
    {
        return $this->set(self::FOLLOW_BET, $value);
    }

    /**
     * Returns value of 'follow_bet' property
     *
     * @return integer
     */
    public function getFollowBet()
    {
        $value = $this->get(self::FOLLOW_BET);
        return $value === null ? (integer)$value : $value;
    }

    /**
     * Returns true if 'follow_bet' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasFollowBet()
    {
        return $this->get(self::FOLLOW_BET) !== null;
    }

    /**
     * Sets value of 'add_bet' property
     *
     * @param integer $value Property value
     *
     * @return null
     */
    public function setAddBet($value)
    {
        return $this->set(self::ADD_BET, $value);
    }

    /**
     * Returns value of 'add_bet' property
     *
     * @return integer
     */
    public function getAddBet()
    {
        $value = $this->get(self::ADD_BET);
        return $value === null ? (integer)$value : $value;
    }

    /**
     * Returns true if 'add_bet' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasAddBet()
    {
        return $this->get(self::ADD_BET) !== null;
    }

    /**
     * Sets value of 'follow_men_ratio' property
     *
     * @param integer $value Property value
     *
     * @return null
     */
    public function setFollowMenRatio($value)
    {
        return $this->set(self::FOLLOW_MEN_RATIO, $value);
    }

    /**
     * Returns value of 'follow_men_ratio' property
     *
     * @return integer
     */
    public function getFollowMenRatio()
    {
        $value = $this->get(self::FOLLOW_MEN_RATIO);
        return $value === null ? (integer)$value : $value;
    }

    /**
     * Returns true if 'follow_men_ratio' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasFollowMenRatio()
    {
        return $this->get(self::FOLLOW_MEN_RATIO) !== null;
    }

    /**
     * Sets value of 'look_ratio' property
     *
     * @param integer $value Property value
     *
     * @return null
     */
    public function setLookRatio($value)
    {
        return $this->set(self::LOOK_RATIO, $value);
    }

    /**
     * Returns value of 'look_ratio' property
     *
     * @return integer
     */
    public function getLookRatio()
    {
        $value = $this->get(self::LOOK_RATIO);
        return $value === null ? (integer)$value : $value;
    }

    /**
     * Returns true if 'look_ratio' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasLookRatio()
    {
        return $this->get(self::LOOK_RATIO) !== null;
    }

    /**
     * Sets value of 'add_men_ratio' property
     *
     * @param integer $value Property value
     *
     * @return null
     */
    public function setAddMenRatio($value)
    {
        return $this->set(self::ADD_MEN_RATIO, $value);
    }

    /**
     * Returns value of 'add_men_ratio' property
     *
     * @return integer
     */
    public function getAddMenRatio()
    {
        $value = $this->get(self::ADD_MEN_RATIO);
        return $value === null ? (integer)$value : $value;
    }

    /**
     * Returns true if 'add_men_ratio' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasAddMenRatio()
    {
        return $this->get(self::ADD_MEN_RATIO) !== null;
    }

    /**
     * Sets value of 'follow_bet_ratio' property
     *
     * @param integer $value Property value
     *
     * @return null
     */
    public function setFollowBetRatio($value)
    {
        return $this->set(self::FOLLOW_BET_RATIO, $value);
    }

    /**
     * Returns value of 'follow_bet_ratio' property
     *
     * @return integer
     */
    public function getFollowBetRatio()
    {
        $value = $this->get(self::FOLLOW_BET_RATIO);
        return $value === null ? (integer)$value : $value;
    }

    /**
     * Returns true if 'follow_bet_ratio' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasFollowBetRatio()
    {
        return $this->get(self::FOLLOW_BET_RATIO) !== null;
    }

    /**
     * Sets value of 'add_bet_ratio' property
     *
     * @param integer $value Property value
     *
     * @return null
     */
    public function setAddBetRatio($value)
    {
        return $this->set(self::ADD_BET_RATIO, $value);
    }

    /**
     * Returns value of 'add_bet_ratio' property
     *
     * @return integer
     */
    public function getAddBetRatio()
    {
        $value = $this->get(self::ADD_BET_RATIO);
        return $value === null ? (integer)$value : $value;
    }

    /**
     * Returns true if 'add_bet_ratio' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasAddBetRatio()
    {
        return $this->get(self::ADD_BET_RATIO) !== null;
    }

    /**
     * Sets value of 'compare_ratio' property
     *
     * @param integer $value Property value
     *
     * @return null
     */
    public function setCompareRatio($value)
    {
        return $this->set(self::COMPARE_RATIO, $value);
    }

    /**
     * Returns value of 'compare_ratio' property
     *
     * @return integer
     */
    public function getCompareRatio()
    {
        $value = $this->get(self::COMPARE_RATIO);
        return $value === null ? (integer)$value : $value;
    }

    /**
     * Returns true if 'compare_ratio' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasCompareRatio()
    {
        return $this->get(self::COMPARE_RATIO) !== null;
    }

    /**
     * Sets value of 'give_up_ratio' property
     *
     * @param integer $value Property value
     *
     * @return null
     */
    public function setGiveUpRatio($value)
    {
        return $this->set(self::GIVE_UP_RATIO, $value);
    }

    /**
     * Returns value of 'give_up_ratio' property
     *
     * @return integer
     */
    public function getGiveUpRatio()
    {
        $value = $this->get(self::GIVE_UP_RATIO);
        return $value === null ? (integer)$value : $value;
    }

    /**
     * Returns true if 'give_up_ratio' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasGiveUpRatio()
    {
        return $this->get(self::GIVE_UP_RATIO) !== null;
    }
}
}