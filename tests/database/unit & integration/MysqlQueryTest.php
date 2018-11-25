<?php
use PHPUnit\Framework\TestCase;

final class MysqlQueryTest extends TestCase
{

    private $instance;

    public function setUp()
    {
        \Panther\Core\Config::setup();
        $this->instance = new \Panther\Database\MysqlQuery;
    }

    public function testCanCreateMysqlQuery()
    {
        $this->assertInstanceOf(\Panther\Database\MysqlQuery::class, $this->instance);        
    }

    public function testCanGetLastQuery()
    {
        $this->assertArrayHasKey('Last Direct Query', $this->instance::getLastQuery());
        $this->assertArrayHasKey('Last Table Query', $this->instance::getLastQuery());
    }

    public function testCanConnect()
    {
        $this->assertTrue($this->instance::connect());
    }

    public function testCanClose()
    {
        $this->assertTrue($this->instance::close());
    }

    public function testCanGetTable()
    {
        $this->assertInstanceOf(\Panther\Database\MysqlTable::class, $this->instance::table('items'));        
    }

}