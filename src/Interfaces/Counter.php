<?php
namespace RedisWrapper\Interfaces;

/**
 * Interface Counter
 * @package RedisWrapper
 */
interface Counter extends Entity
{
    /**
     * @param int $value
     * @return int
     */
    public function increment($value = 1);

    /**
     * @param int $value
     * @return int
     */
    public function decrement($value = 1);

    /**
     * @return int
     */
    public function getValue();

    /**
     * @param int $value
     * @return bool
     */
    public function setValue($value);
}
