<?php
use PHPUnit\Framework\TestCase;

// Dummy config helper
function config($key, $value=''){
    $configs = [
        'db.default' => 'mysql',
        'db.mysql.host' => '127.0.0.1',
        'db.mysql.username' => 'root',
        'db.mysql.password' => '',
        'db.mysql.database' => 'test',
        'db.mysql.port' => '3306',
    ];
    return $configs[$key];
}

final class DatabaseMysqlQueryTest extends TestCase
{

    private $query;

    public function setUp()
    {
        $this->query = new \Panther\Database\MysqlQuery;
    }

    public function testCanCreateMysqlQuery()
    {
        $query = new \Panther\Database\MysqlQuery;
        $this->assertInstanceOf(\Panther\Database\MysqlQuery::class, $query);        
    }

    public function testCanGetLastQuery()
    {
        $query = new \Panther\Database\MysqlQuery;
        $this->assertArrayHasKey('Last Direct Query', $query::getLastQuery());
        $this->assertArrayHasKey('Last Table Query', $query::getLastQuery());
    }

    public function testCanConnect()
    {
        $query = new \Panther\Database\MysqlQuery;
        $this->assertTrue($query->connect());
    }

    public function testCanClose()
    {
        $query = new \Panther\Database\MysqlQuery;
        $this->assertTrue($query->close());
    }

    public function testCanGetTable()
    {
        $query = new \Panther\Database\MysqlQuery;
        $this->assertInstanceOf(\Panther\Database\MysqlTable::class, $query::table('items'));        
    }

}