<?php

require 'vendor/autoload.php';

include_once 'panther/helper.php';

$app = new \Panther\App(['base_url' => 'http://localhost:8080/panther']);

$app->register([
    'class' => App\Entities\HelloEntity::class
]);

$app->run();