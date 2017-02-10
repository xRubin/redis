<?php
namespace RedisWrapper;

use RedisWrapper\Interfaces;
/**
 * Class SortedSet
 * @package RedisWrapper
 */
class SortedSet extends Entity implements Interfaces\SortedSet
{
    /**
     * @example
     * <pre>
     * $sortedSet->add([
     *      $key1 => $value1,
     *      $key2 => $value2
     * ]);
     * </pre>
     * @param array $data
     * @return int
     */
    public function add(array $data)
    {
        return $this->getConnection()->getClient()->zAdd($this->getKey(), ...$this->dataToParams($data));
    }

    /**
     * @param string[] ...$values
     * @return int
     */
    public function remove(...$values)
    {
        return $this->getConnection()->getClient()->zRem($this->getKey(), ...$values);
    }

    /**
     * @return int
     */
    public function length()
    {
        return $this->getConnection()->getClient()->zCard($this->getKey());
    }

    /**
     * @param string $key
     * @return float|false
     */
    public function score($key)
    {
        return $this->getConnection()->getClient()->zScore($this->getKey(), $key);
    }


    /**
     * Returns the number of elements of the sorted set stored at the specified key which have
     * scores in the range [start,end].
     * @param mixed $start
     * @param mixed $end
     * @return int
     */
    public function count($start = self::INFINUM_MIN, $end = self::INFINUM_MAX)
    {
        return $this->getConnection()->getClient()->zCount($this->getKey(), $start, $end);
    }

    /**
     * @param string $key
     * @param float $value
     * @return float
     */
    public function increment($key, $value = 1.0)
    {
        return $this->getConnection()->getClient()->zIncrBy($this->getKey(), $value, $key);
    }

    /**
     * @param string $key
     * @return int
     */
    public function rank($key)
    {
        return $this->getConnection()->getClient()->zRank($this->getKey(), $key);
    }

    /**
     * @param string $key
     * @return int
     */
    public function reverseRank($key)
    {
        return $this->getConnection()->getClient()->zRevRank($this->getKey(), $key);
    }

    /**
     * @param   int $start
     * @param   int $end
     * @param   bool $withScores
     * @return  array
     * @example
     * <pre>
     * $sortedSet->range(0, -1); // array('val0', 'val2', 'val10')
     * // with scores
     * $sortedSet->zRange(0, -1, true); // array('val0' => 0, 'val2' => 2, 'val10' => 10)
     * </pre>
     */
    public function range($start, $end, $withScores = null)
    {
        return $this->getConnection()->getClient()->zRange($this->getKey(), $start, $end, $withScores);
    }

    /**
     * @param   int $start
     * @param   int $end
     * @param   bool $withScores
     * @return  array
     */
    public function reverseRange($start, $end, $withScores = null)
    {
        return $this->getConnection()->getClient()->zRevRange($this->getKey(), $start, $end, $withScores);
    }

    /**
     * @param int $start
     * @param int $end
     * @param boolean $withScores
     * @param integer $limitOffset
     * @param integer $limitCount
     * @return  array
     */
    public function rangeByScore($start, $end, $withScores = null, $limitOffset = null, $limitCount = null)
    {
        $options = [];
        if (null !== $withScores)
            $options['withscores'] = $withScores;
        if ((null !== $limitOffset) || (null !== $limitCount))
            $options['limit'] = [$limitOffset, $limitCount];
        return $this->getConnection()->getClient()->zRangeByScore($this->getKey(), $start, $end, $options);
    }

    /**
     * @param int $start
     * @param int $end
     * @param boolean $withScores
     * @param integer $limitOffset
     * @param integer $limitCount
     * @return  array
     */
    public function reverseRangeByScore($start, $end, $withScores = null, $limitOffset = null, $limitCount = null)
    {
        $options = [];
        if (null !== $withScores)
            $options['withscores'] = $withScores;
        if ((null !== $limitOffset) || (null !== $limitCount))
            $options['limit'] = [$limitOffset, $limitCount];
        return $this->getConnection()->getClient()->zRevRangeByScore($this->getKey(), $start, $end, $options);
    }


    /**
     * @param Interfaces\SortedSet $destination
     * @param array $data
     * @param string $aggregateFunction
     * @return int
     */
    public function intersectStore(Interfaces\SortedSet $destination, array $data, $aggregateFunction = self::AGGREGATE_SUM)
    {
        return $this->getConnection()->getClient()->zInter($destination->getKey(), array_keys($data), array_values($data), $aggregateFunction);
    }

    /**
     * @param Interfaces\SortedSet $destination
     * @param array $data
     * @param string $aggregateFunction
     * @return int
     */
    public function unionStore(Interfaces\SortedSet $destination, array $data, $aggregateFunction = self::AGGREGATE_SUM)
    {
        return $this->getConnection()->getClient()->zUnion($destination->getKey(), array_keys($data), array_values($data), $aggregateFunction);
    }

    /**
     * @param int $start
     * @param int $end
     * @return int
     */
    public function removeRangeByRank($start, $end)
    {
        return $this->getConnection()->getClient()->zRemRangeByRank($this->getKey(), $start, $end);
    }

    /**
     * @param mixed $min
     * @param mixed $max
     * @return int
     */
    public function removeRangeByScore($min, $max)
    {
        return $this->getConnection()->getClient()->zRemRangeByScore($this->getKey(), $min, $max);
    }

    /**
     * @param array $data
     * @return array
     */
    protected function dataToParams(array $data)
    {
        $params = [];
        array_walk($data, function ($value, $key) use (&$params) {
            $params[] = $value;
            $params[] = $key;
        });
        return $params;
    }
}
