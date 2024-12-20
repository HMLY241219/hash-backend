<?php
/**
 * Auto generated from poker_msg_cs.proto at 2023-06-08 09:49:25
 */

namespace {
/**
 * SCResponseRotaryConfig message
 */
class SCResponseRotaryConfig extends \ProtobufMessage
{
    /* Field index constants */
    const ROTARY_1 = 1;
    const ROTARY_2 = 2;
    const ROTARY_3 = 3;
    const ROTARY_NUM = 4;

    /* @var array Field descriptors */
    protected static $fields = array(
        self::ROTARY_1 => array(
            'name' => 'rotary_1',
            'repeated' => true,
            'type' => '\CSRotaryConfiginfo'
        ),
        self::ROTARY_2 => array(
            'name' => 'rotary_2',
            'repeated' => true,
            'type' => '\CSRotaryConfiginfo'
        ),
        self::ROTARY_3 => array(
            'name' => 'rotary_3',
            'repeated' => true,
            'type' => '\CSRotaryConfiginfo'
        ),
        self::ROTARY_NUM => array(
            'name' => 'rotary_num',
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
        $this->values[self::ROTARY_1] = array();
        $this->values[self::ROTARY_2] = array();
        $this->values[self::ROTARY_3] = array();
        $this->values[self::ROTARY_NUM] = null;
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
     * Appends value to 'rotary_1' list
     *
     * @param \CSRotaryConfiginfo $value Value to append
     *
     * @return null
     */
    public function appendRotary1(\CSRotaryConfiginfo $value)
    {
        return $this->append(self::ROTARY_1, $value);
    }

    /**
     * Clears 'rotary_1' list
     *
     * @return null
     */
    public function clearRotary1()
    {
        return $this->clear(self::ROTARY_1);
    }

    /**
     * Returns 'rotary_1' list
     *
     * @return \CSRotaryConfiginfo[]
     */
    public function getRotary1()
    {
        return $this->get(self::ROTARY_1);
    }

    /**
     * Returns true if 'rotary_1' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasRotary1()
    {
        return count($this->get(self::ROTARY_1)) !== 0;
    }

    /**
     * Returns 'rotary_1' iterator
     *
     * @return \ArrayIterator
     */
    public function getRotary1Iterator()
    {
        return new \ArrayIterator($this->get(self::ROTARY_1));
    }

    /**
     * Returns element from 'rotary_1' list at given offset
     *
     * @param int $offset Position in list
     *
     * @return \CSRotaryConfiginfo
     */
    public function getRotary1At($offset)
    {
        return $this->get(self::ROTARY_1, $offset);
    }

    /**
     * Returns count of 'rotary_1' list
     *
     * @return int
     */
    public function getRotary1Count()
    {
        return $this->count(self::ROTARY_1);
    }

    /**
     * Appends value to 'rotary_2' list
     *
     * @param \CSRotaryConfiginfo $value Value to append
     *
     * @return null
     */
    public function appendRotary2(\CSRotaryConfiginfo $value)
    {
        return $this->append(self::ROTARY_2, $value);
    }

    /**
     * Clears 'rotary_2' list
     *
     * @return null
     */
    public function clearRotary2()
    {
        return $this->clear(self::ROTARY_2);
    }

    /**
     * Returns 'rotary_2' list
     *
     * @return \CSRotaryConfiginfo[]
     */
    public function getRotary2()
    {
        return $this->get(self::ROTARY_2);
    }

    /**
     * Returns true if 'rotary_2' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasRotary2()
    {
        return count($this->get(self::ROTARY_2)) !== 0;
    }

    /**
     * Returns 'rotary_2' iterator
     *
     * @return \ArrayIterator
     */
    public function getRotary2Iterator()
    {
        return new \ArrayIterator($this->get(self::ROTARY_2));
    }

    /**
     * Returns element from 'rotary_2' list at given offset
     *
     * @param int $offset Position in list
     *
     * @return \CSRotaryConfiginfo
     */
    public function getRotary2At($offset)
    {
        return $this->get(self::ROTARY_2, $offset);
    }

    /**
     * Returns count of 'rotary_2' list
     *
     * @return int
     */
    public function getRotary2Count()
    {
        return $this->count(self::ROTARY_2);
    }

    /**
     * Appends value to 'rotary_3' list
     *
     * @param \CSRotaryConfiginfo $value Value to append
     *
     * @return null
     */
    public function appendRotary3(\CSRotaryConfiginfo $value)
    {
        return $this->append(self::ROTARY_3, $value);
    }

    /**
     * Clears 'rotary_3' list
     *
     * @return null
     */
    public function clearRotary3()
    {
        return $this->clear(self::ROTARY_3);
    }

    /**
     * Returns 'rotary_3' list
     *
     * @return \CSRotaryConfiginfo[]
     */
    public function getRotary3()
    {
        return $this->get(self::ROTARY_3);
    }

    /**
     * Returns true if 'rotary_3' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasRotary3()
    {
        return count($this->get(self::ROTARY_3)) !== 0;
    }

    /**
     * Returns 'rotary_3' iterator
     *
     * @return \ArrayIterator
     */
    public function getRotary3Iterator()
    {
        return new \ArrayIterator($this->get(self::ROTARY_3));
    }

    /**
     * Returns element from 'rotary_3' list at given offset
     *
     * @param int $offset Position in list
     *
     * @return \CSRotaryConfiginfo
     */
    public function getRotary3At($offset)
    {
        return $this->get(self::ROTARY_3, $offset);
    }

    /**
     * Returns count of 'rotary_3' list
     *
     * @return int
     */
    public function getRotary3Count()
    {
        return $this->count(self::ROTARY_3);
    }

    /**
     * Sets value of 'rotary_num' property
     *
     * @param integer $value Property value
     *
     * @return null
     */
    public function setRotaryNum($value)
    {
        return $this->set(self::ROTARY_NUM, $value);
    }

    /**
     * Returns value of 'rotary_num' property
     *
     * @return integer
     */
    public function getRotaryNum()
    {
        $value = $this->get(self::ROTARY_NUM);
        return $value === null ? (integer)$value : $value;
    }

    /**
     * Returns true if 'rotary_num' property is set, false otherwise
     *
     * @return boolean
     */
    public function hasRotaryNum()
    {
        return $this->get(self::ROTARY_NUM) !== null;
    }
}
}