<?php

class HashTest extends PHPUnit_Framework_TestCase
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
        $key = uniqid('test:Hash:');
        $hash = new \RedisWrapper\Hash($key, $this->connection);

        $this->assertInstanceOf(RedisWrapper\Connection::class, $hash->getConnection());
        $this->assertEquals($key, $hash->getKey());


        $hash->int = 1;
        $hash->string = 'aaabbbccc';

        $this->assertEquals(1, $hash->int);
        $this->assertEquals('aaabbbccc', $hash->string);
        $this->assertEquals(2, $hash->length());

        $hash->bool = false;

        $this->assertEquals(false, $hash->bool);
        $this->assertEquals(3, $hash->length());

        $this->assertTrue($hash->getConnection()->getClient()->exists($hash->getKey()));

        return $hash;
    }

    /**
     * @depends testAssignment
     * @param \RedisWrapper\Hash $hash
     * @return \RedisWrapper\Hash
     */
    public function testDelete(\RedisWrapper\Hash $hash)
    {

        unset($hash->bool);

        $this->assertFalse( $hash->bool); // not value, false = not exists
        $this->assertEquals(2, $hash->length());

        return $hash;
    }

    /**
     * @depends testAssignment
     * @param \RedisWrapper\Hash $hash
     */
    public function testClear(\RedisWrapper\Hash $hash)
    {
        $result = $hash->clear();

        $this->assertEquals(1, $result);
        $this->assertFalse($hash->getConnection()->getClient()->exists($hash->getKey()));
        $this->assertFalse($hash->length());
    }
}