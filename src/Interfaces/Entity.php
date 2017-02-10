<?php
namespace RedisWrapper\Interfaces;

/**
 * Interface Entity
 * @package RedisWrapper
 */
interface Entity
{
    /**
     * @return string
     */
    public function getKey();

    /**
     * @return Connection
     */
    public function getConnection();

    /**
     * @return int
     */
    public function clear();
}