# Documentation


## Routing
Routing can be done internally inside `Entities` or can be managed independantly via `app/routing/Routes.php` external file.

### Routing Methods
Routing supports basic restful methods.
- GET
- POST
- PUT
- PATCH
- DELETE

#### Defining a route
Route can be defined by calling instance of `Panther\Router\Router` method i.e.

```
use Panther\Router\Router;

$router = new Router;
$router->get(<URL>, <CALLBACK>);
```

here <URL> should be the `url` provided in browser/api, and it will trigger a <CALLBACK> against it.

#### Callbacks
Callbacks can be defined in three ways;
- Closure  
- Internal Method Call
- External Method Call

#### Closure
You can provided a `closure` function call simply i.e.
```
$router->get('test', function(){
    return 'tested'; 
})
```
If you have passed in parameters, it would simple accept them in closure accordingly i.e.
```
$router->get('test/:id', function($id){
    return 'tested id:'.$id; 
})
```
#### Internal Method Call
Whenever you have defined your routes via `routes` method inside of `Entity`, you can simple pass method name string as second parameter and panther will handle the rest i.e.

```
$router->post('/save', 'saveName');
```
here `saveName` is actually a method defined inside same entity.

#### External Method Call
If you're using routing via external file `app/routing/Routes.php`, then you need to pass second parameter will entity name string and method name string seperated with `@` symbol. i.e.

```
$this->router->get('/', 'HelloEntity@index');
```
This route will invoke the `HelloEntity` class's method `index` respectively.

#### Internal Routing Example
You need to create a method named `routes` taking parameter of instance `Panther\Router\Router`

```
public function routes(Router $router){		
		
    $router->get('/call/:number', function($number){
        return $this->toJson([
            "status" => "OK",
            "message" => "Calling number ".$number." ..."
        ]);
    });
    $router->post('/save', 'saveName');
    $router->post('/test_post/:name/:age', 'test_post');
    $router->put('/save', 'updateName');
    $router->patch('/save/:id', 'patchName');
    $router->delete('/remove/:id', 'remove');

}
```
