<?php
/**
 * Auto generated from poker_config.proto at 2023-06-08 09:49:25
 */

namespace {
/**
 * PBLogsvrdConfig message
 */
class PBLogsvrdConfig extends \ProtobufMessage
{
    /* Field index constants */
    const IP = 1;
    const PORT = 2;
    const DB_HOST = 3;
    const DB_PORT = 4;
    const DB_USER = 5;
    const DB_PWD = 6;
    const DB_NAME = 7;
    const MAX_SQL_NUM = 8;

    /* @var array Field descriptors */
    protected static $fields = array(
        self::IP => array(
            'name' => 'ip',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_STRING,
        ),
        self::PORT => array(
            'name' => 'port',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_INT,
        ),
        self::DB_HOST => array(
            'name' => 'db_host',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_STRING,
        ),
        self::DB_PORT => array(
            'name' => 'db_port',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_INT,
        ),
        self::DB_USER => array(
            'name' => 'db_user',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_STRING,
        ),
        self::DB_PWD => array(
            'name' => 'db_pwd',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_STRING,
        ),
        self::DB_NAME => array(
            'name' => 'db_name',
            'required' => false,
            'type' => \ProtobufMessage::PB_TYPE_STRING,
        ),
        self::MAX_SQL_NUM => array(
            'name' => 'max_sql_num',
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
        $this->values[self::IP] = null;
        $this->values[self::PORT] = null;
        $this->values[self::DB_HOST] = null;
        $this->values[self::DB_PORT] = null;
        $this->values[self::DB_USER] = null;
        $this->values[self::DB_PWD] = null;
        $this->values[self::DB_NAME] = null;
        $this->values[self::MAX_SQL_NUM] = null;
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
     * Sets value of 'ip' property
     *
     * @param string $value Property value
     *
     * @return null
     */
    public function setIp($value)
    {
        return $this->set(self::IP, $value);
    }

    /**
     * Returns value of 'ip' property
     *
     * @return string
     */
    public function getIp()
    {
        $value = $this->get(self::IP);
        return $value === null ? (string)$value : $value;
    }

    /**
     * Returns true if 'ip' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasIp()
    {
        return $this->get(self::IP) !== null;
    }

    /**
     * Sets value of 'port' property
     *
     * @param integer $value Property value
     *
     * @return null
     */
    public function setPort($value)
    {
        return $this->set(self::PORT, $value);
    }

    /**
     * Returns value of 'port' property
     *
     * @return integer
     */
    public function getPort()
    {
        $value = $this->get(self::PORT);
        return $value === null ? (integer)$value : $value;
    }

    /**
     * Returns true if 'port' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasPort()
    {
        return $this->get(self::PORT) !== null;
    }

    /**
     * Sets value of 'db_host' property
     *
     * @param string $value Property value
     *
     * @return null
     */
    public function setDbHost($value)
    {
        return $this->set(self::DB_HOST, $value);
    }

    /**
     * Returns value of 'db_host' property
     *
     * @return string
     */
    public function getDbHost()
    {
        $value = $this->get(self::DB_HOST);
        return $value === null ? (string)$value : $value;
    }

    /**
     * Returns true if 'db_host' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasDbHost()
    {
        return $this->get(self::DB_HOST) !== null;
    }

    /**
     * Sets value of 'db_port' property
     *
     * @param integer $value Property value
     *
     * @return null
     */
    public function setDbPort($value)
    {
        return $this->set(self::DB_PORT, $value);
    }

    /**
     * Returns value of 'db_port' property
     *
     * @return integer
     */
    public function getDbPort()
    {
        $value = $this->get(self::DB_PORT);
        return $value === null ? (integer)$value : $value;
    }

    /**
     * Returns true if 'db_port' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasDbPort()
    {
        return $this->get(self::DB_PORT) !== null;
    }

    /**
     * Sets value of 'db_user' property
     *
     * @param string $value Property value
     *
     * @return null
     */
    public function setDbUser($value)
    {
        return $this->set(self::DB_USER, $value);
    }

    /**
     * Returns value of 'db_user' property
     *
     * @return string
     */
    public function getDbUser()
    {
        $value = $this->get(self::DB_USER);
        return $value === null ? (string)$value : $value;
    }

    /**
     * Returns true if 'db_user' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasDbUser()
    {
        return $this->get(self::DB_USER) !== null;
    }

    /**
     * Sets value of 'db_pwd' property
     *
     * @param string $value Property value
     *
     * @return null
     */
    public function setDbPwd($value)
    {
        return $this->set(self::DB_PWD, $value);
    }

    /**
     * Returns value of 'db_pwd' property
     *
     * @return string
     */
    public function getDbPwd()
    {
        $value = $this->get(self::DB_PWD);
        return $value === null ? (string)$value : $value;
    }

    /**
     * Returns true if 'db_pwd' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasDbPwd()
    {
        return $this->get(self::DB_PWD) !== null;
    }

    /**
     * Sets value of 'db_name' property
     *
     * @param string $value Property value
     *
     * @return null
     */
    public function setDbName($value)
    {
        return $this->set(self::DB_NAME, $value);
    }

    /**
     * Returns value of 'db_name' property
     *
     * @return string
     */
    public function getDbName()
    {
        $value = $this->get(self::DB_NAME);
        return $value === null ? (string)$value : $value;
    }

    /**
     * Returns true if 'db_name' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasDbName()
    {
        return $this->get(self::DB_NAME) !== null;
    }

    /**
     * Sets value of 'max_sql_num' property
     *
     * @param integer $value Property value
     *
     * @return null
     */
    public function setMaxSqlNum($value)
    {
        return $this->set(self::MAX_SQL_NUM, $value);
    }

    /**
     * Returns value of 'max_sql_num' property
     *
     * @return integer
     */
    public function getMaxSqlNum()
    {
        $value = $this->get(self::MAX_SQL_NUM);
        return $value === null ? (integer)$value : $value;
    }

    /**
     * Returns true if 'max_sql_num' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasMaxSqlNum()
    {
        return $this->get(self::MAX_SQL_NUM) !== null;
    }
}
}