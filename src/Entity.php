<?php
namespace RedisWrapper;

/**
 * Class Entity
 * @package RedisWrapper
 */
abstract class Entity
{
    /**
     * @var string
     */
    protected $_key;

    /**
     * @var Connection
     */
    protected $_connection;

    /**
     * @param string $key
     * @param Connection $connection
     */
    public function __construct($key, Connection $connection)
    {
        $this->_key = $key;
        $this->_connection = $connection;
    }

    /**
     * @return string
     */
    public function getKey()
    {
        return $this->_key;
    }

    /**
     * @return Connection
     */
    public function getConnection()
    {
        return $this->_connection;
    }

    /**
     * @return int
     */
    public function clear()
    {
        return $this->getConnection()->getClient()->del($this->getKey());
    }
}