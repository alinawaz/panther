<?php
use PHPUnit\Framework\TestCase;

final class RouterTest extends TestCase
{

    private $collection;

    public function setUp()
    {

        $this->collection = new \Panther\Router\Collection;

        $this->collection->push(new \Panther\Router\Route([
            'method' => 'GET',
            'url' => '/test',
            'class' => 'Test\Entities\TestEntity',
            'type' => 'function',
            'callable' => 'test_get'
        ]));

        $this->collection->push(new \Panther\Router\Route([
            'method' => 'GET',
            'url' => '/test/:char',
            'class' => 'Test\Entities\TestEntity',
            'type' => 'function',
            'callable' => 'test_get_param'
        ]));

        $this->collection->push(new \Panther\Router\Route([
            'method' => 'POST',
            'url' => '/test',
            'class' => 'Test\Entities\TestEntity',
            'type' => 'function',
            'callable' => 'test_post'
        ]));

        $this->collection->push(new \Panther\Router\Route([
            'method' => 'POST',
            'url' => '/test/:char',
            'class' => 'Test\Entities\TestEntity',
            'type' => 'function',
            'callable' => 'test_post_param'
        ]));

    }

    public function testCanCreateRouter()
    {
        $router = new \Panther\Router\Router;
        $this->assertInstanceOf(\Panther\Router\Router::class, $router);
    }

    /**
     * @dataProvider routeRunProvider
     */
    public function testRunRoutes($request, $config){

        $request->url = $request->getUri();
        
        if($config->has('base_url')){
            $request->url = $request->getUrl();
            $request->url = str_replace($config->get('base_url'), '', $request->url);
        }

		$test = $this->collection->traverse($request, function($request, $route, $response){

            // POST
            if($request->isPost() && $request->hasPostData() && !$response->hasParams){
                $http_request = new \Panther\Http\Request($request->getPostData());
                return $route->invoke($http_request);
            }
            // GET with params
            if($request->isGet() && !$request->hasPostData() && $response->hasParams){
                return $route->invoke($response->params);
            }
            // POST with params
            if($request->isPost() && $request->hasPostData() && $response->hasParams){
                $http_request = new \Panther\Http\Request($request->getPostData());
                $response->params[] = $http_request;
                return $route->invoke($response->params);
            }
            // GET
            if($request->isGet()){
                return $route->invoke();
            }
            
        });

        $this->assertSame('works', $test);

    }

    public function routeRunProvider()
    {
        // Creating new config
        $config = new \Panther\Core\Config([
            'base_url' => 'http://localhost:8080/panther'
        ]);

        // Creating new router request
        $request = new \Panther\Router\Request;

        // Faking GET request {/test}      
        $fake_request = $request->mock('GET','/test');
        $request1 = [$fake_request, $config];

        // Faking GET request {/test/:id} with params
        $fake_request = $request->mock('GET','/test/s');
        $request2 = [$fake_request, $config];

        // Faking POST request {/test}
        $fake_request = $request->mock('POST','/test',['string' => 'works']);
        $request3 = [$fake_request, $config];

        // Faking POST request {/test/:id} with params
        $fake_request = $request->mock('POST','/test/s',['string' => 'work']);
        $request4 = [$fake_request, $config];

        // Returning record
        return [$request1, $request2, $request3, $request4];
    }

}