<?php
use PHPUnit\Framework\TestCase;

final class HttpRequestTest extends TestCase
{

    private $request;

    public function setUp()
    {
        $this->request = new \Panther\Http\Request(['test' => '123']);
    }

    public function testCanCreateRequest()
    {
        $this->assertInstanceOf(\Panther\Http\Request::class, $this->request);        
    }

    public function testCanCreateWithPostVariables()
    {
        $request = new \Panther\Http\Request(['test' => '123']);
        $this->assertSame('123', $request->test);
    }

    public function testCanGet()
    {
        $this->assertSame('123', $this->request->get('test'));
    }

    public function testCanSet()
    {
        $this->request->set('hello', 'world');
        $this->assertSame('world', $this->request->get('hello'));
    }

    public function testCanExceptName()
    {
        $this->request->set('hello', 'world');
        
        $array = $this->request->except('hello');

        $this->assertArrayNotHasKey('hello', $array);
        $this->assertArrayHasKey('test', $array);

        $array = $this->request->except('test');

        $this->assertArrayNotHasKey('test', $array);
        $this->assertArrayHasKey('hello', $array);
    }

    public function testCanExceptArray()
    {
        $this->request->set('test1', 1);
        $this->request->set('test2', 2);
        $this->request->set('test3', 3);
        
        $array = $this->request->except(['test1', 'test2']);

        $this->assertArrayNotHasKey('test1', $array);
        $this->assertArrayNotHasKey('test2', $array);
        $this->assertArrayHasKey('test3', $array);
        $this->assertSame(3, $array['test3']);

        $array = $this->request->except(['test3']);

        $this->assertArrayNotHasKey('test3', $array);
        $this->assertArrayHasKey('test1', $array);
        $this->assertArrayHasKey('test2', $array);
        $this->assertSame(1, $array['test1']);
        $this->assertSame(2, $array['test2']);
    }

    public function testCanFilterName()
    {
        $this->request->set('hello', 'world');
        
        $this->request->filter('hello');

        $this->assertFalse($this->request->get('hello'));
        $this->assertSame('123', $this->request->get('test'));
        $this->assertSame('123', $this->request->test);

        $this->request->set('hello', 'world');

        $this->request->filter('test');

        $this->assertFalse($this->request->get('test'));
        $this->assertSame('world', $this->request->get('hello'));
        $this->assertSame('world', $this->request->hello);
    }

    public function testCanFilterArray()
    {
        $this->request->set('test1', 1);
        $this->request->set('test2', 2);
        $this->request->set('test3', 3);
        
        $this->request->filter(['test1','test2']);

        $this->assertFalse($this->request->get('test1'));
        $this->assertFalse($this->request->get('test2'));
        $this->assertSame(3, $this->request->get('test3'));
        $this->assertSame(3, $this->request->test3);

        $this->request->set('test1', 1);
        $this->request->set('test2', 2);
        $this->request->set('test3', 3);
        
        $this->request->filter(['test3']);

        $this->assertFalse($this->request->get('test3'));
        $this->assertSame(1, $this->request->get('test1'));
        $this->assertSame(1, $this->request->test1);
        $this->assertSame(2, $this->request->get('test2'));
        $this->assertSame(2, $this->request->test2);
    }

    public function testCanFlush()
    {
        $this->request->set('hello', 'world');

        $this->request->flush();

        $this->assertFalse($this->request->get('hello'));

    }

}