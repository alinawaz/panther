<?php

require 'vendor/autoload.php';

/* Global helper file */
include_once 'panther/helper.php';

/* New application initialization
    Constructor takes in configs */ 
$app = new \Panther\App();

/*  Entities registration
    All entity classes needs to be registered here
    Panther will take care of migrations, seeders, routes & models for you! */
$app->register('HelloEntity', 'hello');
$app->register('TestEntity', 'test');

/* Running the application */
$app->run();