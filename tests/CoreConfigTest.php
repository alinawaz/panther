<?php
use PHPUnit\Framework\TestCase;

final class CoreConfigTest extends TestCase
{

    private $config;

    public function setUp()
    {
        $this->config = new \Panther\Core\Config(['test' => '123']);
    }

    public function testCanCreateConfig()
    {
        $config = new \Panther\Core\Config();
        $this->assertInstanceOf(\Panther\Core\Config::class, $config);        
    }

    public function testCanMock()
    {
        $config = new \Panther\Core\Config;
        $config = $config->mock(['test' => '123']);
        $this->assertInstanceOf(\Panther\Core\Config::class, $config);
        $this->assertTrue($config->has('test'));
        $this->assertSame('123',$config->get('test'));
    }

    public function testCanSet()
    {
        $this->config->set('hello', 'world');
        $this->assertTrue($this->config->has('hello'));
        $this->assertSame('world',$this->config->get('hello'));
    }

    public function testCanToArray()
    {
        $array = $this->config->toArray();
        $this->assertArrayHasKey('test', $array);
    }

}