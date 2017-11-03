<?php

require __DIR__ . '/../vendor/autoload.php';
//model
require __DIR__ .'/../src/model/Vehicles.php';
require __DIR__ .'/../src/model/Offers.php';
require __DIR__ .'/../src/model/Users.php';
require __DIR__ .'/../src/model/Bills.php';
require __DIR__ .'/../src/model/ApiClass.php';
require __DIR__ .'/../src/model/Commands.php';
//class
require __DIR__ .'/../src/class/Sprite.php';
require __DIR__ .'/../src/class/Api.php';
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

// Create Transport
$transport = Swift_MailTransport::newInstance();

// Create Mailer with our Transport.
$mailer = Swift_Mailer::newInstance($transport);
// Run app
$app->run();
