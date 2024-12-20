<?php
/**
 * Auto generated from poker_msg_log.proto at 2023-06-08 09:49:25
 */

namespace {
/**
 * LogGameLog message
 */
class LogGameLog extends \ProtobufMessage
{
    /* Field index constants */
    const TABLE_ID = 1;
    const GAME_ID = 2;
    const TABLE_LOG = 3;
    const BEGIN_TIME = 4;
    const END_TIME = 5;
    const TABLE_LEVEL = 6;
    const GAME_TYPE = 7;
    const PLAYERS = 8;
    const SEAT_NUM = 9;
    const AI_PLAYERS = 10;
    const CONTROL_WIN_OR_LOSER = 12;
    const BET_ALL = 15;
    const SERVER_SCORE = 16;
    const SERVICE_SCORE = 17;
    const STOCK_SUB = 18;
    const PLAYERS_CARD_TYPE = 22;
    const PLAYERS_INFO = 23;
    const USER_NUM = 24;
    const USER_MULTIPLE = 25;
    const GAME_MULTIPLE = 26;
    const USER_END = 27;
    const WIN_NUM = 28;
    const LOSER_NUM = 29;
    const STOCK_TYPE = 30;
    const CARDS_0 = 31;
    const CARDS_1 = 32;
    const CARDS_2 = 33;
    const CARDS_3 = 34;
    const CARDS_4 = 35;
    const CARDS_5 = 36;
    const CARDS_6 = 37;
    const CARDS_7 = 38;
    const CARDS_8 = 39;
    const CARDS_9 = 40;
    const CARDS_10 = 41;
    const CARDS_11 = 42;
    const CARDS_12 = 43;
    const CARDS_13 = 44;
    const CARDS_14 = 45;
    const VALUE_1 = 46;
    const VALUE_2 = 47;
    const VALUE_3 = 48;
    const VALUE_4 = 49;
    const VALUE_5 = 50;
    const VALUE_6 = 51;
    const ISSUE = 52;
    const SEED = 53;

