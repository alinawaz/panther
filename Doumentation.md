# Panther Documentation
Panther MVC framework is light-weight and built for quick web application(s) or APIs development. This framework takecares of many aspects for you, which can be a time taking factors in a project development process.

## Getting Started
After pulling panther's fresh source from github, you need to care about entry point to your new application. Which resides in at root directory with name `index.php`

The important section of this file is where you register your `entities`. i.e.

```php
$app->register('HelloEntity', 'hello');
```

`HelloEntity` will be the name of your entity file residing inside `app/entities/HelloEntity.php`, second parameter is just a friendly name you can give to you registered `entity`.

After  you've registered your first `entity`, next thing you will need is a `Routing` to utilize the functionality of that entity. `Routing` can be done inside of `entity` itself or using external file. Before that we need to create our first `entity` file `app/entities/HelloEntity.php`.

## Defining Entity
Entity can be defined by creating a `entity` file `HelloEntity.php` inside `app/entities` directory. The basic layout will look like this i.e.

```php
<?php

namespace App\Entities;

use Panther\Entity\EntityController;

class HelloEntity extends EntityController {

    // Methods goes here

}
```

Now we need a method inside our `entity` named `test` with passed in `$id` parameter, so we can return it i.e.

```php
    public function test($id)
    {
        return $id;
    }

```

Now to test this, we need a `Routing` for this entity, it can be either defined internally or externally (please see routing section below for details). For now, we are going to quickly defined a `route` internally using a built-in method `routes` for this entity. i.e.

```php
    public function routes(Router $router)
    {		
        $router->get('/test/:id', 'HelloEntity@test');
    }
```

Now you can goto your browser type in the project url i.e. in case of xampp/wamp `http://localhost/<project_folder>/test/123` and you will see the `123` id passed in as output

## Routing
Routing can be done internally inside `Entities` or can be managed independantly via `app/routing/Routes.php` external file.

#### Defining a route
Route can be defined by calling instance of `Panther\Router\Router` and required `Routing Method` i.e.

```php
use Panther\Router\Router;

$router = new Router;
$router->get(<URL>, <CALLBACK>); // Here GET routing method is being used
```

here <URL> should be the url provided in browser/api, and it will trigger a <CALLBACK> against it.

#### Routing Methods
Routing supports basic restful methods i.e. `GET`, `POST`, `PUT`, `PATCH` & `DELETE`. You can use these with instance of `Panther\Router\Router` i.e.

```php
$router->get(<URL>, <CALLBACK>);
$router->post(<URL>, <CALLBACK>);
$router->put(<URL>, <CALLBACK>);
$router->patch(<URL>, <CALLBACK>);
$router->delete(<URL>, <CALLBACK>);
```

#### Callbacks
Callbacks can be defined in three ways;
- Closure  
- Internal Method Call
- External Method Call

#### Closure
You can provided a `closure` function call simply i.e.
```php
$router->get('test', function(){
    return 'tested'; 
})
```

If you have passed in parameters, it would simple accept them in closure accordingly i.e.
```php
$router->get('test/:id', function($id){
    return 'tested id:'.$id; 
})
```

Or multiple parameters can be passed as per requirements i.e.
```php
$router->get('test/:id/:name', function($id, $name){
    return 'tested id:'.$id.' & name:'.$name; 
})
```

#### Internal Method Call
Whenever you have defined your routes via `routes` method inside of `Entity`, you can simple pass method name string as second parameter and panther will handle the rest i.e.

```php
$router->post('/save', 'saveName');
```

here `saveName` is actually a method defined inside same entity. Also parameter passing can be same as discussed in above example of closure. i.e.

```php
public function routes(Router $router){		
    $router->post('/save/:some_id', 'saveName');    
}

// saveName method
public function saveName($id, Request $request){
    return $request->some_posted_variable_name;
}
```

Please note that instance `Request` can be used to fetch posted variables, while url get parameters i.e. `id` can be fetched same as we discussed in closure case.

#### External Method Call
If you're using routing via external file `app/routing/Routes.php`, then you need to pass second parameter will entity name string and method name string seperated with `@` symbol. i.e.

```php
$this->router->get('/', 'HelloEntity@index');
```

This route will invoke the `HelloEntity` class's method `index` respectively. All other aspect related to parameters & `Request` object will be same as discussed above.

