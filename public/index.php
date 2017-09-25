<?php

require __DIR__ . '/../vendor/autoload.php';

session_start();

// Instantiate the app
$settings = require __DIR__ . '/../src/settings.php';
$app = new \Slim\App();

// Register routes
require __DIR__ . '/../src/routes.php';

// Run app
$app->run();
