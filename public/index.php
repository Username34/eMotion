<?php

require __DIR__ . '/../vendor/autoload.php';

session_start();

// Instantiate the app
$app = new \Slim\App();

// Register routes
require __DIR__ . '/../src/routes.php';

// Run app
$app->run();
