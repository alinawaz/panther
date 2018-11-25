<?php
use PHPUnit\Framework\TestCase;

final class MysqlTableTest extends TestCase
{

    private $instance;

    public function setUp()
    {
        $this->instance = new \Panther\Database\MysqlTable('table_one');
    }

    public function testCanTableWith()
    {
        $table = $this->instance->with('table_two');
        $expected = trim("SELECT * FROM table_one   JOIN table_two ON table_two.table_one_id=table_one.id");
        $this->assertSame(trim($table->getQuery()), $expected);
    }

    // Rest of the tests will be added later

}