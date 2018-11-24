
<h2>Entities</h2>
<p>
    Entities are like controllers in panther, they contain your code block logic 
    and manage your database models & views for you.
</p>
<h5>HelloEntity</h3>
<p>
    <code>HelloEntity</code> is a default entity you get when panther gets 
    installed for the first time. Let's explore how it works.
    <br/><br/>

    If you look at file <code>index.php</code> resides in root directory 
    of your project.

    <div class="card">
        <div class="card-body">
            $app->register('HelloEntity', 'hello');
        </div>
    </div>
    <br/>

    This line mentioned above registers a entity inside framework. Every 
    entity must be registered here. For ease panther provides a 
    <code>Routing</code> inside of entity itself. If you goto the 
    entity file <code>app/entities/HelloEntity.php</code>
    <br/><br/>

    <div class="card">
        <div class="card-body">
            <pre>
    public function routes(Router $router){		

        $router->get('/hello/:id', 'HelloEntity@test');

    }
            </pre>
        </div>
    </div>
    <br/>

    Now this method <code>routes</code> provides a way initialize all 
    routes related to the entity inside of an entity. If you will goto 
    browser and type in <code>http://panther/test/123</code>, you will 
    see the results of method mapped to the route i.e. <code>test</code>

</p>
<h5>Creating New Entity</h3>
<p>
    Creating new entity is easy, you just need to type in followinf command
    
</p>