<?php
use \Psr\Http\Message\ResponseInterface as Response;
use \Psr\Http\Message\ServerRequestInterface as Request;

$app->group('/list', function () use ($app) {
    $app->get('/offer', function (Request $request, Response $response, $args) {
        $db = connect_db($server = $this['settings']["mysql"]["server"]
            ,$this['settings']["mysql"]["user"]
            ,$this['settings']["mysql"]["pass"]
            ,$this['settings']["mysql"]["database"]);
        $sql = "select o.idoffer, v.`car_brand`, v.`place_number`, v.`model`, o.`date_start`, o.`price`, o.`date_end`, v.`image`  from offers as o
                join vehicles as v
                ON o.id_vehicle = v.idvehicle
                where o.hidden = '0'";
        $result = $db->query($sql);
        while ( $row = $result->fetch_array(MYSQLI_ASSOC) ) {
            $data[] = $row;
        }

        return $response->withJson(['success' => true, 'data' => $data]);
    });

    $app->get('/offer_all', function (Request $request, Response $response, $args) {
        $db = connect_db($server = $this['settings']["mysql"]["server"]
            ,$this['settings']["mysql"]["user"]
            ,$this['settings']["mysql"]["pass"]
            ,$this['settings']["mysql"]["database"]);
        $sql = "select *  from offers as o
                join vehicles as v
                ON o.id_vehicle = v.idvehicle
                where o.hidden = '0'";
        $result = $db->query($sql);
        while ( $row = $result->fetch_array(MYSQLI_ASSOC) ) {
            $data[] = $row;
        }

        return $response->withJson(['success' => true, 'data' => $data]);
    });
    $app->post('/offerbydate', function (Request $request, Response $response, $args) {
        $data = $request->getParsedBody();
        //$data =  Offers::select('*')->where('hidden', '0')->get();
        //return $response->withJson(['success' => true, 'data' => $data]);
        return $response->withJson(['success' => true, 'data' => $data]);
    });
});

function connect_db($server, $user, $pass, $database) {
    $connection = new mysqli($server, $user, $pass, $database);
    return $connection;
 }