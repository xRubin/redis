<?php
namespace RedisWrapper;

use RedisWrapper\Interfaces;
use RedisWrapper\Exceptions;

/**
 * Class Connection
 * @package RedisWrapper
 */
class Connection implements Interfaces\Connection
{
    /**
     * @var \Redis
     */
    protected $_client;

    /**
     * Connection constructor.
     * @param   string $host can be a host, or the path to a unix domain socket
     * @param   integer $port optional
     * @param   float $timeout value in seconds (optional, default is 0.0 meaning unlimited)
     */
    public function __construct($host, $port = 6379, $timeout = 0.0)
    {
        $this->_client = new \Redis();
        $this->_client->pconnect($host, $port, $timeout);
    }

    /**
     * @return \Redis
     */
    public function getClient()
    {
        return $this->_client;
    }

    /**
     * @param   string $password
     * @throws  Exceptions\AuthenticationException
     * @return  bool
     */
    public function auth($password)
    {
        if ($this->getClient()->auth($password) === false) {
            throw new Exceptions\AuthenticationException('Redis authentication failed!');
        }

        return true;
    }

    /**
     * @param integer $dbIndex
     * @return  bool
     */
    public function select($dbIndex)
    {
        return $this->getClient()->select($dbIndex);
    }

    /**
     * @param   string $name parameter name
     * @param   string $value parameter value
     * @return  bool
     */
    public function setOption($name, $value)
    {
        return $this->getClient()->setOption($name, $value);
    }
}