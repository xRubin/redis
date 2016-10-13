<?php

class SortedSetTest extends PHPUnit_Framework_TestCase
{
    /** @var \RedisWrapper\Connection */
    protected $connection;

    public function setUp()
    {
        $this->connection = new RedisWrapper\Connection('127.0.0.1');
    }

    /**
     * @return \RedisWrapper\SortedSet
     */
    public function testAssignment()
    {
        $key = uniqid('test:SortedSet:');
        $set = new \RedisWrapper\SortedSet($key, $this->connection);

        $this->assertInstanceOf(RedisWrapper\Connection::class, $set->getConnection());
        $this->assertEquals($key, $set->getKey());

        $result = $set->add([
            'hello' => 123,
            'world' => 45
        ]);

        $this->assertEquals(2, $result);
        $this->assertEquals(2, $set->length());

        $result = $set->add(['world' => 234]);
        $this->assertEquals(0, $result);
        $this->assertEquals(2, $set->length());

        $this->assertEquals(123, $set->score('hello'));
        $this->assertEquals(234, $set->score('world'));
        $this->assertFalse($set->score('unknown'));

        return $set;
    }

    /**
     * @depends testAssignment
     * @param \RedisWrapper\SortedSet $set
     * @return \RedisWrapper\SortedSet $set
     */
    public function testDelete(\RedisWrapper\SortedSet $set)
    {
        $result = $set->remove('hello', 'world');
        $this->assertEquals(2, $result);
        $this->assertEquals(0, $set->length());

        return $set;
    }
}