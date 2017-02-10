<?php
namespace RedisWrapper\Interfaces;

use RedisWrapper\Exceptions;

/**
 * Interface Connection
 * @package RedisWrapper
 */
interface Connection
{
    /**
     * @return   \Redis
     */
    public function getClient();

    /**
     * @param    string $password
     * @return   bool
     * @throws   Exceptions\AuthenticationException
     */
    public function auth($password);

    /**
     * @param    integer $dbIndex
     * @return   bool
     */
    public function select($dbIndex);

    /**
     * @param    string $name parameter name
     * @param    string $value parameter value
     * @return   bool
     */
    public function setOption($name, $value);
}