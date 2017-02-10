<?php
namespace RedisWrapper\Interfaces;

/**
 * Interface SortedSet
 * @package RedisWrapper
 */
interface SortedSet extends Entity
{
    const AGGREGATE_SUM = 'SUM';
    const AGGREGATE_MIN = 'MIN';
    const AGGREGATE_MAX = 'MAX';

    const INFINUM_MIN = '-inf';
    const INFINUM_MAX = '+inf';

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
    public function add(array $data);

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
     * @param string $key
     * @return float|false
     */
    public function score($key);


    /**
     * Returns the number of elements of the sorted set stored at the specified key which have
     * scores in the range [start,end].
     * @param mixed $start
     * @param mixed $end
     * @return int
     */
    public function count($start = self::INFINUM_MIN, $end = self::INFINUM_MAX);

    /**
     * @param string $key
     * @param float $value
     * @return float
     */
    public function increment($key, $value = 1.0);

    /**
     * @param string $key
     * @return int
     */
    public function rank($key);

    /**
     * @param string $key
     * @return int
     */
    public function reverseRank($key);

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
    public function range($start, $end, $withScores = null);

    /**
     * @param   int $start
     * @param   int $end
     * @param   bool $withScores
     * @return  array
     */
    public function reverseRange($start, $end, $withScores = null);
    /**
     * @param int $start
     * @param int $end
     * @param boolean $withScores
     * @param integer $limitOffset
     * @param integer $limitCount
     * @return  array
     */
    public function rangeByScore($start, $end, $withScores = null, $limitOffset = null, $limitCount = null);

    /**
     * @param int $start
     * @param int $end
     * @param boolean $withScores
     * @param integer $limitOffset
     * @param integer $limitCount
     * @return  array
     */
    public function reverseRangeByScore($start, $end, $withScores = null, $limitOffset = null, $limitCount = null);

    /**
     * @param SortedSet $destination
     * @param array $data
     * @param string $aggregateFunction
     * @return int
     */
    public function intersectStore(SortedSet $destination, array $data, $aggregateFunction = self::AGGREGATE_SUM);

    /**
     * @param SortedSet $destination
     * @param array $data
     * @param string $aggregateFunction
     * @return int
     */
    public function unionStore(SortedSet $destination, array $data, $aggregateFunction = self::AGGREGATE_SUM);

    /**
     * @param int $start
     * @param int $end
     * @return int
     */
    public function removeRangeByRank($start, $end);

    /**
     * @param mixed $min
     * @param mixed $max
     * @return int
     */
    public function removeRangeByScore($min, $max);
}
