<?php

require 'vendor/autoload.php';

use Symfony\Component\Debug\Debug;

Debug::enable();

use Symfony\Component\Dotenv\Dotenv;

$dotenv = new Dotenv();
$dotenv->load(__DIR__.'/.env');


/* Global helper file */
include_once 'panther/helper.php';

/* New application initialization
    Constructor takes in configs */ 
$app = new \Panther\App();

/*  Entities registration
    All entity classes needs to be registered here
    Panther will take care of migrations, seeders, routes & models for you! */
$app->register('HelloEntity', 'hello');

/* Documentation Entity */
$app->register('DocumentationEntity', 'documentation');

/* Running the application */
$app->run();