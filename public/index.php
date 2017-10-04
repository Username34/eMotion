<?php

require __DIR__ . '/../vendor/autoload.php';
//model
require '../src/model/Vehicles.php';
require '../src/model/Offers.php';
require '../src/model/Users.php';
require '../src/model/Bills.php';
require '../src/model/ApiClass.php';
//class
require '../src/class/Sprite.php';
require '../src/class/Api.php';
session_start();

// Instantiate the app
$settings = require __DIR__ . '/../src/settings.php';
$app = new \Slim\App($settings);

// Set up dependencies
require __DIR__ . '/../src/dependencies.php';

// Register routes
require __DIR__ . '/../src/routes.php';

$container = $app->getContainer();
$capsule = new Illuminate\Database\Capsule\Manager;
$capsule->addConnection($container->get('settings')['db']);
$capsule->bootEloquent();

$capsule->getContainer()->singleton(
    Illuminate\Contracts\Debug\ExceptionHandler::class,
    App\Exceptions\Handler::class
);
// Run app
$app->run();
