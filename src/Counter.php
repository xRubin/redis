<?php
namespace RedisWrapper;

/**
 * Class Counter
 * @package RedisWrapper
 */
class Counter extends Entity
{
    /**
     * @param int $value
     * @return int
     */
    public function increment($value = 1)
    {
        return $this->getConnection()->getClient()->incrBy($this->getKey(), $value);
    }

    /**
     * @param int $value
     * @return int
     */
    public function decrement($value = 1)
    {
        return $this->getConnection()->getClient()->decrBy($this->getKey(), $value);
    }

    /**
     * @return int
     */
    public function getValue()
    {
        return (int)$this->getConnection()->getClient()->get($this->getKey());
    }

    /**
     * @param int $value
     * @return bool
     */
    public function setValue($value)
    {
        return $this->getConnection()->getClient()->set($this->getKey(), $value);
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return (string)$this->getValue();
    }
}
