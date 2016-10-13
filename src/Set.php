<?php
namespace RedisWrapper;

/**
 * Class Set
 * @package RedisWrapper
 */
class Set extends Entity
{
    /**
     * @param string[] ...$values
     * @return int
     */
    public function add(...$values)
    {
        return $this->getConnection()->getClient()->sAdd($this->getKey(), ...$values);
    }

    /**
     * @param string[] ...$values
     * @return int
     */
    public function remove(...$values)
    {
        return $this->getConnection()->getClient()->sRem($this->getKey(), ...$values);
    }

    /**
     * @return int
     */
    public function length()
    {
        return $this->getConnection()->getClient()->sCard($this->getKey());
    }

    /**
     * @param string $value
     * @return bool
     */
    public function contains($value)
    {
        return $this->getConnection()->getClient()->sIsMember($this->getKey(), $value);
    }

    /**
     * Removes and returns a random item from the set
     * @return string
     */
    public function pop()
    {
        return $this->getConnection()->getClient()->sPop($this->getKey());
    }

    /**
     * Gets a random member of the set
     * @return string
     */
    public function random()
    {
        return $this->getConnection()->getClient()->sRandMember($this->getKey());
    }

    /**
     * Gets the difference between this set and the given set(s) and returns it
     * @param Set[] ...$sets
     * @return mixed
     */
    public function diff(Set ...$sets)
    {
        array_unshift($sets, $this);
        return call_user_func_array(
            [
                $this->getConnection()->getClient(),
                'sDiff'
            ],
            array_map(function (Set $set) {
                return $set->getKey();
            }, $sets)
        );
    }

    /**
     * Gets the difference between this set and the given set(s), stores it in a new set and returns it
     * @param Set $destination
     * @param Set[] ...$sets
     * @return Set
     */
    public function diffStore(Set $destination, Set ...$sets)
    {
        array_unshift($sets, $this);
        array_unshift($sets, $destination);
        call_user_func_array(
            [
                $this->getConnection()->getClient(),
                'sDiffStore'
            ],
            array_map(function (Set $set) {
                return $set->getKey();
            }, $sets)
        );
        return $destination;
    }

    /**
     * Gets the intersection between this set and the given set(s) and returns it
     * @param Set[] ...$sets
     * @return mixed
     */
    public function intersect(Set ...$sets)
    {
        array_unshift($sets, $this);
        return call_user_func_array(
            [
                $this->getConnection()->getClient(),
                'sInter'
            ],
            array_map(function (Set $set) {
                return $set->getKey();
            }, $sets)
        );
    }

    /**
     * Gets the intersection between this set and the given set(s), stores it in a new set and returns it
     * @param Set $destination
     * @param Set[] ...$sets
     * @return Set
     */
    public function intersectStore(Set $destination, Set ...$sets)
    {
        array_unshift($sets, $this);
        array_unshift($sets, $destination);
        call_user_func_array(
            [
                $this->getConnection()->getClient(),
                'sInterStore'
            ],
            array_map(function (Set $set) {
                return $set->getKey();
            }, $sets)
        );
        return $destination;
    }

    /**
     * Gets the union of this set and the given set(s) and returns it
     * @param Set[] ...$sets
     * @return mixed
     */
    public function union(Set ...$sets)
    {
        array_unshift($sets, $this);
        return call_user_func_array(
            [
                $this->getConnection()->getClient(),
                'sUnion'
            ],
            array_map(function (Set $set) {
                return $set->getKey();
            }, $sets)
        );
    }

    /**
     * Gets the union of this set and the given set(s), stores it in a new set and returns it
     * @param Set $destination
     * @param Set[] ...$sets
     * @return Set
     */
    public function unionStore(Set $destination, Set ...$sets)
    {
        array_unshift($sets, $this);
        array_unshift($sets, $destination);
        call_user_func_array(
            [
                $this->getConnection()->getClient(),
                'sUnionStore'
            ],
            array_map(function (Set $set) {
                return $set->getKey();
            }, $sets)
        );
        return $destination;
    }

    /**
     * Moves an item from this redis set to another
     * @param Set $destination the set to move the item to
     * @param mixed $value the item to move
     * @return boolean true if the item was moved successfully
     */
    public function move(Set $destination, $value)
    {
        return $this->getConnection()->getClient()->sMove($this->getKey(), $destination->getKey(), $value);
    }
    
    /**
     * Gets all the members in the set
     * @return array
     */
    public function values()
    {
        return $this->getConnection()->getClient()->sMembers($this->getKey());
    }
}
