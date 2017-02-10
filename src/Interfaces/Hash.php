<?php
namespace RedisWrapper\Interfaces;

/**
 * Interface Hash
 * @package RedisWrapper
 */
interface Hash extends Entity
{
    /**
     * @return array
     */
    public function keys();

    /**
     * Returns all values in the hash stored at key.
     * @return array
     */
    public function values();

    /**
     * @return array
     */
    public function attributes();

    /**
     * @return int|bool
     */
    public function length();

    /**
     * @param string $name
     * @param int|float $incrBy
     * @return int|float
     */
    public function increment($name, $incrBy = 1);

    /**
     * @param string $name
     * @param mixed $value
     * @return bool
     */
    public function add($name, $value);
}