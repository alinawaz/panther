<?php
use PHPUnit\Framework\TestCase;

final class RouterRouteTest extends TestCase
{

    private $route;

    public function setUp()
    {
        $this->route = new \Panther\Router\Route([
            'method' => 'GET',
            'url' => '/test/:name',
            'class' => 'Test\Entities\TestEntity',
            'type' => 'closure',
            'callable' => function($name){ return $name; }
        ]);
    }

    public function testCanCreateRoute()
    {
        $this->assertInstanceOf(\Panther\Router\Route::class, $this->route);        
    }

    public function testCanInvoke()
    {
        $response = $this->route->invoke(['works']);
        $this->assertSame('works', $response);
    }

}