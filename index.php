<?php

require 'vendor/autoload.php';

$app = new \Panther\App();

$app->register([
    'class' => App\Entities\HelloEntity::class
]);

$app->run();