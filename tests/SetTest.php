<?php

class SetTest extends PHPUnit_Framework_TestCase
{
    /** @var \RedisWrapper\Connection */
    protected $connection;

    public function setUp()
    {
        $this->connection = new RedisWrapper\Connection('127.0.0.1');
    }

    /**
     * @return \RedisWrapper\Hash
     */
    public function testAssignment()
    {
        $key = uniqid('test:Set:');
        $set = new \RedisWrapper\Set($key, $this->connection);

        $this->assertInstanceOf(RedisWrapper\Connection::class, $set->getConnection());
        $this->assertEquals($key, $set->getKey());

        $set->add('hello');
        $set->add('world');
        $this->assertEquals(2, $set->length());

        $set->add('world');
        $this->assertEquals(2, $set->length());

        $this->assertTrue($set->contains('hello'));
        $this->assertTrue($set->contains('world'));

        $values = $set->values();
        sort($values);
        $this->assertEquals(['hello', 'world'], $values);

        return $set;
    }

    /**
     * @depends testAssignment
     * @param \RedisWrapper\Set $set
     * @return \RedisWrapper\Set $set
     */
    public function testDelete(\RedisWrapper\Set $set)
    {
        $result = $set->remove('world');
        $this->assertEquals(1, $result);
        $this->assertEquals(1, $set->length());

        $result = $set->remove('world');
        $this->assertEquals(0, $result);
        $this->assertEquals(1, $set->length());

        return $set;
    }

    /**
     * @depends testAssignment
     * @param \RedisWrapper\Set $set
     * @return \RedisWrapper\Set $set
     */
    public function testPop(\RedisWrapper\Set $set)
    {
        $this->assertEquals(1, $set->length());

        $set->add('world');
        $value = $set->pop();

        $this->assertTrue(is_string($value));
        $this->assertEquals(1, $set->length());

        return $set;
    }

    /**
     * @depends testAssignment
     * @param \RedisWrapper\Set $set
     */
    public function testClear(\RedisWrapper\Set $set)
    {
        $result = $set->clear();

        $this->assertEquals(1, $result);
        $this->assertFalse($set->getConnection()->getClient()->exists($set->getKey()));
        $this->assertEquals(0, $set->length());
    }

    public function testDiff()
    {
        $set1 = new \RedisWrapper\Set(uniqid('test:Set:'), $this->connection);
        $set1->add('a');
        $set1->add('b');
        $set1->add('c');
        
        $set2 = new \RedisWrapper\Set(uniqid('test:Set:'), $this->connection);
        $set2->add('b');
        $set2->add('c');
        $set2->add('d');

        $set3 = new \RedisWrapper\Set(uniqid('test:Set:'), $this->connection);
        $set3->add('c');
        $set3->add('d');
        $set3->add('e');

        $this->assertEquals(['a'], $set1->diff($set2, $set3));
        
        $set1->clear();
        $set2->clear();
        $set3->clear();
    }

    public function testIntersection()
    {
        $set1 = new \RedisWrapper\Set(uniqid('test:Set:'), $this->connection);
        $set1->add('a');
        $set1->add('b');
        $set1->add('c');

        $set2 = new \RedisWrapper\Set(uniqid('test:Set:'), $this->connection);
        $set2->add('b');
        $set2->add('c');
        $set2->add('d');

        $set3 = new \RedisWrapper\Set(uniqid('test:Set:'), $this->connection);
        $set3->add('c');
        $set3->add('d');
        $set3->add('e');

        $this->assertEquals(['c'], $set1->intersect($set2, $set3));

        $set1->clear();
        $set2->clear();
        $set3->clear();
    }

    public function testUnion()
    {
        $set1 = new \RedisWrapper\Set(uniqid('test:Set:'), $this->connection);
        $set1->add('a');
        $set1->add('b');
        $set1->add('c');

        $set2 = new \RedisWrapper\Set(uniqid('test:Set:'), $this->connection);
        $set2->add('b');
        $set2->add('c');
        $set2->add('d');

        $set3 = new \RedisWrapper\Set(uniqid('test:Set:'), $this->connection);
        $set3->add('c');
        $set3->add('d');
        $set3->add('e');

        $result = $set1->union($set2, $set3);
        sort($result);
        $this->assertEquals(['a', 'b', 'c', 'd', 'e'], $result);

        $set1->clear();
        $set2->clear();
        $set3->clear();
    }
}