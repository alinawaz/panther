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
    public function testRunRoutes($route_request, $config){

        $request = $route_request->getUri();
        
        if(isset($config['base_url']) && $config['base_url'] != ''){
            $request = $route_request->getUrl();
            $request = str_replace($config['base_url'], '', $request);
        }

        $matched = false;

		for ($i=0; $i < count($this->routes); $i++) { 
            
            $route = $this->routes[$i];
            
            $response = \Panther\Router\RouteMatch::match($request, $route, $route_request->getMethod());
            
            if($response->matched){

                $matched = true;
				$class = new $route['class']();
                $method_name = $route['callable'];
                
				if($route['type'] == 'function'){	

					if($route_request->hasPostData() && !$response->hasParams){
						$request = new \Panther\Http\Request;
						foreach($_POST as $key => $value){
							$request->$key = $value;
						}
                        $test_string = $class->$method_name($request);
                        $this->assertSame('works', $test_string);
                    }
                    
					if(!$route_request->hasPostData() && $response->hasParams){
                        $test_string = $class->$method_name(...$response->params);
                        $this->assertSame('works', $test_string);
                    }

                    if($route_request->hasPostData() && $response->hasParams){
                        $request = new \Panther\Http\Request;
						foreach($route_request->getPostData() as $key => $value){
							$request->$key = $value;
                        }
                        $response->params[] = $request;
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
        // Creating fake configs
        $fake_config = [];
        $fake_config['base_url'] = 'http://localhost:8080/panther';

        // Creating fake GET request for /test url
        $route_request = new \Panther\Router\RouteRequest;
        $fake_request = $route_request->mock('GET','/test');
        $request1 = [$fake_request, $fake_config];

        // Creating fake GET request for /test/id url
        $route_request = new \Panther\Router\RouteRequest;
        $fake_request = $route_request->mock('GET','/test/3');
        $request2 = [$fake_request, $fake_config];

        // Returning record
        return [$request1, $request2];
    }

}