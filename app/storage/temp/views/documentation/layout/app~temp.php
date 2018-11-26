<?php use System\Libs\Lang; use System\Libs\URL; ?><html>
	<head>
		<title>Panther - Documentation</title>
		<link rel="shortcut icon" href="http://panther.test/public/logo.png">
		<link href="http://panther.test/public/css/bootstrap.min.css" rel="stylesheet"/>
        <script src="http://panther.test/public/js/jquery331.min.js"></script>
        <script src="http://panther.test/public/js/bootstrap.min.js"></script>
	</head>
	<body>
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
            <a class="navbar-brand" href="#">Panther Docs</a>
        </nav>
        <div class="row" style="padding: 10px;">
            <div class="col-2">
                <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                    <a class="nav-link active" id="v-pills-home-tab" data-toggle="pill" href="#v-pills-home" role="tab" aria-controls="v-pills-home" aria-selected="true">Getting Started</a>
                    <a class="nav-link" id="v-pills-profile-tab" data-toggle="pill" href="#v-pills-profile" role="tab" aria-controls="v-pills-profile" aria-selected="false">Entities</a>
                    <a class="nav-link" id="v-pills-messages-tab" data-toggle="pill" href="#v-pills-messages" role="tab" aria-controls="v-pills-messages" aria-selected="false">Routing</a>
                    <a class="nav-link" id="v-pills-settings-tab" data-toggle="pill" href="#v-pills-settings" role="tab" aria-controls="v-pills-settings" aria-selected="false">Database</a>
                </div>
            </div>
            <div class="col-10">
                <div class="tab-content" id="v-pills-tabContent">
                    <div class="tab-pane fade show active" id="v-pills-home" role="tabpanel" aria-labelledby="v-pills-home-tab">
                        
<h2>Getting Started</h2>
<p>
    Getting started with panther is really easy, you can do that by 
    either using <code>GIT</code> or by just directly downloading 
    repository as zip from <code>https://github.com/alinawaz/panther</code>.
</p>
<h5>Using GIT</h3>
<p>
    Goto your <code>XAMPP/WAMP</code> root folder <code>www/htdocs</code> or any other stack you have installed for 
    php & mysql. <br/>
    Open up <code>Command Prompt Or Terminal</code> and type in 
    <div class="card">
        <div class="card-body">
            git clone https://github.com/alinawaz/panther
        </div>
    </div>
    <br/>
    You can rename <code>panther</code> to any name of your project you want. 
    For now let it be panther and let's <code>cd</code> into the directory
    <br/><br/>
    <div class="card">
        <div class="card-body">
            cd panther
        </div>
    </div>
    <br/>
</p>
<h5>Installing dependencies via composer</h3>
<p>
    Panther uses <code>composer</code> to utilize PSR standard & for symfony 
    dependencies. <br/><br/>
    <div class="alert alert-secondary" role="alert">
        Make sure you already have a <a href="https://getcomposer.org/download/">composer</a> installed.
    </div>
    <br/>
    Now run the following command for install required dependencies for panther.
    <br/><br/>
    <div class="card">
        <div class="card-body">
            composer install
        </div>
    </div>
</p>
<h5>That's it, let's test it out.</h3>
<p>
    Let's test out our new installation of panther. Panther comes with default 
    entity named <code>HelloEntity</code> which have a home page at 
    <code>http://your_local_host_url/project_folder/</code>
    <br/><br/>
    You will see welcome page from panther.
</p>
                    </div>
                    <div class="tab-pane fade" id="v-pills-profile" role="tabpanel" aria-labelledby="v-pills-profile-tab">
                    
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
    Creating new entity is easy, you just need to type in following command
    
</p></div>
                    <div class="tab-pane fade" id="v-pills-messages" role="tabpanel" aria-labelledby="v-pills-messages-tab">...</div>
                    <div class="tab-pane fade" id="v-pills-settings" role="tabpanel" aria-labelledby="v-pills-settings-tab">...</div>
                </div>
            </div>
        </div>
	</body>
</html>