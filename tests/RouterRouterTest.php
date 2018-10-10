<?php
use PHPUnit\Framework\TestCase;

final class RouterRouterTest extends TestCase
{

    private $collection;

    public function setUp()
    {

        $this->collection = new \Panther\Router\Collection;


        // GET Requests
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

        // POST Requests
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

        // PUT Requests
        $this->collection->push(new \Panther\Router\Route([
            'method' => 'PUT',
            'url' => '/test',
            'class' => 'Test\Entities\TestEntity',
            'type' => 'function',
            'callable' => 'test_put'
        ]));
        $this->collection->push(new \Panther\Router\Route([
            'method' => 'PUT',
            'url' => '/test/:char',
            'class' => 'Test\Entities\TestEntity',
            'type' => 'function',
            'callable' => 'test_put_param'
        ]));

        // PATCH Requests
        $this->collection->push(new \Panther\Router\Route([
            'method' => 'PATCH',
            'url' => '/test',
            'class' => 'Test\Entities\TestEntity',
            'type' => 'function',
            'callable' => 'test_patch'
        ]));
        $this->collection->push(new \Panther\Router\Route([
            'method' => 'PATCH',
            'url' => '/test/:char',
            'class' => 'Test\Entities\TestEntity',
            'type' => 'function',
            'callable' => 'test_patch_param'
        ]));

        // DELETE Requests
        $this->collection->push(new \Panther\Router\Route([
            'method' => 'DELETE',
            'url' => '/test/:char',
            'class' => 'Test\Entities\TestEntity',
            'type' => 'function',
            'callable' => 'test_delete_param'
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

		$test = $this->collection->traverse($request, function($request, $route, $response){

            // GET Request
            if($request->isGet() && !$response->hasParams){
                return $route->invoke();
            }
            if($request->isGet() && $response->hasParams){
                return $route->invoke($response->params);
            }  

            // POST Request
            if($request->isPost() && !$response->hasParams){
                $http_request = new \Panther\Http\Request($request->getPostData());
                return $route->invoke($http_request);
            }
            if($request->isPost() && $response->hasParams){
                $http_request = new \Panther\Http\Request($request->getPostData());
                $response->params[] = $http_request;
                return $route->invoke($response->params);
            }

            // PUT Request
            if($request->isPut() && !$response->hasParams){
                $http_request = new \Panther\Http\Request($request->getPostData());
                return $route->invoke($http_request);
            }
            if($request->isPut() && $response->hasParams){
                $http_request = new \Panther\Http\Request($request->getPostData());
                $response->params[] = $http_request;
                return $route->invoke($response->params);
            }

            // PATCH Request
            if($request->isPatch() && !$response->hasParams){
                $http_request = new \Panther\Http\Request($request->getPostData());
                return $route->invoke($http_request);
            }
            if($request->isPatch() && $response->hasParams){
                $http_request = new \Panther\Http\Request($request->getPostData());
                $response->params[] = $http_request;
                return $route->invoke($response->params);
            }

            // DELETE Request
            if($request->isDelete() && !$response->hasParams){
                $http_request = new \Panther\Http\Request($request->getPostData());
                return $route->invoke($http_request);
            }
            if($request->isDelete() && $response->hasParams){
                $http_request = new \Panther\Http\Request($request->getPostData());
                $response->params[] = $http_request;
                return $route->invoke($response->params);
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

        // Faking PUT request {/test}
        $fake_request = $request->mock('PUT','/test',['string' => 'works']);
        $request5 = [$fake_request, $config];

        // Faking PUT request {/test/:id} with params
        $fake_request = $request->mock('PUT','/test/s',['string' => 'work']);
        $request6 = [$fake_request, $config];

        // Faking PATCH request {/test}
        $fake_request = $request->mock('PATCH','/test',['string' => 'works']);
        $request7 = [$fake_request, $config];

        // Faking PATCH request {/test/:id} with params
        $fake_request = $request->mock('PATCH','/test/s',['string' => 'work']);
        $request8 = [$fake_request, $config];

        // Faking DELETE request {/test/:id} with params
        $fake_request = $request->mock('DELETE','/test/works');
        $request9 = [$fake_request, $config];

        // Returning record
        return [
            $request1, $request2, $request3, 
            $request4, $request5, $request6,
            $request7, $request8, $request9
        ];
    }

}