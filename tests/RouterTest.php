<?php
use PHPUnit\Framework\TestCase;

final class RouterTest extends TestCase
{

    private $routes = [
        [
            'method' => 'GET',
            'url' => '/test',
            'class' => 'Test\Entities\TestEntity',
            'type' => 'function',
            'callable' => 'test_get'
        ],
        [
            'method' => 'GET',
            'url' => '/test/:id',
            'class' => 'Test\Entities\TestEntity',
            'type' => 'function',
            'callable' => 'test_get_id'
        ]
    ];

    public function testCanCreateRouter()
    {
        $router = new \Panther\Router\Router;
        $this->assertInstanceOf(\Panther\Router\Router::class, $router);
    }

    /**
     * @dataProvider routeRunProvider
     */
    public function testRunRoutes($request, $config){

        $requestUrl = $request->getUri();
        
        if($config->has('base_url')){
            $requestUrl = $request->getUrl();
            $requestUrl = str_replace($config->get('base_url'), '', $requestUrl);
        }

        $matched = false;

		for ($i=0; $i < count($this->routes); $i++) { 
            
            $route = $this->routes[$i];
            
            $response = \Panther\Router\RouteMatch::match($requestUrl, $route, $request->getMethod());
            
            if($response->matched){

                $matched = true;
				$class = new $route['class']();
                $method_name = $route['callable'];
                
				if($route['type'] == 'function'){	

					if($request->hasPostData() && !$response->hasParams){
						$requestUrl = new \Panther\Http\Request;
						foreach($_POST as $key => $value){
							$requestUrl->$key = $value;
						}
                        $test_string = $class->$method_name($requestUrl);
                        $this->assertSame('works', $test_string);
                    }
                    
					if(!$request->hasPostData() && $response->hasParams){
                        $test_string = $class->$method_name(...$response->params);
                        $this->assertSame('works', $test_string);
                    }

                    if($request->hasPostData() && $response->hasParams){
                        $http_request = new \Panther\Http\Request;
						foreach($request->getPostData() as $key => $value){
							$http_request->$key = $value;
                        }
                        $response->params[] = $http_request;
                        $test_string = $class->$method_name(...$response->params);
                        $this->assertSame('works', $test_string);
                    }

                    $test_string = $class->$method_name();
                    $this->assertSame('works', $test_string);

				}else if($route['type'] == 'closure'){

					if($response->hasParams){
                        $test_string = $method_name(...$response->params);
                        $this->assertSame('works', $test_string);
					}
                    $test_string = $method_name();
                    $this->assertSame('works', $test_string);

				}				
			}
        }

        if(!$matched){
            $this->assertSame('works', '404');
        }
    }

    public function routeRunProvider()
    {
        // Creating new config
        $config = new \Panther\Core\Config([
            'base_url' => 'http://localhost:8080/panther'
        ]);

        // Creating new router request
        $request = new \Panther\Router\RouteRequest;

        // Faking GET request for /test url        
        $fake_request = $request->mock('GET','/test');
        $request1 = [$fake_request, $config];

        // Faking GET request for /test/:id url
        $fake_request = $request->mock('GET','/test/3');
        $request2 = [$fake_request, $config];

        // Returning record
        return [$request1, $request2];
    }

}