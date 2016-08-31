<?php
namespace RedisWrapper;

/**
 * Class Hash
 * no multi
 * no scan
 * @package RedisWrapper
 */
class Hash extends Entity
{
    /**
     * @param string $name
     * @param mixed $value
     * @return mixed
     * @throws \ErrorException
     */
    public function __set($name, $value)
    {
        $setter = 'set' . ucfirst($name);

        if (method_exists($this, $setter))
            return $this->$setter($value);

        return $this->getConnection()->getClient()->hSet($this->getKey(), $name, $value);
    }

    /**
     * @param string $name
     * @return mixed
     * @throws \ErrorException
     */
    public function __get($name)
    {
        $getter = 'get' . ucfirst($name);

        if (method_exists($this, $getter))
            return $this->$getter;

        return $this->getConnection()->getClient()->hGet($this->getKey(), $name);
    }

    /**
     * @param string $name
     * @return bool
     */
    public function __isset($name)
    {
        $getter = 'get' . ucfirst($name);

        if (method_exists($this, $getter))
            return $this->$getter() !== null;

        return $this->getConnection()->getClient()->hExists($this->getKey(), $name);
    }

    /**
     * @param string $name
     * @return mixed
     */
    public function __unset($name)
    {
        $setter = 'set' . ucfirst($name);

        if (method_exists($this, $setter))
            return $this->$setter(null);
        else
            $this->getConnection()->getClient()->hDel($this->getKey(), $name);
    }

    /**
     * @return array
     */
    public function keys()
    {
        return $this->getConnection()->getClient()->hKeys($this->getKey());
    }

    /**
     * Returns all values in the hash stored at key.
     * @return array
     */
    public function values()
    {
        return $this->getConnection()->getClient()->hVals($this->getKey());
    }

    /**
     * @return array
     */
    public function attributes()
    {
        return $this->getConnection()->getClient()->hGetAll($this->getKey());
    }

    /**
     * @return int|bool
     */
    public function length()
    {
        return $this->getConnection()->getClient()->hLen($this->getKey());
    }

    /**
     * @param string $name
     * @param int|float $incrBy
     * @return int|float
     */
    public function increment($name, $incrBy = 1)
    {
        if (is_float($incrBy)) {
            return $this->getConnection()->getClient()->hIncrByFloat($this->getKey(), $name, (float)$incrBy);
        } else {
            return $this->getConnection()->getClient()->hIncrBy($this->getKey(), $name, (int)$incrBy);
        }
    }

    /**
     * @param string $name
     * @param mixed $value
     * @return bool
     */
    public function add($name, $value)
    {
        return $this->getConnection()->getClient()->hSetNx($this->getKey(), $name, $value);
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return json_encode($this->attributes());
    }
}