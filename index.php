<?php

require 'vendor/autoload.php';

/* Global helper file */
include_once 'panther/helper.php';

/* New application initialization
    Constructor takes in configs
    base_url is used for no virtual server environment */ 
$app = new \Panther\App(/*['base_url' => 'http://localhost:8080/panther']*/);

/*  Entities registration
    All entity classes needs to be registered here
    Panther will take care of migrations, seeders, routes & models for you! */
$app->register('HelloEntity', 'hello');

/* Running the application */
$app->run();