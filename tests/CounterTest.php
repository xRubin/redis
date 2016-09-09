<?php

class CounterTest extends PHPUnit_Framework_TestCase
{
    /** @var \RedisWrapper\Connection */
    protected $connection;

    public function setUp()
    {
        $this->connection = new RedisWrapper\Connection('127.0.0.1');
    }

    /**
     * @return \RedisWrapper\Counter
     */
    public function testAssignment()
    {
        $key = uniqid('test:Counter:');
        $counter = new \RedisWrapper\Counter($key, $this->connection);

        $this->assertInstanceOf(RedisWrapper\Connection::class, $counter->getConnection());
        $this->assertEquals($key, $counter->getKey());

        $value = mt_rand(1000, 9999);
        $result = $counter->setValue($value);

        $this->assertTrue($result);
        $this->assertEquals($value, $counter->getValue());
        $this->assertTrue($counter->getConnection()->getClient()->exists($counter->getKey()));

        return $counter;
    }

    /**
     * @depends testAssignment
     * @param \RedisWrapper\Counter $counter
     * @return \RedisWrapper\Counter
     */
    public function testIncrement(\RedisWrapper\Counter $counter)
    {
        $value = $counter->getValue();

        $result = $counter->increment();

        $this->assertEquals($value + 1, $result);
        $this->assertEquals($value + 1, $counter->getValue());

        return $counter;
    }

    /**
     * @depends testAssignment
     * @param \RedisWrapper\Counter $counter
     * @return \RedisWrapper\Counter
     */
    public function testDecrement(\RedisWrapper\Counter $counter)
    {
        $value = $counter->getValue();

        $result = $counter->decrement();

        $this->assertEquals($value - 1, $result);
        $this->assertEquals($value - 1, $counter->getValue());

        return $counter;
    }

    /**
     * @depends testAssignment
     * @param \RedisWrapper\Counter $counter
     * @return \RedisWrapper\Counter
     */
    public function testIncrementToPositiveNumber(\RedisWrapper\Counter $counter)
    {
        $value = $counter->getValue();

        $diff = mt_rand(100, 999);
        $result = $counter->increment($diff);

        $this->assertEquals($value + $diff, $result);
        $this->assertEquals($value + $diff, $counter->getValue());

        return $counter;
    }

    /**
     * @depends testAssignment
     * @param \RedisWrapper\Counter $counter
     * @return \RedisWrapper\Counter
     */
    public function testIncrementToZero(\RedisWrapper\Counter $counter)
    {
        $value = $counter->getValue();

        $result = $counter->increment(0);

        $this->assertEquals($value, $result);
        $this->assertEquals($value, $counter->getValue());

        return $counter;
    }

    /**
     * @depends testAssignment
     * @param \RedisWrapper\Counter $counter
     * @return \RedisWrapper\Counter
     */
    public function testIncrementToNegativeNumber(\RedisWrapper\Counter $counter)
    {
        $value = $counter->getValue();

        $diff = - mt_rand(100, 999);
        $result = $counter->increment($diff);

        $this->assertEquals($value + $diff, $result);
        $this->assertEquals($value + $diff, $counter->getValue());

        return $counter;
    }

    /**
     * @depends testAssignment
     * @param \RedisWrapper\Counter $counter
     * @return \RedisWrapper\Counter
     */
    public function testDecrementToPositiveNumber(\RedisWrapper\Counter $counter)
    {
        $value = $counter->getValue();

        $diff = mt_rand(100, 999);
        $result = $counter->decrement($diff);

        $this->assertEquals($value - $diff, $result);
        $this->assertEquals($value - $diff, $counter->getValue());

        return $counter;
    }

    /**
     * @depends testAssignment
     * @param \RedisWrapper\Counter $counter
     * @return \RedisWrapper\Counter
     */
    public function testDecrementToZero(\RedisWrapper\Counter $counter)
    {
        $value = $counter->getValue();

        $result = $counter->decrement(0);

        $this->assertEquals($value, $result);
        $this->assertEquals($value, $counter->getValue());

        return $counter;
    }

    /**
     * @depends testAssignment
     * @param \RedisWrapper\Counter $counter
     * @return \RedisWrapper\Counter
     */
    public function testDecrementToNegativeNumber(\RedisWrapper\Counter $counter)
    {
        $value = $counter->getValue();

        $diff = - mt_rand(100, 999);
        $result = $counter->decrement($diff);

        $this->assertEquals($value - $diff, $result);
        $this->assertEquals($value - $diff, $counter->getValue());

        return $counter;
    }

    /**
     * @depends testAssignment
     * @param \RedisWrapper\Counter $counter
     */
    public function testClear(\RedisWrapper\Counter $counter)
    {
        $result = $counter->clear();

        $this->assertEquals(1, $result);
        $this->assertFalse($counter->getConnection()->getClient()->exists($counter->getKey()));
    }
}