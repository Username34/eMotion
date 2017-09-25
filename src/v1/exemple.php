<?php
/**
 * Created by PhpStorm.
 * User: mehdi
 * Date: 03/05/2017
 * Time: 17:08
 */
use \Psr\Http\Message\ResponseInterface as Response;
use \Psr\Http\Message\ServerRequestInterface as Request;
$app->get('/exemple', function (Request $request, Response $response, $args) {

    return $response->withJson(['success' => true, 'data' => "ceci est un exemple lol"]);
});