    /* @var array Field descriptors */
    protected static $fields = array(
        self::TABLE_ID => array(
            'name' => 'table_id',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_INT,
        ),
        self::GAME_ID => array(
            'name' => 'game_id',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_INT,
        ),
        self::TABLE_LOG => array(
            'name' => 'table_log',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_STRING,
        ),
        self::BEGIN_TIME => array(
            'name' => 'begin_time',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_INT,
        ),
        self::END_TIME => array(
            'name' => 'end_time',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_INT,
        ),
        self::TABLE_LEVEL => array(
            'name' => 'table_level',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_INT,
        ),
        self::GAME_TYPE => array(
            'name' => 'game_type',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_INT,
        ),
        self::PLAYERS => array(
            'name' => 'players',
            'repeated' => true,
            'type' => \ProtobufMessage::PB_TYPE_INT,
        ),
        self::SEAT_NUM => array(
            'name' => 'seat_num',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_INT,
        ),
        self::AI_PLAYERS => array(
            'name' => 'ai_players',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_INT,
        ),
        self::CONTROL_WIN_OR_LOSER => array(
            'name' => 'control_win_or_loser',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_INT,
        ),
        self::BET_ALL => array(
            'name' => 'bet_all',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_INT,
        ),
        self::SERVER_SCORE => array(
            'name' => 'server_score',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_INT,
        ),
        self::SERVICE_SCORE => array(
            'name' => 'service_score',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_INT,
        ),
        self::STOCK_SUB => array(
            'name' => 'stock_sub',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_INT,
        ),
        self::PLAYERS_CARD_TYPE => array(
            'name' => 'players_card_type',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_INT,
        ),
        self::PLAYERS_INFO => array(
            'name' => 'players_info',
            'repeated' => true,
            'type' => '\PBLogPlayersInfo'
        ),
        self::USER_NUM => array(
            'name' => 'user_num',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_INT,
        ),
        self::USER_MULTIPLE => array(
            'name' => 'user_multiple',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_INT,
        ),
        self::GAME_MULTIPLE => array(
            'name' => 'game_multiple',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_INT,
        ),
        self::USER_END => array(
            'name' => 'user_end',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_BOOL,
        ),
        self::WIN_NUM => array(
            'name' => 'win_num',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_INT,
        ),
        self::LOSER_NUM => array(
            'name' => 'loser_num',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_INT,
        ),
        self::STOCK_TYPE => array(
            'name' => 'stock_type',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_INT,
        ),
        self::CARDS_0 => array(
            'name' => 'cards_0',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_INT,
        ),
        self::CARDS_1 => array(
            'name' => 'cards_1',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_INT,
        ),
        self::CARDS_2 => array(
            'name' => 'cards_2',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_INT,
        ),
        self::CARDS_3 => array(
            'name' => 'cards_3',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_INT,
        ),
        self::CARDS_4 => array(
            'name' => 'cards_4',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_INT,
        ),
        self::CARDS_5 => array(
            'name' => 'cards_5',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_INT,
        ),
        self::CARDS_6 => array(
            'name' => 'cards_6',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_INT,
        ),
        self::CARDS_7 => array(
            'name' => 'cards_7',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_INT,
        ),
        self::CARDS_8 => array(
            'name' => 'cards_8',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_INT,
        ),
        self::CARDS_9 => array(
            'name' => 'cards_9',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_INT,
        ),
        self::CARDS_10 => array(
            'name' => 'cards_10',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_INT,
        ),
        self::CARDS_11 => array(
            'name' => 'cards_11',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_INT,
        ),
        self::CARDS_12 => array(
            'name' => 'cards_12',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_INT,
        ),
        self::CARDS_13 => array(
            'name' => 'cards_13',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_INT,
        ),
        self::CARDS_14 => array(
            'name' => 'cards_14',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_INT,
        ),
        self::VALUE_1 => array(
            'name' => 'value_1',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_INT,
        ),
        self::VALUE_2 => array(
            'name' => 'value_2',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_INT,
        ),
        self::VALUE_3 => array(
            'name' => 'value_3',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_INT,
        ),
        self::VALUE_4 => array(
            'name' => 'value_4',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_INT,
        ),
        self::VALUE_5 => array(
            'name' => 'value_5',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_INT,
        ),
        self::VALUE_6 => array(
            'name' => 'value_6',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_INT,
        ),
        self::ISSUE => array(
            'name' => 'issue',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_STRING,
        ),
        self::SEED => array(
            'name' => 'seed',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_STRING,
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
        $this->values[self::TABLE_ID] = null;
        $this->values[self::GAME_ID] = null;
        $this->values[self::TABLE_LOG] = null;
        $this->values[self::BEGIN_TIME] = null;
        $this->values[self::END_TIME] = null;
        $this->values[self::TABLE_LEVEL] = null;
        $this->values[self::GAME_TYPE] = null;
        $this->values[self::PLAYERS] = array();
        $this->values[self::SEAT_NUM] = null;
        $this->values[self::AI_PLAYERS] = null;
        $this->values[self::CONTROL_WIN_OR_LOSER] = null;
        $this->values[self::BET_ALL] = null;
        $this->values[self::SERVER_SCORE] = null;
        $this->values[self::SERVICE_SCORE] = null;
        $this->values[self::STOCK_SUB] = null;
        $this->values[self::PLAYERS_CARD_TYPE] = null;
        $this->values[self::PLAYERS_INFO] = array();
        $this->values[self::USER_NUM] = null;
        $this->values[self::USER_MULTIPLE] = null;
        $this->values[self::GAME_MULTIPLE] = null;
        $this->values[self::USER_END] = null;
        $this->values[self::WIN_NUM] = null;
        $this->values[self::LOSER_NUM] = null;
        $this->values[self::STOCK_TYPE] = null;
        $this->values[self::CARDS_0] = null;
        $this->values[self::CARDS_1] = null;
        $this->values[self::CARDS_2] = null;
        $this->values[self::CARDS_3] = null;
        $this->values[self::CARDS_4] = null;
        $this->values[self::CARDS_5] = null;
        $this->values[self::CARDS_6] = null;
        $this->values[self::CARDS_7] = null;
        $this->values[self::CARDS_8] = null;
        $this->values[self::CARDS_9] = null;
        $this->values[self::CARDS_10] = null;
        $this->values[self::CARDS_11] = null;
        $this->values[self::CARDS_12] = null;
        $this->values[self::CARDS_13] = null;
        $this->values[self::CARDS_14] = null;
        $this->values[self::VALUE_1] = null;
        $this->values[self::VALUE_2] = null;
        $this->values[self::VALUE_3] = null;
        $this->values[self::VALUE_4] = null;
        $this->values[self::VALUE_5] = null;
        $this->values[self::VALUE_6] = null;
        $this->values[self::ISSUE] = null;
        $this->values[self::SEED] = null;
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
     * Sets value of 'table_id' property
     *
     * @param integer $value Property value
     *
     * @return null
     */
    public function setTableId($value)
    {
        return $this->set(self::TABLE_ID, $value);
    }

    /**
     * Returns value of 'table_id' property
     *
     * @return integer
     */
    public function getTableId()
    {
        $value = $this->get(self::TABLE_ID);
        return $value === null ? (integer)$value : $value;
    }

    /**
     * Returns true if 'table_id' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasTableId()
    {
        return $this->get(self::TABLE_ID) !== null;
    }

    /**
     * Sets value of 'game_id' property
     *
     * @param integer $value Property value
     *
     * @return null
     */
    public function setGameId($value)
    {
        return $this->set(self::GAME_ID, $value);
    }

    /**
     * Returns value of 'game_id' property
     *
     * @return integer
     */
    public function getGameId()
    {
        $value = $this->get(self::GAME_ID);
        return $value === null ? (integer)$value : $value;
    }

    /**
     * Returns true if 'game_id' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasGameId()
    {
        return $this->get(self::GAME_ID) !== null;
    }

    /**
     * Sets value of 'table_log' property
     *
     * @param string $value Property value
     *
     * @return null
     */
    public function setTableLog($value)
    {
        return $this->set(self::TABLE_LOG, $value);
    }

    /**
     * Returns value of 'table_log' property
     *
     * @return string
     */
    public function getTableLog()
    {
        $value = $this->get(self::TABLE_LOG);
        return $value === null ? (string)$value : $value;
    }

    /**
     * Returns true if 'table_log' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasTableLog()
    {
        return $this->get(self::TABLE_LOG) !== null;
    }

    /**
     * Sets value of 'begin_time' property
     *
     * @param integer $value Property value
     *
     * @return null
     */
    public function setBeginTime($value)
    {
        return $this->set(self::BEGIN_TIME, $value);
    }

    /**
     * Returns value of 'begin_time' property
     *
     * @return integer
     */
    public function getBeginTime()
    {
        $value = $this->get(self::BEGIN_TIME);
        return $value === null ? (integer)$value : $value;
    }

    /**
     * Returns true if 'begin_time' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasBeginTime()
    {
        return $this->get(self::BEGIN_TIME) !== null;
    }

    /**
     * Sets value of 'end_time' property
     *
     * @param integer $value Property value
     *
     * @return null
     */
    public function setEndTime($value)
    {
        return $this->set(self::END_TIME, $value);
    }

    /**
     * Returns value of 'end_time' property
     *
     * @return integer
     */
    public function getEndTime()
    {
        $value = $this->get(self::END_TIME);
        return $value === null ? (integer)$value : $value;
    }

    /**
     * Returns true if 'end_time' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasEndTime()
    {
        return $this->get(self::END_TIME) !== null;
    }

    /**
     * Sets value of 'table_level' property
     *
     * @param integer $value Property value
     *
     * @return null
     */
    public function setTableLevel($value)
    {
        return $this->set(self::TABLE_LEVEL, $value);
    }

    /**
     * Returns value of 'table_level' property
     *
     * @return integer
     */
    public function getTableLevel()
    {
        $value = $this->get(self::TABLE_LEVEL);
        return $value === null ? (integer)$value : $value;
    }

    /**
     * Returns true if 'table_level' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasTableLevel()
    {
        return $this->get(self::TABLE_LEVEL) !== null;
    }

    /**
     * Sets value of 'game_type' property
     *
     * @param integer $value Property value
     *
     * @return null
     */
    public function setGameType($value)
    {
        return $this->set(self::GAME_TYPE, $value);
    }

    /**
     * Returns value of 'game_type' property
     *
     * @return integer
     */
    public function getGameType()
    {
        $value = $this->get(self::GAME_TYPE);
        return $value === null ? (integer)$value : $value;
    }

    /**
     * Returns true if 'game_type' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasGameType()
    {
        return $this->get(self::GAME_TYPE) !== null;
    }

    /**
     * Appends value to 'players' list
     *
     * @param integer $value Value to append
     *
     * @return null
     */
    public function appendPlayers($value)
    {
        return $this->append(self::PLAYERS, $value);
    }

    /**
     * Clears 'players' list
     *
     * @return null
     */
    public function clearPlayers()
    {
        return $this->clear(self::PLAYERS);
    }

    /**
     * Returns 'players' list
     *
     * @return integer[]
     */
    public function getPlayers()
    {
        return $this->get(self::PLAYERS);
    }

    /**
     * Returns true if 'players' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasPlayers()
    {
        return count($this->get(self::PLAYERS)) !== 0;
    }

    /**
     * Returns 'players' iterator
     *
     * @return \ArrayIterator
     */
    public function getPlayersIterator()
    {
        return new \ArrayIterator($this->get(self::PLAYERS));
    }

    /**
     * Returns element from 'players' list at given offset
     *
     * @param int $offset Position in list
     *
     * @return integer
     */
    public function getPlayersAt($offset)
    {
        return $this->get(self::PLAYERS, $offset);
    }

    /**
     * Returns count of 'players' list
     *
     * @return int
     */
    public function getPlayersCount()
    {
        return $this->count(self::PLAYERS);
    }

    /**
     * Sets value of 'seat_num' property
     *
     * @param integer $value Property value
     *
     * @return null
     */
    public function setSeatNum($value)
    {
        return $this->set(self::SEAT_NUM, $value);
    }

    /**
     * Returns value of 'seat_num' property
     *
     * @return integer
     */
    public function getSeatNum()
    {
        $value = $this->get(self::SEAT_NUM);
        return $value === null ? (integer)$value : $value;
    }

    /**
     * Returns true if 'seat_num' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasSeatNum()
    {
        return $this->get(self::SEAT_NUM) !== null;
    }

    /**
     * Sets value of 'ai_players' property
     *
     * @param integer $value Property value
     *
     * @return null
     */
    public function setAiPlayers($value)
    {
        return $this->set(self::AI_PLAYERS, $value);
    }

    /**
     * Returns value of 'ai_players' property
     *
     * @return integer
     */
    public function getAiPlayers()
    {
        $value = $this->get(self::AI_PLAYERS);
        return $value === null ? (integer)$value : $value;
    }

    /**
     * Returns true if 'ai_players' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasAiPlayers()
    {
        return $this->get(self::AI_PLAYERS) !== null;
    }

    /**
     * Sets value of 'control_win_or_loser' property
     *
     * @param integer $value Property value
     *
     * @return null
     */
    public function setControlWinOrLoser($value)
    {
        return $this->set(self::CONTROL_WIN_OR_LOSER, $value);
    }

    /**
     * Returns value of 'control_win_or_loser' property
     *
     * @return integer
     */
    public function getControlWinOrLoser()
    {
        $value = $this->get(self::CONTROL_WIN_OR_LOSER);
        return $value === null ? (integer)$value : $value;
    }

    /**
     * Returns true if 'control_win_or_loser' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasControlWinOrLoser()
    {
        return $this->get(self::CONTROL_WIN_OR_LOSER) !== null;
    }

    /**
     * Sets value of 'bet_all' property
     *
     * @param integer $value Property value
     *
     * @return null
     */
    public function setBetAll($value)
    {
        return $this->set(self::BET_ALL, $value);
    }

    /**
     * Returns value of 'bet_all' property
     *
     * @return integer
     */
    public function getBetAll()
    {
        $value = $this->get(self::BET_ALL);
        return $value === null ? (integer)$value : $value;
    }

    /**
     * Returns true if 'bet_all' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasBetAll()
    {
        return $this->get(self::BET_ALL) !== null;
    }

    /**
     * Sets value of 'server_score' property
     *
     * @param integer $value Property value
     *
     * @return null
     */
    public function setServerScore($value)
    {
        return $this->set(self::SERVER_SCORE, $value);
    }

    /**
     * Returns value of 'server_score' property
     *
     * @return integer
     */
    public function getServerScore()
    {
        $value = $this->get(self::SERVER_SCORE);
        return $value === null ? (integer)$value : $value;
    }

    /**
     * Returns true if 'server_score' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasServerScore()
    {
        return $this->get(self::SERVER_SCORE) !== null;
    }

    /**
     * Sets value of 'service_score' property
     *
     * @param integer $value Property value
     *
     * @return null
     */
    public function setServiceScore($value)
    {
        return $this->set(self::SERVICE_SCORE, $value);
    }

    /**
     * Returns value of 'service_score' property
     *
     * @return integer
     */
    public function getServiceScore()
    {
        $value = $this->get(self::SERVICE_SCORE);
        return $value === null ? (integer)$value : $value;
    }

    /**
     * Returns true if 'service_score' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasServiceScore()
    {
        return $this->get(self::SERVICE_SCORE) !== null;
    }

    /**
     * Sets value of 'stock_sub' property
     *
     * @param integer $value Property value
     *
     * @return null
     */
    public function setStockSub($value)
    {
        return $this->set(self::STOCK_SUB, $value);
    }

    /**
     * Returns value of 'stock_sub' property
     *
     * @return integer
     */
    public function getStockSub()
    {
        $value = $this->get(self::STOCK_SUB);
        return $value === null ? (integer)$value : $value;
    }

    /**
     * Returns true if 'stock_sub' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasStockSub()
    {
        return $this->get(self::STOCK_SUB) !== null;
    }

    /**
     * Sets value of 'players_card_type' property
     *
     * @param integer $value Property value
     *
     * @return null
     */
    public function setPlayersCardType($value)
    {
        return $this->set(self::PLAYERS_CARD_TYPE, $value);
    }

    /**
     * Returns value of 'players_card_type' property
     *
     * @return integer
     */
    public function getPlayersCardType()
    {
        $value = $this->get(self::PLAYERS_CARD_TYPE);
        return $value === null ? (integer)$value : $value;
    }

    /**
     * Returns true if 'players_card_type' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasPlayersCardType()
    {
        return $this->get(self::PLAYERS_CARD_TYPE) !== null;
    }

    /**
     * Appends value to 'players_info' list
     *
     * @param \PBLogPlayersInfo $value Value to append
     *
     * @return null
     */
    public function appendPlayersInfo(\PBLogPlayersInfo $value)
    {
        return $this->append(self::PLAYERS_INFO, $value);
    }

    /**
     * Clears 'players_info' list
     *
     * @return null
     */
    public function clearPlayersInfo()
    {
        return $this->clear(self::PLAYERS_INFO);
    }

    /**
     * Returns 'players_info' list
     *
     * @return \PBLogPlayersInfo[]
     */
    public function getPlayersInfo()
    {
        return $this->get(self::PLAYERS_INFO);
    }

    /**
     * Returns true if 'players_info' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasPlayersInfo()
    {
        return count($this->get(self::PLAYERS_INFO)) !== 0;
    }

    /**
     * Returns 'players_info' iterator
     *
     * @return \ArrayIterator
     */
    public function getPlayersInfoIterator()
    {
        return new \ArrayIterator($this->get(self::PLAYERS_INFO));
    }

    /**
     * Returns element from 'players_info' list at given offset
     *
     * @param int $offset Position in list
     *
     * @return \PBLogPlayersInfo
     */
    public function getPlayersInfoAt($offset)
    {
        return $this->get(self::PLAYERS_INFO, $offset);
    }

    /**
     * Returns count of 'players_info' list
     *
     * @return int
     */
    public function getPlayersInfoCount()
    {
        return $this->count(self::PLAYERS_INFO);
    }

    /**
     * Sets value of 'user_num' property
     *
     * @param integer $value Property value
     *
     * @return null
     */
    public function setUserNum($value)
    {
        return $this->set(self::USER_NUM, $value);
    }

    /**
     * Returns value of 'user_num' property
     *
     * @return integer
     */
    public function getUserNum()
    {
        $value = $this->get(self::USER_NUM);
        return $value === null ? (integer)$value : $value;
    }

    /**
     * Returns true if 'user_num' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasUserNum()
    {
        return $this->get(self::USER_NUM) !== null;
    }

    /**
     * Sets value of 'user_multiple' property
     *
     * @param integer $value Property value
     *
     * @return null
     */
    public function setUserMultiple($value)
    {
        return $this->set(self::USER_MULTIPLE, $value);
    }

    /**
     * Returns value of 'user_multiple' property
     *
     * @return integer
     */
    public function getUserMultiple()
    {
        $value = $this->get(self::USER_MULTIPLE);
        return $value === null ? (integer)$value : $value;
    }

    /**
     * Returns true if 'user_multiple' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasUserMultiple()
    {
        return $this->get(self::USER_MULTIPLE) !== null;
    }

    /**
     * Sets value of 'game_multiple' property
     *
     * @param integer $value Property value
     *
     * @return null
     */
    public function setGameMultiple($value)
    {
        return $this->set(self::GAME_MULTIPLE, $value);
    }

    /**
     * Returns value of 'game_multiple' property
     *
     * @return integer
     */
    public function getGameMultiple()
    {
        $value = $this->get(self::GAME_MULTIPLE);
        return $value === null ? (integer)$value : $value;
    }

    /**
     * Returns true if 'game_multiple' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasGameMultiple()
    {
        return $this->get(self::GAME_MULTIPLE) !== null;
    }

    /**
     * Sets value of 'user_end' property
     *
     * @param boolean $value Property value
     *
     * @return null
     */
    public function setUserEnd($value)
    {
        return $this->set(self::USER_END, $value);
    }

    /**
     * Returns value of 'user_end' property
     *
     * @return boolean
     */
    public function getUserEnd()
    {
        $value = $this->get(self::USER_END);
        return $value === null ? (boolean)$value : $value;
    }

    /**
     * Returns true if 'user_end' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasUserEnd()
    {
        return $this->get(self::USER_END) !== null;
    }

    /**
     * Sets value of 'win_num' property
     *
     * @param integer $value Property value
     *
     * @return null
     */
    public function setWinNum($value)
    {
        return $this->set(self::WIN_NUM, $value);
    }

    /**
     * Returns value of 'win_num' property
     *
     * @return integer
     */
    public function getWinNum()
    {
        $value = $this->get(self::WIN_NUM);
        return $value === null ? (integer)$value : $value;
    }

    /**
     * Returns true if 'win_num' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasWinNum()
    {
        return $this->get(self::WIN_NUM) !== null;
    }

    /**
     * Sets value of 'loser_num' property
     *
     * @param integer $value Property value
     *
     * @return null
     */
    public function setLoserNum($value)
    {
        return $this->set(self::LOSER_NUM, $value);
    }

    /**
     * Returns value of 'loser_num' property
     *
     * @return integer
     */
    public function getLoserNum()
    {
        $value = $this->get(self::LOSER_NUM);
        return $value === null ? (integer)$value : $value;
    }

    /**
     * Returns true if 'loser_num' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasLoserNum()
    {
        return $this->get(self::LOSER_NUM) !== null;
    }

    /**
     * Sets value of 'stock_type' property
     *
     * @param integer $value Property value
     *
     * @return null
     */
    public function setStockType($value)
    {
        return $this->set(self::STOCK_TYPE, $value);
    }

    /**
     * Returns value of 'stock_type' property
     *
     * @return integer
     */
    public function getStockType()
    {
        $value = $this->get(self::STOCK_TYPE);
        return $value === null ? (integer)$value : $value;
    }

    /**
     * Returns true if 'stock_type' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasStockType()
    {
        return $this->get(self::STOCK_TYPE) !== null;
    }

    /**
     * Sets value of 'cards_0' property
     *
     * @param integer $value Property value
     *
     * @return null
     */
    public function setCards0($value)
    {
        return $this->set(self::CARDS_0, $value);
    }

    /**
     * Returns value of 'cards_0' property
     *
     * @return integer
     */
    public function getCards0()
    {
        $value = $this->get(self::CARDS_0);
        return $value === null ? (integer)$value : $value;
    }

    /**
     * Returns true if 'cards_0' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasCards0()
    {
        return $this->get(self::CARDS_0) !== null;
    }

    /**
     * Sets value of 'cards_1' property
     *
     * @param integer $value Property value
     *
     * @return null
     */
    public function setCards1($value)
    {
        return $this->set(self::CARDS_1, $value);
    }

    /**
     * Returns value of 'cards_1' property
     *
     * @return integer
     */
    public function getCards1()
    {
        $value = $this->get(self::CARDS_1);
        return $value === null ? (integer)$value : $value;
    }

    /**
     * Returns true if 'cards_1' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasCards1()
    {
        return $this->get(self::CARDS_1) !== null;
    }

    /**
     * Sets value of 'cards_2' property
     *
     * @param integer $value Property value
     *
     * @return null
     */
    public function setCards2($value)
    {
        return $this->set(self::CARDS_2, $value);
    }

    /**
     * Returns value of 'cards_2' property
     *
     * @return integer
     */
    public function getCards2()
    {
        $value = $this->get(self::CARDS_2);
        return $value === null ? (integer)$value : $value;
    }

    /**
     * Returns true if 'cards_2' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasCards2()
    {
        return $this->get(self::CARDS_2) !== null;
    }

    /**
     * Sets value of 'cards_3' property
     *
     * @param integer $value Property value
     *
     * @return null
     */
    public function setCards3($value)
    {
        return $this->set(self::CARDS_3, $value);
    }

    /**
     * Returns value of 'cards_3' property
     *
     * @return integer
     */
    public function getCards3()
    {
        $value = $this->get(self::CARDS_3);
        return $value === null ? (integer)$value : $value;
    }

    /**
     * Returns true if 'cards_3' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasCards3()
    {
        return $this->get(self::CARDS_3) !== null;
    }

    /**
     * Sets value of 'cards_4' property
     *
     * @param integer $value Property value
     *
     * @return null
     */
    public function setCards4($value)
    {
        return $this->set(self::CARDS_4, $value);
    }

    /**
     * Returns value of 'cards_4' property
     *
     * @return integer
     */
    public function getCards4()
    {
        $value = $this->get(self::CARDS_4);
        return $value === null ? (integer)$value : $value;
    }

    /**
     * Returns true if 'cards_4' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasCards4()
    {
        return $this->get(self::CARDS_4) !== null;
    }

    /**
     * Sets value of 'cards_5' property
     *
     * @param integer $value Property value
     *
     * @return null
     */
    public function setCards5($value)
    {
        return $this->set(self::CARDS_5, $value);
    }

    /**
     * Returns value of 'cards_5' property
     *
     * @return integer
     */
    public function getCards5()
    {
        $value = $this->get(self::CARDS_5);
        return $value === null ? (integer)$value : $value;
    }

    /**
     * Returns true if 'cards_5' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasCards5()
    {
        return $this->get(self::CARDS_5) !== null;
    }

    /**
     * Sets value of 'cards_6' property
     *
     * @param integer $value Property value
     *
     * @return null
     */
    public function setCards6($value)
    {
        return $this->set(self::CARDS_6, $value);
    }

    /**
     * Returns value of 'cards_6' property
     *
     * @return integer
     */
    public function getCards6()
    {
        $value = $this->get(self::CARDS_6);
        return $value === null ? (integer)$value : $value;
    }

    /**
     * Returns true if 'cards_6' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasCards6()
    {
        return $this->get(self::CARDS_6) !== null;
    }

    /**
     * Sets value of 'cards_7' property
     *
     * @param integer $value Property value
     *
     * @return null
     */
    public function setCards7($value)
    {
        return $this->set(self::CARDS_7, $value);
    }

    /**
     * Returns value of 'cards_7' property
     *
     * @return integer
     */
    public function getCards7()
    {
        $value = $this->get(self::CARDS_7);
        return $value === null ? (integer)$value : $value;
    }

    /**
     * Returns true if 'cards_7' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasCards7()
    {
        return $this->get(self::CARDS_7) !== null;
    }

    /**
     * Sets value of 'cards_8' property
     *
     * @param integer $value Property value
     *
     * @return null
     */
    public function setCards8($value)
    {
        return $this->set(self::CARDS_8, $value);
    }

    /**
     * Returns value of 'cards_8' property
     *
     * @return integer
     */
    public function getCards8()
    {
        $value = $this->get(self::CARDS_8);
        return $value === null ? (integer)$value : $value;
    }

    /**
     * Returns true if 'cards_8' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasCards8()
    {
        return $this->get(self::CARDS_8) !== null;
    }

    /**
     * Sets value of 'cards_9' property
     *
     * @param integer $value Property value
     *
     * @return null
     */
    public function setCards9($value)
    {
        return $this->set(self::CARDS_9, $value);
    }

    /**
     * Returns value of 'cards_9' property
     *
     * @return integer
     */
    public function getCards9()
    {
        $value = $this->get(self::CARDS_9);
        return $value === null ? (integer)$value : $value;
    }

    /**
     * Returns true if 'cards_9' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasCards9()
    {
        return $this->get(self::CARDS_9) !== null;
    }

    /**
     * Sets value of 'cards_10' property
     *
     * @param integer $value Property value
     *
     * @return null
     */
    public function setCards10($value)
    {
        return $this->set(self::CARDS_10, $value);
    }

    /**
     * Returns value of 'cards_10' property
     *
     * @return integer
     */
    public function getCards10()
    {
        $value = $this->get(self::CARDS_10);
        return $value === null ? (integer)$value : $value;
    }

    /**
     * Returns true if 'cards_10' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasCards10()
    {
        return $this->get(self::CARDS_10) !== null;
    }

    /**
     * Sets value of 'cards_11' property
     *
     * @param integer $value Property value
     *
     * @return null
     */
    public function setCards11($value)
    {
        return $this->set(self::CARDS_11, $value);
    }

    /**
     * Returns value of 'cards_11' property
     *
     * @return integer
     */
    public function getCards11()
    {
        $value = $this->get(self::CARDS_11);
        return $value === null ? (integer)$value : $value;
    }

    /**
     * Returns true if 'cards_11' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasCards11()
    {
        return $this->get(self::CARDS_11) !== null;
    }

    /**
     * Sets value of 'cards_12' property
     *
     * @param integer $value Property value
     *
     * @return null
     */
    public function setCards12($value)
    {
        return $this->set(self::CARDS_12, $value);
    }

    /**
     * Returns value of 'cards_12' property
     *
     * @return integer
     */
    public function getCards12()
    {
        $value = $this->get(self::CARDS_12);
        return $value === null ? (integer)$value : $value;
    }

    /**
     * Returns true if 'cards_12' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasCards12()
    {
        return $this->get(self::CARDS_12) !== null;
    }

    /**
     * Sets value of 'cards_13' property
     *
     * @param integer $value Property value
     *
     * @return null
     */
    public function setCards13($value)
    {
        return $this->set(self::CARDS_13, $value);
    }

    /**
     * Returns value of 'cards_13' property
     *
     * @return integer
     */
    public function getCards13()
    {
        $value = $this->get(self::CARDS_13);
        return $value === null ? (integer)$value : $value;
    }

    /**
     * Returns true if 'cards_13' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasCards13()
    {
        return $this->get(self::CARDS_13) !== null;
    }

    /**
     * Sets value of 'cards_14' property
     *
     * @param integer $value Property value
     *
     * @return null
     */
    public function setCards14($value)
    {
        return $this->set(self::CARDS_14, $value);
    }

    /**
     * Returns value of 'cards_14' property
     *
     * @return integer
     */
    public function getCards14()
    {
        $value = $this->get(self::CARDS_14);
        return $value === null ? (integer)$value : $value;
    }

    /**
     * Returns true if 'cards_14' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasCards14()
    {
        return $this->get(self::CARDS_14) !== null;
    }

    /**
     * Sets value of 'value_1' property
     *
     * @param integer $value Property value
     *
     * @return null
     */
    public function setValue1($value)
    {
        return $this->set(self::VALUE_1, $value);
    }

    /**
     * Returns value of 'value_1' property
     *
     * @return integer
     */
    public function getValue1()
    {
        $value = $this->get(self::VALUE_1);
        return $value === null ? (integer)$value : $value;
    }

    /**
     * Returns true if 'value_1' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasValue1()
    {
        return $this->get(self::VALUE_1) !== null;
    }

    /**
     * Sets value of 'value_2' property
     *
     * @param integer $value Property value
     *
     * @return null
     */
    public function setValue2($value)
    {
        return $this->set(self::VALUE_2, $value);
    }

    /**
     * Returns value of 'value_2' property
     *
     * @return integer
     */
    public function getValue2()
    {
        $value = $this->get(self::VALUE_2);
        return $value === null ? (integer)$value : $value;
    }

    /**
     * Returns true if 'value_2' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasValue2()
    {
        return $this->get(self::VALUE_2) !== null;
    }

    /**
     * Sets value of 'value_3' property
     *
     * @param integer $value Property value
     *
     * @return null
     */
    public function setValue3($value)
    {
        return $this->set(self::VALUE_3, $value);
    }

    /**
     * Returns value of 'value_3' property
     *
     * @return integer
     */
    public function getValue3()
    {
        $value = $this->get(self::VALUE_3);
        return $value === null ? (integer)$value : $value;
    }

    /**
     * Returns true if 'value_3' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasValue3()
    {
        return $this->get(self::VALUE_3) !== null;
    }

    /**
     * Sets value of 'value_4' property
     *
     * @param integer $value Property value
     *
     * @return null
     */
    public function setValue4($value)
    {
        return $this->set(self::VALUE_4, $value);
    }

    /**
     * Returns value of 'value_4' property
     *
     * @return integer
     */
    public function getValue4()
    {
        $value = $this->get(self::VALUE_4);
        return $value === null ? (integer)$value : $value;
    }

    /**
     * Returns true if 'value_4' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasValue4()
    {
        return $this->get(self::VALUE_4) !== null;
    }

    /**
     * Sets value of 'value_5' property
     *
     * @param integer $value Property value
     *
     * @return null
     */
    public function setValue5($value)
    {
        return $this->set(self::VALUE_5, $value);
    }

    /**
     * Returns value of 'value_5' property
     *
     * @return integer
     */
    public function getValue5()
    {
        $value = $this->get(self::VALUE_5);
        return $value === null ? (integer)$value : $value;
    }

    /**
     * Returns true if 'value_5' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasValue5()
    {
        return $this->get(self::VALUE_5) !== null;
    }

    /**
     * Sets value of 'value_6' property
     *
     * @param integer $value Property value
     *
     * @return null
     */
    public function setValue6($value)
    {
        return $this->set(self::VALUE_6, $value);
    }

    /**
     * Returns value of 'value_6' property
     *
     * @return integer
     */
    public function getValue6()
    {
        $value = $this->get(self::VALUE_6);
        return $value === null ? (integer)$value : $value;
    }

    /**
     * Returns true if 'value_6' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasValue6()
    {
        return $this->get(self::VALUE_6) !== null;
    }

    /**
     * Sets value of 'issue' property
     *
     * @param string $value Property value
     *
     * @return null
     */
    public function setIssue($value)
    {
        return $this->set(self::ISSUE, $value);
    }

    /**
     * Returns value of 'issue' property
     *
     * @return string
     */
    public function getIssue()
    {
        $value = $this->get(self::ISSUE);
        return $value === null ? (string)$value : $value;
    }

    /**
     * Returns true if 'issue' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasIssue()
    {
        return $this->get(self::ISSUE) !== null;
    }

    /**
     * Sets value of 'seed' property
     *
     * @param string $value Property value
     *
     * @return null
     */
    public function setSeed($value)
    {
        return $this->set(self::SEED, $value);
    }

    /**
     * Returns value of 'seed' property
     *
     * @return string
     */
    public function getSeed()
    {
        $value = $this->get(self::SEED);
        return $value === null ? (string)$value : $value;
    }

    /**
     * Returns true if 'seed' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasSeed()
    {
        return $this->get(self::SEED) !== null;
    }
}
}