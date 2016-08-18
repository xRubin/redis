<?php
namespace RedisWrapper;

class Connection
{
    protected $_client;

    public function __construct( $host, $port = 6379, $timeout = 0.0 )
    {
        $this->_client = new \Redis();
        $this->_client->connect($host, $port, $timeout);
    }
}