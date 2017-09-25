<?php
/**
 * Created by PhpStorm.
 * User: mehdi
 * Date: 03/05/2017
 * Time: 17:08
 */
use \Psr\Http\Message\ResponseInterface as Response;
use \Psr\Http\Message\ServerRequestInterface as Request;
    $app->post('/enregistrement', function (Request $request, Response $response, $args) {
        $data = $request->getParsedBody();
        $db = connect_db($server = $this['settings']["mysql"]["server"]
            ,$this['settings']["mysql"]["user"]
            ,$this['settings']["mysql"]["pass"]
            ,$this['settings']["mysql"]["database"]);


        return $response->withJson(['success' => true, 'data' => $data]);
    });

function connect_db($server, $user, $pass, $database) {
    $connection = new mysqli($server, $user, $pass, $database);
    return $connection;
}