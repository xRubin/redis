<?php
namespace RedisWrapper\Interfaces;

/**
 * Interface Set
 * @package RedisWrapper
 */
interface Set extends Entity
{
    /**
     * Gets all the members in the set
     * @return array
     */
    public function values();

    /**
     * @param string[] ...$values
     * @return int
     */
    public function add(...$values);

    /**
     * @param string[] ...$values
     * @return int
     */
    public function remove(...$values);

    /**
     * @return int
     */
    public function length();

    /**
     * @param string $value
     * @return bool
     */
    public function contains($value);

    /**
     * Removes and returns a random item from the set
     * @return string
     */
    public function pop();

    /**
     * Gets a random member of the set
     * @return string
     */
    public function random();

    /**
     * Gets the difference between this set and the given set(s) and returns it
     * @param Set[] ...$sets
     * @return mixed
     */
    public function diff(Set ...$sets);

    /**
     * Gets the difference between this set and the given set(s), stores it in a new set and returns it
     * @param Set $destination
     * @param Set[] ...$sets
     * @return Set
     */
    public function diffStore(Set $destination, Set ...$sets);

    /**
     * Gets the intersection between this set and the given set(s) and returns it
     * @param Set[] ...$sets
     * @return mixed
     */
    public function intersect(Set ...$sets);
    /**
     * Gets the intersection between this set and the given set(s), stores it in a new set and returns it
     * @param Set $destination
     * @param Set[] ...$sets
     * @return Set
     */
    public function intersectStore(Set $destination, Set ...$sets);

    /**
     * Gets the union of this set and the given set(s) and returns it
     * @param Set[] ...$sets
     * @return mixed
     */
    public function union(Set ...$sets);

    /**
     * Gets the union of this set and the given set(s), stores it in a new set and returns it
     * @param Set $destination
     * @param Set[] ...$sets
     * @return Set
     */
    public function unionStore(Set $destination, Set ...$sets);

    /**
     * Moves an item from this redis set to another
     * @param Set $destination the set to move the item to
     * @param mixed $value the item to move
     * @return boolean true if the item was moved successfully
     */
    public function move(Set $destination, $value);
}
