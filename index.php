<?php

require 'vendor/autoload.php';

$app = new App();
$app->register([
    'default' => true,
    'class' => App\Entities\HelloEntity::class
]);
$app->run();