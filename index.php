<?php

require 'vendor/autoload.php';

use Symfony\Component\Debug\Debug;

Debug::enable();

use Symfony\Component\Dotenv\Dotenv;

$dotenv = new Dotenv();
$dotenv->load(__DIR__.'/.env');


/* Global helper file */
include_once 'panther/helper.php';
base(__DIR__, $_SERVER['DOCUMENT_ROOT']);

/* New application initialization */ 
$app = new \Panther\App();

/*  Entities registration
    All entity classes needs to be registered here
    Panther will take care of migrations, seeders, routes & models for you! */
$app->register('HelloEntity', 'hello');

/* Documentation Entity */
$app->register('DocumentationEntity', 'documentation');

$app->register('UserEntity', 'user');

// For testing new view rendering
$app->register('SleekEntity');

/* Running the application */
$app->run();